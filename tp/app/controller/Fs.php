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
use app\model\FlowsField;
use app\model\FlowsExecutor;

class Fs extends BaseController{

	protected $get;

	/**
     *  加载模板
     */
	 public function load_template(){
		if(Session::get('userinfo')['username'] == 'admin' ) return a('','管理员不能引用模板发送流程','e');
		$auth = FlowAuth::where("node_id = 'creator' && flow_id = ".$_POST['id'])->find();
		$auth2 = array();
		if($auth){
			$auth = json_decode($auth->auth,true);
			foreach($auth as $k => $v){
				$auth2[$k] = $v;
			}
		}
		
		$form = Flow::find($_POST['id']);
		$attr = FlowTable::where("flow_id = ".$_POST['id'])->field('table_name,i,label,type,group,enum_name,enum_id,relation_a,relation_i,main')->order('table_name asc,id asc')->select()->toArray();
		$attr = column($attr,'i');
		foreach($attr as $k => $v){
			if(!isset($auth2[$v['i']])){
				$auth2[$v['i']] = array(
					'b' => $v['type'],
					'a' => 1,
					'm' => 0,
					'd' => '',
					'n' => 1,
					't' => '',
					'z' => $v['main'] //主表还是辅表
				);
			}else{
				$auth2[$v['i']]['a'] = (int)$auth2[$v['i']]['a'];
				$auth2[$v['i']]['z'] = $v['main'];
				if( $v['type'] == 'relation' ){
					$auth2[$v['i']]['relation_a'] = $v['relation_a'];
					$auth2[$v['i']]['relation_i'] = $v['relation_i'];
				}
			}
		}
		$userinfo = SESSION::get('userinfo');
		// 为relation 做准备  $relationMain 关联模型的主体
		$tmp = $relationMain =  array();
		foreach($auth2 as $k => $v){
			if( $attr[$k]['type'] == 'relation'){
				if( !isset($tmp[ $attr[$k]['relation_i'] ]) ){
					$tmp[ $attr[$k]['relation_i'] ] = array('type' => $attr[$attr[$k]['relation_i']]['type'],'t' => $auth2[$attr[$k]['relation_i']]['t']);
				}
				$tmp[ $attr[$k]['relation_i'] ]['relation'][] = $v['relation_a'];
				
			}
		}
		
		foreach($tmp as $k => $v){
			
			switch( $v['type'] ){
				case 'person':
					switch ( $auth[$k]['t'] ){
						case 1 :
							foreach($v['relation'] as $k1 => $v1){
								switch($v1){
									case 'department_name':
										$relationMain[$k][$v1] = $userinfo['department'];
									break;
									case 'post_name' :
										$relationMain[$k][$v1] = $userinfo['post'];
									break;
								}
							}
						break;
					}
				break;
			}
		}
		

		

		foreach($auth2 as $k => $v){
			switch( $attr[$k]['type']){
				case 'person' :
					switch( $v['t'] ){
						case 1:
							$auth2[$k]['person_id'] = $userinfo['employee_id'];
							$auth2[$k]['person_name'] = $userinfo['name'];
						break;
					}
				break;
				case 'relation':
				
					if( isset($relationMain[$v['relation_i']]) ){
						
						$auth2[$k]['d'] = $relationMain[$v['relation_i']][$v['relation_a']];
					}
				break;
				default:
			}
		}
		
		
		

		$r = Db::query(" select b.enum_id,a.i,b.id,b.name from s_flow_table a join s_enum_detail b on a.enum_id = b.enum_id  where a.type = 'enum' && a.flow_id = ".$_POST['id']);

		$select = array();
		foreach($r as $k => $v){
			$select[$v['i']][] = $v;
		}
		$form['cut_form'] = str_replace('table-form','table-form2',$form['cut_form']);

		return a( array('form' => $form['cut_form'],'select' => $select,'auth' => $auth2,'attr' => $attr ),'','s');
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
     *  验证模板数据
     */
	 public function validField($post){
		
		//$post['template_id'] = 28;

		$false = array();

		if(isset($post['template_id'])){  // 新建流程
			$templateId = $post['template_id'];
			$attr = column(FlowTable::where('flow_id = '.$templateId)->select()->toArray(),'i');
			$auth = FlowAuth::where("node_id = 'creator' && flow_id = ".$templateId)->find();
			if($auth){
				$auth = json_decode($auth->auth,true);
			}
		}else{
			$r = FlowsField::where('flows_id = '.$post['flowid'])->find();
			$attr = json_decode($r->field,true);
			$auth = FlowsAuth::where("flows_id = ".$post['flowid']." && node_id = '".$post['nodeid']."'")->find();
			if($auth){
				$auth = json_decode($auth->auth,true);
			}
		}

		//删除没有编辑权限的字段
		if( isset($post['field']) && count($auth) > 0 ){
			// 主表  
			foreach($post['field'] as $k => $v){
				if( $attr[$k]['type'] == 'relation' ){  // 和所关联的字段相同
					if( $auth[$attr[$k]['relation_i']]['a'] != 1){
						unset($post['field'][$k]);
					}
				}else{
					if( $auth[$k]['a'] != 1 ){
						unset($post['field'][$k]);
					}else{
						// checkbox 和 radio 转成 int类型
						if($attr[$k]['type'] == 'checkbox' || $attr[$k]['type'] == 'radio' ){
							$post['field'][$k] += 0;
						}
					}
				}
			}
		}
		

		//判断必填字段有没有赋值
		if( isset($post['field']) && count($auth) > 0 ){
			//主表
			foreach($post['field'] as $k => $v){
				if( $auth[$k]['m'] == 1){
					if(!$v){
						$false[] = array(
							'i' => $k
						);
					}
				}
			}
		}
			
		if( count($false) > 0 ){
			return array('ok' => false,'false' => $false,'msg' => '表单填写不完整 或 表单填写数据格式错误');
		}else{
			return array('ok' => true,'attr' => $attr,'auth' => $auth,'field' => isset($post['field'])?$post['field']:null );
		}
		
	 }
	 
	 /**
     *  发送流程
     */
	 public function send( $type = '' ){
		//sp();exit();
		//gp();

		$userinfo = Session::get('userinfo');

		$flowsAuth = $saveAttr =  $formTable = array();

		if($type != ''){  // 系统内置
			$flowTemplate = Flow::where("system_flow_type = '$type' ")->find();
			$form = array(
				'maker' => $userinfo['username'],
				'maker_name' => $userinfo['name'],
				'datetime' => date('Y-m-d H:i:s',time()),
				'status' => 5,
				'p' => $flowTemplate->p,
				'node' => $flowTemplate->node,
				'title' => $flowTemplate->title,
				'form' => '',
				'flow_id' => $flowTemplate->id,
				'system_flow' => 1,
				'table' => $type
			);

			

			$handleData = array(
				'nodeId' => 'creator',
				'executor' => isset($_POST['executor'])?$_POST['executor']:'',
				'createFalseDelete' => true,
				'prev' => true,
				'prevData' => array( 'node' => $form['node'], 'p' => $form['p'] ,'table' => '' )
			);

			$r = $this->handle($handleData);
		
		}else if( (int)$_POST['template_id'] > 0 ){
			
			$flowTemplate = Flow::find( $_POST['template_id'] );
			if(!$flowTemplate || !$flowTemplate->status) return a('','流程不存在或流程还没发布','e');

			$r = FlowAuth::where("  flow_id = ".$_POST['template_id'])->field('node_id,auth')->select()->toArray();
			$flowsAuth = $r;
			
			$validField = $this->validField($_POST);

			if(!$validField['ok']) return a($validField['false'],$validField['msg'],'e');

			$_POST['field'] = $validField['field'];

			$attr = $validField['attr'];

			$auth = $validField['auth'];

			$saveAttr = array();
		
			foreach($attr as $k => $v){
				$saveAttr[$k] = array(
					'type' => $v['type'],
					'length1' => $v['length1'],
					'length2' => $v['length2'],
					'enum_id' => $v['enum_id'],
					'relation_i' => $v['relation_i'],
					'relation_a' => $v['relation_a'],
					'group' => $v['group'],
					'main' => $v['main'],
					'table_name' => $v['table_name'],
					'label' => $v['label']
				);
			}

		
	
			
			if(isset($_POST['field'])){
				foreach($_POST['field'] as $k => $v){
					$formTable[$attr[$k]['table_name']][$k] = $v;
				}
			}

			if(isset($_POST['subField'])){
				foreach($_POST['subField']  as $k => $v){
					foreach($v as $k1 => $v1){
						$formTable[$k][] = $v1;
					}
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

			$form['form'] = str_replace('table-form','table-form2',$form['form']);
			
		
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

		if(count($saveAttr) > 0){
			FlowsField::create(array('flows_id' => $flows->id,'field' => json_encode($saveAttr)));
		}
		
		if($type){
			return a($flows->id,'','s');
		}else{
			 return a('','','s');
		}

       
	
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

		$w .= " and b.system_flow = 0 ";

        if($post['type'] == '1'){
            if($w == ''){
                $r = Db::query("select count(1) as n from s_flows_executor where status < 2 and number = '".SESSION::get('userinfo')['username']."'");
            }else{
                $r = Db::query("select count(1) as n from s_flows_executor a join s_flows b on a.flow_id = b.id where a.status < 2 and a.number = '".SESSION::get('userinfo')['username']."' $w ");
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

            $r = Db::table('s_flows_executor')->alias('a')->join(['s_flows' =>  'b'],'a.flow_id = b.id')->where("a.number = '".SESSION::get('userinfo')['username']."' and (a.status < 2) $w ")->field("a.id,a.flow_id,a.node_id,a.datetime_r,a.sender,a.name,a.status,b.show,b.title,b.maker_name,b.datetime,CASE a.type when 1 then '审核通过' when 2 then '回退' when 9 then '加签' ELSE '取回' END AS type")->page($post['page'],$post['n'])->order('a.id desc')->select()->toArray();
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
                $tbody .= "<tr data-show = '".$v['show']."' data-flow_id =".$v['flow_id']."  data-node_id = '".$v['node_id']."'  data-id = '".$v['id']."' ><td><input type = 'checkbox' class = 'aya-checkbox' /></td><td><a href = 'javascript:void(0)'  >".$v['title']."</a></td><td>".$v['maker_name']."</td><td>".$v['datetime']."</td><td>".$v['datetime_r']."</td><td>".$v['sender']."</td><td>-</td><td>".$v['handler']."</td><td> $zt </td><td> $rizhi </td></tr>";
            }
            
 
        }

		
 
        return array('tbody' => $tbody,'page_return' => $page_return);
    }

	/**
	+------------------------------------------------------------------------------
	* 获取表单内容
	+------------------------------------------------------------------------------
	*/
	public function flowGet($get){

		$flow = Flows::field('maker,table_name,form,maker_name,datetime,title')->find($get['flow_id']);
		$enumIdName = array();
		$attr = FlowsField::where("flows_id = ".$get['flow_id'])->find();
		$field = $field2 = array();
		if($attr){
			$field = json_decode($attr->field,true);
			foreach($field as $k => $v){
				$field2[$v['table_name']][] = $v;
			}
		}else{
			$field = array();
		}
		$userinfo = Session::get('userinfo');
		$auth = array();

		if($get['node_id']){ // 编辑状态
			$auth = FlowsAuth::where("flows_id = ".$get['flow_id']." && node_id = '".$get['node_id']."'")->find();
			if($auth){
				$auth = json_decode($auth->auth,true);
				foreach($field as $k => $v){
					if( !isset($auth[$k]) ){
						$auth[$k] = array(
							'b' => $v['type'],
							'a' => 0,
							'z' => $v['main']
						);
					}
				}
			}else{
				foreach($field as $k => $v){
					$auth[$k] = array(
						'b' => $v['type'],
						'a' => 0,
						'z' => $v['main']
					);
				}
			}

			

		}else{ // 查看状态
			// 对于发起者，所有都有权限查看
			// 对于其他人，只能查看不是隐藏的属性
			if($userinfo['username'] == $flow->maker){
				foreach($field as $k => $v){
					$auth[$k] = array(
						'b' => $v['type'],
						'a' => 0,
						'z' => $v['main']
					);
				}
			}else{
				$r = FlowsExecutor::where("flow_id = ".$get['flow_id']." && number = '".$userinfo['username']."' ")->field('node_id')->select()->toArray();
				if($r){
					$tmp = '';
					foreach($r as $k => $v){
						$tmp .= "'".$v['node_id']."',";
					}
					$tmp = substr($tmp,0,-1);
					
					$r1 = FlowsAuth::where("flows_id = ".$get['flow_id']." && node_id in (".$tmp.")")->select();
					if($r1){
						foreach($r1->toArray() as $k => $v){
							$tmp = json_decode($v['auth'],true);
							foreach($field as $k => $v){
								if( isset($auth[$k]) && $auth[$k]['a'] < 2 ) continue;
								$auth[$k] =  array(
									'b' => $v['type'],
									'a' => isset($tmp[$k])?($tmp[$k] == 2?2:0):0,
									'z' => $v['main']
								);

							}
						}
					}else{
						foreach($field as $k => $v){
							$auth[$k] =  array(
								'b' => $v['type'],
								'a' => 0,
								'z' => $v['main']
							);
						}
					}
				}else{
					return array('ok' => false,'msg' => '没权限查看');
				}
			}
		}
		
		$tableName = $flow->table_name;
		$data = array();
		$subTableName = array();

		if($tableName){
			foreach( explode(',',$tableName) as $k => $v){
				if( substr($v,0,1) == 'f' ){
					$data['form'] = Db::table('s_'.$v)->where('flows_id = '.$_GET['flow_id'])->find();
				}else{
					$data[$v] = Db::table('s_'.$v)->where('flows_id = '.$_GET['flow_id'])->select()->toArray();
					$subTableName[] = $v;
				}
			}
		}
		
		// 处理系统选择字段 和 枚举

		// 

		$systemSelect = $enumIdNameSee = $enumIdNameEdit = array();
		$tmpSee = $tmpEdit = '';
		
		foreach($field as $k => $v){
			if( $v['enum_id'] ){
				if( $auth[$k]['a'] == 1 ){
					$tmpEdit .= $v['enum_id'].',';
				}
			}
			
		}
		
		if( $tmpEdit != ''){
			$tmpEdit = substr($tmpEdit,0,-1);
			$r = EnumDetail::where("enum_id in (".$tmpEdit.")")->field('id,name')->select()->toArray();
			foreach($r as $k => $v){
				$enumIdNameEdit[$v['id']] = $v['name'];
			}
		}
		

		// 隐藏字段 && 更换枚举和系统选择的值

		foreach($field as $k => $v){
			if( $v['type'] == 'person' ){
				if( $auth[$k]['a'] == 0 ){
					$systemSelect[$k] = $v['type'];
				}
				
			}
		}

		$tmp = array();
		if(isset($data['form'])){
			foreach($data['form'] as $k => $v){
				if(isset($systemSelect[$k])){
					$tmp[$systemSelect[$k]][$k] = $v;
				}
			}
		}
		
		$systemSelectValue = array();
		foreach($tmp as $k => $v){
			switch($k){
				case 'person' :
					if(count($v)>0){
						$r = Db::table('s_employee')->where("id in (".get_w($v,false,true).")")->field('id,name')->select();
						foreach($r as $k => $v){
							$systemSelectValue['person'][$v['id']] = $v['name']; 
						}
						
					}
				break;
			}
		}

		$enumField = array();
		foreach($data['form'] as $k => $v){
			if($k == 'id' || $k == 'flows_id' ) continue;
			if($v === null) continue;
			if($auth[$k]['a'] == 2 ){
				$data['form'][$k] = '---';
			}else if( $field[$k]['type'] == 'enum'){
				$enumIdNameSee[$v] = 1;
			}else if( $field[$k]['type'] == 'person' ){
				$data['form'][$k] = $systemSelectValue['person'][$v];
			}
		}

		foreach($subTableName as $k => $v){
			foreach($data[$v] as $k1 => $v1){
				foreach($v1 as $k2 => $v2){
					if($k2 == 'id' || $k2 == 'flows_id' ) continue;
					if($v2 === null) continue;
					if($auth[$k2]['a'] == 2 ){
						$data['form'][$k2] = '---';
					}else if( $field[$k2]['type'] == 'enum'){
						$enumIdNameSee[$v2] = 1;
					}else if( $field[$k2]['type'] == 'person' ){
						$data[$k][$k2] = $systemSelectValue['person'][$v2];
					}
				}
			}
		}
		if( count($enumIdNameSee) > 0 ){
			$r = column(EnumDetail::where(" id in (".get_w($enumIdNameSee,false,false).") ")->field('id,name')->select()->toArray(),'id');
			foreach($data['form'] as $k => $v){
				if($k == 'id' || $k == 'flows_id' ) continue;
				if($v === null) continue;
				if( $field[$k]['type'] == 'enum'){
					$data['form'][$k] = $r[$v]['name'];
				}
			}
			foreach($subTableName as $k => $v){
				foreach($data[$v] as $k1 => $v1){
					foreach($v1 as $k2 => $v2){
						if($k2 == 'id' || $k2 == 'flows_id' ) continue;
						if($v2 === null) continue;
						if( $field[$k2]['type'] == 'enum'){
							$data[$v][$k1][$k2] = $r[$v2]['name'];
						}
					}
				}
			}
		}

		return array('data' => $data,'auth' => $auth,'field' => $field,'flow' => $flow,'enum' => $enumIdNameEdit);
	}

	
	/**
	+------------------------------------------------------------------------------
	* 打开流程页面 -- 编辑状态
	+------------------------------------------------------------------------------
	*/
	public function flow(){

		$r = $this->flowGet($_GET);
		$executor = FlowsExecutor::find($_GET['id']);
		if($executor->status == 0){
			 $executor->status = 1;
			 $executor->datetime_s = date('Y-m-d H:i:s' , time());
			 $executor->save();
		}
		View::assign('flow',$r['flow']);
		View::assign('comments',FlowsComment::where('flow_id = '.$_GET['flow_id'])->order('id desc')->field('name,datetime,comment,username,department,post')->select());
		View::assign('enum',json_encode($r['enum']));
		View::assign('data',json_encode($r['data']));
		View::assign('field',json_encode($r['field']));
		View::assign('auth',json_encode($r['auth']));
		return View::fetch();
	}

	/**
	+------------------------------------------------------------------------------
	* 打开流程页面 - 查看状态
	+------------------------------------------------------------------------------
	*/
	public function flow2(){
		$r = $this->flowGet($_GET);
		View::assign('flow',$r['flow']);
		View::assign('comments',FlowsComment::where('flow_id = '.$_GET['flow_id'])->order('id desc')->field('name,datetime,comment,username,department,post')->select());
		View::assign('enum',json_encode($r['enum']));
		View::assign('data',json_encode($r['data']) );
		View::assign('field',json_encode($r['field']) );
		View::assign('auth',json_encode($r['auth']));
		return View::fetch();
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
		$flow = Flows::find(125);
		Cache::set('node',$flow->node);
		Cache::set('p',$flow->p);
		Cache::set('handler',$flow->handler);
		$exe = Db::table('s_flows_executor')->where('flow_id = 125')->select()->toArray();
		Cache::set('executor',$exe);
	}

	public function test(){
		$flow = Flows::find(125);
		$flow->node = Cache::get('node');
		$flow->p = Cache::get('p');
		$flow->handler = Cache::get('handler');
		$flow->save();
		$executor = Cache::get('executor');
		Db::table('s_flows_executor')->where('flow_id = 125')->delete();
		Db::table('s_flows_executor')->insertAll($executor);
	}

	public function test2(){
		$k = Cache::get('tmp2');
		$v = Cache::get('tmp1');
		Db::table('s_'.$k)->insertAll($v);
	}

	/**
	+------------------------------------------------------------------------------
	* 流程 处理流程
	* $id  流程ID   $id2 当前ID
	+------------------------------------------------------------------------------
	*/

	public function check(){

		$valid = $this->validField($_POST);

		if(!$valid['ok']) return a($r['false'],'表单填写不完整 或 表单填写数据格式错误','e');
		
		$_POST['field'] = $valid['field'];

		$handleData = array(
			'flowId' => $_POST['flowid'],
			'nodeId' => $_POST['nodeid'],
			'executeId' => $_POST['id'],
			'executor' => isset($_POST['executor'])?$_POST['executor']:'',
			'add' => isset($_POST['add'])?$_POST['add']:array(),
			'opinion' => isset($_POST['opinion'])?trim($_POST['opinion']):'',
			'field' => $valid['field']
		);

		$r = $this->handle( $handleData );

		if($r['ok'] === false)  return a('',$r['msg'],'e');
        
        if($r['ok'] === 'm')    return a($r['data'],'','m');
		
		if($_POST['field'] &&  count($_POST['field']) > 0 ){
			foreach($_POST['field'] as $k => $v){
				$mainTable = $valid['attr'][$k]['table_name'];
				Db::table('s_'.$mainTable)->where('flows_id = '.$_POST['flowid'])->update($_POST['field']);
				break;
			}
		}
 
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

		$isEnd = true;

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
				
				if($flow['table_name']){
					$tmp = explode(',',$flow['table_name']);
					$table = Db::table('s_'.$tmp[0])->where('flows_id = '.$flow['id'])->find();
					if(isset($handleData['field'])){
						foreach($handleData['field'] as $k => $v){
							$table[$k] = $v;
						}
					}
				}else{
					$table = array();
				}
				
				
				
				$r = $this->get_next_executor2($p,$node,$c,$nodeId,$flow,$executor,$table);
				
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
			
			$isEnd = false;

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
		
		return array('ok' => true ,'status' => $isEnd?9:5 );
	
		
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

					if(isset($flow['table_resource'])){

						$table = Db::connect($flow['table_resource'])->table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->find();
					}else{

						//$table = Db::table(substr($flow['table_name'],0,strpos($flow['table_name'],',') === false ? strlen($flow['table_name']) : strpos($flow['table_name'],',') ))->where('id = '.$flow['table_id'])->find();
						
						if(is_set($flow,'table_name')){
							$tmp = explode(',',$flow['table_name']);
							$table = Db::table('s_'.$tmp[0])->where('flows_id = '.$flow['id'])->find();
						}

						
					}
				}
				if($xdzxr == ''){

					$xdzxr = array();
					
					$tmp0 = $this->get->get_employee( array('number' => $flow['maker']) );


					$xdzxr['aya1'] = $tmp0['department_id'];
					$xdzxr['aya2'] = $tmp0['post_id'];
					$xdzxr['aya3'] = SESSION::get('userinfo')['department'];
					$xdzxr['aya4'] = SESSION::get('userinfo')['post'];
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
				if(is_array($executor) && isset($executor[$v]) &&  count($executor[$v]) > 0){
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
							$g = $this->get->get_employee_by_department($depId,$includeChildren);
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
								'name' => $multiMsg.'（'.$tmpNode['B'].'）',
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

		$attr = FlowsField::where('flows_id = '.$_GET['flowid'])->find();

		$label = array();
		if($attr){
			foreach( json_decode($attr->field,true) as $k => $v){
				$label[$k] = $v['label'];
			}
		}
        
        $r = Db::table('s_flows')->where('id = '.$_GET['flowid'])->find();
        $p = json_decode($r['p'],true);
        $node = json_decode($r['node'],true);


		$department = $post = array();
		foreach($node as $k => $v){
			if(isset($v['X']) && count($v['X']) > 0){
				foreach($v['X'] as $k1 => $v1){
					if($v1[1] == 'aya1' || $v1[1] == 'aya3'){
						$tmp = explode('|',$v1[3]);
						$department[] = $tmp[0];
					}else if($v1[1] == 'aya2' || $v1[1] == 'aya4'){
						$post[] = $v1[3];
					}
				}
			}
		}
		if( count($department) > 0 ){
			$department = column(Db::table('s_department')->where("id in (".get_w($department,false).")")->field('id,name')->select()->toArray(),'id');
		}

		if( count($post) > 0 ){
			$post = column(Db::table('s_post')->where("id in (".get_w($post,false).")")->field('id,name')->select()->toArray(),'id');
		}

		






        $dlt = array();
        foreach($node as $k => $v){
            if(isset($v['D']) && $v['D'] == -1){
                $dlt[$k] = 1;
            }else{
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
		View::assign('label',json_encode($label));
		View::assign('department',json_encode($department));
		View::assign('post',json_encode($post));
        return View::fetch();
	}
	
	/**
    +------------------------------------------------------------------------------
    * 查看流程 - 用于新发流程
    +------------------------------------------------------------------------------
    */ 
	public function see2(){
		
		 //判断是否有权限看
		$flowTable = Db::query("select b.id,b.enum_id,b.name,a.i,a.label from s_flow_table a left join s_enum_detail b on a.enum_id = b.enum_id where a.flow_id = ".$_GET['flowid']);
		$enumI = $enum = array();
		if($flowTable){
			foreach($flowTable as $k => $v){
				if($v['id']){
					$enum[$v['id']] = $v['name'];
					$enumI[$v['i']] = $v['enum_id'];
				}
				$label[$v['i']] = $v['label'];
			}
		}else{
			$label = $enumI = $enum = array('-1' => 0);
		}
		
        $r = Db::table('s_flow')->where('id = '.$_GET['flowid'])->find();
		
		$node = json_decode($r['node'],true);
		$department = $post = array();
		foreach($node as $k => $v){
			if(isset($v['X']) && count($v['X']) > 0){
				foreach($v['X'] as $k1 => $v1){
					if($v1[1] == 'aya1' || $v1[1] == 'aya3'){
						$tmp = explode('|',$v1[3]);
						$department[] = $tmp[0];
					}else if($v1[1] == 'aya2' || $v1[1] == 'aya4'){
						$post[] = $v1[3];
					}
				}
			}
		}
		if( count($department) > 0 ){
			$department = column(Db::table('s_department')->where("id in (".get_w($department,false).")")->field('id,name')->select()->toArray(),'id');
		}

		if( count($post) > 0 ){
			$post = column(Db::table('s_post')->where("id in (".get_w($post,false).")")->field('id,name')->select()->toArray(),'id');
		}

		View::assign('department',json_encode($department));
		View::assign('post',json_encode($post));
        View::assign('p',$r['p']);
        View::assign('node',$r['node']);
		View::assign('label',json_encode($label));
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


	public function retrieve(){
		$r = $this->retrieveDo($_POST);
		if($r['ok']) return a();
		return a('',$r['msg'],'e');
	}


	public function retrieveDo($post,$checkEnd = true){
		
		$username = SESSION::get('userinfo')['username'];
		$flowId = $post['flowid'];
		$id = $post['id'];

		$flow  = Db::table('s_flows')->where('id = '.$flowId)->find();

		if(!$flow) return ['ok' => false,'msg' => '流程不存在'];

		$p = json_decode($flow['p'],true);

		$node = json_decode($flow['node'],true);

		$next = $this->get_next($p,$node,$post['nodeid']);
		
		if($checkEnd){
			if($flow['status'] == 9) return ['ok' => false,'msg' => '审核完毕，不能取回'];
		}

		

		$executor = Db::table('s_flows_executor')->where('id = '.$id)->find();

		if($executor['status'] < 2 || $username != $executor['number'] ) return ['ok' => false,'msg' => '取回错误'];
		
		

		if(count($next['p']) > 0){
			
			if(!$checkEnd && $next['n'][0] == 'end'){
				foreach($next['p'] as $k => $v) $node[$v]['D'] = 0;
				foreach($next['n'] as $k => $v) $node[$v]['D'] = 0;
			}else{
				$r = Db::table('s_flows_executor')->where("flow_id = $flowId && status > 1 &&  node_id in (".get_w($next['n']).") ")->field('id')->find();
				if($r) return ['ok' => false,'msg' => '下续节点已被审核，不能取回 或 弃审'];
			}

			
		}
		
		;
		foreach($next['p'] as $k => $v){
			$node[$v]['D'] = 0;
		}
		foreach($next['n'] as $k => $v){
			$node[$v]['D'] = 0;
		}	
		$node[$post['nodeid']]['D'] = 1;

		Db::table('s_flows')->where('id = '.$flowId)->update(['status' => 5,'node' => json_encode($node)]);

		Db::table('s_flows_executor')->where("flow_id = $flowId && node_id in (".get_w($next['n']).") ")->delete();

		Db::table('s_flows_executor')->where('id = '.$id)->update(['status' => 0,'type' => 3]);

		$flowsComment = new FlowsComment;
		$flowsComment->add_one( '审批取回（系统自动生成）' , (int)$flowId );
		
		return array('ok' => true);
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


	public function cancel_do2($flowId = array()){
		$w = get_w($flowId,false);
		Db::table('s_flows')->where('id in ( '.$w.' )')->delete();
		Db::table('s_flows_executor')->where('flow_id in ( '.$w.' )')->delete();
		Db::table('s_flows_comment')->where('flow_id in ( '.$w.' )')->delete();
		Db::table('s_flows_auth')->where('flows_id in ( '.$w.' )')->delete();
	}





	public function flow_log(){
		$flowId = $_GET['flow_id'];
        $flow = Db::table('s_flows')->where('id = '.$flowId)->field('maker_name,datetime,datetime_end')->find();
        $tbody = "<tr><td>1</td><td>".$flow['maker_name']."</td><td>发起</td><td>".$flow['datetime']."</td><td>-</td><td>-</td><td>-</td></tr>";
        $r = Db::table('s_flows_executor')->where('flow_id = '.$flowId)->order('id asc')->select();
        $index = 2;
        foreach($r as $k => $v){
            $zt = '';
            switch($v['status']){
                case 0 :
                    $zt = "<span style = 'color:#148AF5'>未读</span>";
                break;
                case 1:
                    $zt = "<span style = 'color:#18B596'>已读</span>";
                break;
                case 2:
                    $zt = "<span style = 'color:#F7A023'>已处理</span>";
                break;
                case 3:
                    $zt = "<span style = 'color:#2aa515'>竞争执行</span>";
                break;
            }
            $l = "";
            if($v['datetime_h']){
                $tmp = strtotime($v['datetime_h']) - strtotime($v['datetime_r']);
                $day = floor($tmp / 86400);
                $hour = floor(($tmp % 86400) / 3600);
                $minute = floor( (($tmp % 86400) % 3600) / 60 );
                if($day > 0) $l .= $day.'天';
                if($hour > 0) $l .= $hour.'小时';
                if($minute > 0) $l .= $minute.'分钟';
                if($l == "") $l = "小于1分钟";
            }
            $tbody .= "<tr><td>$index</td><td>".$v['name']."</td><td>$zt</td><td>".$v['datetime_r']."</td><td>".$v['datetime_s']."</td><td>".$v['datetime_h']."</td><td>$l</td></tr>";
            $index++;
        }
        if($flow['datetime_end']){
            $tbody .= "<tr><td>$index</td><td>-</td><td>结束</td><td>".$flow['datetime_end']."</td><td>-</td><td>-</td><td>-</td></tr>";
        }
        
        View::assign('tbody',$tbody);
        return View::fetch();
	}

	/**
     * 检查能否审核 和 取回
     */
	public function check1($flowId){
		$username = Session::get('userinfo')['username'];
		$r = Db::table('s_flows_executor')->where("flow_id = $flowId && number = '".$username."' ")->field('status')->select();
		$canCheck = $canRetrieve = false;
		foreach($r as $k => $v){
			if($v['status'] < 2 ) $canCheck = true;
			if($v['status'] == 2) $canRetrieve = true;
		}
		return [ 'canCheck' => $canCheck , 'canRetrieve' => $canRetrieve ];

	}
	
	/*
		$bill = array( 'flow_id' => '' , 'ddh' => '' )
	*/

	public function checkFlow($bill,$nodeId){

		$flowsId = array();
		foreach($bill as $k => $v){
			$flowsId[$v['flow_id']] = 1;
		}

		$userinfo = Session::get('userinfo');

		$fs = Db::table('s_flows')->where('id in ('.get_w($flowsId,false,false).')')->field('node,id,p')->select()->toArray();
		$checkFs = array();
		$node = $p = '';
		foreach($fs as $k => $v){
			$checkFs[$v['node']][] = $flowsId[$v['id']];
			if($node == ''){
				$node = $v['node'];
				$p = $v['p'];
			}
		}
			
		if( count($checkFs) > 1 ){
			return array( 'ok' => 'error' , 'msg' => '不同流程的订单不能合并审核');
		}

		$executors = Db::table('s_flows_executor')->where('flow_id in ('.get_w($flowsId,false,false).')')->where("status < 2 && number = '".$userinfo['username']."'")->field('node_id,number,flow_id,id')->select()->toArray();

		$NodeflowIdIdToId = array();

		$check = array();		
		$selectIds = array();
	
		foreach($executors as $k => $v){
			$selectIds[$v['node_id']] = $flowsId[$v['flow_id']];
			$check[$v['flow_id']] = 1;
			$NodeflowIdIdToId[ $v['node_id'].$v['flow_id'] ] = $v['id'];
		}

		
				
		$checkResult = array();

		foreach($bill as $k => $v){
			if($v['flow_id']){
				if( !isset($check[$v['flow_id']]) ){
					$checkResult[$v['ddh']] = array( 'ok' => false, 'msg' => '非当前审核人不能审核' );
				}else{
					if( count($selectIds) > 1 ){

						if( $nodeId == ''){

							$department = $post = array();
							$node = json_decode($node,true);
							$p = json_decode($p,true);
							foreach($node as $k => $v){
								if(isset($v['X']) && count($v['X']) > 0){
									foreach($v['X'] as $k1 => $v1){
										if($v1[1] == 'aya1' || $v1[1] == 'aya3'){
											$tmp = explode('|',$v1[3]);
											$department[] = $tmp[0];
										}else if($v1[1] == 'aya2' || $v1[1] == 'aya4'){
											$post[] = $v1[3];
										}
									}
								}
							}
							if( count($department) > 0 ){
								$department = column(Db::table('s_department')->where("id in (".get_w($department,false).")")->field('id,name')->select()->toArray(),'id');
							}
							if( count($post) > 0 ){
								$post = column(Db::table('s_post')->where("id in (".get_w($post,false).")")->field('id,name')->select()->toArray(),'id');
							}
							return array( 'ok' => 'selectId' , 'data' => ['node' => $node, 'p' => $p , 'department' => $department,'post' => $post, 'data' => $selectIds] );

						}else{
							$checkResult[$v['ddh']] = array( 'ok' => true , 'ddh' => $v['ddh'],'node_id' => $nodeId,'flow_id' => $v['flow_id'] ,'id' => $NodeflowIdIdToId[$nodeId.$v['flow_id']] );
						}

						
					}else{
						$tmp = '';
						foreach( $selectIds as $k1 => $v1 ){
							$tmp = $k1;
						}

						$checkResult[$v['ddh']] = array( 'ok' => true ,'ddh' => $v['ddh'],'node_id' => $tmp , 'flow_id' => $v['flow_id'] ,'id' => $NodeflowIdIdToId[$tmp.$v['flow_id']] );


						
					}
				}
			}
		}

		return array( 'ok' => true , 'checkResult' => $checkResult);

			


	}
	public function uncheckFlow($bill,$nodeId){

		$flowsId = array();
		foreach($bill as $k => $v){
			$flowsId[$v['flow_id']] = 1;
		}

		$userinfo = Session::get('userinfo');

		$fs = Db::table('s_flows')->where('id in ('.get_w($flowsId,false,false).')')->field('node,id,p')->select()->toArray();
		$checkFs = array();
		$node = $p = '';
		foreach($fs as $k => $v){
			$checkFs[$v['node']][] = $flowsId[$v['id']];
			if($node == ''){
				$node = $v['node'];
				$p = $v['p'];
			}
		}
			
		if( count($checkFs) > 1 ){
			return array( 'ok' => 'error' , 'msg' => '不同流程的订单不能合并弃审');
		}

		$node = json_decode($node,true);
		

		$executors = Db::table('s_flows_executor')->where('flow_id in ('.get_w($flowsId,false,false).')')->where("status = 2 && number = '".$userinfo['username']."'")->field('node_id,number,flow_id,id')->select()->toArray();

		$NodeflowIdIdToId = array();

		$check = array();		
		$selectIds = array();
	
		foreach($executors as $k => $v){
			$selectIds[$v['node_id']] = $flowsId[$v['flow_id']];
			$check[$v['flow_id']] = 1;
			$NodeflowIdIdToId[ $v['node_id'].$v['flow_id'] ] = $v['id'];
		}
		
		
		
		
		$checkResult = array();

		foreach($bill as $k => $v){
			if($v['flow_id']){
				if( !isset($check[$v['flow_id']]) ){
					$checkResult[$v['ddh']] = array( 'ok' => false, 'msg' => '非审核人不能弃审' );
				}else{
					if( count($selectIds) > 1 ){

						if( $nodeId == ''){
							$department = $post = array();
							$p = json_decode($p,true);
							foreach($node as $k => $v){
								if(isset($v['X']) && count($v['X']) > 0){
									foreach($v['X'] as $k1 => $v1){
										if($v1[1] == 'aya1' || $v1[1] == 'aya3'){
											$tmp = explode('|',$v1[3]);
											$department[] = $tmp[0];
										}else if($v1[1] == 'aya2' || $v1[1] == 'aya4'){
											$post[] = $v1[3];
										}
									}
								}
							}

							
							if( count($department) > 0 ){
								$department = column(Db::table('s_department')->where("id in (".get_w($department,false).")")->field('id,name')->select()->toArray(),'id');
							}
							if( count($post) > 0 ){
								$post = column(Db::table('s_post')->where("id in (".get_w($post,false).")")->field('id,name')->select()->toArray(),'id');
							}


							return array( 'ok' => 'selectId' , 'data' => ['node' => $node, 'p' => $p , 'department' => $department,'post' => $post, 'data' => $selectIds] );

							

						}else{
							$checkResult[$v['ddh']] = array( 'ok' => true , 'ddh' => $v['ddh'],'node_id' => $nodeId,'flow_id' => $v['flow_id'] ,'id' => $NodeflowIdIdToId[$nodeId.$v['flow_id']] );
						}

						
					}else{
						$tmp = '';
						foreach( $selectIds as $k1 => $v1 ){
							$tmp = $k1;
						}

						$checkResult[$v['ddh']] = array( 'ok' => true ,'ddh' => $v['ddh'],'node_id' => $tmp , 'flow_id' => $v['flow_id'] ,'id' => $NodeflowIdIdToId[$tmp.$v['flow_id']] );


						
					}
				}
			}
		}

			
	
		return array( 'ok' => true , 'checkResult' => $checkResult);

			


	}


	


	
	
}
