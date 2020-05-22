<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;

class VendorPrice extends Model{

	protected $autoWriteTimestamp = 'datetime';
  
	protected $schema = [
		'id'	=> 'int',
		'vendor_code' => 'varchar',
		'inventory_code' => 'varchar',
		'price' => 'numeric',
		'tax' => 'int',
		'tax_price' => 'numeric',
		'maker' => 'varchar',
		'create_time' => 'datetime'

	];
	
	
	public function getVendorPriceByData($post){

		$data = json_decode($post['data'],true);
		$w = "";
		$tmp = array();
		foreach($data as $k => $v){
			$w .= " (vendor_code = '".$v['vendor_code']."' && inventory_code = '".$v['inventory_code']."') ||";
			$tmp[$v['vendor_code']][$v['inventory_code']] = $v['index']; 
		}
		$vendorPrice = array();
		$w = substr($w,0,-2);
		$r = $this::where($w)->field('vendor_code,inventory_code,price,tax,tax_price')->select()->toArray();
		foreach($r as $k => $v){
			$vendorPrice[$tmp[$v['vendor_code']][$v['inventory_code']]] = [
				'origin_price' => $v['price'] * 1,
				'origin_tax' => $v['tax'],
				'origin_tax_price' => $v['tax_price'] * 1
			];
		}
		return a($vendorPrice);
	}


}
