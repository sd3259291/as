<?php
declare (strict_types = 1);

namespace app\validate\erp;

use think\Validate;
use app\model\erp\Unit;

class UnitValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name'  =>  'require|checkName',
		'sort' => 'number'
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '计量单位名称不能为空',
		'sort.number' => '排序值必须为数字'
	];

	protected function checkName($value){
		$r = Unit::where("name = '".trim($value)."'")->field('id')->find();
		return $r?'计量单位名称已存在':true;
	}
}
