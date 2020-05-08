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

	public function getVendor($post){
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
		$tbody = "";
		foreach($r as $k => $v){
			$tbody .= "<tr><td><a>".$v['code']."</a></td><td>".$v['name']."</td><td>".$v['contact']."</td><td>".$v['phone']."</td><td>".$v['email']."</td><td>".$v['tel']."</td><td>".$v['fax']."</td></tr>";
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
