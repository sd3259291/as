<?php
namespace app\model;

use think\Model;

class Employee extends Model{
  
	protected $schema = [
		'id' => 'int',
		'number' => 'varchar',
		'name' => 'varchar',
		'department_id' => 'int',
		'post_id' => 'int',
		'sex' => 'int',
		'married' => 'int',
		'affiliation' => 'int',
		'idcard' => 'varchar',
		'idcard_date' => 'date',
		'tel' => 'varchar',
		'emergency_contact' => 'varchar',
		'emergency_contact_tel' => 'varchar',
		'addr1' => 'varchar',
		'addr2' => 'varchar',
		'is_zs' => 'int',
		'entry_date' => 'date',
		'resign_date' => 'date'

	];

	public function department(){
		return $this->hasOne(Department::class,'id','department_id');
	}

	public function education(){
		return $this->hasMany(EmployeeEducation::class);
	}

	public function workexperience(){
		return $this->hasMany(EmployeeWorkExperience::class);
	}

	

}
