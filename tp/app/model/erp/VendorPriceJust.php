<?php
namespace app\model\erp;
use think\Model;
use think\facade\Session;
use think\facade\Db;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;
use app\model\erp\ErpConfig;
use app\controller\Fs;

class VendorPriceJust extends Model{


	protected $type = 'vendor_price_just_flow';
  
	protected $schema = [
		'id'	=> 'int',
		'maker' => 'varchar',
		'maker_number' => 'varchar',
		'create_datetime' => 'datetime',
		'modify_datetime' => 'datetime',
		'status' => 'int',
		'ddh' => 'varchar',
		'remark' => 'varchar',
		'flow_id' => 'int',
		'date' => 'date'
	];

	public function get($post){
		$main = $this::where("ddh = '".$post['ddh']."'")->find();
		if(!$main) return a('','表单不存在','e');
		$list = Db::table('s_vendor_price_just_list')->alias('a')->join('s_vendor v','a.vendor_code = v.code')->join('s_inventory i','a.inventory_code = i.code')->join('s_unit u','i.unit_id = u.id')->where('a.id = '.$main->id)->field('a.listid,a.vendor_code,v.name vendor_name,a.inventory_code,i.name inventory_name,i.std inventory_std,u.name inventory_unit,a.price,a.tax,a.tax_price,a.origin_price,a.origin_tax_price	')->select()->toArray();
		$zero = ['price','tax_price','origin_price','origin_tax_price'];
		return a($this->dlt_zero($list,$zero),$main->toArray(),'s');
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

	public function canModify($post){
		$ddh = json_decode($post['ddh'],true);
		$r = $this::where("ddh in (".get_w($ddh).")")->field('id,ddh,status,maker_number')->select()->toArray();
		if(count($ddh) != count($r)) return a('','表单不存在','e');

		if($post['type'] == 'dlt'){

			$dltMyself = Db::table('s_erp_config')->where("type = 'vendor_price_just_only_dlt_myself' && value = 1")->field('id')->find();

			if($dltMyself){
				$userinfo = Session::get('userinfo');
				foreach($r as $k => $v){
					if( $v['maker_number'] != $userinfo['username'] ) return a('',"表单（ ".$v['ddh']." ），非制单人不能删除",'e');
				}
			}

			foreach($r as $k => $v){
				if( $v['status'] >= 9 ) return a('',"表单（ ".$v['ddh']." ）已审核，不能删除",'e');
			}

		}else if($post['type'] == 'check'){
			foreach($r as $k => $v){
				if( $v['status'] >= 9 ) return a('',"表单（ ".$v['ddh']." ）已审核完毕",'e');
			}
		}

		return a('','','s');

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
			'remark' => trim($post['remark'])
		);
		
		Db::startTrans();
		try {

			$r = array();

			$id = $this::insertGetId($main);
			$ddh = sprintf('%08d',$id);
			Db::table('s_vendor_price_just')->where('id = '.$id)->update(array('ddh' => $ddh));
			$validata = $this->validate(json_decode($post['data'],true),$id);
			if(!$validata['ok']) throw new \Exception($validata['msg']);
			$data = $validata['data'];

			if(count($data) == 0) throw new \Exception("表体数据不能为空"); 
			Db::table('s_vendor_price_just_list')->insertAll($data);
			
			$isFlow = Db::table('s_erp_config')->where("type = '".$this->type."' && value = 1 ")->field('id')->find();
			
			if($isFlow){
				$fs = new Fs();
				$tmp = $fs->send($this->type);
				$r = json_decode( $tmp->getContent(),true );
				$status = json_decode( $tmp->getContent(),true )['status'];
				if($r['status'] != 's')  throw new \Exception;
				Db::table('s_vendor_price_just')->where('id = '.$id)->update(['flow_id' => $r['data']]);

			}

			Db::commit();
		} catch (\Exception $e) {
			Db::rollback();
			if(count($r) == 0){
				return a('',$e->getMessage(),'e');
			}else{
				if($r['status'] == 'e') return a('','审核流程：<br />'.$r['info'],'e');
			}
			
		}

		return a($ddh,'','s');
		
	}


	public function dltBill($post){
		$ddh = json_decode($post['ddh'],true);
		$r = $this::where("ddh in (".get_w($ddh).")")->field('id,flow_id')->select()->toArray();
		$id = $flowId = array();
		foreach($r as $k => $v){
			$id[] = $v['id'];
			if($v['flow_id']) $flowId[] = $v['flow_id'];
		}
		if(count($id) > 0){
			$ids = get_w($id,false);
			Db::table('s_vendor_price_just')->where(" id in ( $ids ) ")->delete();
			Db::table('s_vendor_price_just_list')->where(" id in ( $ids ) ")->delete();
		}
		if(count($flowId) > 0){
			$fs = new Fs();
			$fs->cancel_do2($flowId);
		}
		return a();
	}


	public function checkBill($post){
		$result = array();
		$ddh = json_decode($post['ddh'],true);
		foreach($ddh as $k => $v){
			 
			$r = $this->checkBillDo($v);
			if($r['ok'] === true){
				$result[$v] = $r['status'];
			}else{

				if($r['ok'] === false)  return a('',$r['msg'],'e');
			
				if($r['ok'] === 'm')    return a($r['data'],'','m');

				//return a('',$r['msg'],'e');
			}
		}

		return a($result,'','s');

		
	}

	public function checkBillDo($ddh){
		$bill = $this::where("ddh = '$ddh'")->field('flow_id,id,ddh')->find();
		if($bill['flow_id']){
			$userinfo = Session::get('userinfo');
			$r = Db::table('s_flows_executor')->where("flow_id = ".$bill['flow_id']." && number = '".$userinfo['username']."'")->field('id,flow_id,node_id,status')->find();
			if(!$r) return array( 'ok' => false , 'msg' => '审核错误' );

			$fs = new Fs;
			$handleData = array(
				'flowId' => $r['flow_id'],
				'nodeId' => $r['node_id'],
				'executeId' => $r['id'],
				'executor' => isset($_POST['executor'])?$_POST['executor']:'',
				'add' => isset($_POST['add'])?$_POST['add']:array(),
				'opinion' => '',
				'field' => []
			);

			//$r = $fs->handle( $handleData );

			$r = array('ok' => true,'status' => 9);

			if($r['ok'] !== true) return $r;

			$bill->status = $r['status'];
			
			
		}else{
			$bill->status = 9;
		}

		//$bill->save();

		return array( 'ok' => true , 'status' => $bill->status );
	}


	private function validate($postData,$id){
		$data = array();
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
		}
		return array('ok' => true,'data' => $data);
	}


	





}
