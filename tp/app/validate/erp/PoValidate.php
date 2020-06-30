<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;

class PoValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'vendor_code'  =>  'require',
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'vendor_code.require' => '供应商不能为空',
	];


}
