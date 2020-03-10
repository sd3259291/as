<?php
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Layout;

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
		)
	));

	
}
