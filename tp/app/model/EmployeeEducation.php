<?php
namespace app\model;

use think\Model;

class EmployeeEducation extends Model{
  
	protected $schema = [
		'id' => 'int',
		'employee_id' => 'int',
		'start' => 'varchar',
		'end' => 'varchar',
		'school' => 'int',
		'xl' => 'varchar',
		'zy' => 'varchar'

	];

	

}
