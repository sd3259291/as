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

use think\facade\Cache;

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

		$file = file_get_contents('./tp/a_001.sql').'#';

		$erg  = "/CREATE TABLE[\s\S]*?;/";
		preg_match_all($erg,$file,$ma);

		foreach($ma[0] as $k => $v){
			 Db::execute($v);
		}
		
		$erg = "/INSERT INTO[\s\S]*?#/";
		preg_match_all($erg,$file,$ma);

		foreach($ma[0] as $k => $v){
			 Db::execute($v);
		}


		
	}

	




	
}
