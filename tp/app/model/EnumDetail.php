<?php
namespace app\model;

use think\Model;

class EnumDetail extends Model{
  
	protected $schema = [
		'id' => 'int',
		'enum_id' => 'int',
		'name' => 'varchar',
		'value' => 'varchar',
		'status' => 'int',
		'sort' => 'int',

	];

	

}
