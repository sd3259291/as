<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;
use think\facade\Db;

use app\model\Department;

use think\facade\Cache;

class PublicGet extends BaseController{
	
	/**
     * 根据部门 id 返回人员名单
     */
    public function get_employee_by_dept_id(){
		$department = new Department;
		$id = $department->get_children_department($_POST['dep_id']);
		$r = Db::table('s_employee')->alias('e')->join('s_department b','b.id = e.department_id')->join('s_post c','e.post_id = c.id')->where("e.department_id in (".get_w($id,false).")")->field('e.number,e.name,e.sex,b.name  dname,c.name pname,e.entry_date')->select()->toArray();
		return a($r,'','s');
		

	}


	
	
}
