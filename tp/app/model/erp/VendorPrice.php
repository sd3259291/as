<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;

class VendorPrice extends Model{
  
	protected $schema = [
		'id'	=> 'int',
		'vendor_code' => 'varchar',
		'inventory_code' => 'varchar',
		'price' => 'numeric',
		'tax' => 'int',
		'tax_price' => 'numeric',
		'maker' => 'varchar',
		'create_datetime' => 'datetime'

	];
	




}
