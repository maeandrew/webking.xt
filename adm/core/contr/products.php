<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
if(!_acl::isAllow('product')){
	die("Access denied");
}
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_category = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$products = new Products();
	if(isset($_POST['smb']) && isset($_POST['ord'])){
		$products->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}elseif(isset($_FILES["import_file"])){
		// Импорт
		if($_FILES["import_file"]["size"] > 1024*3*1024){
			 echo "Размер файла превышает три мегабайта";
			 exit();
		}
		// Проверяем загружен ли файл
		if(is_uploaded_file($_FILES["import_file"]["tmp_name"])){
			set_time_limit(3600);
			//list($total_added, $total_updated) = $products->ProcessProductsFile($_FILES["import_file"]["tmp_name"]);
			if (isset($_POST['smb_check'])) {
				$res = $products->CheckProductsFile($_FILES["import_file"]["tmp_name"]);
				if (is_array($res)) {
					list($total_added, $total_updated) = $res;
					$tpl->Assign('total_added', $total_added);
					$tpl->Assign('total_updated', $total_updated);
				}else{
					$tpl->Assign('res_check', $res);
				}

			}elseif(isset($_POST['smb_import'])){
				list($total_added, $total_updated) = $products->ProcessProductsFile($_FILES["import_file"]["tmp_name"]);
				$tpl->Assign('total_added', $total_added);
				$tpl->Assign('total_updated', $total_updated);
			}
			//die("Обработан.");
			//move_uploaded_file($_FILES["filename"]["tmp_name"], "/path/to/file/".$_FILES["filename"]["name"]);
		}else{
		   echo "Ошибка загрузки файла";
		}
	}
	if(isset($_POST['smb']) && isset($_POST['supl'])){
		$products->SetProductsList1($_POST['supl']);
		list($r,$cats_cols) = $products->GetExportRows($products->list);
	// Формирование заголовка
	$h = array('Артикул');
	for($ii=0;$ii<$cats_cols;$ii++){
		$h[] = "Категория $ii";
	}
	$h = array_merge($h, array(	'Название','Сертификат','Фото 1','Фото 2','Фото 3',
								'Макс кол-во поставщиков', 'Коэф опт', 'Коэф мелк опт', 'Описание', 'Страна', 'Кол-во в ящ',
								'Минимальное количество по мелкому опту', 'Кратность', 'Видимость', 'транслит', 'Вес', 'Объем', 'Обяз прим', 'Ед. измерения'));
	$products->GenExcelFile($h, $r, $cats_cols);

	exit(0);
}

$orderby = " sort ASC, ord ASC, name ASC";
$products->SetProductsList(array('cp.id_category'=>$id_category), null, array('order_by' => $orderby, 'administration' => '1'));

$arr = $dbtree->GetNodeFields($id_category, array('name', 'category_level'));
// --- --- --- subcats
$l = $arr['category_level']+1;
$tpl->Assign('subcats', $dbtree->GetSubCats($id_category, array('id_category', 'name', 'translit', 'art', 'category_level')));

// === === === subcats
$tpl->Assign('list', $products->list);
$tpl->Assign('catname', $arr['name']);
$tpl->Assign('id_category', $id_category);
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_products.tpl')
);
$res = $dbtree->Parents($id_category, array('id_category', 'name', 'category_level'));
$ii = count($GLOBALS['IERA_LINKS']);
foreach($res as $cat){
	if($cat['category_level'] > 0){
		$GLOBALS['IERA_LINKS'][$ii]['title'] = $cat['name'];
		$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/products/'.$cat['id_category'];
	}
}
if(in_array("export", $GLOBALS['REQAR'])){
	list($r,$cats_cols) = $products->GetExportRows($products->list);
	// Формирование заголовка
	$h = array('Артикул');
	for($ii=0;$ii<$cats_cols;$ii++){
		$h[] = "Категория $ii";
	}
	$h = array_merge($h, array(	'Название','Сертификат','Фото 1','Фото 2','Фото 3',
								'Макс кол-во поставщиков', 'Коэф опт', 'Коэф мелк опт', 'Описание', 'Страна', 'Кол-во в ящ',
								'Минимальное количество по мелкому опту', 'Кратность', 'Видимость', 'транслит', 'Вес', 'Объем', 'Обяз прим', 'Ед. измерения'));
	$products->GenExcelFile($h, $r, $cats_cols);
	exit(0);
}elseif(in_array("exportactive", $GLOBALS['REQAR'])){
	foreach($products->list AS $p){
		if($p['sort'] == 0){
			$prodlist[] = $p;
		}
	}
	list($r,$cats_cols) = $products->GetExportRows($prodlist);

	// Формирование заголовка
	$h = array('Артикул');
	for($ii=0;$ii<$cats_cols;$ii++){
		$h[] = "Категория $ii";
	}
	$h = array_merge($h, array(	'Название', 'Сертификат', 'Фото 1', 'Фото 2', 'Фото 3',
		'Макс кол-во поставщиков', 'Коэф опт', 'Коэф мелк опт', 'Описание', 'Страна',
		'Кол-во в ящ', 'Минимальное количество по мелкому опту', 'Кратность', 'Видимость',
		'транслит', 'Вес', 'Объем', 'Обяз прим', 'Ед. измерения'));
	$products->GenExcelFile($h, $r, $cats_cols);
	exit(0);
}elseif (in_array("export_sup_prices", $GLOBALS['REQAR'])){
	list($r, $suppliers_qty) = $products->GetExportSupPricesRows($products->list);
	$products->GenExcelSupPricesFile($r, $suppliers_qty);
	exit(0);
}else{
	if(isset($_SESSION['_POST_'])) unset($_SESSION['_POST_']);
	$_SESSION['_POST_'] = $_POST;
	if(TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
}
?>