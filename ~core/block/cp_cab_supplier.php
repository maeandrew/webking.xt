<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/assortment/'
);
$Supplier = new Suppliers();
$Order = new Orders();
$Users = new Users();
$Unit = new Unit();
$Supplier->SetFieldsById($User->fields['id_user']);
$check_sum = $Supplier->GetCheckSumSupplierProducts($User->fields['id_user']);
$tpl->Assign("check_sum", $check_sum);
$tpl->Assign("supplier", $Supplier->fields);
$products = new Products();
//*********************************Заполнение рабочих дней
if(isset($GLOBALS['Rewrite'])){
	$cabinet_page = $GLOBALS['Rewrite'];
	$tpl->Assign('cabinet_page', $cabinet_page);
}else{
	header('Location: '._base_url.'/cabinet/assortment/');
}
if(isset($cabinet_page) && $cabinet_page == "productsonmoderation"){
	$header = "Товары на модерации";
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/productsonmoderation/'
	);
	$list = $products->GetProductsOnModeration($_SESSION['member']['id_user']);
	$tpl->Assign('list', $list);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'products_on_moderation.tpl')
	);
}elseif(isset($cabinet_page) && $cabinet_page == "promo_orders"){
	$header = "Заказы с промо-кодом";
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/promo_orders/'
	);
	$orders = $Order->GetOrdersByPromoSupplier($_SESSION['member']['id_user']);
	$tpl->Assign('orders', $orders);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'promo_orders.tpl')
	);
}elseif(isset($cabinet_page) && $cabinet_page == "promo_codes"){
	$header = "Промо-коды";
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/promo_codes/'
	);
	if(isset($_POST['submit'])){
		if($Supplier->AddPromoCode($_POST['percent'], $_POST['name'])){
			header('Location: /cabinet/promo_codes/');
		}
	}elseif(isset($_POST['delete'])){
		if($Supplier->DeletePromoCode($_POST['id'])){
			header('Location: /cabinet/promo_codes/');
		}
	}elseif(isset($_POST['edit'])){
		if($Supplier->EditPromoCode($_POST['id'], $_POST['percent'], $_POST['name'])){
			header('Location: /cabinet/promo_codes/');
		}
	}
	$tpl->Assign('promo', $Supplier->GetPromoCodes($_SESSION['member']['id_user']));
	$tpl->Assign('code', $Users->GetUsersByPromoSupplier($_SESSION['member']['id_user']));
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'promo_codes.tpl')
	);
}elseif(isset($cabinet_page) && $cabinet_page == "editproduct"){
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => 'Товары на модерации',
		'url' => _base_url.'/cabinet/productsonmoderation/'
	);
	$header = "Добавление товара";
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/editproduct/'
	);
	$tpl->Assign('units', $Unit->GetUnitsList());
	$Images = new Images();
	//Физическое удаление файлов
	if(isset($_POST['removed_images'])){
		foreach($_POST['removed_images'] as $k=>$path){
			if($products->CheckPhotosOnModeration($path)){
				$Images->remove($GLOBALS['PATH_root'].str_replace('/files/', 'files/', $path));
			}
		}
	}
	// elseif(isset($_GET['remove']) == true){
	// 	if($products->CheckPhotosOnModeration($_POST['image'])){
	// 		$Images->remove($GLOBALS['PATH_root']."files/".$_SESSION['member']['email']."/".$_POST['image']);
	// 	}
	// 	echo str_replace($GLOBALS['PATH_root'], '/', $GLOBALS['PATH_root']."files/".$_SESSION['member']['email']."/".$_POST['image']);
	// 	exit(0);
	// }


	if(isset($_GET['validate']) == true){
		$Images->validate($_FILES, $GLOBALS['PATH_root']."files/".$_SESSION['member']['email']."/");
		exit(0);
	}elseif(isset($_GET['upload']) == true){
		$res = $Images->upload($_FILES, $GLOBALS['PATH_root']."files/".$_SESSION['member']['email']."/");
		echo str_replace($GLOBALS['PATH_root'], '/', $res);
		exit(0);
	}elseif(isset($_POST['editionsubmit']) == true){
		//Расчет обьема продукта
		$_POST['volume'] = ($_POST['height'] * $_POST['width'] * $_POST['length']) * 0.000001;
		if($products->AddSupplierProduct($_POST)){
			header('Location: '._base_url.'/cabinet/productsonmoderation/');
		}
		exit(0);
	}
	if(isset($_GET['id']) == true && is_numeric($_GET['id']) && $_GET['type'] == 'moderation'){
		$list = $products->GetProductOnModeration($_GET['id']);
		foreach($list as $k=>$l){
			$_POST[$k] = $l;
		}
	}
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'supplier_cab_edit_product.tpl')
	);
}elseif(isset($cabinet_page) && $cabinet_page == "deletefrommoderation"){
	$products->DeleteProductFromModeration($_POST['id']);
}else{
	$header = "Ассортимент поставщика";
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/assortment/'
	);
	if(isset($_POST['SetMinSupplierPrices'])){
		$Supplier->RecalcWhSupplierSalePrice($Supplier->fields['id_user']);
	}
	if(isset($_POST['update_calendar1'])){
		if(isset($_POST['start_date']) && isset($_POST['num_days'])){
			$date = new DateTime($_POST['start_date']);
			for($i = 0; $i < $_POST['num_days']; $i++){
				$date->modify('+1 day');
				$Supplier->CheckSupplierDate($date->format('Y_m_d'));
			}
		}
		header('Location: '._base_url.'/cabinet/settings/');
	}
	//************************************************
	$supplier = $Supplier->fields;
	$supplier['usd_products'] = 0;
	if(isset($cabinet_page) && $cabinet_page == "price"){
		$arr = $Supplier->GetDataForAct();
		$tpl->Assign('products', $arr);
		foreach ($arr as $key => $i){
			if($i['inusd'] == 1){
				$supplier['usd_products']++;
			}
		}
		$tpl->Assign("Supplier", $supplier);
		echo $tpl->Parse($GLOBALS['PATH_root'].'adm/core/tpl/act_supplier.tpl');
		exit(0);
	}elseif(isset($cabinet_page) && $cabinet_page == "price1"){
		$arr = $Supplier->GetDataForAct();
		$tpl->Assign('products', $arr);
		foreach ($arr as $key => $i){
			if($i['inusd'] == 1){
				$supplier['usd_products']++;
			}
		}
		$tpl->Assign("Supplier", $supplier);
		if(isset($_POST['wide'])){
			echo $tpl->Parse($GLOBALS['PATH_root'].'adm/core/tpl/act_supplier_wide.tpl');
		}elseif(isset($_POST['multiple'])){
			echo $tpl->Parse($GLOBALS['PATH_root'].'adm/core/tpl/act_supplier_multiple.tpl');
		}else{
			echo $tpl->Parse($GLOBALS['PATH_root'].'adm/core/tpl/act_supplier_new.tpl');
		}
		exit(0);
	}
	if(isset($_FILES["import_file"])){
		// Импорт
		if($_FILES["import_file"]["size"] > 1024*3*1024){
			$tpl->Assign('msg', "Размер файла превышает три мегабайта");
			$tpl->Assign('errm', 1);
			exit;
		}
		// Проверяем загружен ли файл
		if(is_uploaded_file($_FILES["import_file"]["tmp_name"])){
			if(isset($_POST['smb_import_usd'])){
				list($total_added, $total_updated) = $products->ProcessAssortimentFileUSD($_FILES["import_file"]["tmp_name"]);
			}else{
				list($total_added, $total_updated) = $products->ProcessAssortimentFile($_FILES["import_file"]["tmp_name"]);
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
		$cnt = $products->GetProductsCntSupCab(array('a.id_supplier'=>$Supplier->fields['id_user'], 'p.visible'=>1));
		$tpl->Assign('cnt', $cnt);
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}
	$fields = array('name', 'plimit');
	$f_assoc = array('name'=>'p.name', 'plimit'=>'a.product_limit');
	$orderby = "a.inusd, p.name asc";
	$sort_links = array();
	$GET_limit = "";
	if(isset($_GET['limit'])){
		$GET_limit = "/limit".$_GET['limit'];
	}
	if(isset($cabinet_page) && $cabinet_page == "settings"){
		$header = "Настройки личного кабинета";
		$GLOBALS['IERA_LINKS'][max(array_keys($GLOBALS['IERA_LINKS']))] = array(
			'title' => $header,
			'url' => _base_url.'/cabinet/settings/'
		);
	}else{
		$products->SetProductsListSupCab(array('a.id_supplier' => $Supplier->fields['id_user'], 'p.visible' => 1), $limit, $orderby);
		$tpl->Assign('list', $products->list);
	}
	$products->FillAssort($_SESSION['member']['id_user']);
	if(!isset($_POST['smb'])){
		foreach($Supplier->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	$sup_cal = $Supplier->GetCalendar();
	$cal = array();
	$DaysOfWeek = array("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
	$date_block = time()+(3600*24*$GLOBALS['CONFIG']['order_day_end']); // дата, до которой дни не доступны для редактирования
	$days_qty = $GLOBALS['CONFIG']['order_day_end']+30; // количество отображаемых дней
	for($ii = 0; $ii < $days_qty; $ii++){
		$ts = time()+$ii*3600*24;
		$date = date("Y-m-d", $ts);
		list($cal[$date]['y'], $cal[$date]['m'], $cal[$date]['d']) = explode("-", $date);
		$cal[$date]['date_dot'] = $cal[$date]['d'].'.'.$cal[$date]['m'].'.'.$cal[$date]['y'];
		$cal[$date]['date_'] = $cal[$date]['d'].'_'.$cal[$date]['m'].'_'.$cal[$date]['y'];
		$arr = getdate($ts);
		if($ts>$date_block){
			$cal[$date]['active'] = 1;
		}else{
			$cal[$date]['active'] = 0;
		}
		$cal[$date]['day'] = 0;
		if(isset($sup_cal[$date])){
			$cal[$date]['day'] = $sup_cal[$date]['work_day'];
		}
		$cal[$date]['d_word'] = $DaysOfWeek[$arr['wday']];
		if($arr['wday'] == 0 || $arr['wday'] == 6){
			$cal[$date]['red'] = true;
		}
	}
	// если отправили комментарий
	if(isset($_POST['sub_com'])){
		$put = $_POST['id_product'];
		$text = nl2br($_POST['feedback_text'], false);
		$text = stripslashes($text);
		$author = $_SESSION['member']['id_user'];
		$author_name = $_SESSION['member']['name'];
		$authors_email = $_SESSION['member']['email'];
		$related33 = $products->GetComentProducts($text, $author, $author_name, $authors_email, $put);
		header('Location: '._base_url.'/cabinet/assortment/');
		exit();
	}
	$price_products = $products->GetPricelistProducts();
	$tpl->Assign('price_products', $price_products);
	$tpl->Assign('cal', $cal);
	$tpl->Assign('sidebar', $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_cab.tpl'));
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_cab.tpl')
	);
}
$tpl->Assign('header', $header);
if($GLOBALS['Rewrite'] == "export"){
	$r = $products->GetExportAssortRows($products->list, $Supplier->fields['id_user']);
	$products->GenExcelAssortFile($r);
	exit(0);
}elseif($GLOBALS['Rewrite'] == "export_usd"){
	$r = $products->GetExportAssortRowsUSD($products->list, $Supplier->fields['id_user']);
	$products->GenExcelAssortFile($r);
	exit(0);
}else{
	if(isset($_SESSION['_POST_'])) unset($_SESSION['_POST_']);
	$_SESSION['_POST_'] = $_POST;
}
?>