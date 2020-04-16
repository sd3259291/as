<?php
namespace app\model;

use think\Model;

class FlowTable extends Model{
  
	protected $schema = [
		'id' => 'int',
		'table_name' => 'varchar',
		'flow_id' => 'int',
		'i' => 'varchar',
		'label' => 'varchar',
		'type' => 'varchar',
		'length1' => 'int',
		'length2' => 'int',
		'enum_name' => 'varchar',
		'enum_id' => 'int',
		'main' => 'int',
		'group' => 'varchar'
	];



	

}
