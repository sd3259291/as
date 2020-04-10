<?php
namespace app\model;

use think\Model;

class FlowNode extends Model{
  
	protected $schema = [
		'id' => 'int',
		'name' => 'varchar',
		'sort' => 'int',
		'auth1' => 'varchar',
		'default' => 'int',
		'status' => 'int'
	];



	

}
