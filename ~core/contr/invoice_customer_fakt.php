<?php
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1]) && !isset($GLOBALS['REQAR'][2]) && !isset($_POST['orders'])){
	header('Location: '. _base_url.'/404/');
	exit();
}
isset($_GET['filial'])? $filial = $_GET['filial']:null;
$Suppliers = new Suppliers();
$Orders = new Orders();
$Invoice = new Invoice();
$Users = new Users();
$Address = new Address();
$Customers = new Customers();
$Contragents = new Contragents();
$Citys = new Citys();

if(isset($filial) == true){
	$tpl->Assign('filial', $Suppliers->GetFilialById($filial));
}
if(isset($_POST['orders']) || isset($_GET['orders'])){
	if(isset($_POST['orders'])){
		$orders = $_POST['orders'];
	}else{
		$orders = $_GET['orders'];
	}
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');
	foreach($orders as $id_order){
		$Orders->SetFieldsById($id_order);
		$ord = $Orders->fields;
		$tpl->Assign("order", $ord);
		// Получить данные покупателя
		$id_customer = $ord['id_customer'];
		$Customers->SetFieldsById($id_customer);
		// Получить данные контрагента
		$id_contragent = $ord['id_contragent'];

		if(isset($ord['id_remitter'])){
			$remitter = $Contragents->GetRemitterById($ord['id_remitter'], true);
			$tpl->Assign("remitter", $remitter);
		}
		$Contragents->SetFieldsById($id_contragent);
		$tpl->Assign("customer", $Customers->fields);
		$tpl->Assign("contragent", $Contragents->fields);
		$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
		$tpl->Assign("id_order", $ord['id_order']);

		$city = $Citys->SetFieldsById($ord['id_city']);
		if($ord['id_delivery'] == 1){ // самовывоз
			$addr_deliv = "Самовывоз<br>".$ord['descr'];
		}elseif($ord['id_delivery'] == 2){ // Передать автобусом
			$addr_deliv = "Передать автобусом - ".$city['names_regions']."<br>".$ord['descr'];
		}elseif($ord['id_delivery'] == 3){ // служба доставки
			$addr_deliv = "Служба доставки - ".$city['shipping_comp']."<br>".$city['names_regions']."<br>".$city['address'];
			if(isset($ord['descr'])){
				$addr_deliv.=$ord['descr'];
			}
		}
		$tpl->Assign("addr_deliv", $addr_deliv);
		$arr = $Invoice->GetOrderData_fakt($id_order);
		$positions = array();
		$Sertificates = array();
		if($Orders->GetSuppliers($id_order)){
			$suppliers = $Orders->list;
			$arr2 = array();
			foreach($suppliers as $k=>&$s){
				if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
				$Orders->SetListBySupplier($s['id_supplier'], $id_order);
				$sum = 0;
				$sum_mopt = 0;
				foreach($Orders->list as $product){
					if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])
						$sum = round(($sum + $product['opt_sum']),2);
					if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])
						$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
					if($product['sertificate']!='' && $ord['need_sertificate']!=0){
						$Sertificates[] = $product['sertificate'];
					}
				}
				$suppliers[$k]['sum'] = $sum+$sum_mopt;
			}
			$i = 0;
			foreach($arr as $v){
				if($v['mopt_qty'] > 0){
					$positions[$v['article_mopt']][$i] = $v;
					$positions[$v['article_mopt']][$i]['opt_qty'] = 0;
					$i++;
				}
				if($v['opt_qty'] > 0){
					$positions[$v['article']][$i] = $v;
					$positions[$v['article']][$i]['mopt_qty'] = 0;
					$i++;
				}
			}
			ksort($positions);
			$tpl->Assign('suppliers', $suppliers);
			$tpl->Assign('Sertificates', $Sertificates);
			$tpl->Assign("arr", $positions);
		}
		echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer_fakt.tpl');
	}
	exit(0);
}else{
	$id_order = $GLOBALS['REQAR'][1];
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');

	$Orders->SetFieldsById($id_order);
	if(!isset($_POST['orders'])){
		if($Orders->fields['skey'] != $GLOBALS['REQAR'][2]){
			echo "Доступ запрещен.";
			exit();
		}
	}
	$ord = $Orders->fields;
	$tpl->Assign("order", $ord);

	$address = $Address->GetAddressById($ord['id_address']);
	$tpl->Assign('address', $address);
	// Получить данные покупателя
	$id_customer = $ord['id_customer'];
	$Customers->SetFieldsById($id_customer);
	// Получить данные контрагента
	$id_contragent = $ord['id_contragent'];
	if(isset($ord['id_remitter'])){
		$remitter = $Contragents->GetRemitterById($ord['id_remitter'], true);
		$tpl->Assign("remitter", $remitter);
	}
	$Contragents->SetFieldsById($id_contragent);
	$tpl->Assign("customer", $Customers->fields);
	$tpl->Assign("contragent", $Contragents->fields);
	$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
	$tpl->Assign("id_order", $ord['id_order']);
	$city = $Citys->SetFieldsById($ord['id_city']);
	if($ord['id_delivery'] == 1){ // самовывоз
		$addr_deliv = "Самовывоз<br>".$ord['descr'];
	}elseif($ord['id_delivery'] == 2){ // Передать автобусом
		$addr_deliv = "Передать автобусом - ".$city['names_regions']."<br>".$ord['descr'];
	}elseif($ord['id_delivery'] == 3){ // служба доставки
		$addr_deliv = "Служба доставки - ".$city['shipping_comp']."<br>".$city['names_regions']."<br>".$city['address'];
		if(isset($ord['descr'])){
			$addr_deliv.=$ord['descr'];
		}
	}
	$tpl->Assign("addr_deliv", $addr_deliv);
	$arr = $Invoice->GetOrderData_fakt($id_order, isset($filial)?$filial:null);
	$Sertificates = array();
	if($Orders->GetSuppliers($id_order)){
		$suppliers = $Orders->list;
		$arr2 = array();
		foreach($suppliers as $k=>&$s){
			if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
			$Orders->SetListBySupplier($s['id_supplier'], $id_order);
			$sum = 0;
			$sum_mopt = 0;
			foreach($Orders->list as $product){
				if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])
					$sum = round(($sum + $product['opt_sum']),2);
				if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])
					$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
				if($product['sertificate']!='' && $ord['need_sertificate']!=0){
					$Sertificates[] = $product['sertificate'];
				}
			}
			$suppliers[$k]['sum'] = $sum+$sum_mopt;
		}
		$i = 0;
		if(empty($arr) === false){
			foreach($arr as &$v){
				if($v['mopt_qty'] > 0){
					$positions[$v['article_mopt']][$i] = $v;
					$positions[$v['article_mopt']][$i]['opt_qty'] = 0;
					$i++;
				}
				if($v['opt_qty'] > 0){
					$positions[$v['article']][$i] = $v;
					$positions[$v['article']][$i]['mopt_qty'] = 0;
					$i++;
				}
			}
			ksort($positions);
			$tpl->Assign("arr", $positions);
		}
		$tpl->Assign('suppliers', $suppliers);
		$tpl->Assign('Sertificates', $Sertificates);
	}
	echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer_fakt.tpl');
	exit(0);
}
?>