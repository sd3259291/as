<?php
declare(strict_types=1);
namespace app\model;

use think\Model;

class FlowsField extends Model{
  
	protected $schema = [
		'id' => 'int',
		'flows_id' => 'int',
		'field' => 'text'
	];





	

}
