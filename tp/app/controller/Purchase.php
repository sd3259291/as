<?php

namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Db;
use app\model\erp\VendorPriceJust;
use app\model\erp\VendorPrice;
use app\model\erp\Po;
use app\model\erp\PoList;

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

	/**
     * 采购订单 - 新增
     */
	public function purchaseOrder(){
		return View::fetch();
	}
	/**
     * 采购订单 - 保存
     */
	public function savePo(Po $p){
		return $p->saveBill($_POST);
	}
	/**
     * 根据订单号等，获取采购订单
     */
	 public function getPo(Po $p){
		return $p->get($_POST);
	 }
	/**
     * 删除采购订单
     */
	public function dltPo(Po $p){

		return $p->dltBill($_POST);
	}
	/**
     * 是否可以删除 采购订单
     */
	public function canPo(Po $p){
		return $p->canModify($_POST);
	}
	/**
     * 审核供应商价格调整单
     */
	public function checkPo(Po $p){
		return $p->checkBill($_POST);
	}
	/**
     * 弃审供应商价格调整单
     */
	public function uncheckPo(Po $p){
		return $p->uncheckBill($_POST);
	} 
	/**
     * 获取下一个，上一个供应商价格调整单
     */
	public function nextPrevPo(Po $p){
		return $p->nextPrev($_POST);
	}
	/**
     * 采购订单列表
     */
	public function purchaseOrderList(){
		return View::fetch();
	}
	/**
     * 采购订单列表-搜索
     */
	public function getPoList(Po $p){
		return $p->getList($_POST);
	}
	/**
     * 采购订单 -导出
     */
	public function exportPo(Po $p){
		return $p->export($_POST);
	}
	/**
     * 源单 采购订单 -> 到货单
     */
	public function resourcePoToPoArrive(){
		return View::fetch();
	}

	public function resourcePoToPoArriveSearch(Po $p){
		gp();
		return $p->resourcePoToPoArriveSearch($_POST);
	}

	/**
     * 到货单 - 新增
     */
	public function poArrive(){
		return View::fetch();
	}

	













	

  


	
}
