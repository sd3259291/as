<?php
namespace app\controller;


use think\facade\View;

use think\facade\Session;

class Login
{
    public function index()
    {

		

		Session::clear();


		
		return view();
	
    }



	
}
