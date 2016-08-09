<?php
$header = 'Ассортимент поставщика';
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
//Подключение/отключение поставщика
if(isset($_POST['suppliers_activity'])){
	$update_supplier['active'] = $_POST['supplier_activ'];
	$update_supplier['id_user'] = $id_supplier;
	$Supplier->UpdateSupplier($update_supplier, true);
	if($_POST['supplier_activ'] == 'on'){
		$Products->UpdateActivityProducttSupplier($update_supplier['id_user']);
	}

}
$Supplier->SetFieldsById($id_supplier, 1);

//экспорт в exel
if(isset($_GET['export'])){
	$Products->SetProductsList1($id_supplier, $order, '');
	$Products->GenExcelAssortFile($Products->GetExportAssortRows($Products->list, $Supplier->fields['id_user']));
	exit(0);
}elseif(isset($_GET['export_usd'])){
	$Products->SetProductsList1($id_supplier, $order, '');
	$Products->GenExcelAssortFile($Products->GetExportAssortRowsUSD($Products->list, $Supplier->fields['id_user']));
	exit(0);
}
// Импорт
if(isset($_FILES['import_file'])){
	// Проверяем загружен ли файл
	if(is_uploaded_file($_FILES['import_file']['tmp_name'])){
		// Проверяе объем файла
		if($_FILES['import_file']['size'] > 1024*3*1024){
			$tpl->Assign('msg', "Размер файла превышает три мегабайта");
			$tpl->Assign('errm', 1);
			exit;
		}
		if(isset($_POST['smb_import_usd'])){
			list($total_added, $total_updated) = $Products->ProcessAssortimentFileUSD($_FILES['import_file']['tmp_name']);
		}else{
			list($total_added, $total_updated) = $Products->ProcessAssortimentFile($_FILES['import_file']['tmp_name']);
		}
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
	$cnt = $Products->GetProductsCntSupCab(array('a.id_supplier'=>$Supplier->fields['id_user']));
	$tpl->Assign('cnt', $cnt);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}


// ---------Информация о поставщике
$Supplier->fields['active_products_cnt'] = $Products->GetProductsCntSupCab(
	array('a.id_supplier' => $Supplier->fields['id_user'], 'a.active' => 1, 'p.visible' => 1),
	' AND a.product_limit > 0 AND (a.price_mopt_otpusk > 0 OR a.price_opt_otpusk > 0)'
);
$Supplier->fields['all_products_cnt'] = $Products->GetProductsCntSupCab(array('a.id_supplier'=>$Supplier->fields['id_user'], 'p.visible' => 1));
$Supplier->fields['moderation_products_cnt'] = count($Products->GetProductsOnModeration($Supplier->fields['id_user']));
$check_sum = $Supplier->GetCheckSumSupplierProducts($User->fields['id_user']);
$tpl->Assign("check_sum", $check_sum);

$tpl->Assign('supplier', $Supplier->fields);
$Products->SetProductsList1($id_supplier, $order, $limit);
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
