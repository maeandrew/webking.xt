<?php
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '. _base_url.'/404/');
	exit();
}
if(!isset($GLOBALS['REQAR'][2]) && !is_numeric($GLOBALS['REQAR'][2])){
	header('Location: '. _base_url.'/404/');
	exit();
}
if(!isset($GLOBALS['REQAR'][3])){
	header('Location: '. _base_url.'/404/');
	exit();
}
$id_order = $GLOBALS['REQAR'][1];
$id_supplier = $GLOBALS['REQAR'][2];
unset($parsed_res);
require($GLOBALS['PATH_model'].'invoice_c.php');
$Order = new Orders();
$Order->SetFieldsById($id_order);
if($Order->fields['skey'] != $GLOBALS['REQAR'][3]){
	echo "Доступ запрещен.";
	exit();
}
$ord = $Order->fields;
$tpl->Assign("order", $ord);
$Invoice = new Invoice();
$User = new Users();
// Получить данные покупателя
$id_customer = $ord['id_customer'];
// Получить данные контрагента
$id_contragent = $ord['id_contragent'];
$tpl->Assign("date", date("d.m.Y", $ord['creation_date']));
$tpl->Assign("id_order", $ord['id_order']);
$arr = $Invoice->GetOrderData($id_order);
$tpl->Assign("arr", $arr);
$Order->GetSuppliers($id_order,$id_supplier);
$suppliers = $Order->list;
$parr = array();
foreach($suppliers as $k=>&$s){
	if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
	$Order->SetListBySupplier($s['id_supplier'], $id_order);
	$parr[$s['id_supplier']] =  $Order->list;
	$sum = 0;
	$sum_mopt = 0;
	$suppliers[$k]['sweight'] = 0;
	$suppliers[$k]['svolume'] = 0;
	foreach($Order->list as $product){
		if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier']){
			$sum = round(($sum + $product['opt_sum']),2);
			$suppliers[$k]['sweight'] += round($product['weight']*$product['opt_qty'],2);
			$suppliers[$k]['svolume'] += round($product['volume']*$product['opt_qty'],2);
		}
		if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier']){
			$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
			$suppliers[$k]['sweight'] += round($product['weight']*$product['mopt_qty'],2);
			$suppliers[$k]['svolume'] += round($product['volume']*$product['mopt_qty'],2);
		}
	}
	$suppliers[$k]['sum'] = $sum+$sum_mopt;
}
$tpl->Assign('suppliers', $suppliers);
$tpl->Assign('products', $parr);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_supplier.tpl');
exit(0);
?>
