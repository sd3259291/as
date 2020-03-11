<?php
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;

use think\facade\Cache;

use app\model\Enum;

class Basic extends BaseController{

	/**
     * 枚举首页
    */
    public function enum(){
		
		$enum = new Enum;
		$tree = $enum->tree();
		View::assign('tree',$tree);
		return View::fetch();
	}
	/**
     * 用户管理
    */
	public function addEnum(){
		
		$enum = new Enum;
		if(!$_POST['enum_type_pid']) $_POST['enum_type_pid'] = 0;
		if($_POST['enum_type_name'] == '') return a('','枚举类别 名称不能为空','e');

		$enum->pid = $_POST['enum_type_pid'];
		$enum->name = $_POST['enum_type_name'];
		$enum->sort = $_POST['enum_type_sort']?$_POST['enum_type_sort']:0;
		$enum->has_detail = 0;
		$enum->save();
		
		return a($enum->toArray(),'','s');



	}
	


	
	
}
