<?php

namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Session;
use think\facade\Cache;
use app\model\Role;
use app\model\User;
use app\model\RoleUser;
use think\facade\Db;

class Test
{
	/**
     * 用户管理
     */
    public function aaa()
    {	
		dump(Cache::get('tmp'));


    }

	public function test(){

		echo 1;
	
	}

	

  


	
}
