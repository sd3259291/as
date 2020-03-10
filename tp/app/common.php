<?php
// 应用公共文件

function a($data,$info = '',$status = 's'){
	return json(array('data' => $data,'info' => $info,'status' => $status));
}
function column($data,$id){
	if(!is_array($data)) $data = $data->toArray();
	$r = array();
	foreach($data as $k => $v){
		$r[$v[$id]] = $v;
	}
	return $r;
}