<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
// if(!_acl::isAllow('product')){
// 	die("Access denied");
// }
unset($parsed_res);
$header = 'Позиции фотографа';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/photo_products/';
$tpl->Assign('header', $header);

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_photo_products.tpl');
