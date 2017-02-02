<?php
	if (!_acl::isAllow('users'))
		die("Access denied");

	$Supplier = new Suppliers();

	// ---- center ----
	unset($parsed_res);
	if(isset($_GET['success']) && $_GET['success'] == TRUE){
		$msg = 'Поставщик удален';
	}
	$tpl->Assign('h1', 'Поставщики склада');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Поставщики склада";

	$warehouses = $Supplier->GetWarehouses();

	$tpl->Assign('warehouses', $warehouses);
	$tpl->Assign('msg', $msg);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_warehouse_supplier.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>