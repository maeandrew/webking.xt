<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/'
);
$no_tpl = '';
$suppliers = new Suppliers();
$suppliers->RecalcWhSupplierSalePrice();
if(isset($_GET['toggle_supplier'])){
	$active = '';
	if($_GET['toggle_supplier'] == 0){
		$active = 'on';
	}
	$arr = array(
		"id_user" => $_GET['id'],
		"active" => $active
	);
	if(!$User->UpdateUser($arr)){
		$this->db->errno = $User->db->errno;
		$this->db->FailTrans();
		return false;
	}
	if($suppliers->SwitchEnableDisableProductsInAssort($_GET['id'], $_GET['toggle_supplier'])){
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
}
$sort_list = array("article", "name", "real_email", "next_update_date", "real_phone", "inusd desc, currency_rate asc", "active");
isset($_POST['sort'])?$tpl->Assign('sort', $_POST['sort']):null;
$arr = false;
if(isset($_POST['smb'])){
	if($_POST['filter_article'] !== ''){
		$arr['article'] = '*'.mysql_real_escape_string($_POST['filter_article']).'*';
	}
	if($_POST['filter_name'] !== ''){
		$arr['name'] = '*'.mysql_real_escape_string($_POST['filter_name']).'*';
	}
	if($_POST['filter_email'] !== ''){
		$arr['email'] = '*'.mysql_real_escape_string($_POST['filter_email']).'*';
	}
}

//Запись в куки отсортированных полей в кабинете поставщиков
if(isset($_POST['sort']) && (!isset($_COOKIE['sort_sm']) || $_POST['sort'] != $_COOKIE['sort_sm'])){
	setcookie('sort_sm', $_POST['sort'], 0, "/cabinet");
}elseif(!isset($_POST['sort']) && isset($_COOKIE['sort_sm'])){
	$_POST['sort'] = $_COOKIE['sort_sm'];
}

$supplier_list = $suppliers->GetSuppliersForManager(isset($_POST['sort']) && $_POST['sort'] != ''?substr(trim(str_replace(';', ',', $_POST['sort'])), 0, -1):null, $arr);

$tpl->Assign('supplier_list', $supplier_list);
if(!$no_tpl){
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_manager_cab.tpl')
	);
}?>