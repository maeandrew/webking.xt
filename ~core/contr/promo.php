<?php
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][1]['title'] = "Каталог";
if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}
$products = new Products();
// Пагинатор ===============================================
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all' && !is_array($mass)) || !isset($_GET['limit'])){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = $products->GetPromoProductsCnt($_SESSION['member']['promo_code']);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' limit '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
/*Pagination*/	
$list = $products->GetPromoProducts($_SESSION['member']['promo_code'], $limit);
$tpl->Assign('list', $list);
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_products.tpl'));
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>