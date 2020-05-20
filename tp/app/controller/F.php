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
use app\model\Flow;
use app\model\FlowTable;
use app\model\Max;
use app\model\FlowType;
use app\model\FlowNode;
use app\model\FlowAuth;

class F extends BaseController{
	/**
     * 流程类型管理
     */
	public function flow_type(){
		View::assign('lists',FlowType::select());
		return View::fetch();
	}
	/**
     * 流程类型管理 - 新增
     */
	public function insert_flow_type(){
		if(FlowType::where("name = '".$_POST['name']."'")->find()){
			return a('','类型名称已存在','e');
		}
		$ft = FlowType::create(array('name' => $_POST['name'],'status' => 1,'sort' => $_POST['sort']));
		return a($ft->id,'','s');
	}
	/**
     * 流程类型管理 - 新增
     */
	public function edit_flow_type(){
		if(FlowType::where("name = '".$_POST['name']."' && id != ".$_POST['id'])->find()){
			return a('','类型名称已存在','e');
		}
		$ft = FlowType::find($_POST['id']);
		$ft->name = $_POST['name'];
		$ft->sort = $_POST['sort'];
		$ft->save();
		return a('','','s');
	}
	public function dlt_flow(){
	
		$flow = Flow::find($_POST['id']);
		if(!$flow) return a('','流程不存在','e');
		if($flow->status) return a('','流程已发布，不能删除','e');
		$r = Db::table('s_flows')->where('flow_id = '.$_POST['id'])->field('id')->find();
		if($r) return a('','已生成流程单，不能删除','e');
		$flowTable = Db::query("select distinct table_name from s_flow_table where flow_id = ".$_POST['id']);
		
		foreach($flowTable as $k => $v){	
		
			Db::execute("drop table `s_".$v['table_name']."`");
		}
		
		Flow::destroy($_POST['id']);
		Db::table('s_flow_auth')->where('flow_id = '.$_POST['id'])->delete();
		Db::table('s_flow_table')->where('flow_id = '.$_POST['id'])->delete();

		return a('','','s');

	}

	/**
     * 流程节点管理
     */
	public function node(){
		$list = Db::table('s_flow_node')->select();
		View::assign('list',$list);
		return View::fetch();
	}
	public function get_node(){
		$r = FlowNode::find($_POST['id']);
		return a($r,'','s');
	}
	public function edit_flow_node(){
		Db::table('s_flow_node')->where('id = '.$_POST['id'])->update($_POST);
		return a('','','s');
	}
	public function set_flow_node(){
		Db::table('s_flow_node')->where('id = '.$_POST['id'])->update(array('auth1' => $_POST['auth1']));
        return a('','','s');
	}
	public function insert_flow_node(){
		if(FlowNode::where("name = '".$_POST['name']."'")->find()) return a('','节点名称已经存在','e');
		$node = FlowNode::create(array('name' => $_POST['name'],'sort' => $_POST['sort'] ,'status' => 1));
		return a($node->id,'','s');
	}
	public function status_flow_node(){
		$ft = FlowNode::find($_POST['id']);
		$ft->status = $ft->status == 1?0:1;
		$ft->save();
		return a($ft->status,'','s');
	}
	/**
     * 数据权限管理
     */

	public function flow_auth(){
	
	

		$defaultType = array(
			1   => '登陆者用户',
			100 => '用户姓名',
			101 => '用户岗位',
			102 => '用户部门',
			103 => '系统日期',
		);

		$auth = FlowAuth::where("flow_id = ".$_GET['flowid']." && node_id = '".$_GET['node']."'")->find();

		$default = $auth2 = array();

		if(!$auth){
			$auth = [];
		}else{
			$auth = json_decode($auth->auth,true);
			foreach($auth as $k => $v){
				$auth2[$k] = $v;
			}
		}

		$attr = FlowTable::where("flow_id = ".$_GET['flowid'])->field('table_name,i,label,type,group,enum_name,enum_id')->order('table_name asc,id asc')->select()->toArray();	

		$tmp = $tmp1 = $tmp2 = array();
		$enumId = $enumName = array();
		foreach($attr as $k => $v){
			$tmp[$v['i']] = true;
			if($v['type'] == 'checkbox' || $v['type'] == 'radio'){
				$tmp1[$v['group']][] = $v;
			}else if($v['type'] == 'enum'){
				if( isset( $auth2[$v['i']]['d'] ) && $auth2[$v['i']]['d'] ){
					
					$enumId[] = $auth2[$v['i']]['d'];
				}
			}

			if(isset($auth2[$v['i']])){
				
			}else{
				if($_GET['node'] == 'creator'){
					$auth2[$v['i']] = array(
						'b' => $v['type'],
						'a' => 1,
						'm' => 0,
						'd' => '',
						'n' => 1,
						't' => ''
					);
				}else{
					
					$auth2[$v['i']] = array(
						'b' => $v['type'],
						'a' => 0,
						'm' => 0,
						'd' => '',
						'n' => 1,
						't' => ''
					);
				}
			}
		}
		
		if(count($enumId) > 0){
			$enumName = column(Db::table('s_enum_detail')->field('id,name')->where(" id in (".get_w($enumId,false).") ")->select()->toArray(),'id');
		}
		
		for( $i = 0; $i < count($attr); $i++ ){
			if( !$tmp[$attr[$i]['i']] ) continue;
			if($attr[$i]['type'] == 'checkbox' || $attr[$i]['type'] == 'radio'){
				foreach($tmp1[$attr[$i]['group']] as $k => $v){
					$tmp2[] = $v;
					$tmp[$v['i']] = false;
				}
			}else{
				$tmp2[] = $attr[$i];
			}
		}
		
		

		$tbody = "";
		$tmp3 = ''; // 用于给相同分组的checkbox和radio画分界线
		foreach($tmp2 as $k => $v){
			$type = '';
			if($v['type'] == 'checkbox'){
				$type = "<span style = 'position:absolute;display:inline-block;height:12px;width:12px;color:#28a745;right:0;bottom:0;font-size:12px;line-height:12px'>复</span>";
			}else if($v['type'] == 'radio'){
				$type = "<span style = 'position:absolute;display:inline-block;height:12px;width:12px;color:#28a745;right:0;bottom:0;font-size:12px;line-height:12px'>单</span>";
			}else if($v['type'] == 'enum'){
				$type = "<span style = 'position:absolute;display:inline-block;height:12px;width:12px;color:#28a745;right:0;bottom:0;font-size:12px;line-height:12px'>枚</span>";
			}else if($v['type'] == 'relation'){
				$type = "<span style = 'position:absolute;display:inline-block;height:12px;width:12px;color:#9b9b9b;right:0;bottom:0;font-size:12px;line-height:12px'>联</span>";
			}

			if(isset($tmp1[$v['group']])){
				$checked = $auth2[$v['i']]['d'] == 1?'√':'';
				if($v['i'] == $tmp1[$v['group']][0]['i']){
					$tmp = "";
					//if($v['type'] == 'checkbox'){
						//$tmp = "<select class = 'browser-default'><option value = '-1'>无限制</option>";
						//for($i = 1; $i <= count( $tmp1[$v['group']]); $i++){
						//	$tmp .= "<option value = '".$i."'>".$i."个</option>";
						//}
						//$tmp .= "</select>";
					//}
					$tbody .= "<tr data-field = '".$v['i']."' data-type = '".$v['type']."'><td style = 'position:relative'>".$v['table_name'].$type."</td><td>".$v['label']."</td><td><input value = '0' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '1' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td></td><td></td><td class = 'checked ".$v['group']."' data-type = '".$v['type']."' data-group = '".$v['group']."'>".$checked."</td></tr>";
				}else{
					$tbody .= "<tr data-field = '".$v['i']."' data-type = '".$v['type']."'><td></td><td>".$v['label']."</td><td><input value = '0' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '1' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td></td><td></td><td  class = 'checked ".$v['group']."' data-type = '".$v['type']."' data-group = '".$v['group']."'>".$checked."</td></tr>";
				}
			}else{
				
				$default = '';
				if( $v['type'] == 'enum' ){
					
					if( $auth2[$v['i']]['d'] ) $default = $enumName[$auth2[$v['i']]['d']]['name'];
					$tbody .= "<tr data-enum_id = '".$v['enum_id']."' data-field = '".$v['i']."' data-type = '".$v['type']."'><td style = 'position:relative'>".$v['table_name'].$type."</td><td>".$v['label']."</td><td><input value = '0' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '1' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '2' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input name = '".$v['i']."'  type = 'checkbox' class = 'aya-checkbox' /></td><td class = 'checked' data-d = '".$auth2[$v['i']]['d']."'>".$default."</td></tr>";
				}else{
					$disabled = $auth2[$v['i']]['a'] == 1?'':"disabled";
					$d = $auth2[$v['i']]['t']?$defaultType[$auth2[$v['i']]['t']]:$auth2[$v['i']]['d'];
					$tbody .= "<tr data-enum_id = '".$v['enum_id']."' data-field = '".$v['i']."' data-type = '".$v['type']."'><td style = 'position:relative'>".$v['table_name'].$type."</td><td>".$v['label']."</td><td><input value = '0' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '1' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input value = '2' name = '".$v['i']."' type = 'radio' class = 'aya-radio' /></td><td><input name = '".$v['i']."'  type = 'checkbox' class = 'aya-checkbox' $disabled /></td><td class = 'checked'>".$d."</td></tr>";
				}
			}
		}


		
		View::assign('defaulttype',json_encode($defaultType) );
		View::assign('auth', json_encode($auth2) );
		View::assign('tbody',$tbody);
		return View::fetch();
	}

	public function test(){
		

		dump($r);
		
		
	}

	public function edit_flow_auth(){
	
		
		if( $flowAuth = FlowAuth::where("flow_id = ".$_POST['flow_id']." && node_id = '".$_POST['node_id']."'")->find() ){
			$flowAuth->auth = $_POST['auth'];
			$flowAuth->save();
		}else{
			FlowAuth::create($_POST);
		}
		return a('','','s');
	}

	/**
     * 流程类型管理 - 新增
     */
	public function flow_attr(){
		
		$attr = FlowTable::where("flow_id = ".$_GET['flowid']." && table_name like 'f%'")->field('i,label,type,enum_name,enum_id')->select()->toArray();
		
		$attr2 = array(
			array('i' => 'aya1','label' =>  '发起者部门','type' => ''),
			array('i' => 'aya2','label' =>  '发起者岗位','type' => ''),
			array('i' => 'aya3','label' =>  '执行者部门','type' => ''),
			array('i' => 'aya4','label' =>  '执行者岗位','type' => ''),
		);
		$attr = array_merge($attr,$attr2);
		
		View::assign('attr',$attr);
		View::assign('jdqx',FlowNode::select());
		return View::fetch();
	}

	

	/**
     * 流程类型管理 - 删除
     */
	public function dlt_flow_type(){
	
		$r = Db::table('s_flow')->where('type_id = '.$_POST['id'])->field('id')->find();
		if($r) return a('','已使用，不能删除','e');
		FlowType::destroy($_POST['id']);
		return a('','','s');
	}
	/**
     * 流程类型管理 - 修改状态
     */
	public function status_flow_type(){
		$ft = FlowType::find($_POST['id']);
		$ft->status = $ft->status == 1?0:1;
		$ft->save();
		return a($ft->status,'','s');
	}
	/**
     * 后台管理首页
     */
    public function manage(){
		$r = $this->manage_query(array('page' => 1,'n' => 1000));
		View::assign('page',$r['page_return']);
		View::assign('tbody',$r['tbody']);
		return View::fetch();
	}
	public function manage_search(){
		 $r = $this->manage_query($_POST);
        return a(array('tbody' => $r['tbody'],'page' => $r['page_return']),'','s');
	}
	public function manage_query($post){
		$post['n'] = (int)$post['n'];
		$post['page'] = (int)$post['page'];
		$page_return = array();
        $page_return['totles'] = Flow::count();     //总记录数 返回
        $page_return['totle_page'] = ceil($page_return['totles'] / $post['n']);  //总页数 返回
        $page_return['n'] = $post['n'];
        $page_return['current_page'] = $post['page'];     //当前页 返回
		$start = $page_return['n'] * ( $page_return['current_page'] - 1);
		$r = Db::query(" select a.id,a.title,a.maker,a.status,a.create_datetime,a.modify_datetime,b.name as type_name from s_flow as a left join s_flow_type b on a.type_id = b.id order by a.id desc limit ".$start.",".$page_return['n']." ");
		$tbody = "";
		foreach($r as $k => $v){
			$tbody .= "<tr data-id = '".$v['id']."'><td>".($v['type_name']?$v['type_name']:'无分类')."</td><td>".$v['title']."</td><td>".$v['maker']."</td><td>".($v['status']?'发布':'未发布')."</td><td>".$v['create_datetime']."</td><td>".$v['modify_datetime']."</td></tr>";
		}
		 return array('tbody' => $tbody,'page_return' => $page_return);

	}
	/**
     * 新建流程表格 - 第一步 新建表格
     */
	public function step_1(){
		//$_GET['id'] = 13;
		$form = $_GET['id']?Flow::find($_GET['id']):array('id' => 0,'form' => '','title' => '','td_width' => '{}','type_id' => 0);
		$enum = new Enum;
		$type = FlowType::where('status = 1')->order('sort asc')->select();
		View::assign('types',$type);
		View::assign( 'select' , $enum->mySelect() );
		View::assign( 'form' , $form );
		return View::fetch();
	}
	/**
     * 新建流程表格 - 第二步 数据管理
     */
	public function step_2(){
		$r = FlowTable::where('flow_id = '.$_GET['id'])->field('table_name,type,i,length1,length2,relation_i,relation_a')->order('i asc')->select()->toArray();
		if(!$r) $r = array( array('i' => 'i000') );
		View::assign( 'maxI',(int)substr($r[count($r) - 1]['i'],1) );
		View::assign( 'field',json_encode(column($r,'i')) );
		return View::fetch();
	}
	/**
     * 新增流程
     */
	public function save_table(){
		//sp();exit();
		//gp();
		$_POST['form'] = str_replace('table-form-td-selected','',trim($_POST['form']));
		if(isset($_POST['flow_id']) && $_POST['flow_id']){
			$r = $this->edit_table($_POST);
		}else{
			$r = $this->insert_table($_POST);
		}
	}

	/**
     * 修改流程表格
     */

	 public function edit_table(array $post){
		$form = $post['form'];
		$r = FlowTable::where('flow_id = '.$post['flow_id'])->order('i asc')->select()->toArray();
		
		$field = column($r,'i');
		if(!isset($post['data'])) $post['data'] = array();
		
		$tableNameMap = $newField = $newTable = $update = array();
		
		$subform = array();  // 需要新加的table
		foreach($post['data'] as $k => $v){
			if($v['type2'] == '新'){
				$tmp = substr($v['table'],0,1);
				if($tmp != 'f' && $tmp != 's') $subform[$v['table']] = 1;
			}else{
				
				$tableNameMap[$v['table']] = $v['table'];
			}
		}
		$newFormmain = $newSubform = 0;
		if( count($subform) > 0){
			$max = new Max;
			$tmp = $max->get_max();
			foreach($subform as $k => $v){
				if($k == '主表'){
					$form = str_replace('mainform','form-'.sprintf('%04d',$tmp['f']),$form);
					$tableNameMap['主表'] = 'form-'.sprintf('%04d',$tmp['f']);
					$newFormmain++;
				}else{
					$form = str_replace($k,'subform-'.sprintf('%04d',$tmp['s']),$form);
					$tableNameMap[$k] = 'subform-'.sprintf('%04d',$tmp['s']++);
					$newSubform++;
				}
			}
		}
		if($newFormmain > 0 || $newSubform > 0 ) $max->set_max('flow_table',$newFormmain,$newSubform );
		
		//考虑连主表都没有的情况

		//考虑连主表都没有的情况 - 结束

		// 多个 table 的情况，第二个table 会找不到主表

		if( count($tableNameMap) > 0 ){
			$tmp = '';
			foreach($tableNameMap as $k => $v){
				if( substr($v,0,1) == 'f'){
					$tmp = $v;
					break;
				}
			}
			if($tmp != '' && isset( $tableNameMap['主表'] ) ) $tableNameMap['主表'] = $tmp;
		}
		//结束
		
		$hasSend = false;
		$checkSendTables = array();
		foreach($field as $k => $v){
			$checkSendTables[$v['table_name']] = 1;
		}
		
		foreach($checkSendTables as $k => $v){
			if( count(Db::query("select id from `s_".$k."` limit 1")) > 0 ){
				$hasSend = true;
				break;
			}
		}

		foreach($post['data'] as $k => $v){
			if($v['type2'] == '新'){
				if(substr($v['table'],0,1) == 'f' || substr($v['table'],0,1) == 's'){
					$newField[$v['table']][] = $v;
					
				}else{
					$table = isset($tableNameMap[$v['table']])?$tableNameMap[$v['table']]:$v['table'];
					$newField[$table][] = $v;
				}
			}else{
				switch($v['type']){
					case 'varchar':
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type']){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}
							if($field[$v['i']]['length1'] != $v['length1']){
								if( $v['length1'] < $field[$v['i']]['length1'] ){
									rt('',$v['i'].'：修改后字段长度不能小于原来字段长度','e');
								}
								$update[$v['table']][] = $v;
							}
						}else{
							if($field[$v['i']]['length1'] != $v['length1']){
								$update[$v['table']][] = $v;
							}
						}
					break;
					case 'int' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type']){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}
							if($field[$v['i']]['length1'] != $v['length1']){
								if( $v['length1'] < $field[$v['i']]['length1'] ){
									rt('',$v['i'].'：修改后字段长度不能小于原来字段长度','e');
								}
								$update[$v['table']][] = $v;
							}
						}else{
							if($field[$v['i']]['length1'] != $v['length1']){
								$update[$v['table']][] = $v;
							}
						}
					break;
					case 'decimal' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type']){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}
							if($field[$v['i']]['length1'] != $v['length1'] || $field[$v['i']]['length2'] != $v['length2']){
								if( $v['length1'] < $field[$v['i']]['length1'] || $v['length2'] < $field[$v['i']]['length2']){
									rt('',$v['i'].'：修改后字段长度不能小于原来字段长度','e');
								}
								$update[$v['table']][] = $v;
							}
						}else{
							if($field[$v['i']]['length1'] != $v['length1'] || $field[$v['i']]['length2'] != $v['length2']){
								$update[$v['table']][] = $v;
							}
						}
					break;
					case 'person' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type'] ){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}else{
								
							}
						}else{
							if( $v['type'] != $field[$v['i']]['type'] ){
								$update[$v['table']][] = $v;
							}
							
						}
					break;
					case 'department' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type'] ){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}else{
								
							}
						}else{
							if( $v['type'] != $field[$v['i']]['type'] ){
								$update[$v['table']][] = $v;
							}
						}
					break;
					case 'post' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type'] ){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}else{
								
							}
						}else{
							if( $v['type'] != $field[$v['i']]['type'] ){
								$update[$v['table']][] = $v;
							}
						}
					break;
					case 'relation' :
						if( $hasSend ){
							if( $v['type'] != $field[$v['i']]['type'] || $v['relation_i'] != $field[$v['i']]['relation_i'] || $v['relation_a'] != $field[$v['i']]['relation_a']){
								rt('',$v['i'].'：已生成流程单，不能修改字段类型','e'); 
							}
						}else{
							if( $v['type'] != $field[$v['i']]['type'] || $v['relation_i'] != $field[$v['i']]['relation_i'] || $v['relation_a'] != $field[$v['i']]['relation_a']){
								$update[$v['table']][] = $v;
							}
							
						}
					break;
					case 'enum':
						//$update[] = $v;
					break;
					case 'checkbox' :
						if($v['label'] != $field[$v['i']]['label'] || $v['group'] != $field[$v['i']]['group']) $update[$v['table']][] = $v;
					break;
					case 'radio' :
						if($v['label'] != $field[$v['i']]['label'] || $v['group'] != $field[$v['i']]['group']) $update[$v['table']][] = $v;
					break;
					default:
				}	
			}
		}
		
		$tables = array();  // 已存在的数据表

		$sql = '';

		

		foreach($update as $k => $v){
			$sql = "";
			foreach($v as $k1 => $v1){
				switch($v1['type']){
					case 'varchar' :
						$sql .= " modify column ".$v1['i']." varchar(".$v1['length1']."),";
						FlowTable::update( ['type' => 'varchar','length1' => $v1['length1'] ],['id' => $field[$v1['i']]['id']] );
					break;
					case 'int' :
						$sql .= " modify column ".$v1['i']." int(".$v1['length1']."),";
						FlowTable::update( ['type' => 'int' , 'length1' => $v1['length1'] ],['id' => $field[$v1['i']]['id']] );
					break;
					case 'decimal' :
						$sql .= " modify column ".$v1['i']." decimal(".$v1['length1'].",".$v1['length2']."),";
						FlowTable::update( ['type' => 'decimal','length2' => $v1['length2'],'length1' => $v1['length1'] ],['id' => $field[$v1['i']]['id']] );
					break;
					case 'checkbox':
						FlowTable::update( ['label' => $v1['label'],'group' => $v1['group'] ],['id' => $field[$v1['i']]['id']] );
					break;
					case 'radio':
						FlowTable::update( ['label' => $v1['label'],'group' => $v1['group'] ],['id' => $field[$v1['i']]['id']] );
					break;
					case 'person' :
						$sql .= " modify column ".$v1['i']." int(11),";
						FlowTable::update( ['type' => 'person','length1' => null,'length2' => null,'relation_i' => null,'relation_a' => null],['id' => $field[$v1['i']]['id']] );
					break;
					case 'department' :
						$sql .= " modify column ".$v1['i']." int(11),";
						FlowTable::update( ['type' => 'department','length1' => null,'length2' => null,'relation_i' => null,'relation_a' => null],['id' => $field[$v1['i']]['id']] );
					break;
					case 'post' :
						$sql .= " modify column ".$v1['i']." int(11),";
						FlowTable::update( ['type' => 'post','length1' => null,'length2' => null,'relation_i' => null,'relation_a' => null],['id' => $field[$v1['i']]['id']] );
					break;
					case 'relation' :
						$sql .= " modify column ".$v1['i']." varchar(255),";
						FlowTable::update( ['type' => 'relation','length1' => null,'length2' => null,'relation_i' => $v1['relation_i'],'relation_a' => $v1['relation_a']],['id' => $field[$v1['i']]['id']] );
					break;
					default:
				}
			}
			if($sql != ""){
				$sql = substr($sql,0,-1);
				$sql = "ALTER TABLE `s_".$k.'` '.$sql;
				Db::execute($sql);
			}

			//echo $sql;
			//echo '<br />';
		}
		
		

		if(count($tableNameMap) > 0){
			$r = FlowTable::where("flow_id = ".$post['flow_id'])->field('distinct table_name')->select()->toArray();
			foreach($r as $k => $v){
				$tables[] = $v['table_name'];
			}
		}
		
		$add1 = array();
		foreach($newField as $k => $v){
			
			$sql = "";

			if( in_array($k,$tables) ){
				
				foreach($v as $k1 => $v1){
				
					$tmp = array(
						'table_name' => $k,
						'flow_id' => $post['flow_id'],
						'i' => $v1['i'],
						'label' => $v1['label'],
						'type' => $v1['type'],
						'length1' => $v1['length1']?$v1['length1']:0,
						'length2' => $v1['length2']?$v1['length2']:0,
						'enum_name' => $v1['enum_name']?$v1['enum_name']:'',
						'enum_id' => $v1['enum_id']?$v1['enum_id']:0,
						'group' => $v1['group'],
						'main' => substr($k,0,1) == 'f'?1:0,
						'relation_i' => $v1['relation_i'],
						'relation_a' => $v1['relation_a']
					);

					$add1[] = $tmp;
					
					

					switch($v1['type']){
						case 'varchar':
							$sql .= " ADD COLUMN ".$v1['i']." VARCHAR(".$v1['length1'].") DEFAULT NULL,";
						break;
						case 'int':
							$sql .= " ADD COLUMN ".$v1['i']." int(".$v1['length1'].") DEFAULT NULL,";
						break;
						case 'decimal':
							$sql .= " ADD COLUMN ".$v1['i']." decimal(".$v1['length1'].",".$v1['length2'].") DEFAULT NULL,";
						break;
						case 'relation' :
							$sql .= "ADD COLUMN ".$v1['i']." VARCHAR(255) DEFAULT NULL,";
						break;
						case 'textarea' :
							$sql .= " ADD COLUMN ".$v1['i']." text,";
						break;
						case 'enum' :
							$sql .= " ADD COLUMN ".$v1['i']." int(11) DEFAULT NULL,";
						break;
						case 'person' :
							$sql .= " ADD COLUMN ".$v1['i']." int(11) DEFAULT NULL,";
						break;
						case 'department' :
							$sql .= " ADD COLUMN ".$v1['i']." int(11) DEFAULT NULL,";
						break;
						case 'post' :
							$sql .= " ADD COLUMN ".$v1['i']." int(11) DEFAULT NULL,";
						break;
						case 'checkbox' :
							$sql .= " ADD COLUMN ".$v1['i']." int(1) DEFAULT NULL,";
						break;
						case 'radio' :
							$sql .= " ADD COLUMN ".$v1['i']." int(1) DEFAULT NULL,";
						break;
						default:
					}	
					
				}
				if($sql != ''){
					Db::execute( "ALTER TABLE `s_".$k."` ".substr($sql,0,-1) );
				}
			}else{
				
				$sql = '';
				if(substr($k,0,1) == 'f'){  // 主表
					$sql = "CREATE TABLE `s_".$k."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `flows_id` int(11) NOT NULL DEFAULT '0',";
				}else{
					$sql = "CREATE TABLE `s_".$k."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `flows_id` int(11) NOT NULL DEFAULT '0',";
				}

				foreach($v as $k1 => $v1){

					$tmp = array(
						'table_name' => $k,
						'flow_id' => $post['flow_id'],
						'i' => $v1['i'],
						'label' => $v1['label'],
						'type' => $v1['type'],
						'length1' => $v1['length1']?$v1['length1']:0,
						'length2' => $v1['length2']?$v1['length2']:0,
						'enum_name' => $v1['enum_name']?$v1['enum_name']:'',
						'enum_id' => $v1['enum_id']?$v1['enum_id']:0,
						'group' => $v1['group'],
						'main' => substr($k,0,1) == 'f'?1:0
					);
					$add1[] = $tmp;

					if(isset($v1['type'])){

						switch($v1['type']){
							case 'varchar':
								$sql .= "`".$v1['i']."` varchar(".$v1['length1'].") DEFAULT NULL,";
							break;
							case 'int' :
								$sql .= "`".$v1['i']."` int(".$v1['length1'].") DEFAULT NULL,";
							break;
							case 'decimal' :
								$sql .= "`".$v1['i']."` decimal(".$v1['length1'].",".$v1['length2'].") DEFAULT NULL,";
							break;
							case 'relation':
								$sql .= "`".$v1['i']."` varchar(255) DEFAULT NULL,";
							break;
							case 'person' :
								$sql .= "`".$v1['i']."` int(11) DEFAULT 0,";
							break;
							case 'department' :
								$sql .= "`".$v1['i']."` int(11) DEFAULT 0,";
							break;
							case 'post' :
								$sql .= "`".$v1['i']."` int(11) DEFAULT 0,";
							break;
							case 'textarea' :
								$sql .= "`".$v1['i']."` text,";
							break;
							case 'enum' :
								$sql .= "`".$v1['i']."` int(11) DEFAULT 0,";
							break;
							case 'checkbox' :
								$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
							break;
							case 'radio' :
								$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
							break;
							case 'index' :
								$sql .= "`".$v1['i']."` int(4) DEFAULT 0,";
							default:
						}	
					}else{
						$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
					}
					
				}
				
				if(substr($k,0,1) == 'f'){  // 主表
					$sql .= " PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";
				}else{
					$sql .= " PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";
				}
				Db::execute($sql);
			}
		}

		$update2 = array('type_id' => $post['type_id'],'td_width' => $post['td_width'],'form' => $form,'title' => trim($post['flow_name']),'modify_datetime' => date('Y-m-d H:i:s'),'cut_form' => $this->cut_form($form) ) ;

		Flow::update($update2,  array( 'id' => $post['flow_id'] ) );

		$flowTable = new FlowTable;
		
		if(count($add1) > 0) $flowTable->saveAll($add1);


		if($update2['type_id'] > 0){
			$r = FlowType::find($update2['type_id']);
			$update2['type_name'] = $r->name;
		}else{
			$update2['type_name'] = '无分类';		
		}
		
		rt($update2,'','s');

	 }

	 public function cut_form($form){
		$form = str_replace('text-align: center;','',$form);
		$form = str_replace('vertical-align: middle;','',$form);
		$form = str_replace('text-align:center;','',$form);
		$form = str_replace('vertical-align:middle;','',$form);
		$form = str_replace('background: rgb(255, 255, 255) none repeat scroll 0% 0%;','',$form);
		$form = str_replace('colspan="1"','',$form);
		$form = str_replace('rowspan="1"','',$form);
		$form = str_replace('class=""','',$form);
		$form = preg_replace('/data-x="\d{1,2}"/','',$form);
		$form = preg_replace('/data-y="\d{1,2}"/','',$form);
		return $form;
	 }

	/**
     * 新增流程表格
     */
	 public function insert_table(array $post){
		
		$max = new Max;
		$tmp = $max->get_max();
		if(!isset($post['form']) || !$post['form']) rt('','流程内容不能为空','e');
		$form = $post['form'];

		$form = str_replace('mainform','form-'.sprintf('%04d',$tmp['f']),$form);
		$tableNameMap = array( 'mainform' => 'form-'.sprintf('%04d',$tmp['f']) );
		$data = isset($_POST['data'])?$_POST['data']:array();
		$subform = array();

		foreach($data as $k => $v){
			if( $v['table'] == '主表' ) $data[$k]['table'] = 'mainform';
		}
		
		foreach($data as $k => $v){
			if($v['table'] != 'mainform'){
				$subform[$v['table']] = 1;
			}
		}
		
		foreach($subform as $k => $v){
			$form = str_replace($k,'subform-'.sprintf('%04d',$tmp['s']),$form);
			$tableNameMap[$k] = 'subform-'.sprintf('%04d',$tmp['s']++);
		}

		$max->set_max('flow_table',1,count($subform));
		$flow = new Flow;
		$flow->title = $post['flow_name'];
		$flow->form =  $form;
		$flow->create_datetime = date('Y-m-d H:i:s',time());
		$flow->maker  = Session::get('userinfo')['name'];
		$flow->status = 0;
		$flow->td_width = $post['td_width'];
		$flow->type_id = $post['type_id'];
		$flow->cut_form =  $this->cut_form($form);


		$flow->save();

		$newTable = array();

		foreach($data as $k => $v){
			$data[$k]['flow_id'] = $flow->id;
			$data[$k]['main'] = $data[$k]['table'] == 'mainform' ? 1: 0;
			$data[$k]['table_name'] = $tableNameMap[$data[$k]['table']];
			$data[$k]['length'] = isset($data[$k]['length'])?$data[$k]['length']:0;
			$data[$k]['enum_name'] = isset($data[$k]['enum_name'])?$data[$k]['enum_name']:'';
			$data[$k]['enum_id'] = isset($data[$k]['enum_id'])?$data[$k]['enum_id']:0;
			$data[$k]['group'] = isset($data[$k]['group'])?$data[$k]['group']:'';
			$newTable[$data[$k]['table_name']][] = $data[$k];
		}
		
	
		$flowTable = new FlowTable;
		if(count($data) > 0) $flowTable->saveAll($data);

		foreach($newTable as $k => $v){
			$sql = '';
			if(substr($k,0,1) == 'f'){  // 主表
				$sql = "CREATE TABLE `s_".$k."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `flows_id` int(11) NOT NULL,";
			}else{
				$sql = "CREATE TABLE `s_".$k."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `flows_id` int(11) NOT NULL,";
			}

			foreach($v as $k1 => $v1){
				if(isset($v1['type'])){

					switch($v1['type']){
						case 'varchar':
							$sql .= "`".$v1['i']."` varchar(".$v1['length1'].") DEFAULT NULL,";
						break;
						case 'int' :
							$sql .= "`".$v1['i']."` int(".$v1['length1'].") DEFAULT NULL,";
						break;
						case 'decimal' :
							$sql .= "`".$v1['i']."` decimal(".$v1['length1'].",".$v1['length2'].") DEFAULT NULL,";
						break;
						case 'enum' :
							$sql .= "`".$v1['i']."` int(11) DEFAULT 0,";
						break;
						case 'checkbox' :
							$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
						break;
						case 'radio' :
							$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
						break;
						case 'index' :
							$sql .= "`".$v1['i']."` int(4) DEFAULT 0,";
						default:
					}	
				}else{
					$sql .= "`".$v1['i']."` int(1) DEFAULT 0,";
				}
				
			}
			
			if(substr($k,0,1) == 'f'){  // 主表
				$sql .= " PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";
			}else{
				$sql .= " PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";
			}

			Db::execute($sql);
		}

			
		$r = $flow->toArray();
		
		if($r['type_id'] > 0){
			$tmp = FlowType::find($r['type_id']);
			$r['type_name'] = $tmp->name;
		}else{
			$r['type_name'] = '无分类';
		}

		rt($r,'','s');
		
	 }

	 


	 /**
     * 流程管理
     */
	 public function flow(){
		if(isset($_GET['id']) && $_GET['id']){
			$flow = Flow::find($_GET['id']);
			if(!$flow['p']) $flow = array('id' => $_GET['id'],'p' => json_encode(array()),'node' => json_encode(array()),'max_id' => 0);
		}else if(is_set($_GET,'type')){
		
			$flow = Flow::where("system_flow = 1 && system_flow_type = '".$_GET['type']."'")->find();
			if(!$flow['p']) $flow = array('id' => 0,'type' => $_GET['type'],'p' => json_encode(array()),'node' => json_encode(array()),'max_id' => 0);
		}else{
			$flow = array('p' => array(),'node' => array(),'max_id' => 0);
		}
		$dep = Department::field('id,name')->select()->toArray();
		if($dep){
			$tmp = array();
			foreach($dep as $k => $v){
				$tmp[$v['id']] = $v['name'];
			}
			$dep = $tmp;
		}else{
			$dep = array('-1' => 0);
		}
		$pst = Post::field('id,name')->select()->toArray();
		if($pst){
			$tmp = array();
			foreach($pst as $k => $v){
				$tmp[$v['id']] = $v['name'];
			}
			$pst = $tmp;
		}else{
			$pst = array('-1' => 0);
		}
		if(!isset($_GET['type'])){
			$flowTable = Db::query("select b.id,b.enum_id,b.name,a.i,a.label from s_flow_table a left join s_enum_detail b on a.enum_id = b.enum_id where a.flow_id = ".$_GET['id']." && a.table_name like 'f%' ");
		}else{
			$flowTable = array();
		}
		
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
		View::assign('label',json_encode($label));
		View::assign('enum',json_encode($enum));
		View::assign('enumi',json_encode($enumI));
		View::assign('dep', json_encode($dep));
		View::assign('pst', json_encode($pst));
		View::assign('flowid',1);
		View::assign('jdqx',1);
		View::assign('flow',$flow);
		return View::fetch();
	 }

	/**
     * 流程管理 - 选择审批人
     */
	 public function flow_select(){
		$dept = new Department;
		$tree = $dept->tree();
		View::assign('tree',$tree);
		$post = new Post;
		View::assign('post1',$post->mySelect());
		View::assign('group',array());
		View::assign('post',array());
		return View::fetch();
	 }

	 
	/**
     * 保存流程
     */
	 public function flow_save(){

		
		if(is_set($_POST,'type')){
			$flow = Flow::where("system_flow = 1 && system_flow_type = '".$_POST['type']."'")->find();
			if(!$flow){
				$flow = Flow::create(['system_flow' => 1,'system_flow_type' => $_POST['type']]);
			}
		}else{
			$flow = Flow::find($_POST['id']);
		}
		$flow->p = $_POST['p'];
		$flow->node = $_POST['node'];
		$flow->max_id = $_POST['max_id'];
		$flow->save();

		
		return a('','','s');
	 }

	 /**
     * 禁用，发布流程
     */
	 public function changeStatus(){
	
		$id = $_POST['id'];
		$flow = Flow::find($id);
		$flow->status = $flow->status == 1?0:1;
		$status = $flow->status == 1?'发布':'未发布';
		$flow->save();
		return a($status,'','s');
	 }
	/**
    +------------------------------------------------------------------------------
    * 检查执行条件
    +------------------------------------------------------------------------------
    */
    public function check_zxtj(){
	
		

		$zxtj = json_decode($_POST['zxtj'],true);
        $expression = '';
        foreach($zxtj as $k => $v){
			if( count($v) == 5 ){
				$expression .= $v[0].' 0 == 0 '.$v[3].' '.$v[4].' ';
			}else{
				if(!$v[3]) return a('','表达式不正确！','e');
				$v[3] = 0;
				$expression .= $v[0].' 0 '.$v[2].' 0 '.$v[4].' '.$v[5].' ';
			}
        }
        $expression .= ';';	
		
		
		
        try{
            eval($expression);
        }catch(\Exception $e){
            return a('','表达式不正确！','e');
        }catch(\Error $e){
            return a('','表达式不正确！','e');
        }
        return a('','e','s');
    }
	/**
    +------------------------------------------------------------------------------
    * 执行条件 - 选择部门
    +------------------------------------------------------------------------------
    */
	public function flow_select_department(){
		$dept = new Department;
		$tree = $dept->tree();
		View::assign('tree',$tree);
		return View::fetch();
	}

	/**
    +------------------------------------------------------------------------------
    * 执行条件 - 选择岗位
    +------------------------------------------------------------------------------
    */
	public function flow_select_post(){
		$post = Post::where('status = 1')->field('id,name,type_name')->select();
		View::assign('post',$post);
		return View::fetch();
	}
	/**
    +------------------------------------------------------------------------------
    * 执行条件 - 选择枚举
    +------------------------------------------------------------------------------
    */
	public function flow_select_enum(){
		$r = Db::table('s_enum_detail')->where('status = 1 && enum_id = '.$_GET['id'])->field('id,name,value')->order('sort asc')->select();
		View::assign('enum',$r);
		return View::fetch();
	}




	


	
	
}
