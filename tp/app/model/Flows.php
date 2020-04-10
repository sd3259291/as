<?php
namespace app\model;

use think\Model;

class Flows extends Model{
  
	protected $schema = [
		'id' => 'int',
		'maker' => 'varchar',
		'datetime' => 'datetime',
		'datetime_end' => 'datetime',
		'table_resource' => 'varchar',
		'table_name' => 'varchar',
		'table_id' => 'int',
		'tip_id' => 'int',
		'maker_name' => 'varchar',
		'title' => 'varchar',
		'status' => 'tinyint',
		'p' => 'text',
		'node' => 'text',
		'show' => 'varchar',
		'done' => 'varchar',
		'handler' => 'varchar',
		'before_dlt' => 'varchar',
		'form' => 'text',
		'flow_id' => 'int'

	];



	

}
