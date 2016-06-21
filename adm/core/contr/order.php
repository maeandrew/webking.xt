<?php
if(!_acl::isAllow('order')){
	die("Access denied");
}
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_order = $GLOBALS['REQAR'][1];
}else{
	header('Location: /404/');
	exit();
}
$Order = new Orders();
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Заказы';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/orders/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Заказ';
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
if($Order->GetSuppliers($id_order)){
	$suppliers = $Order->list;
	$arr = array();
	foreach($suppliers as $k=>&$s){
		$Order->SetListBySupplier($s['id_supplier'], $id_order);
		$arr[$s['id_supplier']] = $Order->list;
	}
	$tpl->Assign('suppliers', $suppliers);
	$tpl->Assign('products', $arr);
	$Order->SetFieldsById($id_order);
	$ord = $Order->fields;
	$tpl->Assign("order", $ord);
	// $tpl->Assign("id_supplier", $id_supplier);
	foreach($arr as $tmp){
		if($tmp[0]['id_pretense_status'] != 0){
	 		$pretarr = $Order->GetPretenseAdditionalRows($id_order);
	 		$tpl->Assign("pretarr", $pretarr);
	 	}
	 	break;
	}
	$order_statuses = $Order->GetStatuses();
	$tpl->Assign('order_statuses', $order_statuses);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказ ".$arr[$s['id_supplier']][0]['id_order'];
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
}else{
	$suppliers = array(0 => array('id_supplier' => 0, 'name' => 'Прогноз'));
	$arr = array();
	$arr[0] = $Order->GetOrderForAdmin(array("o.id_order" => $id_order));
	$tpl->Assign('suppliers', $suppliers);
	$tpl->Assign('products', $arr);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказ $id_order";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_order.tpl');