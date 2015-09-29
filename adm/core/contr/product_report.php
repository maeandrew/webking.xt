<?php
if(!_acl::isAllow('product_report')){
	die("Access denied");
}
$Products = new Products();
unset($parsed_res);
$tpl->Assign('h1', 'Отчет неадекватных товаров');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Отчет неадекватных товаров";
$arr = false;
if(isset($_POST['smb'])){
	unset($_GET);
	if($_POST['filter_target_date'] !== ''){
		$arr['target_date'] = mysql_real_escape_string($_POST['filter_target_date']);
		list($d,$m,$y) = explode(".", trim($arr['target_date']));
		$arr['target_date'] = mktime(0, 0, 0, $m , $d, $y);
	}
	if($_POST['filter_id_order'] !== ''){
		$arr['id_order'] = mysql_real_escape_string($_POST['filter_id_order']);
	}
	if($_POST['id_order_status'] !== '0'){
		$arr['id_order_status'] = mysql_real_escape_string($_POST['id_order_status']);
	}
	if($_POST['filter_contragent_name'] !== ''){
		$arr['contragent_name'] = mysql_real_escape_string($_POST['filter_contragent_name']);
	}
	if($_POST['filter_customer_name'] !== ''){
		$arr['customer_name'] = mysql_real_escape_string($_POST['filter_customer_name']);
	}
}else{
	$_POST['id_order_status'] = 0;
}
$fields = array('target_date', 'id_order');
$orderby = "target_date desc";
$sort_links = array();
foreach($fields as $f){
	$sort_links[$f] = $GLOBALS['URL_base']."adm/orders/ord/$f/desc";
	if(in_array("ord", $GLOBALS['REQAR']) && in_array($f,$GLOBALS['REQAR'])){
		if(in_array("desc",$GLOBALS['REQAR'])){
			$sort_links[$f] = $GLOBALS['URL_base']."adm/orders/ord/$f/asc";
			$orderby = "$f desc";
		}else{
			$orderby = "$f asc";
		}
	}
}
$tpl->Assign('sort_links', $sort_links);
if(isset($_POST['diff']) == true AND $_POST['diff'] > 0){
	if($list = $Products->ProductReport(mysql_real_escape_string(str_replace(',', '.', $_POST['diff'])/100+1))){
		$tpl->Assign('list', $list);
	}
	$tpl->Assign('diff', str_replace(',', '.', $_POST['diff']));
}
/*
if(isset($_GET['from']) && isset($_GET['to'])){
	$from_i = $_GET['from'];
	$to_i = $_GET['to'];
	$arr = $Order->GetOrdersByDate($from_i, $to_i);
	$tpl->Assign('list', $arr);
}
if(count($Order->list)){
	if($Order->list[0]['id_pretense_status']!=0){
		$pretarr = $Order->GetPretenseAdditionalRows($id_order);
		$tpl->Assign("pretarr", $pretarr);
	}
}
$order_statuses = $Order->GetStatuses();
*/
$parsed_res = array('issuccess' => TRUE,
						'html'	=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_report.tpl'));
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>