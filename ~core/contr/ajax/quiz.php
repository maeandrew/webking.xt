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
					// Получаем список всех областей
					$regions_list = $address->GetRegionsList();
					$tpl->Assign('regions_list', $regions_list);
					$cities_count = count($address->GetCitiesList());
					$tpl->Assign('cities_count', $cities_count);
					// Если у клиента уже сохранен его город
					if($customer['id_city'] > 0){
						// Получаем данные о городе
						$saved_city = $address->GetCityById($customer['id_city']);
						$tpl->Assign('saved_city', $saved_city);
						// Получаем список городов по сохраненной области клиента
						$cities_list = $address->GetCitiesList((int) $saved_city['id_region']);
						$tpl->Assign('cities_list', $cities_list);
					}
				}
				if($_POST['step'] > 2){
					if(isset($saved_city)){
						$count = array(
							'warehouse' => 0,
							'courier' => 0
						);
						$data['city'] = $saved_city['title'];
						$saved_region = $address->GetRegionById($saved_city['id_region']);
						$tpl->Assign('saved_region', $saved_region);
						$data['region'] = $saved_region['title'];
						//////////////////////////////////////////////////////////////////////
						// проверяем, есть ли в этом городе отделения транспортных компаний //
						//////////////////////////////////////////////////////////////////////
						$shiping_companies = $address->GetShippingCompanies();
						foreach($shiping_companies as $company){
							if($company['courier'] == 1){
								$count['courier']++;
							}
							if($company['has_api'] == 1 && $company['api_key'] != ''){
								$city = $address->UseAPI($company, 'getCity', $data);
								$count['warehouse'] += !empty($city)?1:0;
							}
						}
						$tpl->Assign('count', $count);
						// if(!$DeliveryService->SetFieldsByInput($saved_city['title'], $saved_city['id_region'])){
						// 	unset($alldeliverymethods[3]);
						// }
						// $DeliveryService->SetListByRegion($saved_city['names_regions']);
						// $availabledeliveryservices = $DeliveryService->list;
						// $Delivery->SetFieldsByInput($saved_city['shipping_comp'], $saved_city['name'], $saved_city['region']);
						// $availabledeliverydepartment = $Delivery->list;
						// $tpl->Assign('availabledeliveryservices', $availabledeliveryservices);
						// $tpl->Assign('availabledeliverydepartment', $availabledeliverydepartment);
					}
				}
				$tpl->Assign('step', $_POST['step']);
				$tpl->Assign('customer', $customer);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
				break;
			case 'complete_step':
				$echo = false;
				switch($_POST['current_step']){
					case 1:
						if($Customers->UpdateCustomer($_POST)){
							$echo = true;
						}
						break;
					case 2:
						$region = $address->GetRegionByTitle($_POST['selected_region']);
						$city = $address->GetCityByTitle($_POST['selected_city'], $region['id']);
						$data['id_region'] = $city['id_region'];
						$data['id_city'] = $city['id'];
						if($Customers->UpdateCustomer($data)){
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
