<?php
namespace app\model\erp;
use think\Model;
use think\facade\Db;

/*
	0 存货档案
	1 供应商
	2 客户


*/

class BasicClass extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'class_id'	=> 'int',
		'code' => 'varchar',
		'name' => 'varchar',
		'pid'	=> 'int',

	];

	public function getTree($post,$a = true,$code = true){
		$r = $this::where('class_id = '.$post['class_id'])->order('pid asc,code asc')->select()->toArray();
		if($r){
			$pid = $first_level = $attr = array();
			foreach($r as $k => $v){
				if($code){
					$v['showname'] = $v['name'].' - '.$v['code'].'';
				}else{
					$v['showname'] = $v['name'];
				}
				$pid[$v['pid']][] = $v['id'];
				$attr[$v['id']] = $v;
				if($v['pid'] == 0) $first_level[] = $v['id'];
			}

			// k => v ,k 为 ztree 上的属性 , v 为 数据库中的属性。两者的对应关系
			$key = array(
				'id' => 'id',
				'name' => 'showname',
				'code' => 'code',
				'realname' => 'name'
			);

			$tree = $this->create_tree($attr,$pid,$first_level,$key);
			if($a){
				return a($tree);
			}else{
				return $tree;
			}
		}else{
			if($a){
				return a(array());
			}else{
				return array();
			}
			
		}

	}


	public function create_tree($attr,$pid,$ids,$key){
		$r = array();
		
		foreach($ids as $k => $v){
			
			$tmp = array();
			
			foreach($key as $k1 => $v1){
				$tmp[$k1] = $attr[$v][$v1];
			}
			
			if(isset($pid[$v])){
				$tmp['children'] = $this->create_tree($attr,$pid,$pid[$v],$key); 
			}
			
			$r[] = $tmp;
		}
		return $r;
	}


	public function add($post){
		if(trim($post['name_new']) == '' || trim($post['code_new']) == '') return a('','分类名称或编码不能为空','e');
		if($post['pid_new'] == '') $post['pid_new'] = 0;
		$data = array(
			'pid' => $post['pid_new'],
			'code' => trim($post['code_new']),
			'class_id' => $post['class_id']
		);
		$r = $this::where($data)->find();
		if($r) return a('','同一级下编码不能相同','e');
		$data['name'] = trim($post['name_new']);
		$class = new BasicClass;
		$class->save($data);
		
		return a($class);
	}

	public function select1(){
		return $this->order('sort asc')->select();
	}
	

	// 返回 select 中的选择项，带缩进
	public function get1($class_id){
		$r = $this::where('class_id = '.$class_id)->order('pid asc , code asc')->field('id,name,pid')->select()->toArray();
		$pid = $attr = array();
		foreach($r as $k => $v){
			$pid[$v['pid']][] = $v['id'];
			$attr[$v['id']] = $v;
		}
		if($r){
			return $this->get2($attr,$pid,0,0);
		}else{
			return array();	
		}
	}

	private function get2($attr,$pid,$id,$level){
		
		$r = array();
		foreach($pid[$id] as $k => $v){
			//if($level > 0) $attr[$v]['name'] = str_repeat('- ',$level).$attr[$v]['name'];
			$r[] = $attr[$v];
			if(isset($pid[$v])){
				$l = $level + 1;
				$r = array_merge($r,$this->get2($attr,$pid,$v,$l));
			}
		}
		return $r;
	}

	
	public function dlt($post){
		// 这里要加上不能删除的判断
		if(BasicClass::where('pid = '.$post['id'])->field('id')->find()) return a('','存在子分类，不能删除','e');
		$class = BasicClass::find($post['id']);
		if(!$class) return a('','子类不存在','e');
		$check = null;
		switch($class->class_id){
			case 0 :
				$check = Db::table('s_inventory')->where('class_id = '.$post['id'])->field('id')->find();
			break;
			case 1 :

			break;
			case 2 :

			break;
			default:
		}
		if($check) return a('','不能删除','e');
		$this->destroy($post['id']);
		return a();
	}

}
