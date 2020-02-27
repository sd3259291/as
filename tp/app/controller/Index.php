<?php
namespace app\controller;

use app\BaseController;

use think\facade\View;

use think\facade\Session;

class Index extends BaseController
{
    public function index()
    {
		return 'Hello,ThinkPHP!<br/>';

		
	
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

	
}
