<?php
if(!_acl::isAllow('pricelist')){
	die("Access denied");
}
$Products = new Products();
unset($parsed_res);
$tpl->Assign('h1', 'Прайс-листы');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Прайс-листы";
if(isset($_POST['smb']) === true){
}
$tpl->Assign('list', $Products->GetPricelistFullList());
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_pricelist.tpl'));
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>