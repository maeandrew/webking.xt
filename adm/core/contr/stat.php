<?php
if(!_acl::isAllow('orders')){
	die("Access denied");
}
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Статистика продаж";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
if(in_array("export", $GLOBALS['REQAR'])){
	$_POST = $_SESSION['_POST_'];
}
if(isset($_POST['smb'])){
	// Обработка дат
	$arr = false;
	if($_POST['filter_target_date_start'] !== ''){
		$arr['target_date_start'] = mysql_real_escape_string($_POST['filter_target_date_start']);
		list($d, $m, $y) = explode(".", trim($arr['target_date_start']));
		$arr['target_date_start'] = mktime(0, 0, 0, $m , $d, $y);
	}
	if($_POST['filter_target_date_end'] !== ''){
		$arr['target_date_end'] = mysql_real_escape_string($_POST['filter_target_date_end']);
		list($d, $m, $y) = explode(".", trim($arr['target_date_end']));
		$arr['target_date_end'] = mktime(0, 0, 0, $m , $d, $y);
	}
	$Products = new Products();
	$arr = $Products->GetSalesStatistic($arr);
	foreach($arr as $i){
		$rE[$ii]['art'] = $r[$ii]['art'] = $i['art'];
		$rE[$ii]['name'] = $r[$ii]['name'] = $i['name'];
		$rE[$ii]['orders_cnt'] = $r[$ii]['orders_cnt'] = $i['orders_cnt'];
		$rE[$ii]['total_qty'] = $r[$ii]['total_qty'] = round($i['contragent_qty']+$i['contragent_mqty'],2);
		$rE[$ii]['total_sum'] = $r[$ii]['total_sum'] = round($i['contragent_sum']+$i['contragent_msum'],2);
		$ii++;
	}
}
if(in_array("export", $GLOBALS['REQAR'])){
	$Products->GenExcelStatFile($rE);
	exit(0);
}else{
	if(isset($_SESSION['_POST_'])) unset($_SESSION['_POST_']);
	$_SESSION['_POST_'] = $_POST;
	
	if(isset($r)){
		$tpl->Assign('rows', $r);
	}
	$parsed_res = array(
		'issuccess' => true,
 		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_stat.tpl')
 	);
	if(true == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
}?>