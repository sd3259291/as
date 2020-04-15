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

	

	public function __construct(){
       
    }

	
	
	/**
     * 根据部门 id 返回人员名单
     */
    public function get_employee_by_dept_id($id = ''){
		$department = new Department;
		$dep_id = $id?$id:$_POST['dep_id'];
		$id = $department->get_children_department($dep_id);
		$r = Db::table('s_employee')->alias('e')->join('s_department b','b.id = e.department_id')->join('s_post c','e.post_id = c.id')->where("e.department_id in (".get_w($id,false).")")->field('e.number,e.name,e.sex,b.name  dname,c.name pname,e.entry_date')->select()->toArray();
		return a($r,'','s');
	}


	/**
	+------------------------------------------------------------------------------
	* 返回员工
	+------------------------------------------------------------------------------
	*/
	public function get_employees($post = array()){
		if(count($post) == 0) $post = $_POST;
		if($post['f']){
			$r = Db::table('s_employee')->where($post['w'])->field($post['f'])->select();
		}else{
			$r = Db::table('s_employee')->where($post['w'])->select();
		}
		return $r;
	}

	/**
	+------------------------------------------------------------------------------
	* 根据岗位返回员工
	+------------------------------------------------------------------------------
	*/
	public function get_employee_by_post( $postId , $active = 1 ){
		$g = Db::table('s_employee')->alias('a')->join('s_user b','a.number = b.username')->where('a.active = '.$active.' && a.gwid = '.$postId.' && b.status = 1 ')->field('a.number k,a.name v')->select();
		return $g;
	}

	/**
	+------------------------------------------------------------------------------
	* 根据部门返回部门领导
	+------------------------------------------------------------------------------
	*/
	public function get_leader_by_department( $depId = '' ){
		$r1 = Db::query("select a.type,b.number k ,b.name v from s_department_attr a join s_employee b on a.key = b.id where a.department_id = ".$depId );
		$rt = array(
			'bmzg' => array(),
			'fgld' => array()
		);
		foreach($r1 as $k => $v){
			if($v['type'] == 1){
				$rt['bmzg'][] = $v;
			}else{
				$rt['fgld'][] = $v;
			}
		}
		return $rt;
	}

	/**
	+------------------------------------------------------------------------------
	* 根据部门返回部门成员
	* $includeChildren 是否包含子部门 0 不包含   1 包含
	+------------------------------------------------------------------------------
	*/
	public function get_employee_by_department($depId,$includeChildren = 0){
		//Cache::set('tmp',$includeChildren);
		if($includeChildren == 0){
			$r = Db::table('s_employee')->where('active = 1 && bmid = '.$depId)->field('number k,name v')->select();
		}else{
			$d = action('index/P/get_structure_detail')[1];
			$depIds = array();
			foreach($d as $k => $v){
				$depIds[$v][] = $k;
			}
			$tmp = $this->get_children_dep($depIds,$depId);
			$r = Db::table('s_employee')->where('active = 1 && bmid in ('.get_w($tmp,false).') ')->field('number k,name v')->select();
		}
		return $r;
	}
	/**
	+------------------------------------------------------------------------------
	* 根据部门返回子部门
	+------------------------------------------------------------------------------
	*/
	public function get_children_dep($depIds,$depId){
		$r = array($depId);
		if($depIds[$depId]){
			foreach($depIds[$depId] as $k => $v){
				$tmp = $this->get_children_dep($depIds,$v);
				$r = array_merge($r,$tmp);
			}
		}
		return $r;
	}
	
	/**
	+------------------------------------------------------------------------------
	* 根据员工返回部门领导
	+------------------------------------------------------------------------------
	*/
	public function get_leader_by_employee($employee){
		$r1 = Db::connect('db1')->query("select C.login_name k,B.name v,A.objective1_id as type from org_relationship as A join org_member as B on A.source_id = B.id join org_principal as C on B.id = C.member_id join org_member as D  on A.objective0_id = D.ORG_DEPARTMENT_ID where D.CODE = '".substr($employee['number'],1)."' and (A.objective1_id = -1726439953579618944 || A.objective1_id =  -4798905989785957463)");
		$rt = array(
			'bmzg' => array(),
			'fgld' => array()
		);
		foreach($r1 as $k => $v){
			$number[] = $v['k'];
		}
		if(count($number) > 0){
			$g = Db::table('s_employee')->alias('a')->join('s_user b','a.number = b.username')->field('a.number k,a.name v')->where(" a.number in (".get_w($number).") ")->select();
			$exist = array();
			foreach($g as $k => $v){
				$exist[$v['k']] = 1;
			}
		}
		foreach($r1 as $k => $v){
			if(!$exist[$v['k']]) continue;
			if($v['type'] == -1726439953579618944){
				unset($v['type']);
				$rt['bmzg'][] = $v; //部门主管
			}else{
				unset($v['type']);
				$rt['fgld'][] = $v; //分管领导
			}
		}
		return $rt;
	}
	/**
	+------------------------------------------------------------------------------
	* 根据组成员
	+------------------------------------------------------------------------------
	*/
	public function get_employee_by_group( $groupId ){
		$r = Db::table('aya_flow2_group_list')->alias('a')->join('s_user b','a.number = b.username')->where( 'a.id = '.$groupId.' && b.status = 1 ')->field('a.number k,a.name v')->select();
		return $r;
	}

	/**
	+------------------------------------------------------------------------------
	* 返回部门 ID => name
	+------------------------------------------------------------------------------
	*/
	public function get_department($id = array()){
		if( count($id) == 0){
			return Db::connect('db1')->table('ORG_UNIT')->where("IS_ENABLE = 1 && ID in (".get_w($id,false,false).")" )->column('ID id,NAME name');
		}else{
			return Db::connect('db1')->table('ORG_UNIT')->where(" ID in (".get_w($id,false,false).")" )->column('ID id,NAME name');
		}
	}

	/**
	+------------------------------------------------------------------------------
	* 返回岗位 ID => name
	+------------------------------------------------------------------------------
	*/
	public function get_post($id = array()){
		if( count($id) == 0){
			return Db::connect('db1')->table('ORG_POST')->where("IS_ENABLE = 1 && ID in (".get_w($id,false,false).")" )->column('ID id,NAME name');
		}else{
			return Db::connect('db1')->table('ORG_POST')->where(" ID in (".get_w($id,false,false).")" )->column('ID id,NAME name');
		}
	}
	
	/**
	+------------------------------------------------------------------------------
	* 返回员工信息 流程相关
	+------------------------------------------------------------------------------
	*/
	public function get_employee($w){
		if($w['number'] == 'admin') $w['number'] = '010099';
		$r = Db::table('s_employee')->where($w)->find();
		return $r;
	}
	/**
	+------------------------------------------------------------------------------
	* 返回子部门
	+------------------------------------------------------------------------------
	*/
	public function get_sub_department($depId,$includeSelf = true){
		$dept = Department::field('id,pid')->select()->toArray();
		$pid = array();
		foreach($dept as $k => $v){
			$pid[$v['pid']][] = $v['id'];
		}
		$r = $this->get_children($pid,$depId);
		if($includeSelf) $r[] = $depId;
		return $r;
	}


	/**
	+------------------------------------------------------------------------------
	* 返回子集,$pid = array( 'pid' => array('id1','id2') ),$id 
	+------------------------------------------------------------------------------
	*/
	public function get_children($pid,$id){
		$r = array();
		if(isset($pid[$id])){
			foreach($pid[$id] as $k => $v){
				if(isset($pid[$v])){
					$tmp = $this->get_children($pid,$v);
					$r = array_merge($r,$tmp);
				}else{
					$r[] = $v;
				}
			}
		}
		
		return $r;
	}


	
	
}
