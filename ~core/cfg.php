<?php
$root = $_SERVER['DOCUMENT_ROOT'].'/';
require($root.'config.php');
// ******************************** Начальное конфигурирование *************************************
define('_base_url', '//'.$_SERVER['HTTP_HOST']);
date_default_timezone_set("Europe/Moscow");
$config = array (
	'URL_base'			=> _base_url,
	'URL_request'		=> $_SERVER['REQUEST_URI'],
	'URL_img'			=> _base_url.'/images/',
	'PATH_root'			=> $root,
	'PATH_core'			=> $root.'~core/',
	'PATH_sys'			=> $root.'~core/sys/',
	'PATH_product_img'	=> $root.'product_images/',
	'PATH_block'		=> $root.'~core/block/',
	'PATH_contr'		=> $root.'~core/contr/',
	'PATH_model'		=> $root.'~core/model/'
);
// $config['URL_css']	= _base_url.'/css/';
// $config['URL_js']	= _base_url.'/js/';
// $config['PATH_tpl']	= $root.'~core/tpl/';
// $config['PATH_tpl_global'] = $root.'~core/tpl/_global/';
// android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge\ |maemo|midp|mmp|opera\ m(ob|in)i|palm(\ os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows\ (ce|phone)|xda|xiino
// if($_SESSION['client']['user_agent'] == 'desktop'){
	$config['URL_css']	= _base_url.'/css/';
	$config['URL_js']	= _base_url.'/js/';
	$config['PATH_tpl']	= $root.'~core/tpl/';
	$config['PATH_tpl_global'] = $root.'~core/tpl/_global/';
// }else{
// 	$config['URL_css']	= _base_url . '/mobile/css/';
// 	$config['URL_js']	= _base_url . '/mobile/js/';
// 	$config['PATH_tpl']	= $root . 'mobile/~core/tpl/';
// 	$config['PATH_tpl_global'] = $root . 'mobile/~core/tpl/_global/';
// }
G::ToGlobals($config);
unset($config, $root);
// default controller, if no one else has come
$GLOBALS['DefaultController']	= 'main';
// макет
$GLOBALS['MainTemplate']		= 'main.tpl';
// пустой макет
$GLOBALS['MainEmptyTemplate']	= 'main_empty.tpl';
// страницы с левым сайдбаром
$GLOBALS['LeftSideBar']			= array('main', 'products', 'page', 'newslist', 'news', 'wishes', 'posts', 'post', 'register', 'price', 'demo_order', 'search', 'login', 'customer_order', 'pdf_bill_form');
// если кабинет поставщика или пользователя - отобразить левый сайдбар
if(isset($_SESSION['member']['gid']) && in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_, _ACL_CUSTOMER_, _ACL_ANONIM_))){
	array_push($GLOBALS['LeftSideBar'], 'cabinet');
}
// страницы с правым сайдбаром
$GLOBALS['RightSideBar']		= array('main', 'register', 'login', 'page', 'pdf_bill_form');
// страницы на пустом макете
$GLOBALS['EmptyTemplate']		= array();
// страницы без хлебных крошек
$GLOBALS['NoBreadcrumbs']		= array('main', '404');
// страницы без блока новостей в сайдбаре
$GLOBALS['NoSidebarNews']		= array();
// страницы без макета
$GLOBALS['NoTemplate']			= array('pricelist-order');
// страницы, на которых есть блок фильтров в сайдбаре
$GLOBALS['Filters']				= array('products');
// Массив ссылок иерархии (используются также в хлебных крошках)
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][] = array(
	'title' => 'Главная',
	'url' => _base_url
);
// сколько брать записей из таблицы (при использовании пагинатора)
$GLOBALS['Limit_db'] = 30;
$GLOBALS['Start'] = 0;
$GLOBALS['Limits_db'] = array(30, 60, 100);
// ***************************** Подключение и инициализация системных классов  *****************************
require($GLOBALS['PATH_sys'].'tpl_c.php');
require($GLOBALS['PATH_sys'].'db_c.php');
require($GLOBALS['PATH_sys'].'dbtree_c.php');
require($GLOBALS['PATH_sys'].'pages_c.php');
require($GLOBALS['PATH_sys'].'acl_c.php');
require($GLOBALS['PATH_sys'].'mailer_c.php');
require($GLOBALS['PATH_sys'].'sfYaml.php');
require($GLOBALS['PATH_sys'].'sfYamlParser.php');
require($GLOBALS['PATH_sys'].'status_c.php');
require($GLOBALS['PATH_sys'].'images_c.php');
define ('DB_CACHE', false);
$db = new mysqlDb($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
$GLOBALS['db'] =& $db;
$tpl = new TPL();
$GLOBALS['tpl'] =& $tpl;
// ********************************** Подключение и инициализация моделей  **********************************
require($GLOBALS['PATH_model'].'users_c.php');
require($GLOBALS['PATH_model'].'customers_c.php');
require($GLOBALS['PATH_model'].'suppliers_c.php');
require($GLOBALS['PATH_model'].'contragents_c.php');
require($GLOBALS['PATH_model'].'managers_c.php');
require($GLOBALS['PATH_model'].'page_c.php');
require($GLOBALS['PATH_model'].'news_c.php');
require($GLOBALS['PATH_model'].'wishes_c.php');
require($GLOBALS['PATH_model'].'manufacturers_c.php');
require($GLOBALS['PATH_model'].'products_c.php');
require($GLOBALS['PATH_model'].'cart_c.php');
require($GLOBALS['PATH_model'].'orders_c.php');
require($GLOBALS['PATH_model'].'locations_c.php');
require($GLOBALS['PATH_model'].'product_sdescr_c.php');
require($GLOBALS['PATH_model'].'sphinxapi_c.php');
require($GLOBALS['PATH_model'].'APISMS.php');
require($GLOBALS['PATH_model'].'UploadHandler.php');
require($GLOBALS['PATH_model'].'slides_c.php');
require($GLOBALS['PATH_model'].'unit_c.php');
require($GLOBALS['PATH_model'].'post_c.php');
// получение всех настроек с БД
$sql = "SELECT name, value FROM "._DB_PREFIX_."config";
$arr = $db->GetArray($sql);
// формирование глобального массива настроек
foreach($arr as $i){
	$GLOBALS['CONFIG'][$i['name']] = $i['value'];
}
unset($sql, $arr);
// почтовая конфигурация
$GLOBALS['MAIL_CONFIG']['from_name'] = $GLOBALS['CONFIG']['mail_caption']; // from (от) имя
$GLOBALS['MAIL_CONFIG']['from_email'] = $GLOBALS['CONFIG']['mail_email']; // from (от) email адрес
// На всякий случай указываем настройки для дополнительного (внешнего) SMTP сервера.
$GLOBALS['MAIL_CONFIG']['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$GLOBALS['MAIL_CONFIG']['smtp_host'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_port'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_username'] = null;
?>