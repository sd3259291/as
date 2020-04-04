<?php
namespace app\model;

use think\Model;

class Layout extends Model{
  
	protected $schema = [
		'id' => 'int',
		'level' => 'int',
		'name' => 'varchar',
		'url' => 'varchar',
		'pid' => 'int',
		'sort' => 'int',
		'node_id' => 'int',
		'newwindow' => 'int',
		'icon' => 'varchar',
		'hidenav' => 'int',
		'public' => 'int'

	];

	public function tree($hasSort = true,$json = true){

		$r = $this->order('level asc,sort asc,id asc')->select();

		if(!$r) json_encode(array('name' => '无节点，请创建目录' , 'level' => '0'));
		
		$r = $r->toArray();

		$pid = array();

		$img_url = img_url();

		foreach($r as $k => $v){
			if($v['level'] == 1){

				$list[$v['id']] = array('public' => $v['public'],'name' => $v['name'].($hasSort?' - '.$v['sort']:''),'title' => $v['level'],'layout_id' =>$v['id'],'true_name' => $v['name'] , 'u' => $v['url'] , 'sort' => $v['sort'],'icon' => $img_url.'/tree_level_1.png','i' => $v['icon']);

			}else if($v['level'] == 2){

				$list[$v['pid']]['children'][$v['id']] = array('public' => $v['public'],'name' => $v['name'].($hasSort?' - '.$v['sort']:''),'title' => $v['level'],'layout_id' =>$v['id'],'true_name' => $v['name'],'u' => $v['url'],'sort' => $v['sort'],'icon' => $img_url.'/tree_level_2.png','i' => $v['icon']);

				$pid[$v['id']] = $v['pid'];

			}
		}
		
		$list = array_values($list);
		foreach($list as $k => $v){
			if(isset($v['children'])) $list[$k]['children'] = array_values($v['children']);
		}

		
		return json_encode($list);
	}

}
