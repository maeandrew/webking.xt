<?php
$header = 'Информация о поставщике';
$tpl->Assign('h1', $header);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/assortment/'
);
if(!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '._base_url.'/adm/404/');
	exit();
}
$id_supplier = $GLOBALS['REQAR'][1];
$tpl->Assign('id_supplier', $id_supplier);
$order = 'p.id_product ASC';
if(isset($_GET['sort']) && $_GET['sort'] !='' && isset($_GET['order']) && $_GET['order'] !=''){
	$order = $_GET['sort'].' '.$_GET['order'];
}
$Products = new Products();
$Supplier = new Suppliers();

$arr = false;
if(isset($_GET['smb'])){
	// unset($_GET);
	if(isset($_GET['filter_date_from']) && $_GET['filter_date_from'] !== ''){
		$edited_time_from = $_GET['filter_date_from'];
		list($d,$m,$y) = explode(".", trim($edited_time_from));
		$edited_time_from = mktime(0, 0, 0, $m , $d, $y);
	}
	if(isset($_GET['filter_date_to']) && $_GET['filter_date_to'] !== ''){
		$edited_time_to = $_GET['filter_date_to'];
		// list($d,$m,$y) = explode(".", trim($edited_time_to));
		// $edited_time_to = mktime(0, 0, 0, $m , $d, $y);
	}
	$arr['edited_time'] = array($edited_time_from, $edited_time_to);

	if(isset($_GET['filter_active']) && $_GET['filter_active'] !== ''){
		$params = 'HAVING active = '.$_GET['filter_active'];
	}
	if(isset($_GET['filter_inusd']) && $_GET['filter_inusd'] !== ''){
		$arr['inusd'] = $_GET['filter_inusd'];
	}
	if(isset($_GET['filter_art']) && $_GET['filter_art'] !== ''){
		$arr['p.art'] = $_GET['filter_art'];
	}
}elseif(isset($_GET['clear_filters'])){
	unset($_GET);
	$url = explode('?',$_SERVER['REQUEST_URI']);
	header('Location: '.$url[0]);
	exit();
}
$arr['a.id_supplier'] = $id_supplier;
//Подключение/отключение поставщика
if(isset($_POST['suppliers_activity'])){
	$update_supplier['active'] = $_POST['supplier_active'];
	$update_supplier['id_user'] = $id_supplier;
	$Supplier->UpdateSupplier($update_supplier, true);
	// if($_POST['supplier_active'] == 'on'){
	// 	$Products->UpdateActivityProducttSupplier($update_supplier['id_user']);
	// }
}
$Supplier->SetFieldsById($id_supplier, 1);

//экспорт в exel
if(isset($_GET['export'])){
	ini_set('memory_limit', '1024M');
	$Products->SetProductsList1($id_supplier, $order, '', $arr);
	$Products->GenExcelAssortFile($Products->GetExportAssortRows($Products->list, $id_supplier), $Supplier->fields['article'].' '.date('d.m'));
	ini_set('memory_limit', '192M');
	exit(0);
}elseif(isset($_GET['export_usd'])){
	ini_set('memory_limit', '1024M');
	$Products->SetProductsList1($id_supplier, $order, '', $arr);
	$Products->GenExcelAssortFile($Products->GetExportAssortRowsUSD($Products->list, $id_supplier), $Supplier->fields['article'].' '.date('d.m').' usd');
	ini_set('memory_limit', '192M');
	exit(0);
}
// Импорт
if(isset($_FILES['import_file'])){
	// Проверяем загружен ли файл
	switch ($_FILES['import_file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }
	if(is_uploaded_file($_FILES['import_file']['tmp_name'])){
		// Проверяе объем файла
		if($_FILES['import_file']['size'] > 1024*3*1024){
			$tpl->Assign('msg', "Размер файла не должен превышать 3Мб");
			$tpl->Assign('errm', 1);
			exit;
		}
		list($total_added, $total_updated) = $Products->ProcessAssortimentFile($_FILES['import_file']['tmp_name'], isset($_POST['smb_import_usd']));
		$tpl->Assign('total_added', $total_added);
		$tpl->Assign('total_updated', $total_updated);
	}else{
		$tpl->Assign('msg', 'Файл не был загружен.');
		$tpl->Assign('errm', 1);
	}
}
/*Pagination*/
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = $Products->GetProductsCntSupCab($arr, $params);
	$tpl->Assign('cnt', $cnt);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}


// ---------Информация о поставщике
$Supplier->fields['active_products_cnt'] = $Products->GetProductsCntSupCab(
	array(
		'a.id_supplier' => $id_supplier,
		'a.active' => 1,
		'p.visible' => 1
	),
	' AND a.product_limit > 0 AND (a.price_mopt_otpusk > 0 OR a.price_opt_otpusk > 0)'
);
$Supplier->fields['all_products_cnt'] = $Products->GetProductsCntSupCab($arr);
$Supplier->fields['moderation_products_cnt'] = count($Products->GetProductsOnModeration($id_supplier));
$check_sum = $Supplier->GetCheckSumSupplierProducts($id_supplier);
$tpl->Assign('check_sum', $check_sum);

$tpl->Assign('supplier', $Supplier->fields);
$Products->SetProductsList1($id_supplier, $order, $limit, $arr, $params);
$products = $Products->list;
if($products){
	foreach($products as &$p){
		$p['images'] = $Products->GetPhotoById($p['id_product']);
	}
}

$tpl->Assign('list', $products);
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_assortment.tpl')
);
if($parsed_res['issuccess'] === true){
	$tpl_center .= $parsed_res['html'];
}
