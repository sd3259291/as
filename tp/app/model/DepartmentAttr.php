<?php
namespace app\model;

use think\Model;

class DepartmentAttr extends Model{
  
	protected $schema = [
		'id' => 'int',
		'department_id' => 'int',
		'type' => 'int',
		'key' => 'int',
		'value' => 'varchar'

	];



	

}
