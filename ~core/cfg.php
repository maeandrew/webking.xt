<?php
if(!CMD){
	G::GetUserInfo();
	G::DefineBaseURL();
}
G::DefineRootDirectory();
// ******************************** Начальное конфигурирование *************************************
if(!CMD){
	G::ToGlobals(array(
		'URL_base'			=> _base_url,
		'URL_request'		=> preg_replace('/\/$/', '', (isset($_GET['request'])?$_GET['request']:null)?:preg_replace('/^\/.*/', '', $_SERVER['REQUEST_URI'])),
		'URL_img'			=> _base_url.'/img/',
		'URL_css'			=> _base_url.'/css/',
		'URL_js'			=> _base_url.'/js/'
	));
}
G::ToGlobals(array(
	'PATH_root'				=> _root,
	'PATH_global_root'		=> _root,
	'PATH_core'				=> _root.'~core'.DIRSEP,
	'PATH_sys'				=> _root.'~core'.DIRSEP.'sys'.DIRSEP,
	'PATH_product_img'		=> _root.'product_images'.DIRSEP,
	'PATH_block'			=> _root.'~core'.DIRSEP.'block'.DIRSEP,
	'PATH_contr'			=> _root.'~core'.DIRSEP.'contr'.DIRSEP,
	'PATH_model'			=> _root.'~core'.DIRSEP.'model'.DIRSEP,
	'PATH_tpl'				=> _root.'~core'.DIRSEP.'tpl'.DIRSEP,
	'PATH_tpl_global'		=> _root.'~core'.DIRSEP.'tpl'.DIRSEP.'_global'.DIRSEP,
	'PATH_adm_tpl'			=> _root.'adm'.DIRSEP.'core'.DIRSEP.'tpl'.DIRSEP,
	'PATH_adm_tpl_global'	=> _root.'adm'.DIRSEP.'core'.DIRSEP.'tpl'.DIRSEP.'_global'.DIRSEP,
));
$GLOBALS['Controllers'] = G::GetControllers($GLOBALS['PATH_contr']);
$GLOBALS['Theme'] = 'default';
$GLOBALS['PATH_tpl'] = str_replace($GLOBALS['PATH_core'], _root.'themes'.DIRSEP.$GLOBALS['Theme'].DIRSEP, $GLOBALS['PATH_tpl']);
$GLOBALS['PATH_tpl_global'] = str_replace($GLOBALS['PATH_core'], _root.'themes'.DIRSEP.$GLOBALS['Theme'].DIRSEP, $GLOBALS['PATH_tpl_global']);
if(!CMD){
	$GLOBALS['URL_img_theme'] = _base_url.'/themes/'.$GLOBALS['Theme'].'/img/';
	$GLOBALS['URL_css_theme'] = _base_url.'/themes/'.$GLOBALS['Theme'].'/css/';
	$GLOBALS['URL_js_theme'] = _base_url.'/themes/'.$GLOBALS['Theme'].'/js/';
}
// // ***************************** Подключение и инициализация системных классов  *****************************
spl_autoload_register(function ($className){
	if(strpos($className, 'PHPExcel_') === 0){
		$filename = str_replace('_', DIRECTORY_SEPARATOR, str_replace('PHPExcel', '', $className)).'.php';
		$path = $GLOBALS['PATH_sys'].'PHPExcel';
	}else{
		$filename = strtolower(str_replace('_', '', $className)).'_c.php';
		$path = file_exists($GLOBALS['PATH_sys'].$filename)?$GLOBALS['PATH_sys']:$GLOBALS['PATH_model'];
	}
	if(file_exists($path.$filename)){
		@require_once($path.$filename);
	}else{
		die("<br>Can't find file '$filename' with class '$className' in '$path'");
	}
});
// including configuration file
require(_root.'config.php');
// connection to mysql server
$db = new db($GLOBALS['DB']['HOST'], $GLOBALS['DB']['USER'], $GLOBALS['DB']['PASSWORD'], $GLOBALS['DB']['NAME']);
$GLOBALS['db'] =& $db;
$admin_controllers = G::GetControllers(str_replace('~core', 'adm'.DIRSEP.'core', $GLOBALS['PATH_contr']));
if(!CMD){
	$sql = "SELECT * FROM "._DB_PREFIX_."profiles";
	$profiles = $db->GetArray($sql);
	foreach($profiles as &$profile){
		define('_ACL_'.strtoupper($profile['name']).'_', $profile['id_profile']);
	}
	G::ToGlobals(array(
		'ACL_PERMS' => array(
			// default rights
			'rights' => $admin_controllers,
			// groups
			'groups' => $profiles
		)
	));
	if(G::IsLogged()){
		_acl::load($_SESSION['member']['gid']);
	}
	$unwatch = array('95.69.190.43', '178.150.144.143');
	if(!in_array($_SESSION['client']['ip'], $unwatch) && strpos($_SESSION['client']['ip'], '192.168.0') !== 0){
		$sql1 = "SELECT * FROM "._DB_PREFIX_."ip_connections WHERE ip = '".$_SESSION['client']['ip']."' AND sid = 1";
		$ips = $db->GetOneRowArray($sql1);
		// if(!$ips){
		// 	$sql2 = "INSERT INTO "._DB_PREFIX_."ip_connections (ip, connections, last_connection, user_agent".(G::IsLogged()?', id_user':null).") VALUES ('".$_SESSION['client']['ip']."', 1, '".date("Y-m-d H:i:s")."', '".$_SERVER['HTTP_USER_AGENT']."'".(G::IsLogged()?', '.$_SESSION['member']['id_user']:null).")";
		// 	$ips = $db->GetOneRowArray($sql1);
		// }else{
		// 	$sql2 = "UPDATE "._DB_PREFIX_."ip_connections SET connections = ".($ips['connections']+1).", last_connection = '".date("Y-m-d H:i:s")."', user_agent = '".$_SERVER['HTTP_USER_AGENT']."'".(G::IsLogged()?", id_user = ".$_SESSION['member']['id_user']:null)." WHERE ip = '".$_SESSION['client']['ip']."' AND sid = 1";
		// }
		// $db->Query($sql2);
		if($ips && $ips['block'] == 1){
			header('Location: '._base_url);
			exit();
			// $block = array('77.108.80.2', '193.106.92.242', '89.223.35.117'); x-torg.com
			// $block = array('193.106.92.242');//, '69.162.124.231');
			// if(in_array($_SESSION['client']['ip'], $block)){
			// }
		}
	}
}
// получение всех настроек с БД
$sql = "SELECT name, caption, value FROM "._DB_PREFIX_."config WHERE sid = 1";
$arr = $db->GetArray($sql);
// формирование глобального массива настроек
$GLOBALS['CONFIG']['promo_correction_set'] = false;
foreach($arr as $i){
	if(substr($i['caption'], 0, 5) == 'promo'){
		$GLOBALS['CONFIG']['promo_correction_set'][] = str_replace('correction_set_', '', $i['name']);
	}
	$GLOBALS['CONFIG'][$i['name']] = $i['value'];
}
// default controller, if no one else has come
$GLOBALS['DefaultController']	= 'main';
// макет
$GLOBALS['MainTemplate']		= 'main.tpl';
// пустой макет
$GLOBALS['MainEmptyTemplate']	= 'main_empty.tpl';
// страницы с левым сайдбаром
$GLOBALS['LeftSideBar']			= array(
	// 'main',
	'products',
	'page',
	'newslist',
	'news',
	'wishes',
	'posts',
	'post',
	'register',
	'price',
	'demo_order',
	'search',
	'login',
	// 'customer_order',
	'pdf_bill_form'
);
// если кабинет поставщика или пользователя - отобразить левый сайдбар
// if(isset($_SESSION['member']['gid']) && in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_, _ACL_CUSTOMER_, _ACL_ANONYMOUS_))){
// 	array_push($GLOBALS['LeftSideBar'], 'cabinet');
// }
// страницы с правым сайдбаром
$GLOBALS['RightSideBar']		= array('main', 'register', 'login', 'page', 'pdf_bill_form');
// страницы на пустом макете
$GLOBALS['EmptyTemplate']		= array();
// страницы без хлебных крошек
$GLOBALS['NoBreadcrumbs']		= array('main', '404');
// страницы без блока новостей в сайдбаре
$GLOBALS['NoSidebarNews']		= array();
// страницы без макета
$GLOBALS['NoTemplate']			= array('pricelist-order', 'invoice_dealer');
// страницы, на которых есть блок фильтров в сайдбаре
$GLOBALS['WithFilters']			= array('products', 'main', 'product');
// Массив ссылок иерархии (используются также в хлебных крошках)
if(!CMD){
	$GLOBALS['IERA_LINKS'] = array();
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => 'Служба снабжения xt.ua',
		'url' => _base_url
	);
}
// сколько брать записей из таблицы (при использовании пагинатора)
$GLOBALS['Limit_db'] = 30;
$GLOBALS['Start'] = 0;
$GLOBALS['Limits_db'] = array(30, 60, 100);

$tpl = new Tpl();
$GLOBALS['tpl'] =& $tpl;
// ********************************** Подключение и инициализация моделей  **********************************
// require($GLOBALS['PATH_model'].'users_c.php');
// require($GLOBALS['PATH_model'].'customers_c.php');
// require($GLOBALS['PATH_model'].'suppliers_c.php');
// require($GLOBALS['PATH_model'].'contragents_c.php');
// require($GLOBALS['PATH_model'].'managers_c.php');
// require($GLOBALS['PATH_model'].'page_c.php');
// require($GLOBALS['PATH_model'].'news_c.php');
// require($GLOBALS['PATH_model'].'wishes_c.php');
// require($GLOBALS['PATH_model'].'manufacturers_c.php');
// require($GLOBALS['PATH_model'].'products_c.php');
// require($GLOBALS['PATH_model'].'cart_c.php');
// require($GLOBALS['PATH_model'].'orders_c.php');
// require($GLOBALS['PATH_model'].'locations_c.php');
// require($GLOBALS['PATH_model'].'product_sdescr_c.php');
// require($GLOBALS['PATH_model'].'sphinxapi_c.php');
// require($GLOBALS['PATH_model'].'APISMS.php');
// require($GLOBALS['PATH_model'].'UploadHandler.php');
// require($GLOBALS['PATH_model'].'slides_c.php');
// require($GLOBALS['PATH_model'].'unit_c.php');
// require($GLOBALS['PATH_model'].'post_c.php');
// require($GLOBALS['PATH_model'].'seo_c.php');
// require($GLOBALS['PATH_model'].'NP2.php');
// require($GLOBALS['PATH_model'].'IntimeApi2.php');
// require($GLOBALS['PATH_model'].'specification_c.php');
// require($GLOBALS['PATH_model'].'segmentation_c.php');
// require($GLOBALS['PATH_model'].'config_c.php');
// require($GLOBALS['PATH_model'].'newsletter_c.php');
// require($GLOBALS['PATH_model'].'simple_html_dom_c.php');
// require($GLOBALS['PATH_model'].'parser_c.php');
// require($GLOBALS['PATH_model'].'promo_c.php');


if(!CMD){
	// Получение SEO данных для адреса
	$Seo = new SEO();
	if($Seo->SetFieldsByUrl(_base_url.$_SERVER['REQUEST_URI'])){
		if($Seo->fields['visible'] == 1){
			$tpl->Assign('seotext', $Seo->fields);
		}
	}
}
// почтовая конфигурация
$GLOBALS['MAIL_CONFIG']['from_name'] = $GLOBALS['CONFIG']['mail_caption']; // from (от) имя
$GLOBALS['MAIL_CONFIG']['from_email'] = $GLOBALS['CONFIG']['mail_email']; // from (от) email адрес
// На всякий случай указываем настройки для дополнительного (внешнего) SMTP сервера.
$GLOBALS['MAIL_CONFIG']['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$GLOBALS['MAIL_CONFIG']['smtp_host'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_port'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_username'] = null;

// unset($theme, $sql, $profiles, $admin_controllers, $profile, $unwatch, $block, $arr, $i, $ips);
