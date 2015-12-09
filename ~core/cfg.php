<?php
G::GetUserInfo();
G::DefineBaseURL();
G::DefineRootDirectory();
// ******************************** Начальное конфигурирование *************************************
G::ToGlobals(array(
	'URL_base'			=> _base_url,
	'URL_request'		=> preg_replace('/\/$/', '', $_GET['request']?:preg_replace('/^/.*/', '', $_SERVER['REQUEST_URI'])),
	'URL_img'			=> _base_url.'/images/',
	'URL_css'			=> _base_url.'/css/',
	'URL_js'			=> _base_url.'/js/',
	'PATH_root'			=> _root,
	'PATH_core'			=> _root.'~core'.DIRSEP,
	'PATH_sys'			=> _root.'~core'.DIRSEP.'sys'.DIRSEP,
	'PATH_product_img'	=> _root.'product_images'.DIRSEP,
	'PATH_block'		=> _root.'~core'.DIRSEP.'block'.DIRSEP,
	'PATH_contr'		=> _root.'~core'.DIRSEP.'contr'.DIRSEP,
	'PATH_model'		=> _root.'~core'.DIRSEP.'model'.DIRSEP,
	'PATH_tpl'			=> _root.'~core'.DIRSEP.'tpl'.DIRSEP,
	'PATH_tpl_global'	=> _root.'~core'.DIRSEP.'tpl'.DIRSEP.'_global'.DIRSEP
));
$GLOBALS['Controllers'] = G::GetControllers($GLOBALS['PATH_contr']);
$theme = 'default';
$GLOBALS['PATH_tpl'] = str_replace(PATH_core, _root.'themes'.DIRSEP.$theme.DIRSEP, $GLOBALS['PATH_tpl']);
$GLOBALS['PATH_tpl_global'] = str_replace(PATH_core, _root.'themes'.DIRSEP.$theme.DIRSEP, $GLOBALS['PATH_tpl_global']);
// // ***************************** Подключение и инициализация системных классов  *****************************
require($GLOBALS['PATH_sys'].'link_c.php');
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

// including configuration file
require(_root.'config.php');

// connection to mysql server
if(phpversion() >= 5.6){
	$db = new mysqlPDO($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
}else{
	$db = new mysqlDb($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
}
$GLOBALS['db'] =& $db;

$sql = "SELECT * FROM "._DB_PREFIX_."profiles";
$profiles = $db->GetArray($sql);
$admin_controllers = G::GetControllers(str_replace('~core', 'adm'.DIRSEP.'core', $GLOBALS['PATH_contr']));
foreach($profiles as $profile){
	define('_ACL_'.strtoupper($profile['name']).'_', $profile['id_profile']);
}
$ACL_PERMS = array(
	// default rights
	'rights' => $admin_controllers,
	// groups
	'groups' => $profiles
);
// получение всех настроек с БД
$sql = "SELECT name, value FROM "._DB_PREFIX_."config";
$arr = $db->GetArray($sql);
// формирование глобального массива настроек
foreach($arr as $i){
	$GLOBALS['CONFIG'][$i['name']] = $i['value'];
}
unset($sql, $arr);

// default controller, if no one else has come
$GLOBALS['DefaultController']	= 'main';
// макет
$GLOBALS['MainTemplate']		= 'main.tpl';
// пустой макет
$GLOBALS['MainEmptyTemplate']	= 'main_empty.tpl';
// страницы с левым сайдбаром
$GLOBALS['LeftSideBar']			= array('main', 'products', 'page', 'newslist', 'news', 'wishes', 'posts', 'post', 'register', 'price', 'demo_order', 'search', 'login', 'customer_order', 'pdf_bill_form');
// если кабинет поставщика или пользователя - отобразить левый сайдбар
if(isset($_SESSION['member']['gid']) && in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_, _ACL_CUSTOMER_, _ACL_ANONYMOUS_))){
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
$GLOBALS['WithFilters']			= array('products');
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

$tpl = new Template();
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

// почтовая конфигурация
$GLOBALS['MAIL_CONFIG']['from_name'] = $GLOBALS['CONFIG']['mail_caption']; // from (от) имя
$GLOBALS['MAIL_CONFIG']['from_email'] = $GLOBALS['CONFIG']['mail_email']; // from (от) email адрес
// На всякий случай указываем настройки для дополнительного (внешнего) SMTP сервера.
$GLOBALS['MAIL_CONFIG']['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$GLOBALS['MAIL_CONFIG']['smtp_host'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_port'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_username'] = null;
?>