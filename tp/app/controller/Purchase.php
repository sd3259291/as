<?php

namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Db;
use app\model\erp\VendorPriceJust;
use app\model\erp\VendorPrice;

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
		//gp();
		return $v->saveBill($_POST);
	}

	public function dltVendorPriceJust(VendorPriceJust $v){
		
		return $v->dltBill($_POST);
	}

	public function canModifyVendorPriceJust(VendorPriceJust $v){
		return $v->canModify($_POST);
	}

	public function checkVendorPriceJust(VendorPriceJust $v){
		//gp();
		return $v->checkBill($_POST);
	}
	
	public function uncheckVendorPriceJust(VendorPriceJust $v){
		return $v->uncheckBill($_POST);
	} 

	public function nextPrevVendorPriceJust(VendorPriceJust $v){
		return $v->nextPrev($_POST);
	}
	
	// 根据供应商和物料编码获得价格
	public function getVendorPriceByData(VendorPrice $v){
		
		return $v->getVendorPriceByData($_POST);
	}

	public function vendorPriceJustList(){
		return View::fetch();
	}

	public function getVendorPriceJustList(VendorPriceJust $v){
		//gp();
		return $v->getList($_POST);
	}









	

  


	
}
