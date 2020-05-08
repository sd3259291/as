<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;
use app\model\erp\Vendor;

class VendorValidate extends Validate
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
		'name.require' => '供应商名称不能为空',
		'code.require' => '供应商编码不能为空'
	];

	protected function checkName($value,$a,$b){
		if(isset($b['id'])){
			$r = Vendor::where("id != ".$b['id']." && name = '".trim($value)."'")->field('id')->find();
		}else{
			$r = Vendor::where("name = '".trim($value)."'")->field('id')->find();
		}
		return $r?'供应商（'.$value.'）已存在':true;
	}

	protected function checkCode($value,$a,$b){
		if(isset($b['id'])){
			$r = Vendor::where("id != ".$b['id']." && code = '".trim($value)."'")->field('id')->find();
		}else{
			$r = Vendor::where("code = '".trim($value)."'")->field('id')->find();
		}
		return $r?'供应商编码（'.$value.'）已存在':true;
	}
}
