<?php
namespace app\model\erp;
use think\facade\Db;
use think\Model;
use app\validate\erp\VendorValidate;
use think\exception\ValidateException;

class Vendor extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'code' => 'varchar',
		'name' => 'varchar',
		'contact' => 'varchar',
		'phone' => 'varchar',
		'email' => 'varchar',
		'tel' => 'varchar',
		'fax' => 'varchar',
		'address' => 'varchar',
		'basic_class_id' => 'int',
		'end_date' => 'date',
		'create_date' => 'date',
		'maker' =>'varchar'
	];

	public function tree(){
		
	}

	public function insert($post){
		try {
			validate(VendorValidate::class)->check($post);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		$post['create_date'] = date('Y-m-d H:i:s',time());
		$post['maker'] = session()['userinfo']['name'];
		$r = Vendor::create($post);
		return a();
	}


	//SELECT d.MoRoutingDId FROM sfc_morouting h,sfc_moroutingdetail d WHERE h.MoRoutingId = d.MoRoutingId AND h.MoDId = @MoDId and d.OpSeq = @OpSeq',N'@MoDId int,@OpSeq nchar(4)',@MoDId=1000272553,@OpSeq=N'1111'

	public function getVendor($post){
		$tbody = "";
		if($post['searchType'] == 3){  // hint 页面
			$r = $this::field('code,name,contact,phone,email,tel,fax')->order('code asc')->where("name like '%".$post['name']."%' || code like '%".$post['code']."%'")->limit(10)->select();
			foreach($r as $k => $v){
				$tbody .= "<tr><td class = 'code'>".$v['code']."</td><td class = 'name'>".$v['name']."</td><td class = 'contact'>".$v['contact']."</td><td class = 'phone'>".$v['phone']."</td></tr>";
			}
			return a($tbody,$r?$r:array(),'s');
		}
		$w = " 1 = 1 ";
		if(is_set($post,'basicClassId')) $w .= " && v.basic_class_id = ".$post['basicClassId'];
		if(is_set($post,'name')) $w .= " && v.name like '%".$post['name']."%'";
		if(is_set($post,'code')) $w .= " && v.code like '%".$post['code']."%'";
		$r = Db::query("select count(1) n from s_vendor v where $w");
		$page = array();
        $page['totles'] = $r[0]['n'];     //总记录数 返回
        $page['totle_page'] = ceil($r[0]['n'] / $post['n']);  //总页数 返回
        $page['n'] = $post['n'];
        $page['current_page'] = $post['page'];     //当前页 返回
		$r = Db::table('s_vendor')->alias('v')->join(['s_basic_class' => 'b'],'v.basic_class_id = b.id')->where($w)->field('v.code,v.name,v.contact,v.phone,v.email,v.tel,v.fax')->order('v.code asc')->page($post['page'],$post['n'])->select()->toArray();
		
		if($post['searchType'] == 1){  // 基础资料 - 存货档案页面
			foreach($r as $k => $v){
				$tbody .= "<tr><td><a>".$v['code']."</a></td><td>".$v['name']."</td><td>".$v['contact']."</td><td>".$v['phone']."</td><td>".$v['email']."</td><td>".$v['tel']."</td><td>".$v['fax']."</td></tr>";
			}
		}else if($post['searchType'] == 2){  // 选择layer层页面
			foreach($r as $k => $v){
				$tbody .= "<tr><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td>".$v['code']."</td><td>".$v['name']."</td><td>".$v['contact']."</td><td>".$v['phone']."</td></tr>";
			}
		}
		return a(array('tbody' => $tbody,'page' => $page));
	}

	public function getVendorByCode($get){
		return $this::where(" code = '".$get['code']."' ")->find();
	}
	
	public function edit($post){
		try {
			validate(VendorValidate::class)->check($post);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		$this::update($post);
		return a();
	}

	public function dlt($post){
		// 许增加是否能够删除的判断，等表单做好以后再做
		$this::where("code = '".$post['code']."'")->delete();
		return a();
	}


}

