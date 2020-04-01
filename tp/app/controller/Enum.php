<?php
declare(strict_types=1);
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

use app\model\Department;

use think\facade\Cache;

class Enum extends BaseController{

    public function index(){
		

		return View::fetch();

	}


	
	
}
