<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;

class Unit extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'name'	=> 'varchar',
		'sort'	=> 'int',
		'status' => 'int'
	];


	public function add1($post){
		try {
			validate(UnitValidate::class)->check($post);
        }catch ( ValidateException $e ) {
           return a('',$e->getError(),'e');
        }
		$unit = new Unit;
		$unit->save($post);
		return a($unit);
	}

	public function get1(){
		return $this::where('status = 1')->order('sort asc')->field('id,name')->select();
	}

	public function select1(){
		return $this->order('sort asc')->select();
	}

	public function changeStatus($unitId){
		$unit = $this->find($unitId);
		$unit->status = $unit->status == 1?0:1;
		$unit->save();
		$status =  $unit->status == 1?'启用':'禁用';
		return a($status);
	}
	public function edit($post){
		$this::update($post);
		return a();
	}
	public function dlt($post){
		$r = Db::table('s_inventory')->where('unit_id = '.$post['id'])->field('id')->find();
		if($r) return a('','计量单位已使用，不能删除','e');
		$this->destroy($post['id']);
		return a();
	}


}
