<?php
declare(strict_types=1);
namespace app\model;

use think\Model;

class FlowAuth extends Model{
  
	protected $schema = [
		'id' => 'int',
		'flow_id' => 'int',
		'node_id' => 'varchar',
		'auth' => 'text'
	];





	

}
