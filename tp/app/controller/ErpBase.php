<?php
declare(strict_types=1);
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Db;
use app\model\erp\Unit;
use app\model\erp\Inventory;
use app\model\erp\Vendor;
use app\model\erp\Customer;
use app\model\erp\BasicClass;


class ErpBase extends BaseController
{
	/**
     * 计量单位
     */
    public function unit(Unit $c){	
		View::assign('units',$c->select1());
		return View::fetch();
    }
	public function addUnit(Unit $c){
		return $c->add1($_POST);
	}
	public function changeStatusUnit(Unit $c){
		return $c->changeStatus($_POST['id']);
	}
	public function editUnit(Unit $c){
		return $c->edit($_POST);
	}
	public function dltUnit(Unit $c){
		return $c->dlt($_POST);
	}

	/**
     * 存货档案
     */
    public function inventory(BasicClass $c){
		$tree = $c->getTree(array('class_id' => 0),false);
		View::assign('tree',json_encode($tree));
		return View::fetch();
    }
	public function addInventory(Unit $u,BasicClass $b){
		View::assign('units',$u->get1());
		View::assign('basicclass',$b->get1(0));
		return View::fetch();
	}
	public function editInventory(Inventory $c){
		return $c->edit($_POST);
	}
	public function dltInventory(Inventory $c){
		return $c->dlt($_POST);
	}
	public function insertInventory(Inventory $c){
		return $c->insert($_POST);
	}
	public function getInventory(Inventory $c){
		return $c->getInventory($_POST);
	}
	public function inventoryInfo(Unit $u,BasicClass $b,Inventory $i){
		View::assign('inventory',$i->getInventoryByCode($_GET));
		View::assign('units',$u->get1());
		View::assign('basicclass',$b->get1(0));
		return View::fetch();
	}
	public function selectInventory(BasicClass $c){
		$tree = $c->getTree(array('class_id' => 0),false,false);
		View::assign('tree',json_encode($tree));
		return View::fetch();
	}


	/**
     * 供应商
     */
    public function vendor(BasicClass $c){
		$tree = $c->getTree(array('class_id' => 1),false);
		View::assign('tree',json_encode($tree));
		return View::fetch();
    }
	public function addVendor(BasicClass $b){
		View::assign('basicclass',$b->get1(1));
		return View::fetch();
	}
	public function editVendor(Vendor $c){
		return $c->edit($_POST);
	}
	public function dltVendor(Vendor $c){
		return $c->dlt($_POST);
	}
	public function insertVendor(Vendor $c){
		return $c->insert($_POST);
	}
	public function getVendor(Vendor $c){
		return $c->getVendor($_POST);
	}
	public function vendorInfo(Vendor $v,BasicClass $b){
		View::assign('vendor',$v->getVendorByCode($_GET));
		View::assign('basicclass',$b->get1(1));
		return View::fetch();
	}
	public function selectVendor(BasicClass $c){
		$tree = $c->getTree(array('class_id' => 1),false,false);
		View::assign('tree',json_encode($tree));
		return View::fetch();
	}
	

	/**
     * 客户
     */
    public function customer(BasicClass $c){
		$tree = $c->getTree(array('class_id' => 2),false);
		View::assign('tree',json_encode($tree));
		return View::fetch();
    }
	public function addCustomer(BasicClass $b){
		View::assign('basicclass',$b->get1(2));
		return View::fetch();
	}
	public function editCustomer(Customer $c){
		return $c->edit($_POST);
	}
	public function dltCustomer(Customer $c){
		return $c->dlt($_POST);
	}
	public function insertCustomer(Customer $c){
		return $c->insert($_POST);
	}
	public function getCustomer(Customer $c){
		return $c->getCustomer($_POST);
	}
	public function customerInfo(Customer $c,BasicClass $b){
		View::assign('customer',$c->getCustomerByCode($_GET));
		View::assign('basicclass',$b->get1(2));
		return View::fetch();
	}
	

	/**
     * 基础资料分类
     */
	public function basicClass(){
		return View::fetch();
	}
	public function basicClassGet(BasicClass $c){
		return $c->getTree($_POST);
	}
	public function addBasicClass(BasicClass $c){
		return $c->add($_POST);
	}
	public function dltBasicClass(BasicClass $c){
		return $c->dlt($_POST);
	}


	
	
	
  


	
}
