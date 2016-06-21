<?php
define('EXECUTE', 1);
define('DIRSEP', DIRECTORY_SEPARATOR);
date_default_timezone_set('Europe/Kiev');
// phpinfo();
require(dirname(__FILE__).'/../~core/sys/global_c.php');
require(dirname(__FILE__).'/core/cfg.php');
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
$s_time = G::getmicrotime();
session_start();
$GLOBALS['Controllers'] = G::GetControllers($GLOBALS['PATH_contr']);
require($GLOBALS['PATH_core'].'routes.php');
G::Start();
require($GLOBALS['PATH_core'].'controller.php');
G::AddCSS('reset.css');
G::AddCSS('bootstrap-grid-3.3.2.min.css');
G::AddCSS('style.css');
G::AddCSS('header.css');
G::AddCSS('sidebar.css');
G::AddCSS('highslide.css');
G::AddJS('jquery-2.1.1.min.js');
G::AddJS('jquery.lazyload.min.js');
G::AddJS('jquery-ui.js');
G::AddJS('../plugins/js/jquery.cookie.js');
G::AddJS('bootstrap.min.js');
G::AddJS('../plugins/ckeditor/ckeditor.js');
G::AddJS('main.js');
G::AddJS('func.js');
$GLOBALS['__page_h1'] = '&nbsp;';
if($GLOBALS['CurrentController'] != 'productedit'){
	// G::AddCSS('adm.css');
}
if(isset($_GET['check_art'])){
	$products = new Products();
	echo "<!-- ".$products->CheckArticle($_GET['check_art'])."-->";
}

if(isset($_GET['img'])){
	$img = new Images();
	$img->resize(false, false, strtotime($_GET['img']));
}
if(isset($_GET['clear_thumbs'])){
	$img = new Images();
	$img->clearThumbs();
}
// var_dump(file_exists('adm/css/page_styles/'.$GLOBALS['CurrentController'].'.css'));
// if(file_exists('adm/css/page_styles/'.$GLOBALS['CurrentController'].'.css')){
	G::AddCSS('page_styles/'.$GLOBALS['CurrentController'].'.css');
// }
$tpl->Assign('css_arr', G::GetCSS());
$tpl->Assign('js_arr', G::GetJS());
$tpl->Assign('__page_title', $GLOBALS['__page_title']);
$tpl->Assign('__center', $GLOBALS['__center']);
$tpl->Assign('__sidebar_l', $GLOBALS['__sidebar_l']);
$tpl->Assign('__header', $tpl->Parse($GLOBALS['PATH_tpl_global'].'main_header.tpl'));
echo $tpl->Parse($GLOBALS['PATH_tpl_global'].$GLOBALS['MainTemplate']);
$e_time = G::getmicrotime();
//if ($GLOBALS['CurrentController'] != 'feed')
echo "<!--".date("d.m.Y H:i:s", time())."  ".$_SERVER['REMOTE_ADDR']." gentime = ".($e_time - $s_time)." -->";
session_write_close();
