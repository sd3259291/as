<?php
namespace app\model;

use think\Model;

class RoleUser extends Model{
  
	protected $schema = [
		'role_id' => 'int',
		'user_id' => 'int'

	];

}
