<?php
namespace app\model\erp;
use think\Model;
use think\facade\Session;


class ErpOption extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'username'	=> 'varchar',
		'title' => 'varchar',
		'name'	=> 'varchar',
		'option' => 'text',
		'dft' => 'tinyint'
	];
	
	public function setOption($post){

		//$option = $this::where('id = 1')->find();
		
		//$option->title = 'afsfasf';

		//return a($option,'update','s');

		$w = [
			'username' => Session::get('userinfo')['username'],
			'title' => $post['title'],
			'name' => $post['name']
		];
		$option = $this::where($w)->find();
		if($option){
			$option->option = $post['option'];
			$option->save();
			return a($option,'update','s');
		}else{
			$w['option'] = $post['option'];
			$option = $this::create($w);
			return a($option,'insert','s');
		}
		
	}

	public function getOptions($post){
		$w = [
			'username' => Session::get('userinfo')['username'],
			'name' => $post['name']
		];
		$options = $this::where($w)->select();
		return a($options,'','s');
	}

	public function setDefaultOption($post){
		$r = $this::field('name')->find( $post['id'] );
		if(!$r){
			if($post['id'] != ''){
				return a('','方案不存在','e');
			}else{
				$this::update( [ 'dft' => 0 ],[ 'name' => $post['name'] ] );
			}
		}else{
			$this::update( [ 'dft' => 0 ],[ 'name' => $post['name'] ] );
			$r->dft = 1;
			$r->save();
		}
		return a();
	}

	public function dltOption($post){
		$r = $this::find( $post['id'] );
		if( $r['username'] == Session::get('userinfo')['username'] ){
			$r->delete();
			return a();
		}else{
			return a('','不能删除','e');
		}
	}
	
	


}
