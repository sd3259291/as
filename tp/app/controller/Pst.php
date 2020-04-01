<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;

use think\facade\Cache;

use app\model\Enum;
use app\model\EnumDetail;
use app\model\Post;

class Pst extends BaseController{
	/**
     * 岗位管理首页
     */
    public function index(){
		
		$lastPost = Post::order('id desc')->field('id')->find();
		$sortMax = $lastPost?$lastPost->id:0;

		$enum = Enum::where(" name = '岗位类型' ")->find();

		View::assign('list',Post::order('sort asc')->field('id,name,type_name,sort,status')->select());
		View::assign('post_type',EnumDetail::where('enum_id ='.$enum->id)->select());
		View::assign('sortmax',$sortMax);
		return View::fetch();
	}

	/**
     * 增加岗位
     */
	public function addPst(){
	
		if(!$_POST['name_new']) return a('','岗位名称不能为空','e');
		
		$type_name = EnumDetail::find($_POST['type_id_new']);

		$_POST['sort_new'] = (int)$_POST['sort_new'];
		$p = new Post;
		$p->name = $_POST['name_new'];
		$p->sort = $_POST['sort_new'];
		$p->type_id   = $_POST['type_id_new'];
		$p->type_name = $type_name->name;

		$p->save();
		
		$tbody = "<tr><td>".$p->name."</td><td>".$p->type_name."</td><td>".$p->sort."</td><td>启用</td></tr>";
		return a($tbody,$p->id,'s');

	}

	/**
     * 编辑岗位
     */

	public function editPst(){
		
		if(!$_POST['name']) return a('','岗位名称不能为空','e');
		$type_name = EnumDetail::find($_POST['type_id']);
		$_POST['sort'] = (int)$_POST['sort'];
		$post = Post::find($_POST['id']);
	
		$post->name = $_POST['name'];
		$post->sort = $_POST['sort'];
		$post->type_id = $_POST['type_id'];
		$post->type_name = $type_name->name;
		$post->status = $_POST['status'];

		$post->save();

		return a($post,'','s');

	}
	
	/**
     * 删除岗位
     */
	public function dltPst(){
		

		
	}
	
}
