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

function dlt_zero($array,$zero){
	foreach($zero as $k => $v){
		foreach($array as $k1 => $v1){
			$array[$k1][$v] += 0;
			if(!$array[$k1][$v]) $array[$k1][$v] = '';
		}
	}
	return $array;
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

function tbody($array,$structure,$dltSame = array(),$borderTop = 'top-border',$tbody = false,$tr_data = array()){
	$t = "";
	if($tbody) $t .= "<tbody>";
	$s1 = $s2 = '';
	$d1 = $d2 = array();
	$firstRow = array();
	$firstKey = '';
	$f1 = $f2 = '';

	foreach($array as $k => $v){
		$firstRow = $v;break;
	}
	foreach($structure as $k => $v){
		if(is_array($v)){
			$firstKey = $v['key'];break;
		}else{
			$firstKey = $v;break;
		}
	}

	if(isset($dltSame[0]) && $dltSame[0] > 0){
		$i = 1;
		foreach($firstRow as $k => $v){
			if($i <= $dltSame[0]){
				$d1[] = $k;
				if($f1 == '') $f1 = $k;
			}else{
				if(isset($dltSame[1]) && $dltSame[1] > 0){
					if($i <=  $dltSame[0] +  $dltSame[1]){
						$d2[] = $k;
						if($f2 == '') $f2 = $k;
					}
				}else{
					break;
				}
			}
				$i++;
		}
	}

	$imgTypeUrl = array(
		'90' => "<i class='material-icons text-color3' style = 'font-size:12px'>done</i>", //无流程审核完毕
		'91' => "<i class='material-icons text-color3' style = 'font-size:12px'>done</i>", //有流程审核完毕
		'50' => "<i class='material-icons text-color2' style = 'font-size:12px'>remove</i>", //无流程未审核
		'51' => "<i class='material-icons text-color2' style = 'font-size:12px'>arrow_forward</i>", //有流程未审核
	);
	
	$firstLine = true;
	foreach($array as $k => $v){
		$trData = '';
		foreach($tr_data as $kk => $vv){
			$trData .= " data-".$kk."='".$v[$vv]."' ";
		}
		$ddh = $v[$firstKey];
		if(count($d1) > 0){
			if($s1 == $v[$f1]){
				foreach($d1 as $kk => $vv){
					$v[$vv] = '';
				}
				$t .= "<tr data-ddh = '".$ddh."' data-flow_id = '".(isset($v['flow_id'])?$v['flow_id']:'')."' class = 'c".$ddh."' $trData >";
			}else{
				$s1 = $v[$f1];
				if(!$firstLine){
					$t .= "<tr data-ddh = '".$ddh."' data-flow_id = '".(isset($v['flow_id'])?$v['flow_id']:'')."' class = 'c".$ddh."  $borderTop' $trData >";
				}else{
					$t .= "<tr data-ddh = '".$ddh."' data-flow_id = '".(isset($v['flow_id'])?$v['flow_id']:'')."' class = 'c".$ddh."' $trData>";
				}
			}
		}else{
			$t .= "<tr data-ddh = '".$ddh."' data-flow_id = '".(isset($v['flow_id'])?$v['flow_id']:'')."' class = 'c".$ddh."' $trData>";
		}



		for($i = 0; $i < count($structure); $i++){
			if(is_array($structure[$i])){

				switch( $structure[$i]['type'] ){
					case 'html' :
						$t .= "<td>".$structure[$i]['key']."</td>";
					break;
					case 'index' :
						$t .= "<td>".++$indexii."</td>";
					break;
					case 'input' :
						$t .= "<td><input readonly class = 'td-input' type = 'text' value = '".$v[$structure[$i]['key']]."'  /></td>";
					break;
					case 'status' :
						if( $v['status'] == ''){
							$t .= "<td></td>";
						}else{
							$imgType = $v['status'].( isset($v['flow_id']) && $v['flow_id'] ? 1 : 0 );
							$t .= "<td>".$imgTypeUrl[$imgType]."</td>";
						}
						
					break;
					case 'number' :
						$tmp = $v[$structure[$i]['key']] * 1;
						if($tmp == 0 && isset($structure[$i]['zero'])) $tmp = $structure[$i]['zero'];
						$t .= "<td>".$tmp."</td>";
					break;
					case 'nowrap' :
						$t .= "<td style = ' white-space:nowrap;'>".$v[$structure[$i]['key']]."</td>";
					break;
					case 'img' :
						$t .= "<td><img src = '".config('templete_public')."/Image/".$structure[$i]['src'].".png' class = '".$structure[$i]['class']."' title = '".$structure[$i]['title']."' /></td>";
					break;
					case 'a' :
						$tmp = $v[$structure[$i]['key']];
						if(isset($structure[$i]['num'])) $tmp *=1;
						if(isset($structure[$i]['zero']) && $structure[$i]['zero'] && !$tmp) $tmp = $structure[$i]['zero'];
						$t .= "<td><a href = 'javascript:void(0)' class = '".$structure[$i]['class']."' title = '".(isset($structure[$i]['title'])?$structure[$i]['title']:'')."'>".$tmp."</a></td>";
					break;

				}


			}else{
				$t .= "<td>".$v[$structure[$i]]."</td>";
			}

		}
		$t .= "</tr>";
		$firstLine = false;
	}
	if($tbody) $t .= "</tbody>";
	return $t;
}
function checkAuth($url){
	

	return true;
}