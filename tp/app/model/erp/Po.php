<?php
namespace app\model\erp;
use think\Model;
use think\facade\Session;
use think\facade\Db;
use think\facade\Cache;
use app\validate\erp\PoValidate;
use app\validate\erp\PoListValidate;
use think\exception\ValidateException;
use app\model\erp\ErpConfig;
use app\model\erp\PoList;
use app\controller\Fs;
use app\model\erp\VendorPrice;
use app\controller\PublicGet;
use app\model\erp\Vendor;


class Po extends Model{

	protected $autoWriteTimestamp = true;

	protected $type = 'po';
  
	protected $schema = [
		'id'	=> 'int',
		'maker' => 'varchar',
		'maker_number' => 'varchar',
		'status' => 'int',
		'ddh' => 'varchar',
		'remark' => 'varchar',
		'flow_id' => 'int',
		'date' => 'date',
		'create_time' => 'datetime',
		'update_time' => 'datetime',
		'vendor_code' => 'varchar'
	];

	

	public function get($post){
		
		$main = $this::where("ddh = '".sprintf('%08d',$post['ddh'])."'")->find();
		$r = Vendor::where("code = '".$main->vendor_code."'")->find()->toArray();
		$main->vendor_name = $r['name'];
		if(!$main) return a('','表单不存在','e');
		$list = Db::table('s_po_list')->alias('a')->join('s_inventory i','a.inventory_code = i.code')->join('s_unit u','i.unit_id = u.id')->where('a.id = '.$main->id)->field('a.listid,a.inventory_code,i.name inventory_name,i.std inventory_std,u.name inventory_unit,a.price,a.tax,a.tax_price,a.qty,a.arrive_date,a.sum')->select()->toArray();
		$main = $main->toArray();
		if($main['flow_id'] > 0){
			$fs = new Fs;
			$tmp = $fs->check1($main['flow_id']);
			$main = array_merge($main,$tmp);
		}
		$zero = ['price','tax_price','qty','sum'];
		return a($this->dlt_zero($list,$zero),$main,'s');
	}

	private function dlt_zero($array,$field){
		foreach($field as $k => $v){
			foreach($array as $k1 => $v1){
				$array[$k1][$v] += 0;
				if(!$array[$k1][$v]) $array[$k1][$v] = '';
			}
		}
		return $array;
	}

	public function saveBill($post){

		if($post['ddh'] == ''){
			return $this->insertBill($post);
		}else{
			return $this->modifyBill($post);
		}
	}

	public function canModify($post,$type = 'modify'){
		
		$ddh = json_decode($post['ddh'],true);

		$checkResult = $ddhId = array();

		foreach($ddh as $k => $v){
			$checkResult[$v] = [ 'ok' => false , 'msg' => '表单不存在' ];
		}
		
		$listIds = [];

		$r = $this::where("ddh in (".get_w($ddh).")")->field('id,ddh,status,maker_number,flow_id,update_time')->select()->toArray();
		foreach($r as $k => $v){
			$listIds[$v['id']] = $v['ddh'];
		}

		$flowsId = array();
		
		if($type == 'dlt'){

			$dltMyself = Db::table('s_erp_config')->where(" `key` = '".$this->type."_only_dlt_myself' && value = 1")->field('id')->find();
			$username = Session::get('userinfo')['username'];
			foreach($r as $k => $v){
				if( $v['status'] >= 9 ){
					$checkResult[$v['ddh']] = [ 'ok' => false , 'msg' => '已审核完毕，不能删除'];
				}else if($dltMyself && $v['maker_number'] != $username ){
					$checkResult[$v['ddh']] = ['ok' => false , 'msg' => '非制单人不能删除'];
				}else{
					$checkResult[$v['ddh']] =  ['ok' => true ];
				}
			}

		}else if($type == 'check'){
			// 表单相关的判断

			foreach($r as $k => $v){
				if($v['flow_id']){
					if($v['status'] >= 9){
						$checkResult[$v['ddh']] = ['ok' => false ,'msg' => '已审核完毕'];
					}else{
						$flowsId[$v['flow_id']] = $v;
					}
					
				}else{
					if($v['status'] >= 9){
						$checkResult[$v['ddh']] = ['ok' => false ,'msg' => '已审核完毕'];
					}else{
						$checkResult[$v['ddh']] = array( 'ok' => true);
					}
				}
			}

			// 流程相关的判断
			if(count($flowsId) > 0){
				$fs = new Fs;
				$check = $fs->checkFlow($flowsId,$post['nodeId']);
				if($check['ok'] !== true){
					return $check;
				}else{
					foreach($check['checkResult'] as $k => $v){
						$checkResult[$k] = $v;
					}
				}
			}
			
			if($post['type'] == 'bill' && $checkResult[$ddh[0]]['ok'] && $r){
				if($post['update_time'] != $r[0]['update_time']){
					$checkResult[$ddh[0]] = ['ok' => false ,'msg' => '订单已被修改，请重新载入'];
				}
			}



		}else if($type == 'uncheck'){

			foreach($r as $k => $v){
				if($v['flow_id']){
					if($v['status'] >= 9){
						//$checkResult[$v['ddh']] = ['ok' => false ,'msg' => '已审核完毕'];
						$flowsId[$v['flow_id']] = $v;
					}else{
						$flowsId[$v['flow_id']] = $v;
					}
					
				}else{
					$checkResult[$v['ddh']] = array( 'ok' => true);
				}
			}

			
			// 流程相关的判断
			if(count($flowsId) > 0){
				$fs = new Fs;
				
				$check = $fs->uncheckFlow($flowsId,$post['nodeId']);

				if($check['ok'] !== true){
					return $check;
				}else{
					foreach($check['checkResult'] as $k => $v){
						$checkResult[$k] = $v;
					}
				}
			}
			
			if($post['type'] == 'bill' && $checkResult[$ddh[0]]['ok'] && $r){
				if($post['update_time'] != $r[0]['update_time']){
					$checkResult[$ddh[0]] = ['ok' => false ,'msg' => '订单已被修改，请重新载入'];
				}
			}


			if(count($listIds) > 0){
				$list = Db::table('s_po_list')->where('id in ('.get_w($listIds,false,false).')')->field('arrive_qty,id')->select();
				
				if($list){
					foreach($list->toArray() as $k => $v){
						if($v['arrive_qty'] > 0){
							if($checkResult[$listIds[$v['id']]]['ok']){
							
								$checkResult[$listIds[$v['id']]] = ['ok' => false,'msg' => '订单已被到货单关联，不能弃审'];
							}
						}
					}
				}
			}
			
		
			
			
		}else if($type == 'modify'){

			if(!$r) return a('','表单不存在','e');
			if($r[0]['flow_id']){
				$tmp = Db::table('s_flows_executor')->where('flow_id = '.$r[0]['flow_id'].' && status = 2')->field('id')->find();
				if($tmp) return a('','已审核，不能修改','e');
			}else{
				if($r[0]['status'] == 9) return a('','已审核完毕，不能修改','e');
			}
			return a();
		}

		return $checkResult;
			
	}


	/**
     * 新建表单
     */

	public function insertBill($post){

		$userinfo = Session::get('userinfo');
		$main = array(
			'maker' => $userinfo['name'],
			'maker_number' => $userinfo['username'],
			'create_datetime' => date('Y-m-d H:i:s',time()),
			'status' => 5,
			'date' => $post['date'],
			'remark' => trim($post['remark']),
			'vendor_code' => $post['vendor_code']
		);



		try {
            validate(PoValidate::class)->check($main);
        } catch (ValidateException $e) {
            return a('',$e->getError(),'e');
        }
		
		$data = json_decode($post['data'],true);

		foreach($data as $k => $v){
			try {
				validate(PoListValidate::class)->check($v);
			} catch (ValidateException $e) {
				return a('',$e->getError(),'e');
			}
		}
		
		

		Db::startTrans();
		try {

			$r = array();

			$bill = $this::create($main);
			$id = $bill->id;
			$ddh = sprintf('%08d',$id);
			$bill->ddh = $ddh;
			$bill->save();

			if(count($data) == 0) throw new \Exception("表体数据不能为空");
			foreach($data as $k => $v){
				$data[$k]['id'] = $id;
				unset($data[$k]['listid']);
				$data[$k]['sum']  = decimal($v['qty'] * $v['price'] * ( 1 + $v['tax'] / 100 ) , 2);
			}

			$poList = new PoList;
			$poList->saveAll($data);
	
			$isFlow = Db::table('s_erp_config')->where(" `key` = '".$this->type."_flow' && value = 1 ")->field('id')->find();

			if($isFlow){
				$fs = new Fs();
				$tmp = $fs->send($this->type.'_flow');
				$r = json_decode( $tmp->getContent(),true );
				$status = json_decode( $tmp->getContent(),true )['status'];
				if($r['status'] != 's')  throw new \Exception;
				$bill->flow_id = $r['data'];
				$bill->save();
			}
			Db::commit();
		
			
		} catch (\Exception $e) {
			Db::rollback();
			if(count($r) == 0){
				return a('',$e->getMessage(),'e');
			}else{
				if($r['status'] == 'e') return a('','审核流程：<br />'.$r['info'],'e');
				if($r['status'] == 'm') return a($r['data'],'','m');
			}
		}

		return a($ddh,'','s');

	}

	public function reCal($data){
		foreach($data as $k => $v){
			$data[$k]['tax_price'] = decimal($v['price'] * (1 + $v['tax'] / 100),3);
			$data[$k]['sum'] = decimal($v['price'] * (1 + $v['tax'] / 100) * $v['qty'],2);
		}
		return $data;
	}

	public function modifyBill($post){
		$checkData = [
			'type' => 'modify',
			'ddh' => json_encode( [$post['ddh']] )
		];
		$main = $this::where("ddh = '".$post['ddh']."'")->find();
		//if($main->update_time != $post['update_time']) return a('','订单已被修改，请重新载入','e');
		

		try {
            validate(PoValidate::class)->check($main->toArray());
        } catch (ValidateException $e) {
            return a('',$e->getError(),'e');
        }
		
		$data = $this->reCal(json_decode($post['data'],true));

		foreach($data as $k => $v){
			try {
				validate(PoListValidate::class)->check($v);
			} catch (ValidateException $e) {
				return a('',$e->getError(),'e');
			}
		}

		
		$id = $main['id'];

		$list = Db::table('s_po_list')->where('id = '.$id)->field('listid')->select()->toArray();	
		if( count($list) == 0 ) return a('','表单错误','e');
		$checkList = array();
		foreach($list as $k => $v){
			$checkList[$v['listid']] = 1;
		}
		$update = $insert = $dlt = array();
		foreach($data as $k => $v){
			if($v['listid']){
				$update[] = $v;
				if(isset($checkList[$v['listid']])){
					unset($checkList[$v['listid']]);
				}else{
					return a('','表单错误','e');
				}
			}
			if(!$v['listid']){
				unset($v['index']);
				unset($v['listid']);
				$v['id'] = $id;
				$insert[] = $v;
			}
		}
		
		$dlt = $checkList;
		
		if( count($list) + count($insert) - count($dlt) == 0 ) return a('','表单数据不能为零','e');

		if(count($dlt) > 0){
			Db::table('s_po_list')->where("listid in (".get_w($dlt,false,false).")")->delete();
		}

		if(count($insert) > 0 || count($update) > 0){
			$poList = new PoList;
			$poList->saveAll(array_merge($update,$insert));
		}
		
		$main->date = $post['date'];
		$main->remark = $post['remark'];
		$main->vendor_code = $post['vendor_code'];
		$main->save();

		return a($main['ddh']);
	}


	public function dltBill($post){

		$checkResult = $this->canModify($post,'dlt');


		

		$ddh = array();
		foreach($checkResult as $k => $v){
			if( !$v['ok'] ) continue;
			$ddh[] = $k;
		}

		



		if( count($ddh) > 0 ){
			$r = $this::where("ddh in (".get_w($ddh).")")->field('id,flow_id')->select()->toArray();
			$id = $flowId = array();
			foreach($r as $k => $v){
				$id[] = $v['id'];
				if($v['flow_id']) $flowId[] = $v['flow_id'];
			}
			if(count($id) > 0){
				$ids = get_w($id,false);
				Db::table('s_po')->where(" id in ( $ids ) ")->delete();
				Db::table('s_po_list')->where(" id in ( $ids ) ")->delete();
			}
			if(count($flowId) > 0){
				$fs = new Fs();
				$fs->cancel_do2($flowId);
			}
		}
		return a($checkResult,'','s');
	}


	public function checkBill($post){
		$checkResult = $this->canModify($post,'check');

		if(isset($checkResult['ok'])){
			if( $checkResult['ok'] === 'error' ) return a('',$checkResult['msg'],'error');
			if( $checkResult['ok'] === 'selectId' ) return a($checkResult['data'],'','selectId');
		}

		$w = $q = "";
		$checkDone = [];
		foreach($checkResult as $k => $v){
			if( $v['ok'] ){
				$r = $this->checkBillDo( $v );
				if($r['ok'] === true){
					$checkResult[$k] = array('ok' => true,'status' => $r['status']);
					$q .= " when '".$k."' then ".$r['status'];
					$w .= "'".$k."',";
					if($r['status'] == 9) $checkDone[] = $k;
				}else{
					if($r['ok'] === false)  $checkResult[$k] = array( 'ok' => false , 'msg' => $r['msg']);
					if($r['ok'] === 'm')    return a($r['data'],'','m');
				}
			}
		}

		if($w != ''){
			Db::execute(" update s_po set status = case ddh $q end where ddh in (".substr($w,0,-1).")");
		}
		//$this->afterCheckBill($checkResult);

		return a($checkResult);
	}

	public function checkBillDo($bill){
		$status = 0;
		if(is_set($bill,'flow_id')){
			$fs = new Fs;
			$handleData = array(
				'flowId' => $bill['flow_id'],
				'nodeId' => $bill['node_id'],
				'executeId' => $bill['id'],
				'executor' => isset($_POST['executor'])?$_POST['executor']:'',
				'add' => isset($_POST['add'])?$_POST['add']:array(),
				'opinion' => '',
				'field' => []
			);

			$r = $fs->handle( $handleData );
			if($r['ok'] !== true) return $r;
			$status = $r['status'];
		}else{
			$status = 9;
		}
		return array( 'ok' => true , 'status' => $status , 'imgType' => $status.(is_set($bill,'flow_id')?1:0) );	
	}

	public function uncheckBill($post){
				
		$checkResult = $this->canModify($post,'uncheck');

		if(isset($checkResult['ok'])){
			if( $checkResult['ok'] === 'error' ) return a('',$checkResult['msg'],'error');
			if( $checkResult['ok'] === 'selectId' ) return a($checkResult['data'],'','selectId');
		}
			
		foreach($checkResult as $k => $v){
			if( $v['ok'] ){
				$r = $this->uncheckBillDo( $v );
				if($r['ok'] === true){
					$checkResult[$k] = array('ok' => true,'status' => $r['status']);
				}else{
					
					if($r['ok'] === false)  $checkResult[$k] = array( 'ok' => false , 'msg' => $r['msg']);
				}
			}
		}
		
		$q = $w = '';

		foreach($checkResult as $k => $v){
			if(!$v['ok']) continue;
			$q .= " when '".$k."' then ".$r['status'];
			$w .= "'".$k."',";
		}

		if($w != '') Db::execute(" update s_po set status = case ddh $q end where ddh in (".substr($w,0,-1).")");
	
		return a($checkResult,'','s');
		
	}

	public function uncheckBillDo($bill){

		if(is_set($bill,'flow_id')){
			
			$fs = new Fs;

			$handleData = array(
				'flowid' => $bill['flow_id'],
				'nodeid' => $bill['node_id'],
				'id' => $bill['id'],
			);

			$r = $fs->retrieveDo( $handleData ,false);

			if(!$r['ok']) return $r;	
		}
		
		
		return array( 'ok' => true , 'status' => 5, 'imgType' => '5'.(is_set($bill,'flow_id')?1:0) );
	}


	private function afterCheckBill($result){

	
		$checked = array();
		foreach($result as $k => $v){
			if($v['ok'] && $v['status'] == 9) $checked[] = $k;
		}
		if(count($checked) == 0) return ;
		$r = Db::table('s_vendor_price_just_list')->alias('a')->join(['s_vendor_price_just' => 'b'],'a.id = b.id')->field('a.price,a.tax,a.tax_price,a.origin_price,a.origin_tax,a.origin_tax_price,a.inventory_code,a.vendor_code,b.maker')->where(" b.ddh in (".get_w($checked).") ")->select()->toArray();
		$w = "";
		$vendorPrice = $vendorPriceHistory = array();
		$now = date('Y-m-d H:i:s',time());
		foreach($r as $k => $v){
			$w .= "(vendor_code = '".$v['vendor_code']."' && inventory_code = '".$v['inventory_code']."') || ";
		}
		if($w != ''){
			 $w = substr($w,0,-3);
			 Db::table('s_vendor_price')->where($w)->delete();
		}

		$vp = new VendorPrice;
		$vp->saveAll($r);

		$vpjh = new VendorPriceJustHistory;
		$vpjh->saveAll($r);

	}


	private function validate($postData,$id){
		$data = array();
		$w = '';
		foreach($postData as $k => $v){
			$tmp = array();
			$tmp['id'] = $id;
			$tmp['vendor_code'] = $v['vendor_code'];
			$tmp['inventory_code'] = $v['inventory_code'];
			$tmp['origin_price'] = $v['origin_price'];
			$tmp['price'] = floatval($v['price']);
			$tmp['origin_tax'] = $v['origin_tax'];
			$tmp['tax'] = $v['tax'];
			$tmp['origin_tax_price'] = $v['origin_tax_price'];
			$tmp['tax_price'] = $v['tax_price'];
			if($v['price'] == '' || $tmp['price'] < 0) return array('ok' => false,'msg' => '第'.$v['index'].'行价格错误');
			$data[] = $tmp;
			if(!$v['listid']) $w .= "(a.vendor_code = '".$v['vendor_code']."' && a.inventory_code = '".$v['inventory_code']."') || ";
		}

		if($w != ''){
			 $w = substr($w,0,-3);
			 $r = Db::table('s_vendor_price_just_list')->alias('a')->join(['s_vendor_price_just' => 'b'],'a.id = b.id')->field('b.ddh,a.inventory_code,a.vendor_code')->where(" b.status = 5 && ( $w ) ")->select()->toArray();
			 $tmp = "存在相同 <span class = 'text-color3'>供应商</span> 和 <span class = 'text-color3'>物料编码</span> 的未审核完的表单：<br />";
			 foreach($r as $k => $v){
				$tmp .= "表单号：".$v['ddh']."，供应商编码：".$v['vendor_code']."，物料编码：".$v['inventory_code']."<br />";
			 }
			 $tmp = "<span style = 'font-size:12px'>".$tmp."</span>";
			 if(count($r) > 0 ) return array('ok' => false,'msg' => $tmp);
		}
		return array('ok' => true,'data' => $data);
	}

	public function nextPrev($post){
		
		if(!$post['ddh']){
			if($post['type'] == 'next'){
				$r = $this::order('ddh desc')->field('ddh')->find();
			}else{
				$r = $this::order('ddh asc')->field('ddh')->find();
			}
		}else{
			
			if($post['type'] == 'next'){
				$r = $this::where("ddh > '".$post['ddh']."'")->order('ddh asc')->field('ddh')->find();
			}else{
				$r = $this::where("ddh < '".$post['ddh']."'")->order('ddh desc')->field('ddh')->find();
			}
		}

		if($r){
			return a($r->ddh,'','s');
		}else{
			if($post['type'] == 'next'){
				return a('','已是最后一张','e');
			}else{
				return a('','已是第一张','e');
			}
			
		}
	}




	public function getList($post){

		$r = $page = [];
		if(is_set($post,'my')){
			// 检查 是否有审核权限
			$auth = checkAuth('');

			if($auth){
				$r = Db::table('s_po_list')->alias('a')->join('s_po b','a.id = b.id')->join('s_inventory i','a.inventory_code = i.code')->join('s_vendor v','b.vendor_code = v.code')->join('s_unit u','i.unit_id = u.id')->field('a.qty,a.sum,b.ddh,b.date,b.maker,b.status,b.flow_id,i.code inventory_code,i.name inventory_name,i.std inventory_std,v.code vendor_code,v.name vendor_name,a.price,a.tax,a.tax_price,a.arrive_date,u.name unit_name')->where('b.status < 9')->order('a.id desc,a.listid asc')->select()->toArray();


			
				//有权限的情况下，检查流程上是是否到本人
				$hasFlow = [];
				foreach($r as $k => $v){
					if($v['flow_id']) $hasFlow[] = $v['flow_id'];
				}
				if(count($hasFlow) > 0 ){
					$r1 = Db::table('s_flows_executor')->where("number = '".Session::get('userinfo')['username']."' && flow_id in (".get_w($hasFlow,false).")")->field('flow_id')->select()->toArray();
					$flow = [];
					foreach($r1 as $k => $v){
						$flow[$v['flow_id']] = 1;
					}
					foreach($r as $k => $v){
						if( !isset($flow[$v['flow_id']]) ) unset($r[$k]);
					}
				}

			}
			//我的待审核

		}else{
			//搜索	
			$tmp = $this->getSearchData($post);
			$r = $tmp['r'];
			$page = $tmp['page'];
			
		}

		
		
		$structure = array(
			array('key' => 'ddh' , 'type' => 'a' , 'class' => 'detail'),
			array('key' => 'status' , 'type' => 'status'),
			'date',
			'maker',
			'vendor_code',
			'vendor_name',
			'inventory_code',
			'inventory_name',
			'inventory_std',
			'unit_name',
			array('key' => 'price' , 'type' => 'number' , 'zero' => '0'),
			'tax',
			array('key' => 'tax_price' , 'type' => 'number' , 'zero' => '0'),
			array('key' => 'qty' , 'type' => 'number' , 'zero' => '0'),
			array('key' => 'sum' , 'type' => 'number' , 'zero' => '0'),
			'arrive_date'

		);


		$dltSameList = ['ddh','status','date','maker','vendor_code','vendor_name'];
		$dltSameKey = 'ddh';
		$dltSame = ['key' => $dltSameKey,'list' => $dltSameList];


		$tbody = tbody($r,$structure,is_set($post,'merge')?$dltSame:[] );
		$result = [ 'tbody' => $tbody , 'page' => $page ];


		

		return a($result,'','s');
	}

	public function export($post){
		$post['page'] = 1;
		$post['n'] = 10000000;
		$data = $this->getSearchData($post)['r'];
		$excel = array(
			'ddh' => '表单号',
			'status' => '状态',
			'date' => '日期',
			'maker' => '制单人',
			'vendor_code' => '供应商编码',
			'vendor_name' => '供应商名称',
			'inventory_code' => '物料编码',
			'inventory_name' => '物料名称',
			'inventory_std' => '规格型号',
			'price' => '单价',
			'tax' => '税率',
			'tax_price' => '含税价',
			'qty' => '数量',
			'sum' => '价税合计',
			'arrive_date' => '交货期'
		);
		$pG = new PublicGet();
		$r = $pG->excel($excel,$data);
		return a($r);
	}


	public function getSearchData($post){
		
		$w = " 1 = 1 ";
		if(is_set($post,'option_ddh')){
			$w .= " &&  b.ddh = '".sprintf('%08d',$post['option_ddh'])."' ";
		}
		if(is_set($post,'option_vendor_code')){
			$w .= " && b.vendor_code = '".$post['option_vendor_code']."' ";
		}
		if(is_set($post,'option_inventory_code')){
			$w .= " && a.inventory_code = '".$post['option_inventory_code']."' ";
		}
		$totle = Db::table('s_po_list')->alias('a')->join('s_po b','a.id = b.id')->where($w)->count();
			
		$page['totles'] = $totle;     //总记录数 返回
		$page['totle_page'] = ceil($totle / $post['n']);  //总页数 返回
		$page['n'] = $post['n'];
		$page['current_page'] = $post['page'];     //当前页 返回	

		$r = Db::table('s_po_list')->alias('a')->join('s_po b','a.id = b.id')->join('s_inventory i','a.inventory_code = i.code')->join('s_vendor v','b.vendor_code = v.code')->join('s_unit u','i.unit_id = u.id')->field('b.ddh,b.date,b.maker,b.status,b.flow_id,i.code inventory_code,i.name inventory_name,i.std inventory_std,v.code vendor_code,v.name vendor_name,a.price,a.tax,a.tax_price,a.qty,a.arrive_date,a.sum,u.name unit_name')->where($w)->page($post['page'],$post['n'])->order('a.id desc,a.listid asc')->select()->toArray();
		
		return array(
			'r' => $r,
			'page' => $page
		);
	}




	public function resourcePoToPoArriveSearch($post){

		
		$w = " a.arrive_qty < a.qty && b.status = 9";
		
		if(is_set($post,'vendor_code')){
			$w .= " && b.vendor_code = '".$post['vendor_code']."' ";
		}
		
		$totle = Db::table('s_po_list')->alias('a')->join('s_po b','a.id = b.id')->where($w)->field('distinct(b.id) n')->select();
		if($totle){
			$totle = count($totle->toArray());
		}else{
			$totle = 0;
		}
		
			
		$page['totles'] = $totle;     //总记录数 返回
		$page['totle_page'] = ceil($totle / $post['n']);  //总页数 返回
		$page['n'] = $post['n'];
		$page['current_page'] = $post['page'];     //当前页 返回

		$tbody = '';

		if($totle > 0){
			$r = Db::query("select p.id, p.ddh,v.code vendor_code,v.name vendor_name,p.date,v.maker from s_po p join s_vendor v on p.vendor_code = v.code where p.id in (select distinct(a.id) from s_po_list a join s_po b on a.id = b.id where $w) order by p.id desc limit ".($page['n'] * ($page['current_page']-1) ).",".$page['n']);

			foreach($r as $k => $v){
				$tbody .= "<tr data-id = ".$v['id']." ><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td>".$v['ddh']."</td><td>".$v['date']."</td><td>".$v['vendor_code']."</td><td>".$v['vendor_name']."</td><td>".$v['maker']."</td></tr>";
			}
		}

		return a(['tbody' => $tbody,'page' => $page ],'','s');
				
	}

	public function resourcePoToPoArriveDetail($post){
		$id = $post['id'];
		$resource = json_decode($post['resource'],true);
		$r = Db::table('s_po_list')->alias('a')->join('s_inventory i','a.inventory_code = i.code')->join('s_unit u','i.unit_id = u.id')->join('s_po p ','a.id = p.id')->where('a.id = '.$id)->field('a.arrive_qty,a.arrive_date,a.listid,p.ddh,i.code inventory_code,i.name inventory_name,i.std inventory_std,u.name unit_name,a.qty')->select();
		
		$tbody = '';
		if($r){
			$checkbox = $class = "";
			foreach($r as $k => $v){
				
				if(in_array($v['listid'],$resource)){
					$checkbox = "-";
					$class = "no_select_tr";
				}else{
					$checkbox = "<input type = 'checkbox' class = 'aya-checkbox' />";
					$class = "";
				}
				$tbody .= "<tr class = '$class id".$id."' data-listid = ".$v['listid']."><td>".$checkbox."</td><td>".$v['ddh']."</td><td>".$v['inventory_code']."</td><td>".$v['inventory_name']."</td><td>".$v['inventory_std']."</td><td>".$v['unit_name']."</td><td>".($v['qty']*1)."</td><td>".($v['qty'] - $v['arrive_qty'])."</td><td>".$v['arrive_date']."</td></tr>";
			}
		}

		
		return a($tbody,'','s');

	}



}
