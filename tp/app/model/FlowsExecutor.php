<?php
namespace app\model;

use think\Model;

class FlowsExecutor extends Model{
  
	protected $schema = [
		'id' => 'int',
		'flow_id' => 'int',
		'node_id' => 'varchar',
		'number' => 'varchar',
		'name' => 'varchar',
		'status' => 'tinyint',
		'sender' => 'varchar',
		'datetime_r' => 'datetime',
		'datetime_s' => 'datetime',
		'datetime_h' => 'datetime',
		'type' => 'tinyint',
		'p' => 'tinyint'

	];



	

}
