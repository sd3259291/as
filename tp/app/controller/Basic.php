<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;

use think\facade\Cache;

use app\model\Enum;

use app\model\EnumDetail;

use app\validate\EnumDetailValidate;
use think\exception\ValidateException;

class Basic extends BaseController{

	/**
     * 枚举首页
    */
    public function enum(){
		
		$enum = new Enum;
		$tree = $enum->tree();
		View::assign('tree',$tree);
		return View::fetch();
	}
	/**
     * 增加枚举类别
    */
	public function addEnum(){
		$enum = new Enum;

		if(!$_POST['enum_type_pid']) $_POST['enum_type_pid'] = 0;

		if( $_POST['enum_type_name'] == '') return a('','枚举类别 名称不能为空','e');

		if( $_POST['enum_type_pid'] != 0){

			$tmp = Enum::find($_POST['enum_type_pid']);

			if($tmp->system == 1) return a('','系统枚举不能新增类别','e');

			if($tmp->pid > 0){
				return a('','不能建立二层枚举类别','e');
			}

		}

		$enum->pid  = $_POST['enum_type_pid'];
		$enum->name = $_POST['enum_type_name'];
		$enum->sort = $_POST['enum_type_sort']?$_POST['enum_type_sort']:0;
		$enum->save();
		return a($enum->toArray(),'','s');
	}
	/**
     * 删除枚举类别
    */
	public function dltEnum(){
		if(EnumDetail::where('enum_id = '.$_POST['id'])->field('id	')->find()) return a('','存在枚举值，不能删除','e');
		if(Enum::where('pid = '.$_POST['id'])->field('id')->find()) return a('','存在子类型，不能删除','e');
		$enum = Enum::find($_POST['id']);
		if($enum->system == 1) return a('','系统枚举不能删除','e');
		Enum::destroy($_POST['id']);
		return a('','','s');
	}
	/**
     * 编辑枚举类别
    */
	public function editEnum(){
		$enum = Enum::find($_POST['enum_type_id']);
		if(!$enum) return a('','枚举不存在','e');
		if($enum->system == 1) return a('','系统枚举不能修改','e');
		if( $_POST['enum_type_name'] == '') return a('','枚举类别 名称不能为空','e');
		$enum->name = $_POST['enum_type_name'];
		$enum->sort = $_POST['enum_type_sort'];
		$enum->save();
		return a('','','s');
	}
	/**
     * 编辑枚举类别
    */
	public function addEnumDetail(){

		if( $_POST['name']  == '') return a('','枚举类别 名称不能为空','e');
		if( $_POST['value'] == '') $_POST['value'] = $_POST['name'];
		
		$enumType = Enum::find($_POST['enum_type_pid']);

		if( $enumType->pid == 0 ){
			return a('','不能在一级类别下新建枚举','e');
		}
		if( $enumType->system == 1 ){
			return a('','不能新增系统枚举','e');
		}

		$_POST['sort'] = (int)$_POST['sort'];
		$_POST['enum_id'] = $_POST['enum_type_pid'];
		$_POST['status'] = 1;
		$enumDetail = EnumDetail::create($_POST);

		$tr = "<tr data-id = '".$enumDetail->id."'><td>".$_POST['name']."</td><td>".$_POST['value']."</td><td>".$_POST['sort']."</td><td>启用</td></tr>";

		return a($tr,'','s');

	}
	/**
     * 获取枚举明细
    */
	public function getEnumDetail(){

		$detail = EnumDetail::where('enum_id = '.$_POST['id'])->order('status desc,sort asc')->select()->toArray();
		$tbody = '';
		if(!$detail) return a('','','s');
		foreach($detail as $k => $v){
			$tbody .= "<tr data-id = '".$v['id']."'><td>".$v['name']."</td><td>".$v['value']."</td><td>".$v['sort']."</td><td>".($v['status'] == 1?'启用':'禁用')."</td></tr>";
		}
		return a($tbody ,'','s');
	}
	/**
     * 编辑枚举明细
    */
	public function editEnumDetail(){
		if(!$_POST['id']) return a('','保存错误','e');
		$id = $_POST['id'];
		$detail = EnumDetail::find($_POST['id']);
		$enum_type = Enum::find($detail->enum_id);
		if($enum_type->system == 1) return a('','不能编辑系统枚举','e');
		if( $_POST['name']  == '') return a('','枚举类别 名称不能为空','e');
		if( $_POST['value'] == '') $_POST['value'] = $_POST['name'];
		$_POST['sort'] = (int)$_POST['sort'];
		$detail->name = $_POST['name'];
		$detail->value = $_POST['value'];
		$detail->sort = $_POST['sort'];
		$detail->status = $_POST['status'];
		$detail->save();
		return a('','','s');
	}
	/**
     * 编辑枚举明细
    */
	public function dltEnumDetail(){
		EnumDetail::destroy($_POST['id']);
		return a('','','s');
	}
	


	
	
}
