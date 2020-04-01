<?php
namespace app\model;

use think\Model;

class Post extends Model{
  
	protected $schema = [
		'id' => 'int',
		'type_id' => 'int',
		'type_name' => 'varchar',
		'name' => 'varchar',
		'status' => 'int',
		'sort' => 'int',

	];


	public function mySelect(){
		$r = $this->where('status = 1')->order('sort asc,id asc')->select();
		if(!$r) return json_encode(array());
		return $r;
	}

	

}
