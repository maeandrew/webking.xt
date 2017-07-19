<?php
if(!_acl::isAllow('orders_category')){
	die("Access denied");
}
$Products = new Products();
unset($parsed_res);
$header = 'Добавление категорий группе товаров';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
if(isset($_SESSION['product_action'])){
	$tpl->Assign('product_list', $Products->getArrayProductsById($_SESSION['product_action']));
}
$categories = $Products->generateCategory();
$tpl->Assign('categories', $categories);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_orders_category.tpl');
