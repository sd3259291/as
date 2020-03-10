<?php
namespace app\model;

use think\Model;

class User extends Model{
  
	protected $schema = [
		'id'          => 'int',
		'username' => 'varchar',
		'password' => 'varchar',
		'name'        => 'varchar',
		'email' => 'varchar',
		'reg_date' => 'datetime',
		'last_login_date' => 'datetime',
		'status' => 'tinyint',
		'params' => 'text',
		'number' => 'varchar',
		'email_account' => 'varchar',
		'email_password' => 'varchar',
		'email_name' => 'varchar',
		'openId' => 'varchar',
		'headImg' => 'varchar',
		'access_token' => 'varchar',
		'role_id' => 'varchar'
	];


	/**
     * 分页
     */
	
	public function p( $post ){
		$p = $post['page'];
		$n = $post['n'];
		$w = '1 = 1';
		if(isset($post['name']) && $post['name'] != '') $w .= " && name like '%".$post['name']."%' ";
		if(isset($post['username']) && $post['username'] != '') $w .= " && username like '%".$post['username']."%' ";
		if(isset($post['role_id']) && $post['role_id'] != '') $w .= " && role_id like '%,".$post['role_id'].",%' ";
		
		$page = array();
		$page['totles'] = $this->where($w)->count();             //总记录数 返回
		$page['totle_page'] = (int)ceil( $page['totles'] / $n);  //总页数 返回
		$page['n'] = $n;
		$page['current_page'] = $p;
		
		$tbody = '';
		$data  = column($this->where($w)->field('id,username,name,status,last_login_date')->order('id desc')->page($p,$n)->select()->toArray(),'id');
		
		$tmp = '';
		foreach($data as $k => $v){
			$tmp .= $v['id'].',';
		}
		$tmp = substr($tmp,0,-1);

		$role = column(Role::select(),'id');	

		$role_user = RoleUser::where("user_id in ($tmp)")->select()->toArray();
	
		foreach($data as $k => $v){
			$data[$k]['role_name'] = '';
			$data[$k]['role_id'] = '';
		}
		foreach($role_user as $k => $v){
			if($data[$v['user_id']]['role_name'] == ''){
				$data[$v['user_id']]['role_name'] = $role[$v['role_id']]['name'];
			}else{
				$data[$v['user_id']]['role_name'] .= ','.$role[$v['role_id']]['name'];
			}
			$data[$v['user_id']]['role_id'] .= $v['role_id'].',';
		}
		
		foreach($data as $k => $v){
			$tbody .= "<tr data-role_id = '".$v['role_id']."' data-id = '".$v['id']."' ><td>".$v['username']."</td><td>".$v['name']."</td><td>".$v['role_name']."</td><td>".($v['status'] == 1?'启用':'禁用')."</td><td>".$v['last_login_date']."</td></tr>";
		}
		return array('page' => $page,'tbody' => $tbody);
	}


	public function role_user(){
		return $this->hasMany(RoleUser::class);
	}

}
