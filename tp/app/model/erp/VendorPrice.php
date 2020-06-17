<?php
namespace app\model\erp;
use think\Model;
use app\validate\erp\UnitValidate;
use think\exception\ValidateException;
use think\facade\Db;
use app\controller\PublicGet;

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


	public function getList($post){
		$tmp = $this->getSearchData($post);
		$r = $tmp['r'];
		$page = $tmp['page'];
		$structure = array(
			'create_time',
			'maker',
			'vendor_code',
			'vendor_name',
			'inventory_code',
			'inventory_name',
			'inventory_std',
			array('key' => 'price' , 'type' => 'number' , 'zero' => ''),
			array('key' => 'tax' , 'type' => 'number' , 'zero' => ''),
			array('key' => 'tax_price' , 'type' => 'number' , 'zero' => ''),
		);
		$tbody = tbody($r,$structure,is_set($post,'merge')?[4]:[] );
		$result = [ 'tbody' => $tbody , 'page' => $page ];

		return a($result,'','s');
	}

	public function export($post){
		$post['page'] = 1;
		$post['n'] = 10000000;
		$data = $this->getSearchData($post)['r'];
		$excel = array(
			'create_time' => '启用日期',
			'maker' => '制单人',
			'vendor_code' => '供应商编码',
			'vendor_name' => '供应商名称',
			'inventory_code' => '物料编码',
			'inventory_name' => '物料名称',
			'inventory_std' => '规格型号',
			'price' => '现单价',
			'tax' => '现税率',
			'tax_price' => '现含税价'
		);
		$pG = new PublicGet();
		$r = $pG->excel($excel,$data);
		return a($r);
	}


	public function getSearchData($post){
		$w = " 1 = 1 ";
		
		if(is_set($post,'option_vendor_code')){
			$w .= " && a.vendor_code = '".$post['option_vendor_code']."' ";
		}
		if(is_set($post,'option_inventory_code')){
			$w .= " && a.inventory_code = '".$post['option_inventory_code']."' ";
		}
		$totle = Db::table('s_vendor_price a')->where($w)->count();

		$page['totles'] = $totle;     //总记录数 返回
		$page['totle_page'] = ceil($totle / $post['n']);  //总页数 返回
		$page['n'] = $post['n'];
		$page['current_page'] = $post['page'];     //当前页 返回	

		$r = Db::table('s_vendor_price')->alias('a')->join('s_inventory i','a.inventory_code = i.code')->join('s_vendor v','a.vendor_code = v.code')->field('a.price,a.tax_price,a.tax,i.code inventory_code,i.name inventory_name,i.std inventory_std,v.code vendor_code,v.name vendor_name,a.create_time,a.maker')->where($w)->page($post['page'],$post['n'])->order('a.id desc')->select()->toArray();

		return array(
			'r' => $r,
			'page' => $page
		);
	}


}
