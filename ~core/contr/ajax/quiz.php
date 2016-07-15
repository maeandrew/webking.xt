<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
//    $Cart = new Cart();
	$Customers = new Customers();
	$Regions = new Regions();
	$City = new Citys();
	$DeliveryService = new DeliveryService();
	$Delivery = new Delivery();
	$Orders = new Orders();
	$address = new Address();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "step":
				// Необходимо определить, какой тим диалога нужно вывести
				// Если клиент уже делал заказы
				
				// Если клиент делает первый заказ
				$contragent = $Orders->GetContragentByLastOrder();
				$Customers->SetFieldsById($User->fields['id_user']);
				$customer = $Customers->fields;
				$tpl->Assign('contragent', $contragent);
				// step 2+
				if($_POST['step'] > 1){
					$allregions = $address->GetRegionsList();
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
					$tpl->Assign('allregions', $allregions);
				}
				$tpl->Assign('step', $_POST['step']);
				$tpl->Assign('customer', $customer);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
				break;
			case 'complete_step':
				switch($_POST['current_step']){
					case 1:
						if($Customers->UpdateCustomer($_POST)){
							$echo = true;
						}
						break;
					default:
						$echo = 'No one step was sent';
						break;
				}
				echo json_encode($echo);
				break;
		}
	}
	exit();
}
