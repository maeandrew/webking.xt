<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
if(!_acl::isAllow('photo_products')){
	die("Access denied");
}
$Products = new Products();
$suppliers = new Suppliers();
$header = 'Товары фотографа';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/photo_products/';
$tpl->Assign('header', $header);
if(isset($_POST['change_user'])){
	header('Location: /adm/photo_products/'.$_POST['user']);
}
if($_SESSION['member']['gid'] == _ACL_PHOTOGRAPHER_){
	$id_photographer = $_SESSION['member']['id_user'];
}elseif(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_photographer = $GLOBALS['REQAR'][1];
}
$Users->UsersList(1, array('gid' => _ACL_PHOTOGRAPHER_));
$tpl->Assign('users_list', $Users->list);
$suppliers->SuppliersList();
$tpl->Assign('suppliers_list', $suppliers->list);
if(isset($id_photographer)){
	$categories = $Products->generateCategory();
	$tpl->Assign('categories', $categories);
	$tpl->Assign('id_photographer', $id_photographer);
	// pagination
	if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
		$GLOBALS['Limit_db'] = $_GET['limit'];
	}
	if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
		if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
			$_GET['page_id'] = $_POST['page_nbr'];
		}
		$GLOBALS['Limit_db'] = 30;
		$cnt = count($Products->GetBatchesFhoto($id_photographer));
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}
	// --
	$batch = $Products->GetBatchesFhoto($id_photographer, $limit);
	$tpl->Assign('batch', $batch);
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_photo_products.tpl');
