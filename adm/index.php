<?php
define('EXECUTE', 1);
define('CMD', false);
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
	$Products = new Products();
	echo "<!-- ".$Products->CheckArticle($_GET['check_art'])."-->";
}
if(isset($_GET['img'])){
	$img = new Images();
	$img->resize(false, false, strtotime($_GET['img']));
}
if(isset($_GET['clear_thumbs'])){
	$img = new Images();
	$img->clearThumbs();
}


// if($_SESSION['member']['id_user'] == 8569){
// 	// $sql = "SELECT * FROM "._DB_PREFIX_."image";
// 	// $result = $db->GetArray($sql);
// 	// $xc = 0;
// 	// foreach($result as $image){
// 	// 	print_r('<pre>');
// 	// 	if(!file_exists($GLOBALS['PATH_global_root'].$image['src'])){
// 	// 		$xc++;
// 	// 		var_dump(file_exists($GLOBALS['PATH_global_root'].$image['src']));
// 	// 		$sql = "DELETE FROM "._DB_PREFIX_."image WHERE id = ".$image['id'];
// 	// 		$db->Execute($sql);
// 	// 	}
// 	// 	print_r('</pre>');
// 	// }
// 	// print_r('<pre>');
// 	// print_r($xc);
// 	// print_r('</pre>');




// 	ini_set('memory_limit', '2048M');
// 	ini_set('max_execution_time', 3000);
// 	$images = glob($GLOBALS['PATH_product_img'].'original/2016/11/2*/*.jpg');

// 	// print_r($images);die();

// 	foreach($images as $image) {
// 		// rename($image, str_replace('.JPG', '.jpg', $image));
// 		// rename($image, $image.'jpg');
// 		$check = $db->GetOneRowArray('SELECT * FROM xt_image WHERE src = \''.str_replace($GLOBALS['PATH_global_root'], '/', $image).'\'');
// 		if(!$check){
// 			// unlink($image);
// 			// print_r('SELECT * FROM xt_image WHERE src = \''.str_replace($GLOBALS['PATH_global_root'], '/', $image).'\'');die();
// 			$pattern = '/^.+\/original\/\d{4}\/\d{2}\/\d{2}\/(\d+).+$/';
// 			preg_match($pattern, $image, $matches);
// 			// $sql = "SELECT * FROM xt_image WHERE src LIKE '%/".$matches[1]."%'";
// 			// var_dump($sql);die();
// 			// $db->Execute($sql);
// 			$sql = "SELECT id_product FROM xt_product WHERE art = ".$matches[1];
// 			$res = $db->GetOneRowArray($sql);
// 			if($res['id_product']){
// 				$list[] = array(
// 					'id_product' => $res['id_product'],
// 					'art' => $matches[1]
// 				);
// 				// break;
// 			}
// 			// var_dump($res['id_product']);die();
// 			// if($res['id_product']){
// 			// 	// $img_array[$res['id_product']]['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $image);
// 			// 	// $img_array[$res['id_product']]['visible'][] = 1;
// 			// }
// 			// die();
// 			// print_r('<img width="50px" src="'.G::GetImageUrl(str_replace($GLOBALS['PATH_global_root'], '/', $image)).'" alt="'.str_replace($GLOBALS['PATH_global_root'], '/', $image).'">');
// 		}
// 	}

// 	// var_dump($img_array);die();

// 	// if(!empty($img_array)){
// 	// 	foreach ($img_array as $key => $value) {
// 	// 		$Products->UpdatePhoto($key, $value['images'], $value['visible']);
// 	// 	}
// 	// }
// 	// die();
// 	print_r($list);

// 	// $list = $Products->GetProductsWithoutImages();
// 	foreach($list as $product){
// 		$images = array_merge(
// 			glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$product['art'].'.jpg'),
// 			glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$product['art'].'-*.jpg')
// 		);
// 		// var_dump($images);die();
// 		if(!empty($images)){
// 			foreach ($images as &$image) {
// 				$image = str_replace($GLOBALS['PATH_global_root'], '/', $image);
// 				$images_visible[] = 1;
// 			}
// 			$Products->UpdatePhoto($product['id_product'], $images, $images_visible);
// 		}
// 	}
// 	die();
// }
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