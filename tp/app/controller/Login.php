<?php
namespace app\controller;


use think\facade\View;

use think\facade\Session;

class Login
{
    public function index()
    {

		dump($_SERVER['SCRIPT_NAME']);
		Session::clear();


		
		return view();
	
    }



	
}
