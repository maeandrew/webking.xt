<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
//    $Cart = new Cart();
	$Customers = new Customers();
	$Regions = new Regions();
	$City = new Citys();
	$DeliveryService = new DeliveryService();
	$Delivery = new Delivery();
	$Orders = new Orders();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "step":
				// Необходимо определить, какой тим диалога нужно вывести
				// Если клиент делает первый заказ
				
				// Если клиент уже делал заказы
				//step#1
				$contragent = $Orders->GetContragentByLastOrder();
				$Customers->SetFieldsById($User->fields['id_user']);
				$customer = $Customers->fields;
				$cont_person = explode(' ', $_SESSION['member']['name']);
				$customer['first_name'] = isset($cont_person[0])?$cont_person[0]:'';
				$customer['middle_name'] = isset($cont_person[1])?$cont_person[1]:'';
				$customer['last_name'] = isset($cont_person[2])?$cont_person[2]:'';
				//step#2
				$Regions->SetList();
				$allregions = $Regions->list;
				if($customer['id_city'] > 0){
					$cities = $City->GetSavedFields($customer['id_city']);
					$savedcity = $cities;
				}else{
					$savedcity = false;
				}
				if(isset($savedcity)){
					$availablecities = $City->SetFieldsByInput($savedcity['region']);
					if(!$DeliveryService->SetFieldsByInput($savedcity['name'], $savedcity['region'])){
						unset($alldeliverymethods[3]);
					}
					$DeliveryService->SetListByRegion($savedcity['names_regions']);
					$availabledeliveryservices = $DeliveryService->list;
					$Delivery->SetFieldsByInput($savedcity['shipping_comp'], $savedcity['name'], $savedcity['region']);
					$availabledeliverydepartment = $Delivery->list;
				}
				$tpl->Assign('availabledeliveryservices', $availabledeliveryservices);
				$tpl->Assign('availabledeliverydepartment', $availabledeliverydepartment);
				$tpl->Assign('availablecities', $availablecities);
				$tpl->Assign('savedcity', $savedcity);
				$tpl->Assign('step', $_POST['step']);
				$tpl->Assign('contragent', $contragent);
				$tpl->Assign('customer', $customer);
				$tpl->Assign('allregions', $allregions);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
				break;
		}
	}
	exit();
}
