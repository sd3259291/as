<?php
namespace app\model;

use think\Model;

class Node extends Model{
  
	protected $schema = [
		'id'          => 'int',
		'name'        => 'varchar',
		'action'      => 'varchar',
		'status'      => 'tinyint',
		'remark' => 'varchar',
		'sort' => 'int',
		'pid' => 'int',
		'remark'  => 'varchar',
		'level' => 'tinyint',
		'isdataauth' => 'tinyint'
	];

	public function tree($hasSort = true,$json = true){

		$r = $this->order('level asc,sort asc,id asc')->select();

		if(!$r) json_encode(array('name' => '无节点，请创建新节点' , 'level' => '0'));
		
		$r = $r->toArray();

		$pid = array();

		

		foreach($r as $k => $v){
			if($v['level'] == 1){
				$list[$v['id']] = array('name' => $v['name'].' - '.$v['action'].($hasSort?' - '.$v['sort']:''),'title' => $v['level'],'node_id' =>$v['id'],'true_name' => $v['name'],'action' => $v['action'],'sort' => $v['sort'],'icon' => 'tp/view/public/image/tree_level_1.png');
			}else if($v['level'] == 2){
				$list[$v['pid']]['children'][$v['id']] = array('name' => $v['name'].' - '.$v['action'].($hasSort?' - '.$v['sort']:''),'title' => $v['level'],'node_id' =>$v['id'],'true_name' => $v['name'],'action' => $v['action'],'sort' => $v['sort'],'icon' => 'tp/view/public/image/tree_level_2.png');
				$pid[$v['id']] = $v['pid'];
			}else{
				$list[$pid[$v['pid']]]['children'][$v['pid']]['children'][$v['id']] = array('name' => $v['name'].' - '.$v['action'].($hasSort?' - '.$v['sort']:''),'title' => $v['level'],'node_id' =>$v['id'],'true_name' => $v['name'],'action' => $v['action'],'sort' => $v['sort'] );
			}
		}
		

		$list = array_values($list);
		foreach($list as $k => $v){
			if(isset($v['children'])) $list[$k]['children'] = array_values($v['children']);
		}
		foreach($list as $k => $v){
			if(isset($v['children'])){
				foreach($v['children'] as $k1 => $v1){
					if(isset($v1['children'])){
						$list[$k]['children'][$k1]['children'] = array_values($v1['children']);
					}
				}
			}
			
		}
		
		return json_encode($list);
	}

	

	


}
