<?php
namespace app\model;

use think\Model;

class Access extends Model{
  
	protected $schema = [
		'role_id' => 'int',
		'node_id' => 'int',
		'action' => 'varchar',
		'controller' => 'varchar',
		'user_id' => 'int'

	];

}
