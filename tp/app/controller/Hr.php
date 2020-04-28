<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Session;
use app\model\Department;
use app\model\Post;
use app\model\Employee;
use app\model\EmployeeEducation;
use app\model\EmployeeWorkexperience;
use think\facade\Cache;
use app\validate\EmployeeValidate;
use think\exception\ValidateException;
use think\facade\Db;

class Hr extends BaseController{
	/**
     * 人事首页
     */
    public function index(){
		
		$post = new Post;
		$dept = new Department;
		$tree = $dept->tree(false);

	
		View::assign('tree',$tree);
		View::assign('department',$dept->mySelect());
		View::assign('post',$post->mySelect());

		
		return View::fetch();

	}
	/**
     * 增加员工
     */
	public function add(){
		$dept = new Department;
		$post = new Post;
		View::assign('department',$dept->mySelect());
		View::assign('post',$post->mySelect());
		View::assign('date',date('Y-m-d',time()));
		return View::fetch();
	}

	/**
     * 增加员工
     */
	 
	public function insert(){

		try {
			validate(EmployeeValidate::class)->check($_POST);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }

		$employee = Employee::create($_POST);
		if(isset($_POST['education']) && count($_POST['education']) > 0 ){
			$education = new EmployeeEducation;
			foreach($_POST['education'] as $k => $v){
				$_POST['education'][$k]['employee_id'] = $employee->id;
			}
			$education->saveAll($_POST['education']);
		}
		if(isset($_POST['workexperience']) && count($_POST['workexperience']) > 0){
			$workexperience = new Employeeworkexperience;
			foreach($_POST['workexperience'] as $k => $v){
				$_POST['workexperience'][$k]['employee_id'] = $employee->id;
			}
			$workexperience->saveAll($_POST['workexperience']);
		}
		return a($employee,'','s');
	}

	 /**
     * 员工信息
     */
	 public function info(){
		$number = $_GET['number'];
		$dept = new Department;
		$post = new Post;
		$employee = Employee::where("number = '$number'")->find();
		View::assign('department',$dept->select());
		View::assign('post',$post->select());
		View::assign('employee',$employee);
		View::assign('education',$employee->education);
		View::assign('workexperience',$employee->workexperience);
		return View::fetch();
	 }
	/**
     * 编辑信息
     */
	 public function edit(){
		try {
			validate(EmployeeValidate::class)->check($_POST);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		Employee::update($_POST);
		
		EmployeeEducation::where('employee_id','=',$_POST['id'])->delete();

		EmployeeWorkExperience::where('employee_id','=',$_POST['id'])->delete();

		if(isset($_POST['education']) && count($_POST['education']) > 0 ){
			$education = new EmployeeEducation;
			foreach($_POST['education'] as $k => $v){
				$_POST['education'][$k]['employee_id'] = $_POST['id'];
			}
			$education->saveAll($_POST['education']);
		}
		if(isset($_POST['workexperience']) && count($_POST['workexperience']) > 0){
			$workexperience = new Employeeworkexperience;
			foreach($_POST['workexperience'] as $k => $v){
				$_POST['workexperience'][$k]['employee_id'] = $_POST['id'];
			}
			$workexperience->saveAll($_POST['workexperience']);
		}
		return a('','','s');	
	 }

	 /**
     * 删除员工
     */
	public function dlt(){
		
		$number = $_POST['number'];
		// 一些自定义判断能否删除的代码
		Employee::where("number = '$number'")->delete();
		return a('','','s');

	}

	
	 /**
     * 搜索员工
     */
	 public function search(){
		$w = " 1 = 1 ";
		if($_POST['number']) $w .= " && e.number like '%".$_POST['number']."%' ";
		if($_POST['name']) $w .= " && e.name like '%".$_POST['name']."%' ";
		if($_POST['department_id']) $w .= " && e.department_id = ".$_POST['department_id'];
		if($_POST['post_id']) $w .= " && e.post_id = ".$_POST['post_id'];
		$r = Db::table('s_employee')->alias('e')->join('s_department b','b.id = e.department_id')->join('s_post c','e.post_id = c.id')->where($w)->field('e.number,e.name,e.sex,b.name  dname,c.name pname,e.entry_date')->select()->toArray();
		$tbody = "";
		foreach($r as $k => $v){
			$tbody .= "<tr><td>".$v['number']."</td><td><a>".$v['name']."</a></td><td>".$v['dname']."</td><td>".$v['pname']."</td><td>".($v['sex']== '1'?'男':'女')."</td><td>".$v['entry_date']."</td></tr>";
		}
		return a($tbody,count($r),'s');
	 }


	 /**
     * 获取员工列表
     */
	 public function getList(){
		$department = new Department;
		$id = $department->get_children_department($_POST['id']);
		$r = Db::table('s_employee')->alias('e')->join('s_department b','b.id = e.department_id')->join('s_post c','e.post_id = c.id')->where("e.department_id in (".get_w($id,false).")")->field('e.number,e.name,e.sex,b.name  dname,c.name pname,e.entry_date')->select()->toArray();
		$tbody = "";
		foreach($r as $k => $v){
			$tbody .= "<tr><td>".$v['number']."</td><td><a>".$v['name']."</a></td><td>".$v['dname']."</td><td>".$v['pname']."</td><td>".($v['sex']== '1'?'男':'女')."</td><td>".$v['entry_date']."</td></tr>";
		}
		return a($tbody,count($r),'s');
	 }









	
	
}
