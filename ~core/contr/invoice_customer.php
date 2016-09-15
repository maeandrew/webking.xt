<?php
if((!isset($GLOBALS['Rewrite']) || !is_numeric($GLOBALS['Rewrite'])) && !isset($GLOBALS['REQAR'][2]) && !isset($_POST['orders'])){
	header('Location: '.Link::Custom('404'));
	exit();
}
if(isset($_POST['orders']) || isset($_GET['orders'])){
	if(isset($_GET['orders'])){
		$orders = $_GET['orders']; // Получаем id контрагента
		isset($_GET['filial'])? $filial = $_GET['filial']:null;
	}else{
		$orders = $_POST['orders']; //Сюда приходит список всех задействованых заказов
	}
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');
	foreach($orders as $id_order){
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		$ord = $Order->fields;
		$tpl->Assign("order", $ord);
		$Invoice = new Invoice();
		$User = new Users();
		$Address = new Address();
		// Получаем адреc доставки
		$addr = $Address->GetAddressById($ord['id_address']);
		// Получить данные покупателя
		$id_customer = $ord['id_customer'];
		$Customer = new Customers();
		$Customer->SetFieldsById($id_customer);
		// Получить данные контрагента
		$id_contragent = $ord['id_contragent'];
		$Contragent = new Contragents();
		if(isset($ord['id_remitter'])){
			$remitter = $Contragent->GetRemitterById($ord['id_remitter'], true);
			$tpl->Assign("remitter", $remitter);
		}
		$Contragent->SetFieldsById($id_contragent);
		$tpl->Assign("address", $addr);
		$tpl->Assign("Customer", $Customer->fields);
		$tpl->Assign("Contragent", $Contragent->fields);
		$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
		$tpl->Assign("id_order", $ord['id_order']);
		$Citys = new Citys();
		$city = $Citys->SetFieldsById($ord['id_city']);
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
		$arr = $Invoice->GetOrderData($id_order);
		$positions = array();
		$Sertificates = array();
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
				}
				if($v['opt_qty'] > 0){
					$positions[$v['article']][$i] = $v;
					$positions[$v['article']][$i]['mopt_qty'] = 0;
				}
				$i++;
			}
			ksort($positions);
			$tpl->Assign('suppliers', $suppliers);
			$tpl->Assign('Sertificates', $Sertificates);
			$tpl->Assign("arr", $positions);
		}
		echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer.tpl');
	}
	exit(0);
}else{
	$id_order = $GLOBALS['Rewrite'];
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');
	$Order = new Orders();
	$Order->SetFieldsById($id_order);
	if(!isset($_POST['orders'])){
		if($Order->fields['skey'] != $GLOBALS['REQAR'][2]){
			echo "Доступ запрещен.";
			exit();
		}
	}
	$ord = $Order->fields;
	$tpl->Assign("order", $ord);
	$Invoice = new Invoice();
	$User = new Users();
	$Address = new Address();
	// Получаем адреc доставки
	$addr = $Address->GetAddressById($ord['id_address']);
	// Получить данные покупателя
	$id_customer = $ord['id_customer'];
	$Customer = new Customers();
	$Customer->SetFieldsById($id_customer);
	// Получить данные контрагента
	$id_contragent = $ord['id_contragent'];
	$Contragent = new Contragents();
	if(isset($ord['id_remitter'])){
		$remitter = $Contragent->GetRemitterById($ord['id_remitter'], true);
		$tpl->Assign("remitter", $remitter);
	}
	$Contragent->SetFieldsById($id_contragent);
	$tpl->Assign("address", $addr);
	$tpl->Assign("Customer", $Customer->fields);
	$tpl->Assign("Contragent", $Contragent->fields);
	$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
	$tpl->Assign("id_order", $ord['id_order']);
	$Citys = new Citys();
	$city = $Citys->SetFieldsById($ord['id_city']);
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
	$arr = $Invoice->GetOrderData($id_order, isset($filial)?$filial:null);
	$Sertificates = array();
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
	echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer.tpl');
	exit(0);
}
?>
