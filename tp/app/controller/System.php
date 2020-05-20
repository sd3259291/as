<?php
declare(strict_types=1);
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use app\model\Role;
use app\model\Erp\ErpConfig;


class System extends BaseController
{
	/**
     * 用户管理
     */

	private $billType = [
		[
			'type' => '',
			'name' => '采购',
			'children' => [
				['type' => 'vendorPrice' , 'name' => '供应商价格表'],
				['type' => 'purchase' , 'name' => '采购订单']
			]
		],
		[
			'type' => '',
			'name' => '质检'
		]
	];

    public function config(ErpConfig $e){
		$tree = array(
			'type' => '',
			'name' => '表单类型',
			'children' => $this->billType
		);
		View::assign('tree',json_encode($tree) );
		View::assign('erpconfig',json_encode($e->getAllConfig()));
		return View::fetch();
    }

	public function setConfig(ErpConfig $e){
		return $e->setConfig($_POST);
	}
	
	





  


	
}
