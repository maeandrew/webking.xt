<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
// if(!_acl::isAllow('product')){
// 	die("Access denied");
// }
$users = new Users();
$products = new Products();
$suppliers = new Suppliers();
$header = 'Товары фотографа';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/photo_products/';
$tpl->Assign('header', $header);
$users->UsersList(1, array('gid' => 13));
$tpl->Assign('users_list', $users->list);
$suppliers->SuppliersList();
$tpl->Assign('suppliers_list', $suppliers->list);
// pagination
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$GLOBALS['Limit_db'] = 10;
	$cnt = count($products->GetProductsByIdUser($_SESSION['member']['id_user']));
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt, 10);
	$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
// --
$list = $products->GetProductsByIdUser($_SESSION['member']['id_user'], $limit);
$tpl->Assign('list', $list);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_photo_products.tpl');
