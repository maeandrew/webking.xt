<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
if(!_acl::isAllow('duplicates')){
	die("Access denied");
}
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Дубли товаров";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/duplicates/';
$products = new Products();
$list = $products->GetDuplicateProducts();

// === === === subcats
$tpl->Assign('list', $list);
$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_duplicates.tpl'));
if(TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>