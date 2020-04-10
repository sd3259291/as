<?php
declare(strict_types=1);
namespace app\model;

use think\Model;

class FlowsAuth extends Model{
  
	protected $schema = [
		'id' => 'int',
		'flows_id' => 'int',
		'node_id' => 'varchar',
		'auth' => 'text'
	];





	

}
