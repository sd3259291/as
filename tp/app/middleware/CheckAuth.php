<?php
declare (strict_types = 1);

namespace app\middleware;

use think\facade\Session;

class CheckAuth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
		$response = $next($request);

		$controller = strtolower($request->controller());

		//$action = strtolower($request->action());

		if($controller != 'login'){
			//$u = md5( strtolower($controller.$action) );

			$auth = Session::get('auth');
			
			if(!$auth['user_id']){

				return redirect( (string) url('Login/index')->suffix('') );

			}

		}
	
    	return $response;

		
    }



}
