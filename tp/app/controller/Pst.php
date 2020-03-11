<?php
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;

use think\facade\Cache;

class Pst extends BaseController{

    public function index(){
		
		return View::fetch();
	}


	public function addDept(){
		if(!$_POST['pid_new']){
			$_POST['pid_new'] = 0;
		}
		if(!$_POST['name_new']) return a('','部门名称不能为空','e');
		$dept = new Department;
		$dept->name = $_POST['name_new'];
		$dept->status = 1;
		$dept->sort = $_POST['sort_new']?$_POST['sort_new']:0;
		$dept->pid  = $_POST['pid_new'];
		if($_POST['pid_new'] == 0){
			$dept->level = 1;
		}else{
			$pd = Department::where('id = '.$_POST['pid_new'])->field('level')->find();
			if(!$pd) return a('','上级部门不存在','e');
			$dept->level = $pd->level + 1 ;
		}
		$dept->save();	
		return a($dept,'','s');
	}

	public function dltDept(){
		
		$id = $_POST['id'];

		// 检查部门里有没有人

		

		// 检查有没有下级部门


		$child_dept = Department::where('pid = '.$id)->find();

		if($child_dept) return a('','存在子部门，不能删除','e');


		Department::destroy($id);

		return a('','','s');

		
	}
	
}
