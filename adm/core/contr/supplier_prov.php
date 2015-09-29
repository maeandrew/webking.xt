<?php
if(!_acl::isAllow('orders')){
	die("Access denied");
}
$Order = new Orders();
// ---- center ----
unset($parsed_res);
$tpl->Assign('h1', 'Позиции по поставщикам');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Позиции по поставщикам";
$arr = false;
//$Order->Suplir_prov();
$order_statuses = $Order->Suplir_prov($arr);
	$tpl->Assign('list1', $order_statuses);
$parsed_res = array(
	'issuccess'	=> true,
 	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_suplir_prov.tpl')
 );
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>