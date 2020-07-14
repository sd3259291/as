<?php
namespace app\model\erp;
use think\facade\Db;
use think\Model;
use app\validate\erp\InventoryValidate;
use think\exception\ValidateException;

class Inventory extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'code' => 'varchar',
		'name'	=> 'varchar',
		'std' => 'varchar',
		'self' => 'tinyint',
		'unit_id' => 'int',
		'basic_class_id' => 'int',
		'end_date' => 'date',
		'create_date' => 'date',
		'maker' =>'varchar',
		'is_qc' => 'tinyint'
	];

	public function tree(){
		
	}

	public function insert($post){
		try {
			validate(InventoryValidate::class)->check($post);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		$post['create_date'] = date('Y-m-d H:i:s',time());
		$post['maker'] = session()['userinfo']['name'];
		$r = Inventory::create($post);
		return a();
	}

	public function getInventory($post){
		$tbody = "";
		if($post['searchType'] == 3){  // hint 页面
			$r = Db::table('s_inventory')->alias('i')->join(['s_unit' => 'u'],'i.unit_id = u.id')->join(['s_basic_class' => 'b'],'i.basic_class_id = b.id')->where("i.name like '%".$post['name']."%' || i.code like '%".$post['code']."%'")->field('i.code,i.name,i.std,i.self,u.name unit,b.name basicClassName')->order('i.code asc')->limit(10)->select()->toArray();
			foreach($r as $k => $v){
				$tbody .= "<tr><td class = 'code'>".$v['code']."</td><td class = 'name'>".$v['name']."</td><td class = 'std'>".$v['std']."</td><td class = 'unit'>".$v['unit']."</td></tr>";
			}
			return a($tbody,$r?$r:array(),'s');
		}
		$w = " 1 = 1 ";
		if(is_set($post,'basicClassId')) $w .= " && i.basic_class_id = ".$post['basicClassId'];
		if(is_set($post,'name')) $w .= " && i.name like '%".$post['name']."%'";
		if(is_set($post,'code')) $w .= " && i.code like '%".$post['code']."%'";
		if(is_set($post,'std')) $w .= " && i.std like '%".$post['std']."%'";
		if(isset($post['self']) && $post['self'] != '') $w .= " && i.self = ".$post['self'];
		$r = Db::query("select count(1) n from s_inventory i where $w");
		$page = array();
        $page['totles'] = $r[0]['n'];     //总记录数 返回
        $page['totle_page'] = ceil($r[0]['n'] / $post['n']);  //总页数 返回
        $page['n'] = $post['n'];
        $page['current_page'] = $post['page'];     //当前页 返回	
		$r = Db::table('s_inventory')->alias('i')->join(['s_unit' => 'u'],'i.unit_id = u.id')->join(['s_basic_class' => 'b'],'i.basic_class_id = b.id')->where($w)->field('i.code,i.name,i.std,i.self,u.name unitName,b.name basicClassName')->order('i.code asc')->page($post['page'],$post['n'])->select()->toArray();
		
		if($post['searchType'] == 1){// 基础资料 - 存货档案页面
			foreach($r as $k => $v){
				$tbody .= "<tr><td><a>".$v['code']."</a></td><td>".$v['name']."</td><td>".$v['std']."</td><td>".$v['unitName']."</td><td>".$v['basicClassName']."</td><td>".($v['self']?'√':'')."</td></tr>";
			}
		}else if($post['searchType'] == 2){
			foreach($r as $k => $v){
				$tbody .= "<tr><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td>".$v['code']."</td><td>".$v['name']."</td><td>".$v['std']."</td><td>".$v['unitName']."</td><td>".($v['self']?'√':'')."</td></tr>";
			}
		}
		
		return a(array('tbody' => $tbody,'page' => $page));
	}

	public function getInventoryByCode($get){
		return $this::where(" code = '".$get['code']."' ")->find();
	}
	

	public function edit($post){
		// 需增加是否能够修改计量单位的判断，等表单做好以后再做
		// isUsed
		try {
			validate(InventoryValidate::class)->check($post);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		$this::update($post);
		return a();
	}

	public function dlt($post){
		// 许增加是否能够删除的判断，等表单做好以后再做
		// isUsed
		$this::where("code = '".$post['code']."'")->delete();
		return a();
	}


}
