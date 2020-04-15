<?php
declare(strict_types=1);
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use app\model\Department;
use app\model\Post;
use think\facade\Cache;
use think\facade\Db;
use app\model\Enum;
use app\model\EnumDetail;
use app\model\Flow;
use app\model\Flows;
use app\model\FlowTable;
use app\model\Max;
use app\model\FlowsComment;
use app\controller\PublicGet;
use app\model\FlowType;
use app\model\FlowAuth;
use app\model\FlowsAuth;

class Fs extends BaseController{

	protected $get;

	/**
     *  加载模板
     */
	 public function load_template(){

		// $_POST['id'] = 7;
		 //gp();
		
		$auth = FlowAuth::where("node_id = 'creator' && flow_id = ".$_POST['id'])->find();
		//$auth = $auth?json_decode($auth->auth):array();
		$form = Flow::find($_POST['id']);

		$r = Db::query(" select b.enum_id,a.i,b.id,b.name from s_flow_table a join s_enum_detail b on a.enum_id = b.enum_id  where a.type = 'enum' && a.flow_id = ".$_POST['id']);

		$select = array();
		foreach($r as $k => $v){
			$select[$v['i']][] = $v;
		}

		

		if($auth){
			$auth = json_decode($auth->auth);
		}else{
			$auth = array();

			$r = FlowTable::where("flow_id = ".$_POST['id'])->field('i')->select();

			foreach($r as $k => $v){
				$auth[] = array(
					'i' => $v['i'],
					'a' => 1,
					'm' => 0

				);
			}
		}
		
		return a( array('form' => $form,'select' => $select,'auth' => $auth),'','s');
	 }

	 /**
     *  新建流程
     */

	
	public function __construct(){
		$this->get = new \app\controller\PublicGet;
    }

	 public function newFlow(){
		return View::fetch();
	 }

	 public function selectFlow(){
		$type = FlowType::where('status = 1')->order('sort asc')->select();
		View::assign('types',$type);
		return View::fetch();
	 }

	public function get_flow_by_type_id(){
		$flow = Flow::where('status = 1 && type_id = '.$_POST['id'])->field('id,title')->select();
		return a($flow,'','s');
	}
	 
	public function get_flow_by_title(){
		$flow = Flow::where("title like '%".$_POST['title']."%'")->field('id,title')->select();
		return a($flow,'','s');
	}



	 
	 /**
     *  自定义流程
     */

	 public function customFlow(){
		
		$flow = array('id' => 0,'p' => json_encode(array()),'node' => json_encode(array()),'max_id' => 0);
		
		View::assign('dep',1);
		View::assign('pst',1);
		View::assign('flowid',1);
	
		View::assign('jdqx',1);
		View::assign('flow',$flow);

		return View::fetch();
	 }

	 
	  /**
     *  加签
     */
	 public function flow_add(){
		//$jdqx = Db::table('aya_flow2_node')->field('id,name')->select();
		//$this->assign('jdqx',$jdqx);
		return View::fetch();
	 }

	 /**
     *  加签 选择人员
     */
	 public function flow_add_select(){
		$dept = new Department;
		$tree = $dept->tree();
		View::assign('tree',$tree);
		return View::fetch();
	 }

	 
	 /**
     *  发送流程
     */
	 public function send(){
		
		
		$userinfo = Session::get('userinfo');
		if( (int)$_POST['template_id'] > 0 ){
			$iName = column(FlowTable::where("flow_id = ".$_POST['template_id'])->field('i,label,table_name')->select()->toArray(),'i');
			$flowTemplate = Flow::find( $_POST['template_id'] );
			if(!$flowTemplate || !$flowTemplate->status) return a('','流程不存在或流程还没发布','e');
			$r = FlowAuth::where("  flow_id = ".$_POST['template_id'])->field('node_id,auth')->select()->toArray();
			$flowsAuth = $r;
			//dump($flowTemplate->toArray());	
			$auth = array();
			if($r && isset($r['creator']) ){
				$r = column($r,'node_id');
				$r = json_decode($r['creator']['auth'],true);
				foreach($r as $k => $v){
					if($v['a'] == 1){
						$auth[$v['i']] = array('a' => $v['a'],'m' => $v['m'],'n' => $iName[$v['i']]['label'],'t' => $iName[$v['i']]['table_name']);
					}
				}
			}
			$formTable = array();
			foreach($_POST['field'] as $k => $v){
				$formTable[$iName[$k]['table_name']][$k] = $v;
			}
			foreach($_POST['subField']  as $k => $v){
				foreach($v as $k1 => $v1){
					foreach($v1 as $k2 => $v2){
					}
					$formTable[$k][] = $v1;
				}
			}
			$form = array(
				'maker' => $userinfo['username'],
				'maker_name' => $userinfo['name'],
				'datetime' => date('Y-m-d H:i:s',time()),
				'status' => 5,
				'p' => $flowTemplate->p,
				'node' => $flowTemplate->node,
				'title' => $flowTemplate->title,
				'form' => $flowTemplate->cut_form,
				'flow_id' => $_POST['template_id']
			);
		
			if( count($formTable) > 0 ){
				$form['table_name'] = get_w($formTable,false,false);
			}

			$handleData = array(
				'nodeId' => 'creator',
				'executor' => isset($_POST['executor'])?$_POST['executor']:'',
				'createFalseDelete' => true,
				'prev' => true,
				'prevData' => array( 'node' => $form['node'], 'p' => $form['p'] ,'table' => $_POST['field'] )
			);
			$r = $this->handle($handleData);
		}else{

			$form = $_POST;
			$form['maker'] = $userinfo['username'];
			$form['maker_name'] = $userinfo['name'];
			$form['datetime'] = date('Y-m-d H:i:s',time());
			$form['status'] = 5;
			$form['title'] = trim($_POST['title']);
			$form['form'] = $_POST['form'];
			if(!$form['title']) rt('','标题不能为空','e');
			if(!$form['form'] ) rt('','流程内容不能为空','e');
			//$flows = Flows::create($d);
			$handleData = array(
				'nodeId' => 'creator',
				'executor' => isset($_POST['executor'])?$_POST['executor']:'',
				'createFalseDelete' => true,
				'prev' => true,
				'prevData' => array( 'node' => $form['node'], 'p' => $form['p'] ,'table' => '' )
			);
			$r = $this->handle($handleData);
		}
		
		if($r['ok'] === false)  return a('',$r['msg'],'e');
        
        if($r['ok'] === 'm')    return a($r['data'],'','m');

		

		$form['node'] = json_encode( $r['node'] );


		$flows = Flows::create( $form );

		$executor = isset($r['executor'])?$r['executor']:'';
		if($executor){
			foreach($executor as $k => $v){
				$executor[$k]['flow_id'] = $flows->id;
			}
		}
		Db::table('s_flows_executor')->insertAll($executor);
		
		$exc = array();
		foreach($executor as $k => $v){
			$exc[$v['name']] = 1;
		}
		$flows->handler = get_w($exc,false,false);
		$flows->save();

		
		
		
		foreach($formTable as $k => $v){
			if(substr($k,0,1) == 'f'){
				$v['flows_id'] = $flows->id;
				Db::table('s_'.$k)->insert($v);
			}else{
				foreach($v as $k1 => $v1){
					$v[$k1]['flows_id'] = $flows->id;
				}
				Db::table('s_'.$k)->insertAll($v);
			}
		}

		
		if(count($flowsAuth) > 0){
			foreach( $flowsAuth as $k => $v){
				$flowsAuth[$k]['flows_id'] = $flows->id;
			}
			Db::table('s_flows_auth')->insertAll( $flowsAuth );

		}
		
		

        return a('','','s');
	
	 }
	

	/**
     *  
     */



	  /**
     *  待办事项
     */
	public function notDone(){
		$r = $this->query(array('page' => 1,'n' => 1000,'type' => 1));
		View::assign('page',$r['page_return']);
		View::assign('tbody',$r['tbody']);
		return View::fetch();
	}
	 /**
     *  已发事项
     */
	public function hasSend(){
		$r = $this->query(array('page' => 1,'n' => 1000,'type' => 2));
		View::assign('page',$r['page_return']);
		View::assign('tbody',$r['tbody']);
		return View::fetch();
	}

	/**
     *  已发事项
     */
	public function hasDone(){
		$r = $this->query(array('page' => 1,'n' => 1000,'type' => 3));
		View::assign('page',$r['page_return']);
		View::assign('tbody',$r['tbody']);
		return View::fetch();
	}

	public function research(){

		
		
        $r = $this->query($_POST);
        return a(array('tbody' => $r['tbody'],'page' => $r['page_return']),'','s');
    }
 
 
    
 
    public function query($post){

		

		$post['n'] = (int)$post['n'];
		$post['page'] = (int)$post['page'];
		
        $w = "";
 
        if(isset($post['title']) && $post['title'] != ''){
            $w .= " and b.title like '%".$post['title']."%' ";
        }
        if(isset($post['maker_name']) && $post['maker_name'] != ''){
            $w .= " and b.maker_name like '%".$post['maker_name']."%' ";
        }
        if(isset($post['start']) && $post['start'] != ''){
            $w .= " and b.datetime >= '".$post['start']."  00:00:00'";
        }
        if(isset($post['end']) && $post['end'] != ''){
            $w .= " and b.datetime <= '".$post['start']."  23:59:59'";
        }
       
        if($post['type'] == '1'){
            if($w == ''){
                $r = Db::query("select count(1) as n from s_flows_executor where status = 0 and number = '".SESSION::get('userinfo')['username']."'");
            }else{
                $r = Db::query("select count(1) as n from s_flows_executor a join s_flows b on a.flow_id = b.id where a.status = 0 and a.number = '".SESSION::get('userinfo')['username']."' $w ");
            }
        }else if($post['type'] == 2){
            $r = Db::query("select count(1) as n from s_flows b where b.maker = '".SESSION::get('userinfo')['username']."' $w ");
          
        }else{
            if($w == ''){
                $r = Db::query("select count(1) as n from s_flows_executor where status = 2 and number = '".SESSION::get('userinfo')['username']."' $w ");
            }else{
                $r = Db::query("select count(1) as n from s_flows_executor a join s_flows b on a.flow_id = b.id  where a.status = 2 and a.number = '".SESSION::get('userinfo')['username']."' $w ");
            }
            
        }        

        $page_return = array();
        $page_return['totles'] = $r[0]['n'];     //总记录数 返回
        $page_return['totle_page'] = ceil($r[0]['n'] / $post['n']);  //总页数 返回
        $page_return['n'] = $post['n'];
        $page_return['current_page'] = $post['page'];     //当前页 返回

		$tbody = "";

		$imgUrl = img_url().'/flow/';

        if($post['type'] == '1'){  //待办

            $r = Db::table('s_flows_executor')->alias('a')->join(['s_flows' =>  'b'],'a.flow_id = b.id')->where("a.number = '".SESSION::get('userinfo')['username']."' and (a.status = 0 or a.status = 1) $w ")->field("a.id,a.flow_id,a.node_id,a.datetime_r,a.sender,a.name,a.status,b.show,b.title,b.maker_name,b.datetime,CASE a.type when 1 then '审核通过' when 2 then '回退' when 9 then '加签' ELSE '取回' END AS type")->page($post['page'],$post['n'])->order('a.id desc')->select()->toArray();
            foreach($r as $k => $v){
                $clzt = "";
                if($v['status'] == 0){
                    $clzt = "<img title = '未读' class = 'height16'  src = '".$imgUrl."/notsee.png' />";
                }else{
                    $clzt = "<img title = '已读' class = 'height16'  src = '".$imgUrl."/hassee.png' />";
                }
                $rizhi = "<img class = 'height16 rizhi' src= '".$imgUrl."/detail.png' data-flow_id =".$v['flow_id']." />";
                $tbody .= "<tr data-show = '".$v['show']."' data-flow_id =".$v['flow_id']."  data-node_id ='".$v['node_id']."'  data-id = ".$v['id']." ><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td><a href = 'javascript:void(0)' >".$v['title']."</a></td><td>".$v['maker_name']."</td><td>".$v['datetime']."</td><td>".$v['datetime_r']."</td><td>".$v['sender']."</td><td>".$v['type']."</td><td>".$v['name']."</td><td> $clzt </td><td> $rizhi </td></tr>";
            }
        }else if($post['type'] == 2){  // 已发
 
            $r = Db::table('s_flows')->alias('b')->where("b.maker = '".SESSION::get('userinfo')['username']."' $w ")->field("b.id as flow_id,b.maker,b.title,b.maker_name,b.datetime,b.handler,b.show,b.status")->page($post['page'],$post['n'])->order('b.id desc')->select();
		
			

            foreach($r as $k => $v){
                $zt = $v['status'] == 9 ? '<span class = "hint6">结束</span>' : '<span class = "hint3">流转中</span>';
                $rizhi = "<img class = 'height16 rizhi' src= '".$imgUrl."/detail.png' data-flow_id =".$v['flow_id']." />";
                $tbody .= "<tr data-show = '".$v['show']."' data-flow_id =".$v['flow_id']." data-node_id = '0' data-id = '0'><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td><a href = 'javascript:void(0)' >".$v['title']."</a></td><td>".$v['maker_name']."</td><td>".$v['datetime']."</td><td>-</td><td>".$v['handler']."</td><td> $zt </td><td> $rizhi </td></tr>";
            }

			
 
        }else{ //已办

            $r = Db::table('s_flows_executor')->alias('a')->join(['s_flows' => 'b'],'a.flow_id = b.id')->where("a.number = '".SESSION::get('userinfo')['username']."' and a.status = 2 $w")->field("a.id,a.flow_id,a.node_id,a.datetime_r,a.sender,b.handler,b.title,b.maker_name,B.datetime,b.show,b.status")->page($post['page'],$post['n'])->order('a.id desc')->select();

		
	
            foreach($r as $k => $v){
                $zt = $v['status'] == 9 ? '<span class = "hint1">结束</span>' : '<span class = "hint5">流转中</span>';
                $rizhi = "<img class = 'height16 rizhi' src= '".$imgUrl."/detail.png' data-flow_id =".$v['flow_id']." />";
                $tbody .= "<tr data-show = '".$v['show']."' data-flow_id =".$v['flow_id']."  data-node_id = '0'  data-id = '0' ><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td><a href = 'javascript:void(0)'  >".$v['title']."</a></td><td>".$v['maker_name']."</td><td>".$v['datetime']."</td><td>".$v['datetime_r']."</td><td>".$v['sender']."</td><td>-</td><td>".$v['handler']."</td><td> $zt </td><td> $rizhi </td></tr>";
            }
            
 
        }

		
 
        return array('tbody' => $tbody,'page_return' => $page_return);
    }
	
	/**
	+------------------------------------------------------------------------------
	* 打开流程页面
	+------------------------------------------------------------------------------
	*/
	public function flow(){
		
		$r1 = Db::table('s_flows_executor')->where('id = '.$_GET['id'])->field('status,number')->find();
            //判断有没有条件查看  
		if($r1['number'] == SESSION::get('userinfo')['username'] && $r1['status'] == 0){
			Db::table('s_flows_executor')->where('id = '.$_GET['id'])->update(array('status' => 1,'datetime_s' => date('Y-m-d H:i:s',time())));
		}
		
		

		$flow = Flows::find($_GET['flow_id']);
		View::assign('flow',$flow);
		View::assign('comments',FlowsComment::where('flow_id = '.$_GET['flow_id'])->order('id desc')->field('name,datetime,comment,username,department,post')->select());


		
		$enumIdName = array();

		if( !isset($_GET['type']) || $_GET['type'] == '0'){

			$auth = FlowsAuth::where("flows_id = ".$_GET['flow_id']." && node_id = 'creator'")->find();

			if($auth){
				$auth = $auth->toArray();
				$auth = column(json_decode($auth['auth'],true),'i');
			}
			
			$enum = array();
			if($flow->flow_id){
				$enum = FlowTable::where("flow_id = ".$flow->flow_id." && type = 'enum'")->field('enum_id')->select()->toArray();
				if($enum){
					$tmp = '';
					foreach($enum as $k => $v){
						$tmp .= $v['enum_id'].',';
					}
					$tmp = substr($tmp,0,-1);
					$r = EnumDetail::where("enum_id in (".$tmp.")")->field('id,name')->select()->toArray();
					foreach($r as $k => $v){
						$enumIdName[$v['id']] = $v['name'];
					}
				}
			}
			//$enum = Flow

			$tableName = $flow->table_name;
			$data = array();
			if($tableName){
				foreach( explode(',',$tableName) as $k => $v){
					if( substr($v,0,1) == 'f' ){
						$data['form'] = Db::table('s_'.$v)->where('flows_id = '.$_GET['flow_id'])->find();
					}else{
						$data[$v] = Db::table('s_'.$v)->where('flows_id = '.$_GET['flow_id'])->select()->toArray();
					}
				}
			}

			

			
			// 处理查看权限

			//处理查看权限结束

			View::assign('enum',json_encode($enumIdName));
			View::assign('data',json_encode($data) );
			return View::fetch('flow1');
		}else{
			return View::fetch();
		}

		
		
		

		
		
	}

	


	/**
	+------------------------------------------------------------------------------
	* 流程 增加一条实例
	* $zx 是否立即执行
	+------------------------------------------------------------------------------
	*/
	public function add_one($id,$table_id = '',$title = '',$zx = true,$executor = '' ){
	
		$r = Db::table('aya_flow2')->where('id = '.$id)->find();
		
		$flow = array(
			'maker' => SESSION::get('userinfo')['username'],
			'maker_name' => SESSION::get('userinfo')['name'],
			'datetime' => date('Y-m-d H:i:s',time()),
			'table_name' => $r['table_name'],
			'table_resource' => $r['table_resource'],
			'table_id' => $table_id,
			'status' => 5,
			'title' => $title == ''?$r['title']:$title,
			'node' => $r['node'],
			'p' => $r['p'],
			'show' => $r['show'],
			'done' => $r['done'],
			'tip_id' => $r['tip_id'],
			'before_dlt' => $r['before_dlt']
		);

		$flowId = Db::table('s_flows')->insertGetId($flow);
		
		$update = array(
			'status' => 5,
			'flow_id' => $flowId
		);
		if($r['table_resource']){
			Db::connect($r['table_resource'])->table(substr($r['table_name'],0,strpos($r['table_name'],',') === false ? strlen($r['table_name']) : strpos($r['table_name'],',') ))->where('id = '.$table_id)->update($update);
		}else{
			Db::table(substr($r['table_name'],0,strpos($r['table_name'],',') === false ? strlen($r['table_name']) : strpos($r['table_name'],',') ))->where('id = '.$table_id)->update($update);
		}
		
		if($zx){
			$handleData = array(
				'flowId' => $flowId,
				'nodeId' => 'creator',
				'executor' => $executor,
				'createFalseDelete' => true
			);

			$r = $this->handle($handleData);

			if($r['ok'] === true){
				$a = array(
					'comment' => '流程发起（系统自动生成）',
					'flowId'  => $flowId
				);
				action('index/Flowcomment2/add',array('post' => $a),'db');
				return a($flowId,'','s');
			}else{
				if($r['ok'] === false){
					return a('',$r['msg'],'e');
				}else if($r['ok'] == 'm'){
					if($r['ok'] === 'm')    return a($r['data'],'','m');
				}
				
			}
		}else{
			$a = array(
				'comment' => '流程发起（系统自动生成）',
				'flowId'  => $flowId
			);
			action('index/Flowcomment2/add',array('post' => $a),'db');
			return a($flowId,'','s');
		}
	}

	public function test1(){
		$flow = Flows::find(1687);
		Cache::set('node',$flow->node);
		Cache::set('p',$flow->p);
		Cache::set('handler',$flow->handler);
		$exe = Db::table('s_flows_executor')->where('flow_id = 1687')->select()->toArray();
		Cache::set('executor',$exe);
	}

	public function test(){
		$flow = Flows::find(1687);

		$flow->node = Cache::get('node');
		$flow->p = Cache::get('p');
		$flow->handler = Cache::get('handler');

		$flow->save();

		$executor = Cache::get('executor');

		Db::table('s_flows_executor')->where('flow_id = 1687')->delete();

		Db::table('s_flows_executor')->insertAll($executor);	

	}

	/**
	+------------------------------------------------------------------------------
	* 流程 处理流程
	* $id  流程ID   $id2 当前ID
	+------------------------------------------------------------------------------
	*/

	public function check(){

		//sp();exit();

		//$this->test();

		//gp();

		//$this->test();
		//gp();
		//$_POST = array(
			//'flowid' => 1599,
			//'id' => 19,
			//'nodeid' => 'id2'
		//);
	
		//if( isset($_POST['executor']) ) rt();

		$handleData = array(
			'flowId' => $_POST['flowid'],
			'nodeId' => $_POST['nodeid'],
			'executeId' => $_POST['id'],
			'executor' => isset($_POST['executor'])?$_POST['executor']:'',
			'add' => isset($_POST['add'])?$_POST['add']:array(),
			'opinion' => isset($_POST['opinion'])?trim($_POST['opinion']):''
		);

		$r = $this->handle( $handleData );

		 if($r['ok'] === false)  return a('',$r['msg'],'e');
        
        if($r['ok'] === 'm')    return a($r['data'],'','m');
 
        return a('','','s');

	}

	
	/**
	+------------------------------------------------------------------------------
	* 流程 处理流程
	* $id  流程ID   $id2 当前ID
	* 获取所有子节点 node
	+------------------------------------------------------------------------------
	*/
	public function get_next2($p,$node,$id){
		$r = array($id => 1);
		if($p[$id]){
			foreach($p[$id] as $k => $v){
				$r[$v] = 1;
				if(isset($p[$v]) && $p[$v]){
					$r1 = $this->get_next2($p,$node,$v);
					$r = array_merge($r,$r1);
				}
			}
		}
		return $r;
		
	}
	/**
	+------------------------------------------------------------------------------
	* 流程 处理流程
	* $id  流程ID   $id2 当前ID
	* 执行到下一步
	+------------------------------------------------------------------------------
	*/
	public function get_next($p,$node,$id){
		
		$r = array( 'p' => array(),'n' => array() );
		
		foreach($p[$id] as $k => $v){
			if($node[$v]['S'] == 'p' ){
				$r['p'][] = $v;
				$tmp = $this->get_next($p,$node,$v);
				$r['p'] = array_merge($r['p'],$tmp['p']);
				$r['n'] = array_merge($r['n'],$tmp['n']);
			}else{
				$r['n'][] = $v;
				//if($node[$v]['T'] == 'X' && $node[$v]['V'] == '空'){
					//$tmp = $this->get_next($p,$node,$v);
					//$r['p'] = array_merge($r['p'],$tmp['p']);
					//$r['n'] = array_merge($r['n'],$tmp['n']);
				//}
			}
		}
		return $r;
	}

	public function check_if($table,$x,$xdzxr){

		

		$expression = "";
		foreach($x as $k => $v){

			if( !isset( $v[1]) ) continue;

			if($v[1] == 'aya1'){


				
				$bmid = substr($v[3],0,-2);
				$type = substr($v[3],-1);
				if($type == 0){
					$expression .= $v[0]."'".$xdzxr['aya1']."'".$v[2]."'".substr($v[3],0,-2)."'".$v[4]." ".$v[5]." ";
				}else{
					$bms = $this->get->get_sub_department($bmid);
					$tmp = " ( ";
					if($v[2] == '=='){
						foreach($bms as $k1 => $v1){
							$tmp .= "('".$xdzxr['aya1']."' == '".$v1."') || ";
						}
					}else{
						foreach($bms as $k1 => $v1){
							$tmp .= "('".$xdzxr['aya1']."' != '".$v1."') && ";
						}
					}
					$tmp = substr($tmp,0,-3);
					$tmp .= " ) ";
				
					$expression .= $v[0].$tmp.$v[4]." ".$v[5]." ";
				}
				
			}else if($v[1] == 'aya2'){
				$expression .= $v[0]."'".$xdzxr['aya2']."'".$v[2]."'".$v[3]."'".$v[4]." ".$v[5]." ";
			}else if($v[1] == 'aya3'){
				$bmid = substr($v[3],0,-2);
				$type = substr($v[3],-1);
				if($type == 0){
					$expression .= $v[0]."'".$xdzxr['aya3']."'".$v[2]."'".substr($v[3],0,-2)."'".$v[4]." ".$v[5]." ";
				}else{
					$bms = $this->get->get_sub_department($bmid);
					$tmp = " ( ";
					if($v[2] == '=='){
						foreach($bms as $k1 => $v1){
							$tmp .= "('".$xdzxr['aya3']."' == '".$v1."') || ";
						}
					}else{
						foreach($bms as $k1 => $v1){
							$tmp .= "('".$xdzxr['aya3']."' != '".$v1."') && ";
						}
					}
					$tmp = substr($tmp,0,-3);
					$tmp .= " ) ";

					$expression .= $v[0].$tmp.$v[4]." ".$v[5]." ";
				}
				
			}else if($v[1] == 'aya4'){
				$expression .= $v[0]."'".$xdzxr['aya4']."'".$v[2]."'".$v[3]."'".$v[4]." ".$v[5]." ";
			}else{
				if( count($v) == 6){
					$expression .= $v[0]."'".$table[$v[1]]."'".$v[2]."'".$v[3]."'".$v[4]." ".$v[5]." ";
				}else{
					$tmp = $table[$v[1]]?$table[$v[1]]:'0';
					$expression .= $v[0].$tmp."==".$v[2].$v[3]." ".$v[4]." ";
					
				}
				
			}
		}

		
		$result = true;
		if($expression != '') eval("$"."result = $expression; ");

		
	
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function get_next_p($p,$node,$id){
		$r = array();
		foreach($p[$id] as $k => $v){
			if($node[$v]['S'] == 'p'){
				 $r[] = $v;
			}
			
			if($v != 'end'){
				$tmp = $this->get_next_p($p,$node,$v);
				$r = array_merge($r,$tmp);
			}				
		}
		return $r;
	}

	public function insert_node($node,$p,$insert,$nodeId,$maxId){

		


		if($insert[1] == '1'){
			
			$tmp = $this->insert_node2($node,$p,1,$insert[0],$nodeId,$maxId);
			$node = $tmp['node'];
			$p = $tmp['p'];
			$maxId = $tmp['maxId'];
		}else if($insert[1] == '2'){
			
			foreach($insert[0] as $k => $v){
				$tmp = $this->insert_node2($node,$p,1,array($insert[0][$k]),$nodeId,$maxId);
				$node = $tmp['node'];
				$p = $tmp['p'];
				$maxId = $tmp['maxId'];
			}
			
		}else if($insert[1] == '3'){

			
			$nextPId = $p[$nodeId][0];

			$nextN = $this->get_next($p,$node,$nextPId)['n'];

			$nextP = array();
			$a = '0';
			foreach($nextN as $k => $v){
				if($v == 'end') return array('ok' => false,'msg' => '结束节点不能并发');
				$nextP[$v] = $this->get_next_p($p,$node,$v);
				if($a == '0') $a = $v;
			}
			
			
			$sameId = '';
			foreach($nextP[$a] as $k => $v){
				$same = true;
				foreach($nextP as $k1 => $v1){
					if($k1 == $a) continue;
					$same = true;
					if( !in_array( $v , $v1 ) ){
						$same = false;
						break;
					}
				}
				if($same){
					$sameId = $v;
					break;
				}
			}
			
			if($sameId == '') return array('ok' => false,'msg' => '并发错误');


			if($insert[2] == 'true'){
				$idMe = 'id'.++$maxId;
				$idTmpP = 'id'.++$maxId;
				$me = array(
					'C' => 1,
					'K' => SESSION::get('userinfo')['username'],
					'V' => SESSION::get('userinfo')['name'],
					'T' => 'P',
					'S' => 'n',
					'Z' => 1,
				);
				$tmpP = array(
					'S' => 'p'	
				);
				foreach($insert[0] as $k => $v){
					unset($v['info']);
					unset($v['id']);
					$node['id'.++$maxId] = $v;
					$p[$nextPId][] = 'id'.$maxId;
					$p['id'.$maxId] = array($idTmpP);
				}

				$node[$idMe] = $me;
				$node[$idTmpP] = $tmpP;
				$p[$idTmpP] = array($idMe);
				$p[$idMe] = array($sameId);
				

			}else{
				foreach($insert[0] as $k => $v){
					unset($v['info']);
					unset($v['id']);
					$node['id'.++$maxId] = $v;
					$p[$nextPId][] = 'id'.$maxId;
					$p['id'.$maxId] = array($sameId);
				}
			}
	
		}
		
		return array('node' => $node,'p' => $p,'maxId' => $maxId,'ok' => true);
	}


	public function insert_node2($node,$p,$type,$insert,$nodeId,$maxId){
		
		$nextId = $p[$nodeId][0];
		$point1 = array(
			'id' => 'id'.++$maxId,
			'S'  => 'p'
		);
		
		$p[$nodeId] = array($point1['id']);
		$node[$point1['id']] = $point1;
		
		foreach($insert as $k => $v){
			unset($v['id']);
			unset($v['info']);
			$v['D'] = 0;
			$v['C'] = 1;
			$node['id'.++$maxId] = $v;
			$p['id'.$maxId] = array($nextId);
			$p[$point1['id']][] = 'id'.$maxId;

		}
	

		return array('node' => $node, 'p' => $p,'maxId' => $maxId);

	}


	public function get_max_id($node){
		$tmp = array();
		foreach($node as $k => $v){
			if($k == 'creator' || $k == 'end') continue;
			$tmp[] = substr($k,2);
		}
		rsort($tmp);
		return $tmp[0];
	}
	

	public function prev_check($flowId,$table,$executor){
		

		if( $executor || ( is_array($executor) && count($executor) > 0 ) ) return ;


		
		$r = Db::table('aya_flow2')->where('id = '.$flowId)->field('p,node')->find();
		$prevData = array();
		$prevData['node']  = json_decode($r['node'],true);
		$prevData['p']     = json_decode($r['p'],true);
		$prevData['table'] = $table;
		
		$handleData = array(
			'nodeId' => 'creator',
			'prev' => true,
			'prevData' => $prevData
		);

		$this->handle($handleData);
	
	}

	/**
	+------------------------------------------------------------------------------
	* $prev 默认为false,= true时表示只是主表插入前判断下节点是否多人执行
	* 当 $prev = true  的时候，$prevData 为预插入的主表，流程ID等一系列信息

	+------------------------------------------------------------------------------
	*/

	public function handle($handleData){
		
		$flowId = isset($handleData['flowId'])?$handleData['flowId']:0;
		$nodeId = $handleData['nodeId'];
		$executeId = isset($handleData['executeId'])?$handleData['executeId']:0;
		$executor  = isset($handleData['executor'])?$handleData['executor']:[];
		$createFalseDelete = isset($handleData['createFalseDelete'])?$handleData['createFalseDelete']:false;
		$add = isset($handleData['add'])?$handleData['add']:[];
		$prev = isset($handleData['prev'])?$handleData['prev']:false;
		$prevData = isset($handleData['prevData'])?$handleData['prevData']:[];
		$opinion = isset($handleData['opinion'])?$handleData['opinion']:'';

		if($executor){
			$tmp = json_decode($executor,true);
			$executor = array();
			foreach($tmp as $k => $v){
				if(is_array($v['executor'])){
					$executor[$v['id']] = $v['executor'];
				}else{
					$executor[$v['id']] = json_decode($v['executor'],true);
				}
			}
		}
		
		if($executeId > 0){
			 $executeNode = Db::table('s_flows_executor')->where('id = '.$executeId)->find();
			 if($executeNode['number'] != SESSION::get('userinfo')['username']){
				rt('','非当前审核人，不能审核','e');
			 }
			 if($executeNode['status'] == 2 ){
				rt('','已处理完毕，不能重复审核','e');
			 }
			 if($executeNode['status'] == -1 ){
				rt('','不能审核','e');
			 }
		}

		if($prev){
			$flow = array('maker' => SESSION::get('userinfo')['username']);
			$node = json_decode($prevData['node'],true);
			$p    = json_decode($prevData['p'],true);
		}else{
			$flow = Flows::find($flowId)->toArray();
			$node = json_decode($flow['node'],true);
			$p    = json_decode($flow['p'],true);
		}

		
		$c = $this->get_c($p);
		
		if(count($add) > 0){
			$maxId = $this->get_max_id($node);
			foreach($add as $k => $v){
				$tmp  = $this->insert_node($node,$p,$v,$nodeId,$maxId);
				$node = $tmp['node'];
				$p    = $tmp['p'];
				$maxId = $tmp['maxId'];
			}
		}

		$now = date('Y-m-d H:i:s' , time());

		//处理本节点

		//流转到下一节点

		$nextPointId = $p[$nodeId][0];
	
		$tmp = array();  // 记录 哪些节点的下一个节点 是 $nextPoint

		foreach($this->get_PN($p,$node,$c)['p'] as $k => $v){
			foreach($v as $k1 => $v1){
				if($v1 == $nextPointId){
					$tmp[] = $k;
				}
			}
		}

		$allDone = true;  //判断下一个节点的前序节点是不是都完成了
		
		foreach($tmp as $k => $v){
			if($node[$v]['D'] != 2 && $node[$v]['D'] != -1 && $v != $nodeId){
	
				$allDone = false;
				break;
			}
		}

		$mul = array();

		

		if($allDone){
	
			$currentNodeAllDone = true;
		
			if(isset($node[$nodeId]['Z']) && ($node[$nodeId]['Z'] == 2 || $node[$nodeId]['Z'] == 3) ){
				$tmp = Db::table('s_flows_executor')->where(" flow_id = ".$flowId." and node_id = '".$nodeId."' and number != '".SESSION::get('userinfo')['username']."' and status != 2 ")->field('id')->find();
				
				if($tmp){   // 多人执行未结束
					$currentNodeAllDone = false;
				}
			}
	
			if(!$currentNodeAllDone){  //多人，和全部执行时候

				Db::table('s_flows_executor')->where('id = '.$executeId)->update(array('status' => 2,'datetime_h' => $now));

				$ex = Db::table('s_flows_executor')->where(" ( status = 0 or status = 1) and flow_id = ".$flowId)->field('name')->select();
				$exs = array();
				foreach($ex as $k => $v){
					$exs[$v['name']] = 1;
				}
				if(count($add) > 0){
					Db::table('s_flows')->where('id = '.$flowId)->update(array('handler' => get_w($exs,false,false),'p' => json_encode($p),'node' => json_encode($node)));
				}else{
					Db::table('s_flows')->where('id = '.$flowId)->update(array('handler' => get_w($exs,false,false),'node' => json_encode($node)));
				}
				
				$flowsComment = new FlowsComment;
				$flowsComment->add_one( $opinion == ''?'审批通过（系统自动生成）':$opinion , (int)$flowId );
				rt();

			}else{
				$node[$nodeId]['D'] = 2;
			}

	
		
			if($prev){

				$r = $this->get_next_executor2($p,$node,$c,$nodeId,$flow,$executor,$prevData['table']);
							
				if($r['ok'] === false){
					return array('ok' => false,'msg' => $r['msg']);
				}
				if(count($r['mul']) > 0){
					return array('data' =>  $r['mul'],'ok' => 'm');
				}



				return $r;
				
				
			}else{
				
			

				$r = $this->get_next_executor2($p,$node,$c,$nodeId,$flow,$executor);

				
				
				
			}
			

			
		
			

			if($r['ok'] === false){
				if( $nodeId == 'creator'  ){
					$this->cancel_do(array('flowid' => $flowId));
				}
				return $r;
			}
			
			if(count($r['mul']) > 0){
				if( $nodeId == 'creator'  ){
					$this->cancel_do(array('flowid' => $flowId));
				}
				return array('ok' => 'm','data' => $r['mul']);
			}

			$node = $r['node'];

			$isEnd = true;

			
			
			$tmp = $this->get_PN($p,$r['node'],$c);

			

			if( !isset($tmp['p'][ $c['end'][0] ]) ){  //没有结束，并且下续接节点处理人是空，判断条件时end节点的上一节点
				if($r['ok'] && count( $r['executor']) == 0){
					return array('ok' => false,'msg' => '没有下续节点，不能审核');
				}
			}
			
			

			foreach($tmp['p'] as $k => $v){
				foreach($v as $k1 => $v1){
				
					if($r['node'][$v1]['D'] != 2){
						$isEnd = false;
						break;
					}
				}
				if(!$isEnd) break;
			}

			//判断是否结束
			
		
		
			if($isEnd){  //流程结束

				if($executeId > 0) Db::table('s_flows_executor')->where('id = '.$executeId)->update(array('status' => 2,'datetime_h' => $now));
				
				//foreach($isEnd['endParent'][1] as $k1 => $v1){
					//$node[$k1]['D'] = 2;
				//}
				//$node['end']['D'] = 2;
				
				if($flow['done']){
					//action($flow['done'],array( 'flow' => $flow,'id' => $flow['table_id'] ));
				}
				
				if($flow['table_resource']){
					Db::connect($flow['table_resource'])->table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->update(array('status' => 9 ));
				}else{
					//Db::table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->update( array( 'status' => 9 ) );
				}
				
				$flowsComment = new FlowsComment;
				$flowsComment->add_one( $opinion == '' ? '审批通过（系统自动生成）':$opinion , (int)$flowId);

				
				
				if(count($add) > 0){
					Db::table('s_flows')->where('id = '.$flowId)->update(array('status' => 9,'handler' => '-','node' => json_encode($node),'p' => json_encode($p) ));
				}else{
					
					Db::table('s_flows')->where('id = '.$flowId)->update(array('status' => 9,'handler' => '-','node' => json_encode($node)));
				}

				

			}else{
				
				if(count($r['executor']) == 0){
					if( $nodeId == 'creator'  ){
						$this->cancel_do(array('flowid' => $flowId));
					}
					rt('','流程没有下续节点，不能操作','e');
				}

				if($executeId > 0) Db::table('s_flows_executor')->where('id = '.$executeId)->update(array('status' => 2,'datetime_h' => $now));
				
				foreach($r['executor'] as $k1 => $v1){
					$r['executor'][$k1]['flow_id'] = $flow['id'];
				}

				foreach($r['executor'] as $k => $v){
					if(isset($node[$v['node_id']]['J']) &&  $node[$v['node_id']]['J']) $r['executor'][$k]['type'] = 9;
				}
			
				Db::table('s_flows_executor')->insertAll($r['executor']);

				
				
				$h = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
				//triggerRequest($h.'/index/Trigger/sendWechatMsg',array('flowId' => $flowId,'msg' => json_encode($r['executor'])));

				if( $executeId > 0){
					
					$flowsComment = new FlowsComment;
					$flowsComment->add_one( $opinion == '' ? '审批通过（系统自动生成）':$opinion , (int)$flowId);
				}



				$ex = Db::table('s_flows_executor')->where(" (status = 0 || status = 1) and flow_id = ".$flowId)->field('name')->select();

				$exs = array();
				foreach($ex as $k => $v){
					$exs[$v['name']] = 1;
				}
				
				if(count($add) > 0){
					Db::table('s_flows')->where('id = '.$flowId)->update(array('handler' => get_w($exs,false,false),'node' => json_encode($node) ,'p' => json_encode($p) ));
				}else{
					Db::table('s_flows')->where('id = '.$flowId)->update(array('handler' => get_w($exs,false,false),'node' => json_encode($node)));
				}

			}

			if(isset($node[$nodeId]['Z']) && $node[$nodeId]['Z'] == 4){
				$tmp = Db::table('s_flows_executor')->where(" flow_id = ".$flowId." and node_id = '".$nodeId."' and number != '".SESSION::get('userinfo')['username']."' ")->column('id');
				if($tmp){
					Db::table('s_flows_executor')->where('id in ('.get_w($tmp,false).')')->update( array('status' => 3 ));
				}
			}

		}else{
			
			$currentNodeAllDone = true;

			Db::table('s_flows_executor')->where('id = '.$executeId)->update(array('status' => 2,'datetime_h' => $now));
		
			if($node[$nodeId]['Z'] == 2 || $node[$nodeId]['Z'] == 3){
				$tmp = Db::table('s_flows_executor')->where(" flow_id = ".$flowId." and node_id = '".$nodeId."' and number != '".SESSION::get('userinfo')['username']."' and status != 2 ")->field('id')->find();
				
				if($tmp){   // 多人执行未结束
					$currentNodeAllDone = false;
				}
			}

			
			if($node[$nodeId]['Z'] == 4){
				
				$tmp = Db::table('s_flows_executor')->where(" flow_id = ".$flowId." and node_id = '".$nodeId."' and number != '".SESSION::get('userinfo')['username']."' ")->column('id');
				if($tmp){
					Db::table('s_flows_executor')->where('id in ('.get_w($tmp,false).')')->update( array('status' => 3 ));
				}
			}
			

			if($currentNodeAllDone){
				$node[$nodeId]['D'] = 2;
			}
			
			
			$ex = Db::table('s_flows_executor')->where(" ( status = 0 or status = 1) and flow_id = ".$flowId)->field('name')->select();
			$exs = array();
			foreach($ex as $k => $v){
				$exs[$v['name']] = 1;
			}
			Db::table('s_flows')->where('id = '.$flowId)->update(array('handler' => get_w($exs,false,false),'node' => json_encode($node)));

			$flowsComment = new FlowsComment;
			$flowsComment->add_one( $opinion == '' ? '审批通过（系统自动生成）':$opinion , (int)$flowId);
			

		}
		
		return array('ok' => true);
	
		
	}

	public function check_is_end($p,$node){
		$endParent = $this->get_end_parent($p);
		
		foreach($endParent[0] as $k => $v){
			if($node[$v]['D'] != -1 && $node[$v]['D'] != 2){
				return array('end' => false,'endParent' => $endParent);
			}
		}
		return array('end' => true,'endParent' => $endParent);
	}

	public function get_end_parent($p){
		$prev = array();
		$flag = false;
		foreach($p as $k => $v){
			foreach($v as $k1 => $v1){
				if($v1 == 'end'){
					$prev[$k] = 1;
					break;
				}
			}
		}

		foreach($p as $k => $v){
			foreach($v as $k1 => $v1){
				if($prev[$v1]){
					$r[] = $k;
					break;
				}
			}
		}

		return array($r,$prev);
	}

	public function get_PN($p,$node,$c){

		
		foreach($node as $k => $v){
			if(isset($v['D']) && $v['D'] == -1){
				
				foreach($c[$k] as $k1 => $v1){
					
					
					foreach($p[$v1] as $k2 => $v2){

						
						if($v2 == $k){
							
							
							unset($p[$v1][$k2]);
						}
					}
				}
			}
		}
		

		$tmp = $this->get_next2($p,$node,'creator');  //取得所有节点，去掉节点的D是-1以及以下的所有节点

		
		
		foreach($p as $k => $v){

			if(!isset($tmp[$k]) || !$tmp[$k] ) unset($p[$k]);
		}

		return array('p' => $p,'node' => $node,'c' => $c);		
	}

	public function get_next_executor2($p,$node,$c,$id,$flow,$executor,$table = '',$xdzxr = ''){

		$r = $this->get_next_executor( $p,$node,$c,$id,$flow,$executor,$table,$xdzxr);
		
		
		
		
		if($r['ok']){
			
			$node = $r['node'];
			$tmp = $this->get_PN($p,$node,$c);
			$p = $tmp['p'];
			$c = $this->get_c($p);
			foreach($r['rightNode'] as $k => $v){
				
				if($node[$v]['T'] == 'X' && $node[$v]['K'] == 9){
					$node[$v]['D'] = 2;
					$next = $this->get_next($p,$node,$v);
				
					$c = $this->get_c($p);
					$prev = $this->get_prev($c,$node,$next['p'][0]);
					
					$hasDone = true;

					foreach($prev as $k1 => $v1){
						if($node[$v1]['D'] != -1 && $node[$v1]['D'] != 2){
							$hasDone = false;
							break;
						}
					}
					
					if($hasDone){
						$tmp = $this->get_next_executor2($p,$node,$c,$v,$flow,$executor,$table,$xdzxr);
						if($tmp['ok']){
							$r['node'] = $tmp['node'];
							$r['executor'] = array_merge($tmp['executor'],$r['executor']);
							$r['mul'] = array_merge($tmp['mul'],$r['mul']);
							$r['errorNode'] = array_merge($tmp['errorNode'],$r['errorNode']);
							$r['rightNode'] = array_merge($tmp['rightNode'],$r['rightNode']);
						}else{
							return $tmp;
						}
					}
				}
			}

			return $r;
		}else{
			return $r;
		}
		
		

	}

	public function get_next_executor($p,$node,$c,$id,$flow,$executor,$table,$xdzxr){ ///相对执行人
		

		$r = array();
		$now = date('Y-m-d H:i:s',time());

		$next = $this->get_next($p,$node,$id);

		

		$tmpFlow = $flow;
		$tmpFlow['executor'] = $executor;

		foreach( $next['p'] as $k => $v ){
			if(isset($node[$v]['P']) && $node[$v]['P'] ){
				$tmpP = action($node[$v]['P'],array('flow' => $tmpFlow) );
				if(!$tmpP['ok']) return array('ok' => false,'msg' => $tmpP['msg']);
			}
			if(isset($node[$v]['A']) && $node[$v]['A']){
				$tmpP = action($node[$v]['A'],array('flow' => $tmpFlow) );
				if(!$tmpP['ok']) return array('ok' => false,'msg' => $tmpP['msg']);
			}
			$node[$v]['D'] = 2;
		}


		// start
		$hasEndNode  = false;
		$newExecutor = $mul = $errorNode = $rightNode =  $null = array();
		
		
		foreach($next['n'] as $k => $v){
			
			
			if($v == 'end'){
			
				$node['end']['D'] = 2;
			
				continue;
			}

			$tmpNode = $node[$v];
			
		
			//判断分支条件
			if(isset($tmpNode['X']) && $tmpNode['X']){
				if($table == ''){

					if($flow['table_resource']){
						$table = Db::connect($flow['table_resource'])->table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->find();
					}else{
						//$table = Db::table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->find();
						$tmp = explode(',',$flow['table_name']);
						$table = Db::table('s_'.$tmp[0])->where('flows_id = '.$flow['id'])->find();
					}
				}
				if($xdzxr == ''){
					$xdzxr = array();
					
					$tmp0 = $this->get->get_employee( array('number' => $flow['maker']) );
					$xdzxr['aya1'] = $tmp0['department_id'];
					$xdzxr['aya2'] = $tmp0['post_id'];
					$xdzxr['aya3'] = SESSION::get('userinfo')['department_id'];
					$xdzxr['aya4'] = SESSION::get('userinfo')['post_id'];
				}
				
				
	
						
				if(!$this->check_if($table,$tmpNode['X'],$xdzxr)){
					$node[$v]['D'] = -1;
					$errorNode[] = $v;
					continue;
				}else{
					$rightNode[] = $v;
					
				}

				
				
				
			}else if(isset($tmpNode['Q']) && $tmpNode['Q']){

				if(!action($tmpNode['Q'],array('flow' => $flow)) ){
					$node[$v]['D'] = -1;
					$errorNode[] = $v;
					unset($nextNode2[$k]);
					continue;
				}else{
					$rightNode[] = $v;
					
				}
			}else{
				$rightNode[] = $v;
				
			}
			//判断分支条件结束

			

			$node[$v]['D'] = 1;

	

			if($tmpNode['T'] == 'P'){
				$newExecutor[] = array(
					'flow_id' => $id,
					'node_id' => $v,
					'number'  => $tmpNode['K'],
					'name'    => $tmpNode['V'],
					'status'  => 0,
					'sender'  => SESSION::get('userinfo')['name'],
					'datetime_r' => $now
				);
				
			}else{
				if(is_array($executor) && count($executor[$v]) > 0){
					foreach($executor[$v] as $k1 => $v1){
						$newExecutor[] = array(
							'flow_id' => $id,
							'node_id' => $v,
							'number'  => $v1['k'],
							'name'    => $v1['v'],
							'status'  => 0,
							'sender'  => SESSION::get('userinfo')['name'],
							'datetime_r' => $now
						);
					}
				}else{

					$emptyMsg = '';
					$mulName = '';
					$g = array();
							
					switch($tmpNode['T']){
						case 'R' :
						
							
							$r1 = $this->get->get_leader_by_department($tmpNode['K']);
							if($tmpNode['V'] == 'B'){
								$emptyMsg = "部门主管（".$tmpNode['B']."）不存在";
								$multiMsg = '部门主管';
								$g = $r1['bmzg'];
							}else{
								$emptyMsg = "分管领导不存在";
								$multiMsg = '分管领导';
								$g = $r1['fgld'];
							}
						break;

						case 'G' :
							$emptyMsg = '岗位（'.$tmpNode['V'].'）员工数为 0';
							$g = action('index/Get/get_employee_by_post',array('postId' => $tmpNode['K']));
							$multiMsg = '岗位';
						break;

						case 'Z' :
							$emptyMsg = '组成员人数为 0';
							$g = action('index/Get/get_employee_by_group',array('groupId' => $tmpNode['K']));
							$multiMsg = '组';
						break;

						case 'D' :
							$emptyMsg = '部门人数为 0';
							$depId = substr($tmpNode['K'],0,-2);
							$includeChildren = substr($tmpNode['K'],-1);
							$g = action('index/Get/get_employee_by_department',array('depId' => $depId,'includeChildren' => $includeChildren));
							$multiMsg = '部门';
						break;

						case 'X' :
							if($tmpNode['K'] == 9){
								//
							}else if($tmpNode['K'] == 1){
								$r1 = action('index/Get/get_leader_by_employee',array('employee' => array('number' => $flow['maker']) ));
								$emptyMsg = "发起者部门主管不存在";
								$g = $r1['bmzg'];
								$multiMsg = '发起者部门主管';
								
							}else if($tmpNode['K'] == 2){
								$r1 = action('index/Get/get_leader_by_employee',array('employee' => array('number' => $flow['maker']) ));
								$emptyMsg = "发起者部门分管领导不存在";
								$multiMsg = '发起者部门分管领导';
								$g = $r1['fgld'];
							}else if($tmpNode['K'] == 3){
								$r1 = action('index/Get/get_leader_by_employee',array('employee' => array('number' => SESSION::get('userinfo')['username'] )));
								$emptyMsg = "执行者部门主管不存在";
								$multiMsg = '执行者部门主管';
								$g = $r1['bmzg'];

							}else if($tmpNode['K'] == 4){
								$r1 = action('index/Get/get_leader_by_employee',array('employee' => array('number' => SESSION::get('userinfo')['username'] )));
								$emptyMsg = "执行者部门分管领导不存在";
								$multiMsg = '执行者部门分管领导';
								$g = $r1['fgld'];
							}else if($tmpNode['K'] == 5){
								$g[] = array(
									'k' => $flow['maker'],
									'v' => $flow['maker_name']
								);
							}
						break;

						default :
					}
					
					if(  $tmpNode['T'] && $tmpNode['V'] == '空'  ) continue;
				
					if(count($g) == 0){
						return array('ok' => false,'msg' => $emptyMsg );
					}else if($tmpNode['Z'] == 3 || $tmpNode['Z'] == 4){

						foreach($g as $k1 => $v1){
							$newExecutor[] = array(
								'flow_id' => $id,
								'node_id' => $v,
								'number'  => $v1['k'],
								'name'    => $v1['v'],
								'status'  => 0,
								'sender'  => SESSION::get('userinfo')['name'],
								'datetime_r' => $now
							);
						}

					}else{

						if(count($g) > 1){
							$mul[$v] = array(
								'name' => $multiMsg.'（'.$tmpNode['V'].'）',
								'list' => $g,
								'zxms' => $tmpNode['Z']
							);
						}else{
							$newExecutor[] = array(
								'flow_id' => $id,
								'node_id' => $v,
								'number'  => $g[0]['k'],
								'name'    => $g[0]['v'],
								'status'  => 0,
								'sender'  => SESSION::get('userinfo')['name'],
								'datetime_r' => $now
							);
						}

					}

				}

			}
			// end
		}

		
		
		return array('ok'=>true,'executor'=>$newExecutor,'mul'=>$mul,'errorNode'=>$errorNode,'rightNode'=>$rightNode,'node'=>$node);

		
	}

	
	

	public function node(){
		$list = Db::table('aya_flow2_node')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	

	public function get_node(){
		$r = Db::table('aya_flow2_node')->where('id = '.$_POST['id'])->find();
		return a($r,'','s');
	}

	public function set_node(){
		Db::table('aya_flow2_node')->where('id = '.$_POST['id'])->update(array('auth1' => $_POST['auth1']));
		return a('','','s');
	}




	/**
	+------------------------------------------------------------------------------
	* 流程上增加评论
	+------------------------------------------------------------------------------
	*/
	public function add_flow_comment(){
		$r = action('index/Flowcomment2/add',array('post' => $_POST),'db');
		if(!$r['ok']) return a('',$r['msg'],'e');
		return a($r,'','s');
	}
	public function flow_select(){
		$r = Db::connect('db1')->query("select id ,name from org_post where is_enable = 1 ");
		foreach($r as $k => $v){
			$r[$k]['id'] = (string)$v['id'];
		}
		$r1 = Db::query("select id,name from aya_flow2_group");
		$this->assign( 'post',$r);
		$this->assign('group',$r1);
		$this->assign('ztreeData', action('index/P/get_structure'));
		return $this->fetch();
	}
	public function flow_select_department(){
		$this->assign('ztreeData', action('index/P/get_structure'));
		return $this->fetch();
	}
	public function flow_select_post(){
		$r = Db::connect('db1')->query("select id ,name from org_post where is_enable = 1 ");
		foreach($r as $k => $v){
			$r[$k]['id'] = (string)$v['id'];
		}
		
		$this->assign( 'post',$r);
		return $this->fetch();
	}
	public function flow_group_save(){
		$data = json_decode($_POST['data'],true);
		if(count($data) == 0) return a('','组成员不能为空','e');
		$main = array('name' => $_POST['name']);
		if(Db::table('aya_flow2_group')->where($main)->find()){
			return a('','组名已存在','e');
		}
		
		$id = Db::table('aya_flow2_group')->insertGetId($main);

		foreach($data as $k => $v){
			$data[$k]['id'] = $id;
			if(!isset($v['value'])) $data[$k]['value'] = '';
		}

		

		Db::table('aya_flow2_group_list')->insertAll($data);
		
		return a('','','s');
	}
	public function flow_group_dlt(){
		Db::table('aya_flow2_group_list')->where('id = '.$_POST['id'])->delete();
		Db::table('aya_flow2_group')->where('id = '.$_POST['id'])->delete();
		return a('','','s');
	}

	public function flow_attr(){
		
		$flow = Db::table('aya_flow2')->where('id = '.$_GET['flowid'])->find();

		$table = substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') );

		$r = Db::connect('erp')->query("SELECT A.name AS table_name,B.name AS column_name,C.value AS column_description FROM sys.tables A INNER JOIN sys.columns B ON B.object_id = A.object_id LEFT JOIN sys.extended_properties C ON C.major_id = B.object_id AND C.minor_id = B.column_id WHERE A.name = '".$table."' and C.value is not NULL");

		$jdqx = Db::table('aya_flow2_node')->field('id,name')->select();

		$this->assign('jdqx',$jdqx);
		$this->assign('list',$r);
		return $this->fetch();
	}

	public function flow_attr2(){
		return $this->fetch();
	}

	public function search_post(){
		$w = $_POST['keyword'] == ''?'':" and name like '%".$_POST['keyword']."%' ";
		$r = Db::connect('db1')->query("select id ,name from org_post where is_enable = 1 $w ");
		foreach($r as $k => $v){
			$r[$k]['id'] = (string)$v['id'];
		}
		return a($r,'','s');
	}
	public function get_employee_by_post(){
		$r = Db::table('s_employee')->where("gw = '".$_POST['post']."'")->field("name,number,gw")->where('active = 1')->select();
		return a($r,'','s');
	}
	public function get_employee_by_group(){
		$r = Db::table('aya_flow2_group_list')->where('id = '.$_POST['id'])->select();
		$number = array();
		foreach($r as $k => $v){
			if($v['type'] == 'P'){
				$number[] = $v['number'];
			}
		}
		if(count($number) > 0){
			$r1 = Db::table('')->query("select number ,gw from s_employee where number in (".get_w($number).") ");
		}
		foreach($r1 as $k => $v){
			$ng[$v['number']] = $v['gw'];
		}
		foreach($r as $k => $v){
			if($v['type'] == 'P'){
				$r[$k]['gw'] = $ng[$v['number']];
			}
		}

		return a($r,'','s');
	}
	public function get_employee_by_name(){
		$r = Db::table('s_employee')->where("name like '%".$_POST['keyword']."%'")->field("name,number,gw")->where('active = 1')->select();
		return a($r,'','s');
	}
	

	public function flow_create(){
		$id = $_POST['id'];
		$tableId = $_POST['tableId'];
		$tableType = $_POST['tableType'];
	}



	public function see(){

		
		
		$e = Db::table('s_flows_executor')->where('flow_id = '.$_GET['flowid'])->field('node_id,name,status')->select();
        $executor = array();
        foreach($e as $k => $v){
            $tmp = '';
            switch($v['status']){
                case 0 :
                    $tmp = '未读';
                break;
                case 1 :
                    $tmp = '已读';
                break;
                default:
                    $tmp = '已处理';
            }
            $executor[$v['node_id']][] = array('name' => $v['name'] , 'status' => $tmp);
        }
 
        //判断是否有权限看
        
        $r = Db::table('s_flows')->where('id = '.$_GET['flowid'])->find();

		
 
        
        
        $p = json_decode($r['p'],true);
        
        $node = json_decode($r['node'],true);
 
        $dlt = array();
        foreach($node as $k => $v){
            if(isset($v['D']) && $v['D'] == -1){
                $dlt[$k] = 1;
            }else{
                //if($v['X']){
                    
                //}
            }
        }
 
        
 
        foreach($p as $k => $v){
            $toDlt = array();
            for($i = 0; $i < count($v); $i++){
                if(isset($dlt[$v[$i]]) && $dlt[$v[$i]]){
                    $toDlt[] = $i;    
                }
            }
            if(count($toDlt) > 0){
                for($i = count($toDlt) - 1; $i >=0; $i--){
                    unset($p[$k][$toDlt[$i]]);
                }
            }
        }
        
        $pp = array();
 
        foreach($p as $k => $v){
            foreach($v as $k1 => $v1){
                $pp[$k][] = $v1;
            }
        }
 

        $tmp = $this->get_exist_node($node,$pp);
        $existNode = array();
        foreach($tmp as $k => $v){
            $existNode[$v] = $node[$v];
        }

        
        //$this->assign('add',json_encode($add));
        View::assign('executor',json_encode($executor));
        View::assign('p',json_encode($pp));
        View::assign('node',json_encode($existNode));
        return View::fetch();
	}

	public function get_exist_node($node,$p,$id = 'creator'){
        $r = array();
        $r[] = $id;
		if(isset($p[$id])){
			foreach($p[$id] as $k => $v){
				$tmp = $this->get_exist_node($node,$p,$v);
				$r = array_merge($r,$tmp);
			}
		}
        
        return $r;
    }

	public function get_prev($c,$node,$nodeid){
		$r = array();
		foreach($c[$nodeid] as $k => $v){
			if($node[$v]['S'] == 'p'){
				$tmp = $this->get_prev($c,$node,$v);
				$r = array_merge($r,$tmp);
			}else{
				$r[] = $v;
			}
		}
		return $r;
	}

	public function get_c($p){
		$c = array();
		foreach($p as $k => $v){
			foreach($v as $k1 => $v1){
				$c[$v1][] = $k;
			}
		}
		return $c;
	}

	public function get_prev2($c,$node,$nodeid){
		$r = array();
		foreach($c[$nodeid] as $k => $v){
			if($node[$v]['D'] == -1) continue;
			if($node[$v]['S'] == 'n' && $node[$v]['D'] == 2 && ( !isset($node[$v]['T']) || $node[$v]['T'] != 'X' || $node[$v]['K'] != 9) ){
				$r[] = $v;
			}else{
				$tmp = $this->get_prev2($c,$node,$v);
				$r = array_merge($r,$tmp);
			}
		}
		return $r;
	}

	public function get_prev_P($c,$node,$nodeid){
		
	}

	public function back(){
		
		$opinion = isset($_POST['opinion'])?$_POST['opinion']:'审批回退（系统自动生成）';
		if(!$opinion) rt('','回退意见不能为空','e');
		
		$executor = Db::table('s_flows_executor')->where(array('id' => $_POST['id']))->find();
		if($executor['number'] != SESSION::get('userinfo')['username']) rt('','不能回退','e');

		$flow  = Db::table('s_flows')->where('id = '.$_POST['flowid'])->field('node,p,handler')->find();
		if(!$flow) rt('','表单不存在','e');
		$p = json_decode($flow['p'],true);
		$node = json_decode($flow['node'],true);
		if($node[$_POST['nodeid']]['D'] == 2){
			return a('','已审批，不能回退','e');
		}
		$c = $this->get_c($p);
		$prev = $this->get_prev2($c,$node,$_POST['nodeid']);
		//dump($prev);
		
		
		foreach($prev as $k => $v){			
			if($v == 'creator') return a('','不能回退到根节点','e');
		}

		$tmp = array();
		foreach($prev as $k => $v){
			$children = $this->get_next2($p,$node,$v);
			foreach($children as $k1 => $v1){
				if($k1 != $v){
					 $node[$k1]['D'] = 0;
					 $tmp[] = $k1;
				}
			}
			$node[$v]['D'] = 1;
		}

		$r = array();
		if(count($tmp) > 0){
			$r = Db::table('s_flows_executor')->where("flow_id = ".$_POST['flowid']." && node_id in (".get_w($tmp).")")->field('node_id,id')->select();
		}
		
		$dlt = $add = $update = array();
		
		foreach($r as $k => $v){
			if(!in_array($v['node_id'],$prev)){
				$dlt[] = $v['id'];
			}
		}
		//exit();
		if(count($dlt) > 0){
			Db::table('s_flows_executor')->where("id in (".get_w($dlt,false).")")->delete();
		}
	
		$r = Db::table("s_flows_executor")->where("flow_id = ".$_POST['flowid']." && node_id in (".get_w($prev).") ")->field('id,name,number,node_id,status')->select();
		
		$backExecutor = array();
		foreach($r as $k => $v){
			if($v['status'] == 2){
				$update[$v['id']] = $v;
				$backExecutor[] = array(
					'node_id' => $v['node_id'],
					'name' => $v['name'],
					'number' => $v['number'],
				);
			}
		}

		if( count($update) > 0){
			$u = array(
				'sender' => SESSION::get('userinfo')['name'],
				'datetime_r' => date('Y-m-d H:i:s',time()),
				'datetime_s' => null,
				'datetime_h' => null,
				'status' => 0,
				'type' => 2
			);
			Db::table('s_flows_executor')->where(" id in (".get_w($update,false,false).") ")->update($u);
		}
		
		$handler = '';
		$tmp = Db::table('s_flows_executor')->where(" flow_id = ".$_POST['flowid']." and status < 2")->field('name')->select();
		foreach($tmp as $k => $v){
			$handler .= $v['name'].',';
		}
		$handler = substr($handler,0,-1);
		
		Db::table('s_flows')->where('id = '.$_POST['flowid'])->update(array('node' => json_encode($node),'handler' => $handler));

		$flowsComment = new FlowsComment;

		

		$flowsComment->add_one( $opinion , (int)$_POST['flowid'] );
		
		if(count($backExecutor) > 0){
			//$h = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
			//triggerRequest($h.'/index/Trigger/sendWechatMsg',array('type' => '回退','flowId' => $_POST['flowid'],'msg' => json_encode($backExecutor)));
		}

		rt();
	}

	public function add(){
		$jdqx = Db::table('aya_flow2_node')->field('id,name')->select();
		$this->assign('jdqx',$jdqx);
		return $this->fetch();
	}

	public function add_select(){
		$r = Db::connect('db1')->query("select id ,name from org_post where is_enable = 1 ");
		foreach($r as $k => $v){
			$r[$k]['id'] = (string)$v['id'];
		}
		$r1 = Db::query("select id,name from aya_flow2_group");
		$this->assign( 'post',$r);
		$this->assign('group',$r1);
		$this->assign('ztreeData', action('index/P/get_structure'));
		return $this->fetch();
		
	}

	


	public function get1($pid,$p){
		$tmp = array();
		foreach($p[$pid] as $k => $v){
			$tmp[] = $v['autoid'];
			if($p[$v['id']]){
				$r = $this->get1($v['id'],$p);
				$tmp = array_merge($tmp,$r);
			}
		}
		return $tmp;
	}


	public function quhui(){
		
		//$_POST['flow_id'] = 60;
		
		$username = SESSION::get('userinfo')['username'];
		$flowId = $_POST['flow_id'];

		$flow  = Db::table('s_flows')->where('id = '.$flowId)->find();
		$table = Db::table($flow['table_name'])->where('id = '.$flow['table_id'])->field('checked')->find();

		if($table['checked'] == 1) return  a('','审核完毕，不能取回','e');
		if($table['checked'] == 9) return  a('','已回退，不能取回','e');

		$r = Db::query("select A.pid,B.id,B.number from aya_flows_detail A join aya_flows_detail_executor B on A.autoid = B.autoid where A.id = $flowId and B.done = 0 and A.pid != 0");
		if(!$r) return a('','不可取回','e');
		
		foreach($r as $k => $v){
			$pid[] = $v['pid'];
			
			$m[$v['pid']][] = $v['id'];
			$n[$v['pid']][] = $v['number'];

		}


		$r = Db::query("select B.id,A.flow_id from aya_flows_detail A join aya_flows_detail_executor B on A.autoid = B.autoid where A.flow_id in (".get_w($pid,false).") and A.id = $flowId and B.number = '$username' ");

		if(!$r) return a('','不可取回','e');


		$dlttip = $tip = array();
		$update2 = $update1 = array();
		foreach($r as $k => $v){
			$tip[] = array(
				$username,$username,$flow['table_id']
			);
			$update[] = $v['id'];
			$delete = array_merge($update2,$m[$v['flow_id']]);
			foreach($n[$v['flow_id']] as $k => $v){
				$dlttip[] = $v;
			}
			
		}

		if(count($update) > 0){
			$u = array(
				'done' => 0	
			);

			
			Db::table('aya_flows_detail_executor')->where(" id in (".get_w($update,false).") ")->update($u);
			tip($flow['tip_id'],$tip);
		}

		if(count($delete) > 0){
			Db::table('aya_flows_detail_executor')->where(" id in (".get_w($delete,false).") ")->delete();
			if(count($dlttip) > 0){
				foreach($dlttip as $k => $v){
					dlt_tip(array($flow['table_id']),$flow['tip_id'],$v);
				}
			}
		}
		
		$a = array(
			'comment' => "<span class = 'hint2'>审批取回</span>（系统自动生成）",
			'flowId'  => $flowId
		);

		action('index/Flowcomment/add',array('post' => $a),'db');
	
		return a('','','s');
	}


	public function cancel(){
	
		$r = $this->cancel_do($_POST);
		if($r['ok']) return a('','','s');
		return a('',$r['msg'],'e');
		

	}

	public function cancel_do($post){

		

	
		$username = SESSION::get('userinfo')['username'];
		$flowId = $post['flowid'];
		$flow  = Db::table('s_flows')->field('status,maker,table_name,table_id,table_resource,before_dlt')->where('id = '.$flowId)->find();


		
		if($flow['status'] == 9) return array('ok' => false,'msg' => '流程已结束，不能取消','e');
		if($flow['maker'] != $username) return array('ok' => false,'msg' => '<span class  = "hint2">非制单人</span>不能取消','e');
		//$tables = explode(',',$flow['table_name']);
		
		
		/*
		if($flow['before_dlt'] && !$post['not_before_dlt'] ){
		
			$r = action($flow['before_dlt'],array('flow' => $flow));
			if(!$r['ok']) return array( 'ok' => false,'msg' => $r['msg']);
		}*/
		
	
		
		Db::table('s_flows')->where('id = '.$flowId)->delete();
		Db::table('s_flows_executor')->where('flow_id = '.$flowId)->delete();
		Db::table('s_flows_comment')->where('flow_id = '.$flowId)->delete();
		Db::table('s_flows_auth')->where('flows_id = '.$flowId)->delete();

		return array('ok' => true);
		
	}
	


	
	
}
