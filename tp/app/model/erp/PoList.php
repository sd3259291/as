<?php

namespace app\model\erp;

use think\Model;

class PoList extends Model{
  
	protected $schema = [
		'listid' => 'int',
		'id'	=> 'int',
		'inventory_code' => 'varchar',
		'price'	=> 'numeric',
		'tax' => 'int',
		'tax_price' => 'numeric',
		'arrive_date' => 'date',
		'qty' => 'numeric'
	];

	public function test($data){
		dump($data);
		$this::saveAll($data);
	}


}
