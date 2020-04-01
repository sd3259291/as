<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;
use app\model\Employee;
use app\model\DepartmentAttr;

use think\facade\Cache;

class Dept extends BaseController{

    public function index(){
		$dept = new Department;
		$tree = $dept->tree();
		View::assign('tree',$tree);
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

		$r = Employee::where("department_id = $id")->find();

		if($r) return a('','部门员工数不为0，不能删除','e');

		// 检查有没有下级部门

		$child_dept = Department::where('pid = '.$id)->find();

		if($child_dept) return a('','存在子部门，不能删除','e');
		
		Department::destroy($id);

		return a('','','s');	
	}

	public function editDept(){
		
		$dept = Department::find($_POST['id']);
		if(!$_POST['name']) return a('','部门名称不能为空','e');
		$dept->name = $_POST['name'];
		$dept->sort = (int)$_POST['sort'];
		$dept->status = $_POST['status'];
	

		if(!$_POST['status']){
			$r = Employee::where("department_id = ".$_POST['id'])->find();
			if($r) return a('','部门员工数不为0，不能禁用','e');
		}
		$dept->save();
		$tmp = array();
		if($_POST['fgld']){
			$fgld = explode(',',substr($_POST['fgld'],0,-1));
			$fgld_name = explode(',',substr($_POST['fgld_name'],0,-1));
			foreach($fgld as $k => $v){
				$tmp[] = array( 
					'department_id' => $_POST['id'],
					'type' => 2,
					'key' => $v,
					'value' => $fgld_name[$k]
				);
			}
		}
		if($_POST['bmzg']){
			$bmzg = explode(',',substr($_POST['bmzg'],0,-1));
			$bmzg_name = explode(',',substr($_POST['bmzg_name'],0,-1));
			foreach($bmzg as $k => $v){
				$tmp[] = array( 
					'department_id' => $_POST['id'],
					'type' => 1,
					'key' => $v,
					'value' => $bmzg_name[$k]
				);
			}
		}
		$departmentAttr = new DepartmentAttr;
		$departmentAttr->where("department_id = ".$_POST['id']." && type <= 2")->delete();
		if(count($tmp) > 0){
			$departmentAttr->saveAll($tmp);
		}

		return a('','','s');
	}

	public function info(){
		
		$department = Department::find($_POST['id'])->toArray();
		$attr = DepartmentAttr::where("department_id = ".$_POST['id']." && type <= 2")->select();
		$department['fgld'] = $department['fgld_name'] = $department['bmzg'] = $department['bmzg_name'] = '';
		foreach($attr as $k => $v){
			if($v['type'] == 1){
				$department['bmzg'] .= $v['key'].',';
				$department['bmzg_name'] .= $v['value'].',';
			}else if($v['type'] == 2){
				$department['fgld'] .= $v['key'].',';
				$department['fgld_name'] .= $v['value'].',';
			}
		}
		
		return a($department,'','s');

	}
	
}
