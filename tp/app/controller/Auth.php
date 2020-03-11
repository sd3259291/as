<?php
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use app\model\Role;
use app\model\User;
use app\model\RoleUser;
use app\model\Node;
use app\model\Access;
use app\model\Layout;

class Auth extends BaseController
{
	/**
     * 用户管理
     */
    public function index()
    {	
		$user = new User;
		$tmp = $user->p(array('page' => 1,'n' => 100));
		View::assign('tbody',$tmp['tbody'] );
		View::assign('page',$tmp['page'] );
		View::assign('role',Role::where('status = 1')->select());
		return View::fetch();
    }
	
	public function getUser(){
	Cache::set('tmp',$_POST);
		$user = new User;
		$tmp = $user->p($_POST);
		return a($tmp,'','s');
	}

	public function test(){
		dump(Cache::get('tmp'));
	}


	/**
     * 用户组管理
     */
	public function group()
    {	
		View::assign('list',Role::order('id desc')->select());
		return View::fetch();
    }
	/**
     * 增加用户组
     */
	public function addGroup(){
		$name = trim($_POST['name']);
		$remark = trim($_POST['remark']);
		if(!$name) return a('','用户组名不能为空','e');
		if(Role::where('name',$name)->find()) return a('','用户组名（'.$name.'）已存在','e');
		$role = new Role;
		$role->name = $name;
		$role->status = 1;
		$role->remark = $remark;
		$role->save();
		$tr = "<tr><td>".$name."</td><td>-</td><td>启用</td><td>$remark</td></tr>";
		return a($tr,'','s');
	}
	/**
     * 修改用户组状态
     */
	public function changeGroupStatus(){
		$id = $_POST['id'];
		$role = Role::find($id);
		$role->status = $role->status == 1?0:1;
		$status = $role->status == 1?'启用':'禁用';
		$role->save();
		return a($status,'','s');
	}
	/**
     * 修改用户组姓名和备注
     */
	public function editGroup(){
		$name = trim($_POST['name']);
		$remark = trim($_POST['remark']);
		if(!$name) return a('','用户组名不能为空','e');
		$id = $_POST['id'];
		$role = Role::find($id);
		$role->name = $name;
		$role->remark = $remark;
		$role->save();
		return a('','','s');
	}
	/**
     * 删除用户组
     */
	 public function dltGroup(){
		// 检查组下有没有用户
		Role::destroy($_POST['id']);
		return a('','','s');
	 }

	 /**
     * 新增用户
     */
	 public function addUser(){

		if(!$_POST['username']) return a('','登录名不能为空','e');
		if(!$_POST['name']) return a('','用户名不能为空','e');
		if(!$_POST['password']) return a('','密码不能为空','e');
		if(!$_POST['role']) return a('','用户组不能为空','e');

		$role_name = column(Role::select($_POST['role']),'id');

		$user1 = User::where("username = '".$_POST['username']."'")->find();
		if($user1) return a('',"登录名（".$_POST['username']."）已存在",'e');

		$_POST['password'] = md5($_POST['password']);
		$roles = $_POST['role'];
		
		$tmp = ',';
		foreach($roles as $k => $v){
			$tmp .= $v.',';
		}
		
		$user = User::create(array_merge($_POST,array('role_id' => $tmp,'status' => 1,'reg_date' => date('Y-m-d H:i:s',time()))));
		
		$role = array();
		
		$tmp = '';
		foreach($roles as $k => $v){
			$role[] = array(
				'user_id' => $user->id,
				'role_id' => $v
			);
			if($tmp == ''){
				$tmp = $role_name[$v]['name'];
			}else{
				$tmp .= ','.$role_name[$v]['name'];
			}
		}
		$role_user = new RoleUser;
		$role_user->saveAll($role);

		return a("<tr><td>".$_POST['username']."</td><td>".$_POST['name']."</td><td>".$tmp."</td><td>启用</td><td></td></tr>",'','s');
		
	 }
	/**
    * 修改用户状态
    */
	public function changeUserStatus(){
		$id = $_POST['id'];
		$role = User::find($id);
		$role->status = $role->status == 1?0:1;
		$status = $role->status == 1?'启用':'禁用';
		$role->save();
		return a($status,'','s');
	}
	/**
    * 编辑用户
    */
	public function editUser(){
		//Cache::set('tmp',$_POST);exit();
		//$_POST = Cache::get('tmp');
		$id = $_POST['id'];
		if(!$_POST['username']) return a('','登录名不能为空','e');
		if(!$_POST['name']) return a('','用户名不能为空','e');
		if(!$_POST['role']) return a('','用户组不能为空','e');

		$user1 = User::where("username = '".$_POST['username']."' && id != ".$id)->find();
		if($user1) return a('',"登录名（".$_POST['username']."）已存在",'e');

		$role_name = column(Role::select($_POST['role']),'id');

		$roles = $_POST['role'];

		$tmp = ',';
		foreach($roles as $k => $v){
			$tmp .= $v.',';
		}

		$user = User::find($id);
		$user->username = $_POST['username'];
		$user->name = $_POST['name'];
		$user->role_id = $tmp;
		$user->save();

		
		$tmp = $tmp1 = '';
		foreach($roles as $k => $v){
			$role[] = array(
				'user_id' => $id,
				'role_id' => $v
			);
			if($tmp == ''){
				$tmp = $role_name[$v]['name'];
			}else{
				$tmp .= ','.$role_name[$v]['name'];
			}
			$tmp1 .= $v.',';
		}
		RoleUser::where('user_id = '.$id)->delete();
		$role_user = new RoleUser;
		$role_user->saveAll($role);
		return a(array('role_name' => $tmp,'role_id' => $tmp1),'','s');
	}

	/**
    * 删除用户
    */
	public function dltUser(){
		$id = $_POST['id'];
		User::destroy($id);
		RoleUser::where('user_id ='.$id)->delete();
		return a('','','s');
	}

	/**
    * 节点首页
    */
	public function node(){
		$node = new Node;
		$tree = $node->tree();
		View::assign('tree',$tree);
		return View::fetch();

	}

	/**
    * 新增节点
    */
	public function addNode(){

		if(!$_POST['pid']){
			 $_POST['pid'] = 0;
			 $_POST['level'] = 1;
		}

		if($_POST['level'] > 3) return a('','最多支持3层结构','e');
		
		if(!$_POST['name']) return a('','节点名称不能为空','e');
		if(!$_POST['action']) return a('','方法不能为空','e');

		if(Node::where(" pid = ".$_POST['pid']." && level = ".$_POST['level']." && action = '".$_POST['action']."'")->find()){
			return a('','已存在','e');
		}
		
		$node = new Node;

		$node->name = $_POST['name'];
		$node->action = $_POST['action'];
		$node->sort = $_POST['sort'];
		$node->pid = $_POST['pid'];
		$node->level = $_POST['level'];
		$node->save();

		return a($node->toArray(),'','s');

	}

	/**
    * 删除节点
    */
	public function dltNode(){

		if(Node::where('pid = '.$_POST['id'])->find()) return a('','包含子节点，不能删除','e');

		Node::destroy($_POST['id']);

		return a('','','s');
	}
	/**
    * 编辑节点
    */
	public function editNode(){
		
		if(!$_POST['name']) return a('','节点名称不能为空','e');
		if(!$_POST['action']) return a('','方法不能为空','e');
		$node = Node::find($_POST['id']);
		if(!$node) return a('','节点不存在','e');
		$node->name = $_POST['name'];
		$node->action = $_POST['action'];
		$node->sort = $_POST['sort'];
		$node->save();
		return a('','','s');
	}

	/**
    * 权限管理
    */
	public function auth(){
		$node = new Node;
		$tree = $node->tree(false);
		$role = Role::field('id,name')->select();
		$user = User::where("username != 'admin'")->field('id,name,username')->select();
		View::assign('role',$role);
		View::assign('user',$user);
		View::assign('tree',$tree);
		return View::fetch();
	}
	/**
    * 编辑管理
    */
	public function editAuth(){
		
		$data = json_decode($_POST['p'], true);
		
		if($_POST['type'] == '组'){
			Access::where('role_id = '.$_POST['id'])->delete();
		}else{
			Access::where('user_id = '.$_POST['id'])->delete();
		}

		if(count($data) == 0) return a('','','s');
		
		$node = column(Node::select($data)->toArray(),'id');
		
		$add = array();

		foreach($node as $k => $v){
			if($v['level'] == 3){
				$add[] = array(
					'action' => strtolower($v['action']),
					'controller' => strtolower($node[$node[$v['pid']]['pid']]['action']),
					'node_id' => $v['id']
				);
			}else if($v['level'] == 2){
				$add[] = array(
					'action' => strtolower($v['action']),
					'controller' => strtolower($node[$v['pid']]['action']),
					'node_id' => $v['id']
				);
			}
		}
		
		if($_POST['type'] == '组'){
			foreach($add as $k => $v){
				$add[$k]['role_id'] = $_POST['id'];
			}
		}else{
			foreach($add as $k => $v){
				$add[$k]['user_id'] = $_POST['id'];
			}
		}

		$access = new Access;

		$access->saveAll($add);

		return a('','','s');

	}
	/**
    * 获取权限
    */
	public function getAuth(){
		if($_POST['type'] == '组'){
			$auth = Access::where('role_id = '.$_POST['id'])->field('node_id')->select()->toArray();
		}else{
			$auth = Access::where('user_id = '.$_POST['id'])->field('node_id')->select()->toArray();
		}
		return a($auth,'','s');
	}
	/**
    * 页面布局
    */
	public function layout(){
		$layout = new Layout;
		$tree = $layout->tree();
		View::assign('tree',$tree);
		return View::fetch();
	}

	/**
    * 增加页面
    */
	public function addLayout(){

		

		if(!$_POST['name']) return a('','目录名称不能为空','e');

		if($_POST['level'] == 2 && !$_POST['url']) return a('','页面地址不能为空','e');

		if($_POST['level'] > 2) return a('','不支持3层以上目录','e');

		$layout = new Layout;
		
		$layout->name = $_POST['name'];
		$layout->url  = $_POST['url'];
		$layout->pid  = $_POST['pid'];
		$layout->sort = $_POST['sort'];
		$layout->icon = $_POST['icon'];

		if($_POST['level'] == 2){
			$tmp = explode('/',$_POST['url']);
			if(count($tmp) < 2) return a('','URL地址错误','e');
			$controller = $tmp[0];
			$action = $tmp[1];
			$node1 = Node::where( " action = '".$controller."' && level = 1")->field('id')->find();
			if(!$node1) return a('','URL地址错误','e');
			$node2 = Node::where(" action = '".$action."' && level = 2 && pid = ".$node1->id)->field('id')->find();
			if(!$node2) return a('','URL地址错误','e');
			$layout->node_id = $node2->id;
		}

		if($_POST['pid']){
			$layout->level = 2;
		}else{
			$layout->level = 1;
		}

		$layout->save();

		return a( $layout,'','s' );

	}

	/**
    * 删除目录
    */
	public function dltLayout(){
		if(Layout::where('pid = '.$_POST['id'])->find()) return a('','需先删除下级页面','e');
		Layout::destroy($_POST['id']);
		return a('','','s');
	}
	/**
    * 编辑目录
    */
	public function editLayout(){
		//Cache::set('tmp',$_POST);
		//$_POST = Cache::get('tmp');
		$layout = Layout::find($_POST['id']);
		if(!$layout) return a('','目录不存在','e');
		$layout->name = $_POST['name'];
		$layout->url = $_POST['url'];
		$layout->sort = $_POST['sort'];
		$layout->icon = $_POST['icon'];
		if($_POST['url']){
			$tmp = explode('/',$_POST['url']);
			$controller = $tmp[0];
			$action = $tmp[1];
			$node1 = Node::where( " action = '".$controller."' && level = 1")->field('id')->find();
			if(!$node1) return a('','URL地址错误','e');
			$node2 = Node::where(" action = '".$action."' && level = 2 && pid = ".$node1->id)->field('id')->find();
			if(!$node2) return a('','URL地址错误','e');
			$layout->node_id = $node2->id;
		}

		$layout->save();

		return a($layout,'','s');

	}

	





  


	
}
