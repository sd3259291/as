<?php
declare(strict_types=1);
namespace app\controller;


use think\facade\View;

use think\facade\Session;

use think\facade\Db;

use think\facade\Config;

use app\model\Access;

use app\model\RoleUser;

use app\model\Employee;

use PDO;

class Login
{
    public function index()
    {
		Session::clear();
		try{
			Db::query('select 1 from s_user');
		}catch (\Exception $e) {
			return redirect( (string) url('Login/i')->suffix('') );
		}
		return view();
	
    }

	public function i(){
		$databases = Config::get('database.connections');
		View::assign('database',$databases[$databases['default']]);
		return View::fetch();
	}

	public function c(){

		$databases = Config::get('database.connections');
		$host = $databases[$databases['default']]['hostname'];
		$port = $databases[$databases['default']]['hostport'];
		$char = $databases[$databases['default']]['charset'];
		$username = $databases[$databases['default']]['username'];
		$password = $databases[$databases['default']]['password'];
		$default = $databases[$databases['default']]['database'];

		if(!$default){
			echo '默认数据库不能为空';
			exit();
		}

		$dsn = "mysql:host=".$host.";port=".$port.";charset=".$char;
		
		

		try{
			$pdo = new PDO($dsn, $username, $password);


			//$dlt = "DROP DATABASE a;";

			//$pdo->exec($dlt);

			
			
			try{
				$dsn = "mysql:host=".$host.";port=".$port.";dbname=".$default.";charset=".$char;

				new PDO($dsn, $username, $password);
				echo "系统已经初始化 或者 数据库名重复！";
			}catch (\Exception $e) {

				$this->d($pdo,$default);

				
				return View::fetch();
				
			}

		}catch (\Exception $e) {
			echo "<div>连接数据库错误：".$e->getMessage()."</div>";
		}
	
	}

	public function check_login(){
	

		$username = $_POST['username'];
		$password = $_POST['password'];

		

		$authInfo = Db::table('s_user')->where("username = '$username'")->find();

		if($authInfo['status'] != 1) return a('','账号不存在或被禁用!','e');	


		if(!$authInfo){
			return a('','账号不存在或被禁用!' , 's') ;	
		}else{
				
			if($authInfo['password'] != md5($_POST['password'])){
				return a('','密码错误!','e');
			}else{

				$employee = Employee::where("number = '$username'")->find();

				if($employee){
					$authInfo['post'] = $employee->post->name;
					$authInfo['department'] = $employee->department->name;
					$authInfo['post_id'] = $employee->post->id;
					$authInfo['department_id'] = $employee->department->id;
					$authInfo['employee_id'] = $employee->id;
				}else{
					$authInfo['post'] = '-';
					$authInfo['department'] = '-';
				}

				Session::set('userinfo',$authInfo);
				
				if(substr($authInfo['username'],0,5)=='admin'){
					Session::set('admin_auth_key',true);
				}else{
					
					
					$role = RoleUser::where('user_id = '.$authInfo['id'])->field('role_id')->select()->toArray();
					
					$roles = '';
					foreach($role as $k => $v){
						$roles .= $v['role_id'].',';
					}
					$roles = substr($roles,0,-1);
					

					$r = Access::where(" user_id = ".$authInfo['id']." || role_id in (".$roles.")")->field('action,controller')->select()->toArray();

					foreach($r as $k => $v){
						Session::set(md5(strtolower($v['controller'].$v['action'])),1);
					}
					

					
				}

				$data = array('last_login_date' => date('Y-m-d H:i:s',time()));
				DB::table('s_user')->where('id = '.$authInfo['id'])->data($data)->update();

				
					
				return a('','','s');			
			}	
		}
		
		
	}


	private function d($pdo,$default){

		$sql = " CREATE DATABASE ".$default;
		$pdo->exec($sql);

		foreach($this->dataBase as $k => $v){
			Db::execute($v);
		}
		
		//增加系统管理员账户
		$admin = array(
			'username' => 'admin',
			'password' => 'duoduo',
			'name' => '管理员',
			'email' => '42686394@qq.com',
			'status' => 1
		);
		Db::table('s_user')->insert($admin);
		
		//增加系统枚举
		$tmp = array(
			'name' => '系统枚举',
			'pid' => 0,
			'system' => 1,
			'sort' => 1
		);
		$id = Db::table('s_enum')->insertGetId($tmp);
		$tmp = array(
			array(
				'name' => '岗位类型',
				'children' =>array(
					'管理类','技术类','营销类','智能类'
				)
			),
			array(
				'name' => '工作类型',
				'children' =>array(
					'类1','类2','类3','类4'
				)
			),
		);
		
		$tmp1 = array();
		foreach($tmp as $k => $v){
			$tmp1[] = array(
				'pid' => $id,
				'name' => $v['name'],
				'system' => 1,
				'sort' => 1
			);
		}
		Db::table('s_enum')->insertAll($tmp1);
		$enum = Db::table('s_enum')->select()->toArray();
		$enum_name_to_id = array();
		foreach($enum as $k => $v){
			$enum_name_to_id[$v['name']] = $v['id'];
		}
		$tmp1 = array();
		foreach($tmp as $k => $v){
			foreach($v['children'] as $k1 => $v1){
				$tmp1[] = array(
					'enum_id' => $enum_name_to_id[$v['name']],
					'name' => $v1, 
					'value' => $k1,
					'status' => 1,
					'sort' => 1
				);
			}
		}
		Db::table('s_enum_detail')->insertAll($tmp1);


		


		
	}

	private $dataBase = array(
		// 用户表
		'user' => "CREATE TABLE `s_user` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `username` varchar(150) NOT NULL,
		  `password` varchar(100) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `email` varchar(100) DEFAULT '',
		  `reg_date` datetime DEFAULT NULL,
		  `last_login_date` datetime DEFAULT NULL,
		  `status` tinyint(1) NOT NULL DEFAULT '0',
		  `params` text,
		  `number` varchar(20) DEFAULT NULL,
		  `email_account` varchar(255) DEFAULT NULL,
		  `email_password` varchar(255) DEFAULT NULL,
		  `email_name` varchar(255) DEFAULT NULL,
		  `openId` varchar(255) DEFAULT NULL,
		  `headImg` varchar(255) DEFAULT NULL,
		  `access_token` varchar(255) DEFAULT NULL,
		  `role_id` varchar(255) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `username` (`username`),
		  KEY `name` (`name`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//用户角色 
		'role' => "CREATE TABLE `s_role` (
		  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(20) NOT NULL,
		  `status` tinyint(1) unsigned DEFAULT NULL,
		  `remark` varchar(255) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
		//用户 用户角色 对照表
		'role_user' => "CREATE TABLE `s_role_user` (
		  `role_id` mediumint(9) unsigned DEFAULT NULL,
		  `user_id` char(32) DEFAULT NULL,
		  KEY `group_id` (`role_id`),
		  KEY `user_id` (`user_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
		//节点
		'node' => "CREATE TABLE `s_node` (
		  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(50) NOT NULL DEFAULT '',
		  `action` varchar(50) DEFAULT NULL,
		  `status` tinyint(1) DEFAULT '0',
		  `remark` varchar(255) DEFAULT NULL,
		  `sort` int(6) unsigned DEFAULT NULL,
		  `pid` int(6) unsigned NOT NULL,
		  `level` tinyint(1) unsigned NOT NULL,
		  `isdataauth` tinyint(3) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`),
		  KEY `level` (`level`),
		  KEY `pid` (`pid`),
		  KEY `status` (`status`),
		  KEY `name` (`name`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
		//访问权限
		'access' => "CREATE TABLE `s_access` (
		  `role_id` int(5) unsigned DEFAULT NULL,
		  `action` varchar(50) DEFAULT '0',
		  `controller` varchar(50) DEFAULT NULL,
		  `user_id` int(11) DEFAULT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
		//流程后台数据
		'flow' => "CREATE TABLE `s_flow` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) DEFAULT NULL,
		  `create_datetime` datetime DEFAULT NULL,
		  `modify_datetime` datetime DEFAULT NULL,
		  `done` varchar(50) DEFAULT NULL,
		  `show` varchar(50) DEFAULT NULL,
		  `node` text,
		  `p` text,
		  `max_id` int(11) DEFAULT NULL,
		  `before_dlt` varchar(255) DEFAULT NULL,
		  `form` mediumtext,
		  `maker` varchar(20) DEFAULT NULL,
		  `status` int(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//流程分组
		'flow_group' => "CREATE TABLE `s_flow_group` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(50) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//流程分组明细
		'flow_group_list' => "CREATE TABLE `s_flow_group_list` (
		  `autoid` int(11) NOT NULL AUTO_INCREMENT,
		  `id` int(11) DEFAULT NULL,
		  `number` varchar(50) DEFAULT NULL,
		  `name` varchar(50) DEFAULT NULL,
		  `type` varchar(5) DEFAULT NULL,
		  `value` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`autoid`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//流程节点
		'flow_node' => "CREATE TABLE `s_flow_node` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(100) DEFAULT NULL,
		  `sort` tinyint(3) DEFAULT NULL,
		  `auth1` varchar(255) DEFAULT NULL,
		  `default` tinyint(3) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//流程
		'flows' => "CREATE TABLE `s_flows` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `maker` varchar(10) DEFAULT NULL,
		  `datetime` datetime DEFAULT NULL,
		  `datetime_end` datetime DEFAULT NULL,
		  `table_resource` varchar(50) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `table_id` int(11) DEFAULT NULL,
		  `tip_id` int(11) DEFAULT NULL,
		  `maker_name` varchar(10) DEFAULT NULL,
		  `title` varchar(100) DEFAULT NULL,
		  `status` tinyint(3) DEFAULT NULL,
		  `p` text,
		  `node` text,
		  `show` varchar(50) DEFAULT NULL,
		  `done` varchar(50) DEFAULT NULL,
		  `handler` varchar(255) DEFAULT NULL,
		  `before_dlt` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		//流程评论
		'flows_comment' => "CREATE TABLE `s_flows_comment` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(10) DEFAULT NULL,
		  `datetime` datetime DEFAULT NULL,
		  `comment` text,
		  `flow_id` int(11) DEFAULT NULL,
		  `username` varchar(10) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;",
		// 页面管理
		'layout' => "CREATE TABLE `s_layout` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `level` int(3) NOT NULL DEFAULT '0',
		  `name` varchar(255) NOT NULL DEFAULT '',
		  `url` varchar(255) DEFAULT '',
		  `pid` int(11) NOT NULL DEFAULT '0',
		  `sort` int(11) NOT NULL DEFAULT '0',
		  `node_id` int(11) DEFAULT NULL,
		  `newwindow` int(1) NOT NULL DEFAULT '0',
		  `icon` varchar(50) DEFAULT NULL,
		  `hidenav` int(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏导航栏',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
		//枚举
		'enum' => "CREATE TABLE `s_enum` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) DEFAULT NULL,
		  `system` int(1) DEFAULT '0',
		  `sort` int(11) NOT NULL DEFAULT '0',
		  `pid` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
		//枚举明细
		'enum_detail' => "CREATE TABLE `s_enum_detail` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `enum_id` int(11) DEFAULT NULL,
		  `name` varchar(255) DEFAULT NULL,
		  `value` varchar(255) DEFAULT NULL,
		  `status` varchar(255) DEFAULT NULL,
		  `sort` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
		//组织
		'department' => "CREATE TABLE `s_department` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) DEFAULT NULL,
		  `pid` int(11) DEFAULT NULL,
		  `status` int(1) DEFAULT NULL,
		  `level` int(1) DEFAULT NULL,
		  `sort` int(11) NOT NULL DEFAULT '0',
		  `icon` int(1) DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;",
		

		
		


		
			
	);





	
}
