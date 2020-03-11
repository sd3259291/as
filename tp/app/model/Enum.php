<?php
namespace app\model;

use think\Model;

class Enum extends Model{
  
	protected $schema = [
		'id' => 'int',
		'name' => 'varchar',
		'system' => 'int',
		'sort' => 'int',
		'pid' => 'int',
		'has_detail' => 'int'
	];

	public function tree(){
		
		$r = $this->order('sort asc,id asc')->select()->toArray();
		if(!$r) return json_encode(array());

		$attr = $first_level = $pid = array();

		$img_url = img_url();

		foreach($r as $k => $v){
			$attr[$v['id']] = $v;
			$attr[$v['id']]['icon'] = $v['has_detail'] == 1?$img_url.'/tree_level_1.png':$img_url.'/tree_level_2.png';
			if($v['pid'] == 0){
				$first_level[] = $v['id'];
			}else{
				$pid[$v['pid']][] = $v['id'];
			}
		}
		
		$key = array(
			'name' => 'name',
			'id' => 'id',
			'icon' => 'icon'
			
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

}
