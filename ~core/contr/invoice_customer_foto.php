<?php
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '. _base_url.'/404/');
	exit();
}
if(!isset($GLOBALS['REQAR'][2])){
	header('Location: '. _base_url.'/404/');
	exit();
}
$id_order = $GLOBALS['REQAR'][1];
// ---- center ----
unset($parsed_res);

$Order = new Orders();
$Order->SetFieldsById($id_order);
if($Order->fields['skey'] != $GLOBALS['REQAR'][2]){
	echo "Доступ запрещен.";
	exit();
}
$ord = $Order->fields;
$tpl->Assign("order", $ord);
$Invoice = new Invoice();
// Получить данные покупателя
$id_customer = $ord['id_customer'];
$Customer = new Customers();
$Customer->SetFieldsById($id_customer);
// Получить данные контрагента
$id_contragent = $ord['id_contragent'];
$Contragent = new Contragents();
$Contragent->SetFieldsById($id_contragent);
$tpl->Assign("Customer", $Customer->fields);
$tpl->Assign("Contragent", $Contragent->fields);
$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
$tpl->Assign("id_order", $ord['id_order']);
$Cities = new Cities();
$city = $Cities->SetFieldsById($ord['id_city']);
if($ord['id_delivery'] == 1){ // самовывоз
	$addr_deliv = "Самовывоз<br>".$ord['descr'];
}elseif($ord['id_delivery'] == 2){ // Передать автобусом
	$addr_deliv = "Передать автобусом - ".$city['names_regions']."<br>".$ord['descr'];
}elseif($ord['id_delivery'] == 3){ // служба доставки
	$addr_deliv = "Служба доставки - ".$city['shipping_comp']."<br>".$city['names_regions']."<br>".$city['address'];
	if(isset($ord['descr'])){
		$addr_deliv.="<br>".$ord['descr'];
	}
}
$tpl->Assign("addr_deliv", $addr_deliv);
$arr = $Invoice->GetOrderData_prise($id_order);
if($Order->GetSuppliers($id_order)){
	$suppliers = $Order->list;
	$arr2 = array();
	foreach($suppliers as $k=>&$s){
		if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
		$Order->SetListBySupplier($s['id_supplier'], $id_order);
		$sum = 0;
		$sum_mopt = 0;
		foreach($Order->list as $product){
			if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])
				$sum = round(($sum + $product['opt_sum']),2);
			if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])
				$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
			if($product['sertificate']!='' && $ord['need_sertificate']!=0){
			}
		}
		$suppliers[$k]['sum'] = $sum+$sum_mopt;
		foreach($arr as $i){
			if($i['article']==$s['article'] || $i['article_mopt']==$s['article'] ){
				$arr2[] = $i;
			}
		}
	}
	$tpl->Assign('suppliers', $suppliers);
	$tpl->Assign('Sertificates', $Sertificates);
	$tpl->Assign("arr", $arr2);
}
echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer_foto.tpl');
exit(0);
