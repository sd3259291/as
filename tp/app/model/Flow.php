<?php
namespace app\model;

use think\Model;

class Flow extends Model{
  
	protected $schema = [
		'id' => 'int',
		'title' => 'varchar',
		'create_datetime' => 'datetime',
		'modify_datetime' => 'datetime',
		'done' => 'varchar',
		'show' => 'varchar',
		'node' => 'text',
		'p' => 'text',
		'max_id' => 'int',
		'before_dlt' => 'varchar',
		'form' => 'mediumtext',
		'maker' => 'varchar',
		'status' => 'int',
		'td_width' => 'text',
		'type_id' => 'int',
		'cut_form' => 'mediumtext',

	];



	

}
