<?php

namespace app\model\erp;

use think\Model;

class PoArriveList extends Model{

	protected $pk = 'listid';
  
	protected $schema = [
		'listid' => 'int',
		'id'	=> 'int',
		'inventory_code' => 'varchar',
		'qty' => 'numeric',
		'is_qc' => 'int',
		'resource_type' => 'varchar',
		'resource_listid' => 'int',
		'po_ddh' => 'varchar'
		
	];

	


}
