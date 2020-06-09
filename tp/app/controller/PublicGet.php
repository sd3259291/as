<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;
use think\facade\Db;

use app\model\Department;
use app\model\Employee;
use think\facade\Cache;
use app\model\erp\ErpOption;

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
	public function get_employee_by_department($depId,$includeChildren = 1,$json = 0){
		$depId = (int)$depId;
		$r = array();
		if($includeChildren == 0){
			$r = Db::query(" select a.id,a.number k,a.name v,d.name department_name,p.name post_name from s_employee a join s_department d on a.department_id = d.id join s_post p on a.post_id = p.id where a.active = 1 && a.department_id = ".$depId);
		}else{
			$d = Db::table('s_department')->where('status = 1')->select()->toArray();
			$pid = array();
			foreach($d as $k => $v){
				$pid[$v['pid']][] = $v;
			}
			$tmp = $this->get_children_dep($pid,$depId);
			$r = Db::query(" select a.id,a.number k,a.name v,d.name department_name,p.name post_name from s_employee a join s_department d on a.department_id = d.id join s_post p on a.post_id = p.id where a.active = 1 && a.department_id in (".get_w($tmp,false).") ");
		}
		$r = column($r,'id');
		return $json?json($r):$r;
	}
	
	/**
	+------------------------------------------------------------------------------
	* 根据部门返回子部门
	+------------------------------------------------------------------------------
	*/
	public function get_children_dep($pid,$depId){
		$r = array($depId);
		if(isset($pid[$depId])){
			foreach($pid[$depId] as $k => $v){
				$tmp = $this->get_children_dep($pid,$v['id']);
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
	/**
	+------------------------------------------------------------------------------
	* 根据 enum_id 返回 枚举明细
	+------------------------------------------------------------------------------
	*/
	public function get_enum_detail($enum_id){
		$r = Db::table('s_enum_detail')->where('enum_id = '.$enum_id.' and status = 1')->order('sort asc')->select();
		return json($r);
	}
	/**
	+------------------------------------------------------------------------------
	* 选择人员
	+------------------------------------------------------------------------------
	*/
	public function select_person(){
		$dept = new Department;
		$tree = $dept->tree(false);
		View::assign('tree',$tree);
		return View::fetch();
	}
	/**
	+------------------------------------------------------------------------------
	* 根据人名返回员工列表
	+------------------------------------------------------------------------------
	*/
	public function get_employees_by_name(){
		$r = Db::query(" select a.id,a.number k,a.name v,d.name department_name,p.name post_name from s_employee a join s_department d on a.department_id = d.id join s_post p on a.post_id = p.id where a.active = 1 && a.name like '%".$_POST['name']."%'");
		return json(column($r,'id'));
	}
	
	/**
	+------------------------------------------------------------------------------
	* 根据text 返回 U8存货档案明细
	* text 为 编码 用 ' '的连接
	+------------------------------------------------------------------------------
	*/
	public function get_erp_by_text(){
		//gp();
		$code = explode(' ',$_POST['text']);  
        $i = 0;
        foreach($code as $k => $v){
            $tmp = trim($v);
            if($tmp != ''){
                 $a[$tmp] = 1;
                 $codes[] = $tmp;
            }
        }
        
        if(count($a) < 1) return a('','请输入编码，用空格隔开','e');
 
        $w = get_w($a,true,false);
 
        $type = $_POST['type'];
        $query = '';
        $now = date('Y-m-d',time()).' 00:00:00.000';
      
        switch($type){
            case 'inventory':
				$query = "select a.code,a.name,a.std,b.name unit from s_inventory a join s_unit b on a.unit_id = b.id where a.code in ($w) and a.end_date is null ";

            break;
 
            case 'vendor':
				$query = "select code,name from s_vendor where code in ($w) ";
            break;
 
            case 'warehouse':
                $query = "select cWhCode as code,cWhName as name from Warehouse where cWhCode in ($w)";
            break;
 
            case 'purchasetype':
                $query = "select cPTCode as code,cPTName as name from purchasetype where cPTCode in ($w)";
            break;
        }


        $n = Db::query($query);
        
        foreach($n as $k => $v){
            $m[$v['code']] = $v;
        }

	
 
        $r = array();
        foreach($codes as $k => $v){
            if(!isset($m[$v])) return a('','不存在<br />'.$v,'e');
 
            
            switch($type){
                case 'inventory':
                    $r[] = array(
                        'name' => $m[$v]['name'],
                        'code' => $m[$v]['code'],
                        'std'  => $m[$v]['std']?$m[$v]['std']:'',
                        'unit' => $m[$v]['unit']
                    );
                break;
 
                default:
                    $r[] = array(
                        'name' => $m[$v]['name'],
                        'code' => $m[$v]['code']
                    );
            }
 
        }      
		
		
        return a($r,'','s');
	}
	/**
	+------------------------------------------------------------------------------
	* option
	+------------------------------------------------------------------------------
	*/
	public function getOptions(ErpOption $o){
		return $o->getOptions($_POST);
	}
	public function setOption(ErpOption $o){
		return $o->setOption($_POST);
	}
	public function setDefaultOption(ErpOption $o){
		return $o->setDefaultOption($_POST);
	}
	public function dltOption(ErpOption $o){
		return $o->dltOption($_POST);
	}
	
	
}
