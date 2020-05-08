<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;
use app\model\erp\Customer;

class CustomerValidate extends Validate
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
		'name.require' => '客户名称不能为空',
		'code.require' => '客户编码不能为空'
	];

	protected function checkName($value,$a,$b){
		if(isset($b['id'])){
			$r = Customer::where("id != ".$b['id']." && name = '".trim($value)."'")->field('id')->find();
		}else{
			$r = Customer::where("name = '".trim($value)."'")->field('id')->find();
		}
		return $r?'客户（'.$value.'）已存在':true;
	}

	protected function checkCode($value,$a,$b){
		if(isset($b['id'])){
			$r = Customer::where("id != ".$b['id']." && code = '".trim($value)."'")->field('id')->find();
		}else{
			$r = Customer::where("code = '".trim($value)."'")->field('id')->find();
		}
		return $r?'客户编码（'.$value.'）已存在':true;
	}
}
