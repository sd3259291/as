<?php
declare(strict_types=1);
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Db;
use app\model\Department;
use app\model\Post;
use app\model\Employee;

class S extends BaseController
{
	/**
     * 员工列表
     */
	public function select_employee(){
		$post = new Post;
		$dept = new Department;
		$tree = $dept->tree();
		View::assign('tree',$tree);
		View::assign('department',$dept->mySelect());
		View::assign('post',$post->mySelect());
		return View::fetch();
	}

	public function select_employee_get(){
		$department = new Department;
		$id = $department->get_children_department($_POST['id']);
		$r = Db::table('s_employee')->alias('e')->join('s_department b','b.id = e.department_id')->join('s_post c','e.post_id = c.id')->where("e.department_id in (".get_w($id,false).")")->field('e.id,e.number,e.name,e.sex,b.name  dname,c.name pname,e.entry_date')->select()->toArray();

		return a($r,'','s');
	}

	

  


	
}
