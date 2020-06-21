<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;
use think\facade\Db;
use app\model\RoleUser;
use app\model\Layout;
use app\model\Access;

class Index extends BaseController
{
    public function index()
    {	
		$list = array();
		if(Session::get('userinfo')['username'] == 'admin'){
			foreach(Layout::order('level asc,sort asc')->select()->toArray() as $k => $v){
				if($v['level'] == 1){
					$list[$v['id']] = $v;
					$list[$v['id']]['children'] = array();
				}else if($v['level'] == 2){
					$list[$v['pid']]['children'][] = $v;
				}
			}
		}else{
			$l = array();


			$role = RoleUser::where('user_id = '.Session::get('userinfo')['id'])->field('role_id')->select()->toArray();	
			$roles = '';
			foreach($role as $k => $v){
				$roles .= $v['role_id'].',';
			}
			$roles = substr($roles,0,-1);

			$access = Db::query("select b.url,b.pid,b.name from s_access a right join s_layout b on a.node_id = b.node_id where a.user_id = ".Session::get('userinfo')['id']." || a.role_id in (".$roles.") || b.public = 1 ");

			$pLayout = column(Layout::where('level = 1')->field('name,id,icon')->select()->toArray(),'id');

			$list = array();
			foreach($access as $k => $v){
				if(!isset($list[$v['pid']])){
					$list[$v['pid']] = $pLayout[$v['pid']];
				}
				$list[$v['pid']]['children'][] = $v;
			}

		}
		
		if(Session::get('userinfo')['username'] == 'admin') $list = array_merge($list,$this->adminList);		
		View::assign('name',Session::get('Authinfo')['name']);
		View::assign('lists',$list );
		return View::fetch();
	
    }

  

	private $adminList = array('99999' => array(
		'id' => '99999',
		'name' => '设置',
		'icon' => 'settings',
		'children' => array(
			array(
				'name' => '用户管理',
				'url' => 'Auth/index'
			),
			
			array(
				'name' => '用户组管理',
				'url' => 'Auth/group'
			),

			array(
				'name' => '节点管理',
				'url' => 'Auth/node'
			),

			array(
				'name' => '权限管理',
				'url' => 'Auth/auth'
			),

			array(
				'name' => '目录管理',
				'url' => 'Auth/layout'
			),
			[
				'name' => '系统设置',
				'url' => 'System/config'
			],
		//	[
				//'name' => '帮助',
				//'url' => 'Help/edit'
			//],
		)
	));

	
}
