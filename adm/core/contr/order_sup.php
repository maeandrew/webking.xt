<?php
	if (!_acl::isAllow('orders'))
		die("Access denied");

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1]) &&
				isset($GLOBALS['REQAR'][2]) && is_numeric($GLOBALS['REQAR'][2])){
		$id_order = $GLOBALS['REQAR'][1];
		$id_supplier = $GLOBALS['REQAR'][2];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	
	$Order = new Orders();
	
	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказы по поставщикам";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/orders_sup/';
	
	$Order->SetFieldsById($id_order);
 	$ord = $Order->fields;
 	$tpl->Assign("order", $ord);
	$tpl->Assign("id_supplier", $id_supplier);
 	
	if ($Order->GetSupplier($id_supplier)){
		$s = $Order->list;
		
		if ($s['id_supplier'] == 0) $s['name'] = "Прогноз";
		$Order->SetListBySupplier($s['id_supplier'], $id_order);
		$arr[$s['id_supplier']] =  $Order->list;
		
		
		$tpl->Assign('s', $s);
		$tpl->Assign('products', $arr);
//print_r($arr[$s['id_supplier']]);die();

		
		$order_statuses = $Order->GetStatuses();
		$tpl->Assign('order_statuses', $order_statuses);
		
		$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказ ".$arr[$s['id_supplier']][0]['id_order'];
		$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	}else{
		$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказ";
		$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	}
	

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_order_sup.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>