<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;
use app\model\erp\Inventory;

class InventoryValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'code' => 'require|checkCode',
		'name'  =>  'require|checkName',
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '物料名称不能为空',
		'code.require' => '物料编码不能为空'
	];

	protected function checkName($value,$a,$b){
		if(isset($b['id'])){
			$r = Inventory::where("id != ".$b['id']." && name = '".trim($value)."' && std = '".trim($b['std'])."'")->field('id')->find();
		}else{
			$r = Inventory::where("name = '".trim($value)."' && std = '".trim($b['std'])."'")->field('id')->find();
		}
		return $r?'相同物料名称、规格型号的物料已存在':true;
	}

	protected function checkCode($value,$a,$b){
		if(isset($b['id'])){
			$r = Inventory::where("id != ".$b['id']." && code = '".trim($value)."'")->field('id')->find();
		}else{
			$r = Inventory::where("code = '".trim($value)."'")->field('id')->find();
		}
		return $r?'存货编码已存在':true;
	}
}
