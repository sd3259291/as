<?php
namespace app\model;

use think\Model;

class Department extends Model{
  
	protected $schema = [
		'id' => 'int',
		'name' => 'varchar',
		'pid' => 'int',
		'status' => 'int',
		'level' => 'int',
		'sort' => 'int'

	];

	public function tree($all = true ){
		if($all){
			$r = $this->order('level asc,sort asc,id asc')->select()->toArray();
		}else{
			$r = $this->where('status = 1')->order('level asc,sort asc,id asc')->select()->toArray();
		}
		
	
		if(!$r) return json_encode(array());

		//'icon' => $img_url.'/tree_level_1.png'ztree_department

		$img_url = img_url();

		$attr = $first_level = $pid = array();
		foreach($r as $k => $v){
			$attr[$v['id']] = $v;
			$attr[$v['id']]['icon'] = $v['icon'] == 1?$img_url.'/ztree_company.png':$img_url.'/ztree_department.png';
			if(!$v['status']){
				 $attr[$v['id']]['name1'] = $v['name']."（禁用）";
			}else{
				 $attr[$v['id']]['name1'] = $v['name'];
			}
			if($v['pid'] == 0){
				$first_level[] = $v['id'];
			}else{
				$pid[$v['pid']][] = $v['id'];
			}
			
		}


		// k => v ,k 为 ztree 上的属性 , v 为 数据库中的属性。两者的对应关系
		$key = array(
			'name' => 'name1',
			'id' => 'id',
			'title' => 'level',
			'icon' => 'icon',
			'sort' => 'sort',
			'status' => 'status',
			'truename' => 'name'
		);
		$tree = $this->create_tree($attr,$pid,$first_level,$key);
		return json_encode($tree);
	}

	public function create_tree($attr,$pid,$ids,$key){
		$r = array();
		foreach($ids as $k => $v){
			$tmp = array();
			foreach($key as $k1 => $v1){
				$tmp[$k1] = $attr[$v][$v1];
			}
			if(isset($pid[$v])){
				$tmp['children'] = $this->create_tree($attr,$pid,$pid[$v],$key); 
			}
			$r[] = $tmp;
		}
		return $r;
	}

	public function mySelect(){
		$r = $this->where('status = 1')->order('level asc,sort asc,id asc')->select();
		if(!$r) return json_encode(array());
		return $r;
	}

	public function get_children_department($id){
		$r = column($this->select(),'id');
		$r1 = $this->get_children($r,$id);	
		$r1 = array_merge($r1,array($id));
		return $r1;
	}

	public function get_children($data,$id){
		$r = array();
		foreach($data as $k => $v){
			if($v['pid'] == $id){
				$r[] = $v['id'];
				$tmp = $this->get_children($data,$v['id']);
				$r = array_merge($r,$tmp);
			}
		}
		return $r;
	}

}