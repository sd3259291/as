<?php
namespace app\model;

use think\Model;

class EmployeeWorkexperience extends Model{
  
	protected $schema = [
		'id' => 'int',
		'employee_id' => 'int',
		'start' => 'varchar',
		'end' => 'varchar',
		'company' => 'int',
		'department' => 'varchar',
		'post' => 'varchar'

	];

	

}
