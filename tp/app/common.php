<?php
// 应用公共文件

function a($data = '',$info = '',$status = 's'){
	return json(array('data' => $data,'info' => $info,'status' => $status));
}

function ua($data){
	return json_decode($data->getContent(),true);
}

function uas($data){
	$tmp =  json_decode($data->getContent(),true);
	return $tmp['status'];
}

function rt($data = '',$info = '',$status = 's'){
	json(array('data' => $data,'info' => $info,'status' => $status))->send();exit();
}

function column($data,$id){
	if(!is_array($data)) $data = $data->toArray();
	$r = array();
	foreach($data as $k => $v){
		$r[$v[$id]] = $v;
	}
	return $r;
}

function img_url(){
	return 'HTTP://'.$_SERVER['HTTP_HOST'].( dirname($_SERVER['SCRIPT_NAME']) == '/'? '': dirname($_SERVER['SCRIPT_NAME']) ) .'/tp/view/public/image';
}
function get_w($d,$kh = true,$kv = true){
	$w = '';
	foreach($d as $k => $v){
		if($kh){
			if($kv){
				if($v) $w .= "'$v',";
			}else{
				if($k) $w .= "'$k',";
			}
		}else{
			if($kv){
				if($v) $w .= "$v,";
			}else{
				if($k) $w .= "$k,";
			}
		}
	}
	if($w != '') return substr($w,0,-1);
	return '';
}

function is_set($a,$b){
	if(isset($a[$b]) && $a[$b]) return true;
	return false;
}



function sp(){
	if(count($_POST) > 0 ){
		cache('tmp',$_POST);
	}else{
		cache('tmp',$_GET);
	}
	
}

function gp(){
	$_GET = $_POST = cache('tmp');
}