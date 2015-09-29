<?php
	if (!_acl::isAllow('orders'))
		die("Access denied");

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_order = $GLOBALS['REQAR'][1];
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
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказ №$id_order возврат";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if ($Order->GetSuppliers($id_order)){
		$suppliers = $Order->list;
		
		$arr = array();
		
		foreach ($suppliers as $k=>&$s){
			if ($s['id_supplier'] == 0) $s['name'] = "Прогноз";
			$Order->SetListBySupplier($s['id_supplier'], $id_order);
			$arr[$s['id_supplier']] =  $Order->list;
		}
		
		$tpl->Assign('suppliers', $suppliers);
		$tpl->Assign('products', $arr);

		foreach ($arr as $tmp){
			if ($tmp[0]['id_pretense_status']!=0){
		 		$pretarr = $Order->GetPretenseAdditionalRows($id_order);
		 		$tpl->Assign("pretarr", $pretarr);
		 	}
		 	break;
		}
		
		$order_statuses = $Order->GetStatuses();
		$tpl->Assign('order_statuses', $order_statuses);
	}
	

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_order_return.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>