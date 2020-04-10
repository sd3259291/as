<?php
namespace app\model;

use think\Model;

class FlowType extends Model{
  
	protected $schema = [
		'id' => 'int',
		'name' => 'varchar',
		'status' => 'int',
		'sort' => 'int'
	];

	

}
