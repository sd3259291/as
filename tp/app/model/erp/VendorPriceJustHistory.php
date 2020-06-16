<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;

class VendorPriceJustHistory extends Model{

	protected $autoWriteTimestamp = 'datetime';
  
	protected $schema = [
		'id'	=> 'int',
		'vendor_code' => 'varchar',
		'inventory_code' => 'varchar',
		'price' => 'numeric',
		'tax' => 'int',
		'tax_price' => 'numeric',
		'maker' => 'varchar',
		'create_time' => 'datetime',
		'origin_price' => 'numeric',
		'origin_tax' => 'int',
		'origin_tax_price' => 'numeric'

	];
	




}
