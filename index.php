<?php
// echo memory_get_peak_usage()/pow(1000, 2);
header("Content-type: text/html; charset=utf-8");
session_start();
if(isset($_GET['test'])){
	define('_test', true);
	ini_set('display_errors', '1');
}else{
	define('_test', false);
}
function isMobile() {
	$user_agent = strtolower(getenv('HTTP_USER_AGENT'));
	$accept     = strtolower(getenv('HTTP_ACCEPT'));
	if ((strpos($accept, 'text/vnd.wap.wml') !== false) || (strpos($accept, 'application/vnd.wap.xhtml+xml') !== false)) {
		return 1;// Мобильный браузер обнаружен по HTTP-заголовкам
	}
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
		return 2;// Мобильный браузер обнаружен по установкам сервера
	}
	if (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|'.
			'wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|'.
			'lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|'.
			'mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|'.
			'm881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|'.
			'r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|'.
			'i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|'.
			'htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|'.
			'sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|'.
			'p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|'.
			'_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|'.
			's800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|'.
			'd736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |'.
			'sonyericsson|samsung|240x|x320vx10|nokia|sony cmd|motorola|'.
			'up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|'.
			'pocket|kindle|mobile|psp|treo|android|iphone|ipod|webos|wp7|wp8|'.
			'fennec|blackberry|htc_|opera m|windowsphone)/', $user_agent)) {
		return 3;// Мобильный браузер обнаружен по сигнатуре User Agent
	}
	if (in_array(substr($user_agent, 0, 4),
			Array("1207", "3gso", "4thp", "501i", "502i", "503i", "504i", "505i", "506i",
				"6310", "6590", "770s", "802s", "a wa", "abac", "acer", "acoo", "acs-",
				"aiko", "airn", "alav", "alca", "alco", "amoi", "anex", "anny", "anyw",
				"aptu", "arch", "argo", "aste", "asus", "attw", "au-m", "audi", "aur ",
				"aus ", "avan", "beck", "bell", "benq", "bilb", "bird", "blac", "blaz",
				"brew", "brvw", "bumb", "bw-n", "bw-u", "c55/", "capi", "ccwa", "cdm-",
				"cell", "chtm", "cldc", "cmd-", "cond", "craw", "dait", "dall", "dang",
				"dbte", "dc-s", "devi", "dica", "dmob", "doco", "dopo", "ds-d", "ds12",
				"el49", "elai", "eml2", "emul", "eric", "erk0", "esl8", "ez40", "ez60",
				"ez70", "ezos", "ezwa", "ezze", "fake", "fetc", "fly-", "fly_", "g-mo",
				"g1 u", "g560", "gene", "gf-5", "go.w", "good", "grad", "grun", "haie",
				"hcit", "hd-m", "hd-p", "hd-t", "hei-", "hiba", "hipt", "hita", "hp i",
				"hpip", "hs-c", "htc ", "htc-", "htc_", "htca", "htcg", "htcp", "htcs",
				"htct", "http", "huaw", "hutc", "i-20", "i-go", "i-ma", "i230", "iac",
				"iac-", "iac/", "ibro", "idea", "ig01", "ikom", "im1k", "inno", "ipaq",
				"iris", "jata", "java", "jbro", "jemu", "jigs", "kddi", "keji", "kgt",
				"kgt/", "klon", "kpt ", "kwc-", "kyoc", "kyok", "leno", "lexi", "lg g",
				"lg-a", "lg-b", "lg-c", "lg-d", "lg-f", "lg-g", "lg-k", "lg-l", "lg-m",
				"lg-o", "lg-p", "lg-s", "lg-t", "lg-u", "lg-w", "lg/k", "lg/l", "lg/u",
				"lg50", "lg54", "lge-", "lge/", "libw", "lynx", "m-cr", "m1-w", "m3ga",
				"m50/", "mate", "maui", "maxo", "mc01", "mc21", "mcca", "medi", "merc",
				"meri", "midp", "mio8", "mioa", "mits", "mmef", "mo01", "mo02", "mobi",
				"mode", "modo", "mot ", "mot-", "moto", "motv", "mozz", "mt50", "mtp1",
				"mtv ", "mwbp", "mywa", "n100", "n101", "n102", "n202", "n203", "n300",
				"n302", "n500", "n502", "n505", "n700", "n701", "n710", "nec-", "nem-",
				"neon", "netf", "newg", "newt", "nok6", "noki", "nzph", "o2 x", "o2-x",
				"o2im", "opti", "opwv", "oran", "owg1", "p800", "palm", "pana", "pand",
				"pant", "pdxg", "pg-1", "pg-2", "pg-3", "pg-6", "pg-8", "pg-c", "pg13",
				"phil", "pire", "play", "pluc", "pn-2", "pock", "port", "pose", "prox",
				"psio", "pt-g", "qa-a", "qc-2", "qc-3", "qc-5", "qc-7", "qc07", "qc12",
				"qc21", "qc32", "qc60", "qci-", "qtek", "qwap", "r380", "r600", "raks",
				"rim9", "rove", "rozo", "s55/", "sage", "sama", "samm", "sams", "sany",
				"sava", "sc01", "sch-", "scoo", "scp-", "sdk/", "se47", "sec-", "sec0",
				"sec1", "semc", "send", "seri", "sgh-", "shar", "sie-", "siem", "sk-0",
				"sl45", "slid", "smal", "smar", "smb3", "smit", "smt5", "soft", "sony",
				"sp01", "sph-", "spv ", "spv-", "sy01", "symb", "t-mo", "t218", "t250",
				"t600", "t610", "t618", "tagt", "talk", "tcl-", "tdg-", "teli", "telm",
				"tim-", "topl", "tosh", "treo", "ts70", "tsm-", "tsm3", "tsm5", "tx-9",
				"up.b", "upg1", "upsi", "utst", "v400", "v750", "veri", "virg", "vite",
				"vk-v", "vk40", "vk50", "vk52", "vk53", "vm40", "voda", "vulc", "vx52",
				"vx53", "vx60", "vx61", "vx70", "vx80", "vx81", "vx83", "vx85", "vx98",
				"w3c ", "w3c-", "wap-", "wapa", "wapi", "wapj", "wapm", "wapp", "wapr",
				"waps", "wapt", "wapu", "wapv", "wapy", "webc", "whit", "wig ", "winc",
				"winw", "wmlb", "wonu", "x700", "xda-", "xda2", "xdag", "yas-", "your",
				"zeto", "zte-"))){
		return 4;// Мобильный браузер обнаружен по сигнатуре User Agent
	}
	return false;// Мобильный браузер не обнаружен
}
/* Browser version control */
preg_match_all('/(?P<engine>\w+)\/(?P<version>[\d]+\.[\d]+)/', $_SERVER['HTTP_USER_AGENT'], $matches);

$Mozilla  = 5.0;
$IEMobile = 10.0;
$Safari   = $AppleWebKit   = $AppleWebkit   = 535.19;
$Chrome   = 18.0;
$OPR      = 26.0;
$Firefox  = $Gecko  = 35.0;
unset($matches);
if(isset($_GET['rememberDesktop']) || isset($_COOKIE['user_agent'])){
	if(!isset($_COOKIE['user_agent'])){
		$user_agent = 'desktop';
		setcookie('user_agent', $user_agent, time()+3600*24*30, '/');
		header('Location: /');
		exit();
	}else{
		$user_agent = $_COOKIE['user_agent'];
	}
}else{
	if(isMobile() === false){
		$user_agent = 'desktop';
	}else{
		$user_agent = 'mobile';
	}
}
if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	$ip = $_SERVER['HTTP_CLIENT_IP'];
}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
	$ip = $_SERVER['REMOTE_ADDR'];
}
$_SESSION['client']['ip'] = $ip;
$_SESSION['client']['user_agent'] = $user_agent;
unset($user_agent, $ip);
date_default_timezone_set('Europe/Kiev');
ini_set('session.gc_maxlifetime', 43200);
ini_set('session.cookie_lifetime', 43200);
define('EXECUTE', 1);
require(dirname(__FILE__).'/~core/sys/global_c.php');
require(dirname(__FILE__).'/~core/cfg.php');
// Memcached init
$mc = new Memcached();
$mc->addServer("localhost", 11211);
$s_time = G::getmicrotime();
/*ini_set('session.save_path', $GLOBALS['PATH_root'].'sessions');*/
if(!isset($_COOKIE['manual'])){
	if(!isset($_SESSION['cart']['cart_sum']) || $_SESSION['cart']['cart_sum'] == 0 || (isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] >= $GLOBALS['CONFIG']['full_wholesale_order_margin'])){
		setcookie('sum_range', 0, time()+3600, '/');
		$_COOKIE['sum_range'] = 0;
	}elseif(isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] > $GLOBALS['CONFIG']['wholesale_order_margin'] && $_SESSION['cart']['cart_sum'] < $GLOBALS['CONFIG']['full_wholesale_order_margin']){
		setcookie('sum_range', 1, time()+3600, '/');
		$_COOKIE['sum_range'] = 1;
	}elseif($_SESSION['cart']['cart_sum'] < $GLOBALS['CONFIG']['wholesale_order_margin'] && $_SESSION['cart']['cart_sum'] > $GLOBALS['CONFIG']['retail_order_margin']){
		setcookie('sum_range', 2, time()+3600, '/');
		$_COOKIE['sum_range'] = 2;
	}elseif(isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] <= $GLOBALS['CONFIG']['retail_order_margin']){
		setcookie('sum_range', 3, time()+3600, '/');
		$_COOKIE['sum_range'] = 3;
	}
}
G::Start();
require($GLOBALS['PATH_core'].'routes.php');
/* Объявление CSS файлов */
G::AddCSS('reset.css');
G::AddCSS('bootstrap-grid-3.3.2.css');
G::AddCSS('bootstrap-partial.css');
G::AddCSS('style.css');
G::AddCSS('header.css');
G::AddCSS('sidebar.css');
G::AddCSS('footer.css');

G::AddCSS('custom.css');

// G::AddCSS('jquery-ui.css');
/* plugins css */
G::AddCSS('../plugins/owl-carousel/owl.carousel.css');
G::AddCSS('../plugins/formstyler/jquery.formstyler.css');
G::AddCSS('../plugins/icomoon/style.css');
G::AddCSS('page_styles/'.$GLOBALS['CurrentController'].'.css');
/* Объявление JS файлов */
G::AddJS('jquery-2.1.4.min.js');
G::AddJS('jquery-ui.min.js');
G::AddJS('main.js');
G::AddJS('func.js');
if($GLOBALS['CurrentController'] == 'cart'){
	G::AddJS('cart.js');
}else{
	G::AddJS('cart.js', true);
}
/* plugins js */
G::AddJS('../plugins/dropzone.js');
G::AddJS('../plugins/jquery.lazyload.min.js');
G::AddJS('../plugins/jquery.cookie.js');
G::AddJS('../plugins/owl-carousel/owl.carousel.min.js');
G::AddJS('../plugins/formstyler/jquery.formstyler.js');
G::AddJS('../plugins/maskedinput.min.js', true);
G::AddJS('../plugins/icomoon/liga.js', true);
G::AddJS('../plugins/tagcanvas/jquery.tagcanvas.min.js');

// слайдер на главной странице
if($GLOBALS['CurrentController'] == 'main'){
	$Slides = new Slides();
	$Slides->SetFieldsBySlider('main');
	$slides = $Slides->fields;
	$tpl->Assign('main_slides', $slides);
}
if(in_array($GLOBALS['CurrentController'], array('promo_cart', 'promo'))){
	G::AddJS('promo_cart.js');
}
$active_tab = 1;
if(isset($_SESSION['ActiveTab']) && $_SESSION['ActiveTab'] == '0'){
	$active_tab = 0;
}
$_SESSION['ActiveTab'] = $active_tab;
if(!isset($_SESSION['layout'])){
	$_SESSION['layout'] = 'block';
}elseif(isset($_POST['layout']) && $_POST['layout'] != $_SESSION['layout']){
	$_SESSION['layout'] = $_POST['layout'];
}
$GLOBALS['__page_h1'] = '&nbsp;';
$User = new Users();
if(isset($_SESSION['member'])){
	$User->SetUser($_SESSION['member']);
	if($_SESSION['member']['email'] != 'anonymous'){
		$GLOBALS['user'] = $User->fields;
	}
}
unset($active_tab);
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){
	$SavedContragent = new Contragents();
	$SavedContragent->GetSavedFields($Customer->fields['id_contragent']);
	$tpl->Assign('SavedContragent', $SavedContragent->fields);
	unset($SavedContragent);
}else{
	$promo_supplier = new Suppliers();
	$promo_supplier->GetSupplierIdByPromoCode($_SESSION['member']['promo_code']);
	$tpl->Assign('promo_supplier', $promo_supplier->fields);
	unset($promo_supplier);
}
unset($Customer);

// Выборка просмотренных товаров
$products = new Products();
if(isset($_COOKIE['view_products'])){
	foreach(json_decode($_COOKIE['view_products']) as $value){
		$products->SetFieldsById($value);
		$product = $products->fields;
		if(isset($product['id_product']) && $product['id_product'] != ''){
			$product['images'] = $products->GetPhotoById($product['id_product']);
		}
		$result[] = $product;
	}
	$tpl->Assign('view_products_list', array_reverse($result));
	unset($result);
}

// Выборка популярных товаров
$pops = $products->GetPopularsOfCategory(0, true);
foreach($pops AS &$pop){
	$pop['images'] = $products->GetPhotoById($pop['id_product']);
}
$tpl->Assign('pops', $pops);
unset($pops);

// Обработка сортировок ====================================
if(isset($_COOKIE['sorting'])){
	$sort = unserialize($_COOKIE['sorting']);
}
if(isset($_POST['value']) && isset($_POST['direction'])){
	$sort_value = $_POST['value'];
	$sorting    = array('value' => $sort_value);
	setcookie('sorting', serialize(array($GLOBALS['CurrentController']=> $sorting)), time()+3600*24*30, '/');
}elseif(!empty($sort) && isset($sort[$GLOBALS['CurrentController']])){
	$sorting = $sort[$GLOBALS['CurrentController']];
}
// =========================================================

// Обработка фильтров ======================================
// if(isset($_POST['filters'])){
// 	$filters[] = $_POST['filters'];
// 	$mc->set('filters', array($GLOBALS['CurrentController'] => $filters));
// }elseif(isset($mc->get('filters')[$GLOBALS['CurrentController']])){
// 	$filters = $mc->get('filters')[$GLOBALS['CurrentController']];
// }else{
// 	$filters = false;
// }
// =========================================================

require($GLOBALS['PATH_core'].'controller.php');
$tpl->Assign('css_arr', G::GetCSS());
$tpl->Assign('js_arr', G::GetJS());
$tpl->Assign('__page_description', $GLOBALS['__page_description']);
$tpl->Assign('__page_title', $GLOBALS['__page_title']);
$tpl->Assign('__page_kw', $GLOBALS['__page_kw']);
$tpl->Assign('__page_h1', $GLOBALS['__page_h1']);
$tpl->Assign('__center', $GLOBALS['__center']);
$tpl->Assign('__nav', $GLOBALS['__nav']);
$tpl->Assign('__header', $GLOBALS['__header']);
$tpl->Assign('__breadcrumbs', $GLOBALS['__breadcrumbs']);
$tpl->Assign('__sidebar_l', $GLOBALS['__sidebar_l']);
$tpl->Assign('__sidebar_r', $GLOBALS['__sidebar_r']);
$tpl->Assign('__popular', $GLOBALS['__popular']);
$Cart = new Cart();
// Создание базового массива корзины
$Cart->RecalcCart();
// $Cart->SetTotalQty();
// $Cart->SetAllSums();
// $tpl->Assign('cart_string', $Cart->GetString());
if(in_array($GLOBALS['CurrentController'], $GLOBALS['NoTemplate'])){
	if($GLOBALS['MainTemplate'] == 'main.tpl'){
		$GLOBALS['MainTemplate'] = 'main_empty.tpl';
	}
}
$tpl->Assign('_test', _test);
echo $tpl->Parse($GLOBALS['PATH_tpl_global'].$GLOBALS['MainTemplate']);
// include svg icons library
$e_time = G::getmicrotime();
//if ($GLOBALS['CurrentController'] != 'feed')
echo "<!--".date("d.m.Y H:i:s", time())." ".$_SERVER['REMOTE_ADDR']." gentime = ".($e_time-$s_time)." -->";
// echo memory_get_peak_usage()/pow(1000, 2);
session_write_close();
?>