<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
// if(!_acl::isAllow('product')){
// 	die("Access denied");
// }
$users = new Users();
$products = new Products();
$suppliers = new Suppliers();
unset($parsed_res);
$header = 'Позиции фотографа';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/photo_products/';
$tpl->Assign('header', $header);
$users->UsersList(1, array('gid' => 13));
$tpl->Assign('users_list', $users->list);
$suppliers->SuppliersList();
$tpl->Assign('suppliers_list', $suppliers->list);
$list = $products->GetProductsByIdUser($_SESSION['member']['id_user']);
$tpl->Assign('list', $list);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_photo_products.tpl');
