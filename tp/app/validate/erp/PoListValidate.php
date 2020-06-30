<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;

class PoListValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'inventory_code'  =>  'require',
		'price' => 'float|gt:0',
		'qty' => 'float|gt:0',
		'arrive_date' => 'require'
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'inventory_code.require' => '物料编码不能为空',
		'price.float' => '采购单价必须为数字',
		'price.gt' => '采购单价必须大于 0',
		'arrive_date.require' => '到货日期不能为空',
		'qty.float' => '采购数量必须为数字',
		'qty.gt' => '采购数量必须大于 0',
	];

	


}
