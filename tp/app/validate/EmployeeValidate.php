<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

use think\facade\Db;

class EmployeeValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name'  =>  'require',
		'idcard'  =>  'require|number|checcIdcard',
		'idcard_date'  =>  'require',
		'number'  =>  'require|checkNumber',
		'tel'  =>  'require',
		'emergency_contact'  =>  'require',
		'emergency_contact_tel'  =>  'require',
		'addr1'  =>  'require',
		'addr2'  =>  'require',
		'entry_date' => 'require'
		
		
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '姓名 不能为空',
		'idcard.require' => '身份证号 不能为空',
		'idcard.number' => '身份证号 格式错误',
		'idcard_idcard.require' => '身份证过期时间 不能为空',
		'number.require' => '工号 不能为空',
		'tel.require' => '电话 不能为空',
		'emergency_contact.require' => '紧急联系人 不能为空',
		'emergency_contact_tel.require' => '紧急联系人电话 不能为空',
		'addr1.require' => '家庭住址 不能为空',
		'addr2.require' => '现地址 不能为空',
		'entry_date.require' => '入职日期 不能为空',
		'idcard_date.require' => '身份证过期日期 不能为空',
	];


	protected function checcIdcard($value, $rule, $data=[])
    {
		return strlen($value) == 18?true:'身份证号 长度错误';
    }

	protected function checkNumber($value,$rule,$data=[]){
		if(is_set($data,'id')){
			$r = Db::table('s_employee')->where("number = '$value' && id != ".$data['id'])->find();
			return $r?'工号重复':true;
		}else{
			$r = Db::table('s_employee')->where("number = '$value'")->find();
			return $r?'工号重复':true;
		}
		
	}
}
