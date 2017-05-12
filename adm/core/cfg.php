<?php
G::GetUserInfo();
G::DefineBaseURL();
G::DefineRootDirectory();
$root = _root.'adm'.DIRECTORY_SEPARATOR;
require(_root.'config.php');
// ******************************** Начальное конфигурирование *************************************
$baseUrl = '//'.$_SERVER['SERVER_NAME'].'/';
/*define('_base_url', $baseUrl);*/
G::ToGlobals(array(
	'URL_base'			=> $baseUrl,
	'URL_request'		=> 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
	'URL_img'			=> $baseUrl.'adm/img/',
	'URL_css'			=> $baseUrl.'adm/css/',
	'URL_js'			=> $baseUrl.'adm/js/',
	'PATH_root'			=> $root,
	'PATH_global_root'	=> _root,
	'PATH_core'			=> $root.'core/',
	'PATH_sys'			=> _root.'~core/sys/',
	'PATH_model'		=> _root.'~core/model/',
'PATH_product_img'	=> _root.'product_images/',
	'PATH_block'		=> $root.'core/block/',
	'PATH_contr'		=> $root.'core/contr/',
	'PATH_tpl'			=> $root.'core/tpl/',
	'PATH_tpl_global'	=> $root.'core/tpl/_global/',
	'PATH_news_img'		=> _root.'news_images/',
	'PATH_post_img'		=> _root.'post_images/',
));
unset($config);

$GLOBALS['DefaultController'] = 'main';
//$GLOBALS['__graph'] = $tpl_graph;
$GLOBALS['MainTemplate'] = 'main.tpl';
$GLOBALS['NoSidebarTemplControllers'] = array('msg', 'srv');
// Массив ссылок иерархии (используются также в хлебных крошках)
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][] = array(
	'title' => 'Главная',
	'url' => _base_url.'/adm/'
);
// Лимит ссылок в навигации
$GLOBALS['Limit_nav'] = 10; // ???
// сколько брать записей из таблицы (при использовании пагинатора)
$GLOBALS['Limit_db'] = 30;
$GLOBALS['Start'] = 0;
$GLOBALS['Limits_db'] = array(30, 60, 100);

// ********************************** Подключение и инициализация классов  **********************************
require($GLOBALS['PATH_sys'].'tpl_c.php');
require($GLOBALS['PATH_sys'].'link_c.php');
require($GLOBALS['PATH_sys'].'db_c.php');
require($GLOBALS['PATH_sys'].'dbtree_c.php');
require($GLOBALS['PATH_sys'].'paginator_c.php');
require($GLOBALS['PATH_sys'].'acl_c.php');
require($GLOBALS['PATH_sys'].'mailer_c.php');
require($GLOBALS['PATH_sys'].'status_c.php');
require($GLOBALS['PATH_sys'].'images_c.php');
require($GLOBALS['PATH_sys'].'sfYaml.php');
require($GLOBALS['PATH_sys'].'sfYamlParser.php');
// including configuration file
// require(_root.'config.php');
// connection to mysql server
if(phpversion() >= 5.6){
	$db = new mysqlPDO($GLOBALS['DB']['HOST'], $GLOBALS['DB']['USER'], $GLOBALS['DB']['PASSWORD'], $GLOBALS['DB']['NAME']);
}else{
	$db = new mysqlDb($GLOBALS['DB']['HOST'], $GLOBALS['DB']['USER'], $GLOBALS['DB']['PASSWORD'], $GLOBALS['DB']['NAME']);
}
$GLOBALS['db'] =& $db;
$sql = "SELECT * FROM "._DB_PREFIX_."profiles";
$profiles = $db->GetArray($sql);
$admin_controllers = G::GetControllers(str_replace('~core', 'adm'.DIRSEP.'core', $GLOBALS['PATH_contr']));
foreach($profiles as $profile){
	define('_ACL_'.strtoupper($profile['name']).'_', $profile['id_profile']);
}
// $ACL_PERMS = array(
// 	// default rights
// 	'rights' => $admin_controllers,
// 	// groups
// 	'groups' => $profiles
// );
G::ToGlobals(array(
	'ACL_PERMS' => array(
		// default rights
		'rights' => array(
			'admin_panel',
			'anonim_cab',
			'catalog',
			'configs',
			'contragent_cab',
			'customer_cab',
			'diler_cab',
			'duplicates',
			'locations',
			'manager_cab',
			'manufacturers',
			'moderation_edit_product',
			'news',
			'orders',
			'pages',
			'posts',
			'pricelist',
			'photo_products',
			'product',
			'product_moderation',
			'product_report',
			'remitters',
			'slides',
			'specifications',
			'supplier_cab',
			'units',
			'wishes',
			'segmentations',
			'supplier_prov',
			'monitoring',
			'seotext',
			'orders_category',
			'order',
			'guestbook',
			'graphics',
			'users',
			'customers',
			'contragents',
			'suppliers',
			'parser'
		),
		// groups
		'groups' => array(
			0 => array(
				'name' => 'guest',
				'caption' => 'Все',
				'permissions' => 0 // disallow all
			),
			1 => array(
				'name' => 'admin',
				'caption' => 'Администратор',
				'permissions' => 1 // allow all
			),
			2 => array(
				'name' => 'moderator',
				'caption' => 'Администратор наполнения',
				'permissions' => array(
					'admin_panel',
					'catalog',
					'product',
					'news',
					'product_report',
					'product_moderation',
					'moderation_edit_product',
					'pages',
					'pageedit',
					'slides',
					'duplicates',
					'specifications',
					'units',
					'wishes',
					'segmentations',
					'pricelist',
					'supplier_prov',
					'orders_category',
					'monitoring',
					'guestbook',
					'graphics',
					'suppliers',
					'parser',
					'photo_products'
				)
			),
			3 => array(
				'name' => 'supplier',
				'caption' => 'Поставщик',
				'permissions' => array(
					'supplier_cab',
					'product'
				)
			),
			4 => array(
				'name' => 'contragent',
				'caption' => 'Контрагент',
				'permissions' => array(
					'contragent_cab'
				)
			),
			5 => array(
				'name' => 'customer',
				'caption' => 'Покупатель',
				'permissions' => array(
					'customer_cab'
				)
			),
			6 => array(
				'name' => 'manager',
				'caption' => 'Менеджер',
				'permissions' => array(
					'manager_cab'
				)
			),
			7 => array(
				'name' => 'diler',
				'caption' => 'Дилер',
				'permissions' => array(
					'diler_cab'
				)
			),
			8 => array(
				'name' => 'anonim',
				'caption' => 'Покупатель аноним',
				'permissions' => array(
					'anonim_cab'
				)
			),
			9 => array(
				'name' => 'SEO_optimizator',
				'caption' => 'СЕО - оптимизатор',
				'permissions' => array(
					'admin_panel',
					'pages',
					'pageedit',
					'news',
					'catalog',
					'product',
					'product_moderation',
					'moderation_edit_product',
					'slides',
					'duplicates',
					'specifications',
					'units',
					'wishes',
					'segmentations',
					'product_report',
					'monitoring',
					'seotext',
					'orders_category',
					'order',
					'guestbook',
					'graphics'
				)
			),
			10 => array(
				'name' => 'm_diler',
				'caption' => 'M-Дилер',
				'permissions' => array(
					'm_diler_cab'
				)
			),
			11 => array(
				'name' => 'terminal',
				'caption' => 'Терминальный клиент',
				'permissions' => array(
					'terminal_cab'
				)
			),
			12 => array(
				'name' => 'supplier_manager',
				'caption' => 'Менеджер поставщиков',
				'permissions' => array(
					'supplier_manager_cab'
				)
			),
			13 => array(
				'name' => 'photographer',
				'caption' => 'Фотограф',
				'permissions' => array(
					'admin_panel',
					'catalog',
					'product',
					'news',
					'product_report',
					'product_moderation',
					'moderation_edit_product',
					'pages',
					'pageedit',
					'slides',
					'duplicates',
					'specifications',
					'units',
					'wishes',
					'segmentations',
					'pricelist',
					'supplier_prov',
					'photo_products'
				)
			),
			14 => array(
				'name' => 'remote_content',
				'caption' => 'Удаленный контент-менеджер',
				'permissions' => array(
					'admin_panel',
					'catalog',
					'product',
				)
			)
		)
	)
));
$tpl = new Template();
$GLOBALS['tpl'] =& $tpl;
// ********************************** Подключение и инициализация моделей  **********************************
require($GLOBALS['PATH_model'].'users_c.php');
require($GLOBALS['PATH_model'].'profiles_c.php');
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
require($GLOBALS['PATH_model'].'segmentation_c.php');
require($GLOBALS['PATH_model'].'specification_c.php');
require($GLOBALS['PATH_model'].'config_c.php');
require($GLOBALS['PATH_model'].'seo_c.php');
require($GLOBALS['PATH_model'].'newsletter_c.php');
require($GLOBALS['PATH_model'].'simple_html_dom_c.php');
require($GLOBALS['PATH_model'].'parser_c.php');
// получение всех настроек с БД
$sql = "SELECT name, value FROM "._DB_PREFIX_."config WHERE sid = 1";
$arr = $db->GetArray($sql);
// формирование глобального массива настроек
foreach ($arr as $i){
	$GLOBALS['CONFIG'][$i['name']] = $i['value'];
}
unset($sql, $arr);

// почтовая конфигурация
$GLOBALS['MAIL_CONFIG']['from_name'] = $GLOBALS['CONFIG']['mail_caption']; // from (от) имя
$GLOBALS['MAIL_CONFIG']['from_email'] = $GLOBALS['CONFIG']['mail_email']; // from (от) email адрес
// На всякий случай указываем настройки
// для дополнительного (внешнего) SMTP сервера.
$GLOBALS['MAIL_CONFIG']['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$GLOBALS['MAIL_CONFIG']['smtp_host'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_port'] = null;
$GLOBALS['MAIL_CONFIG']['smtp_username'] = null;
