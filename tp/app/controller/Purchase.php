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
     * 供应商价格调整单-新增
     */
    public function vendorPriceJust(){	
		return View::fetch();
    }
	/**
     * 根据订单号等，获取供应商价格调整单
     */
	public function getVendorPriceJust(VendorPriceJust $v){
		return $v->get($_POST);
	}
	/**
     * 保存供应商价格调整单
     */
	public function saveVendorPriceJust(VendorPriceJust $v){
		return $v->saveBill($_POST);
	}
	/**
     * 删除供应商价格调整单
     */
	public function dltVendorPriceJust(VendorPriceJust $v){	
		return $v->dltBill($_POST);
	}
	/**
     * 是否可以删除供应商价格调整单
     */
	public function canModifyVendorPriceJust(VendorPriceJust $v){
		return $v->canModify($_POST);
	}
	/**
     * 审核供应商价格调整单
     */
	public function checkVendorPriceJust(VendorPriceJust $v){
		return $v->checkBill($_POST);
	}
	/**
     * 弃审供应商价格调整单
     */
	public function uncheckVendorPriceJust(VendorPriceJust $v){
		return $v->uncheckBill($_POST);
	} 
	/**
     * 获取下一个，上一个供应商价格调整单
     */
	public function nextPrevVendorPriceJust(VendorPriceJust $v){
		return $v->nextPrev($_POST);
	}
	// 根据供应商和物料编码获得价格
	public function getVendorPriceByData(VendorPrice $v){
		return $v->getVendorPriceByData($_POST);
	}
	/**
     * 供应商价格调整单列表
     */
	public function vendorPriceJustList(){
		return View::fetch();
	}
	/**
     * 供应商价格调整单列表-搜索
     */
	public function getVendorPriceJustList(VendorPriceJust $v){
		return $v->getList($_POST);
	}
	/**
     * 供应商价格调整单列表-导出
     */
	public function exportVendorPriceJust(VendorPriceJust $v){
		return $v->export($_POST);
	}
	/**
     * 供应商价格表
     */
	public function vendorPrice(){
		return View::fetch();
	}
	/**
     * 供应商价格表-搜索
     */
	public function getVendorPriceList(VendorPrice $v){
		return $v->getList($_POST);
	}
	/**
     * 供应商价格表-导出
     */
	public function exportVendorPrice(VendorPrice $v){
		return $v->export($_POST);
	}












	

  


	
}
