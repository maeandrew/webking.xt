<?php

	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/personal/'
	);
	// Подключаем необходимые классы
	$Customers = new Customers();
	$cities = new Citys();
	$contragents = new Contragents();
	$delivery = new Delivery();
	$deliveryservice = new DeliveryService();
	$regions = new Regions();
	// Все классы подключены


	/* selecting clear data */

	// about customer
	$Customers->SetFieldsById($User->fields['id_user']);  //print_r($Customer); die();
	$Customer = $Customers->fields;
	$cont_person = explode(' ', $Customer['cont_person']);
	$Customer['last_name'] = $cont_person[2];
	$Customer['first_name'] = isset($cont_person[0])?$cont_person[0]:'';
	$Customer['middle_name'] = isset($cont_person[1])?$cont_person[1]:'';
	// print_r($Customer);
	// outside managers
	$contragents->SetList(false, false);
	$availablemanagers = $contragents->list;
	// regions
	$regions->SetList();
	$allregions = $regions->list;
	// delivery methods
	$delivery->SetDeliveryList();
	$alldeliverymethods = $delivery->list;

	/* selecting saved data */

	// city
	if($Customer['id_city'] > 0){
		$cities->GetSavedFields($Customer['id_city']);
		$savedcity = $cities->fields;
	}else{
		$savedcity = false;
	}
	// delivery method
	if($Customer['id_delivery'] > 0){
		$delivery->GetSavedFields($Customer['id_delivery']);
		$saveddeliverymethod = $delivery->fields;
	}else{
		$saveddeliverymethod = false;
	}
	// manager
	if($Customer['id_contragent'] > 0){
		$contragents->GetSavedFields($Customer['id_contragent']);
		$savedmanager = $contragents->fields;
	}else{
		$savedmanager = false;
	}
	// temp manager
	$tempmanager = false;
	$_POST['tempmanager'] = 1;
	if($availablemanagers){
		foreach($availablemanagers as $am){
			if(!$savedmanager || $savedmanager['id_user'] == $am['id_user']){
				$_POST['tempmanager'] = 0;
			}
		}
		if($_POST['tempmanager'] == 1){
			$tempmanager = $availablemanagers[array_rand($availablemanagers)];
		}
	}
	// Select array of available cities if customer's region was saved.
	if(isset($savedcity)){
		$availablecities = $cities->SetFieldsByInput($savedcity['region']);
		if(!$deliveryservice->SetFieldsByInput($savedcity['names_regions'])){
			unset($alldeliverymethods[3]);
		}
		$deliveryservice->SetListByRegion($savedcity['names_regions']);
		$availabledeliveryservices = $deliveryservice->list;
		$delivery->SetFieldsByInput($savedcity['shipping_comp'], $savedcity['names_regions']);
		$availabledeliverydepartment = $delivery->list;
	}
	/* output data */
	$tpl->Assign('Customer', $Customer);
	$tpl->Assign('allregions', $allregions);
	$tpl->Assign('alldeliverymethods', $alldeliverymethods);
	$tpl->Assign('availablecities', $availablecities);
	$tpl->Assign('availabledeliveryservices', $availabledeliveryservices);
	$tpl->Assign('availabledeliverydepartment', $availabledeliverydepartment);
	$tpl->Assign('availablemanagers', $availablemanagers);
	$tpl->Assign('savedcity', $savedcity);
	$tpl->Assign('saveddeliverymethod', $saveddeliverymethod);
	$tpl->Assign('savedmanager', $savedmanager);
	$tpl->Assign('tempmanager', $tempmanager);


	$success = false;
	// $cities->GetSavedFields($Customers->fields['id_city']);
	// $contragents->GetSavedFields($Customers->fields['id_contragent']);
	// $delivery->SetDeliveryList();
	// $delivery->GetSavedFields($Customers->fields['id_delivery']);
	// if($regions->SetList()){
	// 	$tpl->Assign('regions', $regions->list);
	// }
	// if($cities->SetList()){
	// 	$tpl->Assign('citys', $cities->list);
	// }
	// $tpl->Assign('manager', $contragents->GetContragentList());
	// if(isset($cities->fields)){
	// 	if($deliveryservice->SetListByregions($cities->fields['names_regions']))
	// 		$tpl->Assign('delivery_services', $deliveryservice->list);
	// 	if($delivery->SetFieldsByInput($cities->fields['shipping_comp'], $cities->fields['names_regions']))
	// 		$tpl->Assign('delivery', $delivery->list);
	// }else{
	// 	if($deliveryservice->SetList())
	// 		$tpl->Assign('delivery_services', $deliveryservice->list);
	// 	if($delivery->SetList())
	// 		$tpl->Assign('delivery', $delivery->list);
	// }
	$User->SetUser($_SESSION['member']);
	$tpl->Assign('User', $User->fields);
	// $tpl->Assign('customers', $Customers->fields);
	// $tpl->Assign('SavedCity', $cities->fields);
	// $tpl->Assign('SavedContragent', $contragents->fields);
	// $tpl->Assign('DeliveryMethod', $delivery->list);
	// $tpl->Assign('SavedDeliveryMethod', $delivery->fields);
	if(isset($_POST['save_contacts'])){//print_r($_POST); die();
		if(!$_POST['cont_person']){
			$_POST['cont_person'] = trim($_POST['last_name']).' '.trim($_POST['first_name']).' '.trim($_POST['middle_name']);
		}
		if($Customers->updateCustomer($_POST) &&
		$Customers->updateContPerson($_POST['cont_person']) &&
		$Customers->updatePhones($_POST['phones'])){
			header("Location: " .Link::Custom('cabinet', 'personal')."?t=".$_GET['t']."&success");
		}else{
			header("Location: " .Link::Custom('cabinet', 'personal')."?t=".$_GET['t']."&unsuccess");
		}
	}elseif(isset($_POST['save_delivery'])){
		if($Customers->updateCity($_POST['id_delivery_department']) && $Customers->updateDelivery($_POST['id_delivery'])){
			header("Location: /cabinet/personal/?t=delivery&success");
		}else{
			header("Location: /cabinet/personal/?t=delivery&unsuccess");
		}
	}
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_personal.tpl'));
?>
