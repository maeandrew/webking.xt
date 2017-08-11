<?php



	if (!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){

		header('Location: '. _base_url.'/404/');

    	exit();

	}



	if (!isset($GLOBALS['REQAR'][2])){

		header('Location: '. _base_url.'/404/');

    	exit();

	}



	$id_order = $GLOBALS['REQAR'][1];





	// ---- center ----

	unset($parsed_res);



 	require($GLOBALS['PATH_model'].'invoice_c.php');



 	$Order = new Orders();

 	$Order->SetFieldsById($id_order);



 	if ($Order->fields['skey'] != $GLOBALS['REQAR'][2]){

 		//header('Location: '.$GLOBALS['URL_base'].'404/');

 		echo "Доступ запрещен.";

    	exit();

 	}



 	$ord = $Order->fields;

 	$tpl->Assign("order", $ord);

 	//print_r($ord);

 	$Invoice = new Invoice();



	//print_r($arr);




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

	//print_r($Contragent);

	$tpl->Assign("date", date("d.m.Y",$ord['target_date']));

	$tpl->Assign("id_order", $ord['id_order']);







	$tpl->Assign("addr_deliv", $addr_deliv);



	$arr = $Invoice->GetOrderData_prise($id_order);

	//$tpl->Assign("arr", $arr);

	//print_r($arr);





	if ($Order->GetSuppliers($id_order)){

		$suppliers = $Order->list;

		$arr2 = array();

		foreach ($suppliers as $k=>&$s){

			if ($s['id_supplier'] == 0) $s['name'] = "Прогноз";

			$Order->SetListBySupplier($s['id_supplier'], $id_order);

			//echo $s['id_supplier'];print_r($Order->list);

			$sum = 0;

			$sum_mopt = 0;

			foreach($Order->list as $product){

				if ($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])

					$sum = round(($sum + $product['opt_sum']),2);

				if ($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])

					$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);

				if ($product['sertificate']!='' && $ord['need_sertificate']!=0){



				}

			}

			$suppliers[$k]['sum'] = $sum+$sum_mopt;



			foreach ($arr as $i){

				if ($i['article']==$s['article'] || $i['article_mopt']==$s['article'] ){

					$arr2[] = $i;

				}

			}

		}



		$tpl->Assign('suppliers', $suppliers);

		$tpl->Assign('Sertificates', $Sertificates);

		$tpl->Assign("arr", $arr2);

	}

	//print_r($suppliers);

	echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_customer_no_foto.tpl');



	exit(0);



?>

