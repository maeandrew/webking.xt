<?php
G::metaTags();
$Page = new Page();
$Products = new Products();
$Page->PagesList("menu");
$tpl->Assign('list_menu', $Page->list);
if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
	header('Location: '. _base_url.'/cabinet/');
}
unset($parsed_res);
$page = $Page->PagesListByType('main');
// if(!empty($page)){
	$tpl->Assign('data', !empty($page)?$page[0]:false);
// }
unset($Page, $page);
$products = $Products->GetRandomList();
if(isset($products) && !empty($products)){
	foreach($products as &$p){
		$p['images'] = $Products->GetPhotoById($p['id_product']);
	}
    $tpl->Assign('list', $products);
}
unset($products);

$header = 'Главная';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = _base_url;

$products_list = $tpl->Parse($GLOBALS['PATH_tpl_global'].'products_list.tpl');
$tpl->Assign('products_list', $products_list);

$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_page.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>