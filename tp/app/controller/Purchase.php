<?php

namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Db;
use app\model\erp\VendorPriceJust;

class Purchase
{
	/**
     * 供应商价格表
     */
    public function vendorPriceJust(){	
		return View::fetch();
    }

	public function getVendorPriceJust(VendorPriceJust $v){
		return $v->get($_POST);
	}

	public function saveVendorPriceJust(VendorPriceJust $v){
		return $v->saveBill($_POST);
	}

	public function dltVendorPriceJust(VendorPriceJust $v){
		return $v->dltBill($_POST);
	}

	public function canModifyVendorPriceJust(VendorPriceJust $v){
		return $v->canModify($_POST);
	}

	public function checkVendorPriceJust(VendorPriceJust $v){
		return $v->checkBill($_POST);
	} 









	

  


	
}
