<?php
// echo memory_get_peak_usage()/pow(1000, 2);
session_start();
header('Content-type: text/html; charset=utf-8');
header('Server: nginx');
header('X-Powered-By: PHP');
date_default_timezone_set('Europe/Kiev');
define('EXECUTE', 1);
define('DIRSEP', DIRECTORY_SEPARATOR);
ini_set('session.gc_maxlifetime', 43200);
ini_set('session.cookie_lifetime', 43200);
// ini_set('max_execution_time', 30);
require(dirname(__FILE__).DIRSEP.'~core'.DIRSEP.'sys'.DIRSEP.'global_c.php');
require(dirname(__FILE__).DIRSEP.'~core'.DIRSEP.'cfg.php');
$s_time = G::getmicrotime();
/*ini_set('session.save_path', $GLOBALS['PATH_root'].'sessions');*/
require($GLOBALS['PATH_core'].'routes.php');
G::Start();
/* Объявление CSS файлов */
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/reset.css', 0);
G::AddCSS('../plugins/mdl-select.min.css', 1);
G::AddCSS('../plugins/owl-carousel/owl.carousel.css', 1);
if(SETT == 2){
	G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/fonts.css', 0);
}
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/colors.css', 0);
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/style.css', 0);
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/header.css', 0);
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/footer.css', 1);
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/custom.css', 1);
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/jquery-ui.css', 1);
/* plugins css */
G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/page_styles/'.$GLOBALS['CurrentController'].'.css', 0);
/* Объявление JS файлов */
G::AddJS('jquery-2.1.4.min.js', false, 1);
// G::AddJS('jquery-3.1.0.min.js');
G::AddJS('jquery-ui.min.js', true, 1);
G::AddJS('../plugins/Chart.min.js', true);
G::AddJS('../plugins/material/material.min.js', false, 1);
G::AddJS('../plugins/mdl-select.min.js', true, 1);
G::AddJS('../plugins/owl-carousel/owl.carousel.min.js', false, 1);
G::AddJS('../themes/'.$GLOBALS['Theme'].'/js/func.js');
G::AddJS('../themes/'.$GLOBALS['Theme'].'/js/main.js?v123');
if($GLOBALS['CurrentController'] == 'cart'){
	G::AddJS('cart.js');
}else{
	G::AddJS('cart.js', true);
}
/* plugins js */
G::AddJS('../plugins/dropzone.js', false, 1);
G::AddJS('../plugins/jquery.lazyload.min.js', false, 1);
G::AddJS('../plugins/jquery.cookie.js', false, 1);
G::AddJS('../plugins/maskedinput.min.js', false);
G::AddJS('../js/html2canvas.js', true);
G::AddJS('../plugins/masonry.pkgd.min.js', false);
if($GLOBALS['CurrentController'] == 'page'){
	G::AddJS('../themes/'.$GLOBALS['Theme'].'/js/page.js', true);
}
if(in_array($GLOBALS['CurrentController'], array('promo_cart', 'promo'))){
	G::AddJS('promo_cart.js');
}
$_SESSION['ActiveTab'] = isset($_SESSION['ActiveTab']) && $_SESSION['ActiveTab'] == '0'?0:1;
$_SESSION['layout'] = isset($_POST['layout']) && $_POST['layout'] != $_SESSION['layout']?$_POST['layout']:'block';
$GLOBALS['__page_h1'] = '&nbsp;';
$Users = new Users();
$Customers = new Customers();
$Contragents = new Contragents();
$Products = new Products();
$News = new News();
$Cart = new Cart();
if(isset($_SESSION['member'])){
	$Users->SetUser($_SESSION['member']);
	if(isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != 'anonymous'){
		$GLOBALS['user'] = $Users->fields;
	}
}
$Customers->SetFieldsById($Users->fields['id_user']);
// список всех менеджеров
$Contragents->SetList();
$tpl->Assign('managers_list', $Contragents->list);
if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){
	$Contragents->GetSavedFields($Customers->fields['id_contragent']);
	$tpl->Assign('SavedContragent', $Contragents->fields);
}else{
	$Suppliers = new Suppliers();
	$Suppliers->GetSupplierIdByPromoCode($_SESSION['member']['promo_code']);
	$tpl->Assign('promo_supplier', $Suppliers->fields);
	unset($Suppliers);
}
// Выборка просмотренных товаров
if(isset($_COOKIE['view_products'])){
	foreach(json_decode($_COOKIE['view_products']) as $value){
		$Products->SetFieldsById($value, 1, 1);
		$product = $Products->fields;
		if(isset($product['id_product']) && $product['id_product'] != ''){
			$product['images'] = $Products->GetPhotoById($product['id_product']);
		}
		$result[] = $product;
	}
	$tpl->Assign('view_products_list', array_reverse($result));
	unset($result, $product, $value);
}
// Обработка сортировок ====================================
if(isset($_COOKIE['sorting'])){
	$sort = (array)json_decode($_COOKIE['sorting'], true);
	if(isset($sort[$GLOBALS['CurrentController']]) && $sort[$GLOBALS['CurrentController']] == 'Array'){
		setcookie('sorting', json_encode(array($GLOBALS['CurrentController'] => 'name asc')), time()+3600*24*30, '/');
		$sort = (array)json_decode($_COOKIE['sorting'], true);
	}
}
if(isset($GLOBALS['Sort'])){
	if(is_array($GLOBALS['Sort'])){
		$GLOBALS['Sort'] = $GLOBALS['Sort']['value'];
	}
	setcookie('sorting', json_encode(array($GLOBALS['CurrentController'] => $GLOBALS['Sort'])), time()+3600*24*30, '/');
}elseif(!empty($sort) && isset($sort[$GLOBALS['CurrentController']])){
	$GLOBALS['Sort'] = $sort[$GLOBALS['CurrentController']];
}
// else{
// 	$GLOBALS['Sort'] = 'name asc';
// 	setcookie('sorting', json_encode(array($GLOBALS['CurrentController'] => 'name asc')), time()+3600*24*30, '/');
// }
unset($sort);
// Получаем список новостей=================================
if($GLOBALS['CurrentController'] == 'news'){
	if(isset($GLOBALS['Rewrite'])){
		$tpl->Assign('news', $News->GetNews(4, true));
	}
}else{
	$tpl->Assign('news', $News->GetNews(4));
}
// Создание базового массива корзины=======================
if(G::IsLogged() && !_acl::isAdmin()){
	if(!isset($_SESSION['cart']['id'])) $Cart->LastClientCart();
	$Users->SetUserAdditionalInfo($_SESSION['member']['id_user']);
	$_SESSION['member']['favorites'] = $Users->fields['favorites'];
	$_SESSION['member']['waiting_list'] = $Users->fields['waiting_list'];
	$_SESSION['member']['contragent'] = $Users->fields['contragent'];
	$_SESSION['member']['ordered_prod'] = $Users->fields['ordered_prod'];
}
$Cart->RecalcCart();
if(G::IsLogged()){
	$tpl->Assign('customer', $Customers->fields);
	$tpl->Assign('user_profile', $tpl->Parse($GLOBALS['PATH_tpl_global'].'user_profile.tpl'));
}
require($GLOBALS['PATH_core'].'controller.php');
$tpl->Assign('css_arr', G::GetCSS());
$tpl->Assign('js_arr', G::GetJS());
$tpl->Assign('__page_description', $GLOBALS['__page_description']);
$tpl->Assign('__page_title', $GLOBALS['__page_title']);
$tpl->Assign('__page_keywords', $GLOBALS['__page_keywords']);
$tpl->Assign('__page_h1', $GLOBALS['__page_h1']);
$tpl->Assign('__center', $GLOBALS['__center']);
$tpl->Assign('__nav', $GLOBALS['__nav']);
$tpl->Assign('__header', $GLOBALS['__header']);
$tpl->Assign('__breadcrumbs', $GLOBALS['__breadcrumbs']);
$tpl->Assign('__sidebar_l', $GLOBALS['__sidebar_l']);
if(isset($GLOBALS['__graph'])){
	$tpl->Assign('__graph',  $GLOBALS['__graph']);
}
if(in_array($GLOBALS['CurrentController'], $GLOBALS['NoTemplate'])){
	if($GLOBALS['MainTemplate'] == 'main.tpl'){
		$GLOBALS['MainTemplate'] = 'main_empty.tpl';
	}
}
$tpl->Assign('product_label_modal', $tpl->Parse($GLOBALS['PATH_tpl_global'].'product_label_modal.tpl'));
echo $tpl->Parse($GLOBALS['PATH_tpl_global'].$GLOBALS['MainTemplate']);
// include svg icons library
$e_time = G::getmicrotime();
echo "<!--".date("d.m.Y H:i:s", time())." ".$_SERVER['REMOTE_ADDR']." gentime = ".($e_time-$s_time)." -->";
unset($s_time, $e_time);
echo "<!--
Design: Alexander Parkhomenko;
Front-end: Alexander Riabukha, Nadezhda Kovalyova, Alexander Parkhomenko;
Back-end: Alexander Parkhomenko;
 -->";
// echo memory_get_peak_usage()/pow(1000, 2);
session_write_close();