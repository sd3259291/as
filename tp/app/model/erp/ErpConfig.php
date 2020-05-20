<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;

class ErpConfig extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'type'	=> 'varchar',
		'value'	=> 'varchar',
	];
	

	public function setConfig($post){
		$e = $this::where("type = '".$post['type']."'")->find();
		if(!$e) $e = $this::create(['type' => $post['type']]);
		$e->value = $post['value'];
		$e->save();
		return a('','','s');
	}

	public function getAllConfig(){
		$e = $this::field('type,value')->select()->toArray();
		$tmp = [];
		foreach($e as $k => $v){
			$tmp[$v['type']] = $v['value'];
		}
		return $tmp;
	}
	


}
