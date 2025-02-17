<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
//    $Cart = new Cart();
	$Customers = new Customers();
	$Regions = new Regions();
	$Cities = new Cities();
	$DeliveryService = new DeliveryService();
	$Delivery = new Delivery();
	$Orders = new Orders();
	$Address = new Address();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'step':
				$id_user = isset($_POST['id_user'])?$_POST['id_user']:$Users->fields['id_user'];
				$contragent = $Orders->GetContragentByLastOrder();
				$tpl->Assign('contragent', $contragent);
				$Customers->SetFieldsById($id_user);
				$customer = $Customers->fields;
				// Необходимо определить, какой тим диалога нужно вывести
				// Проверяем, есть ли у клиента сохраненный адрес доставки
				if($saved_addresses = $Address->GetListByUserId($id_user)){
					// Если клиент уже делал заказы
					$tpl->Assign('saved_addresses', $saved_addresses);
				}
				// Если клиент делает первый заказ
				// step 2+
				if($_POST['step'] > 1){
					// Получаем список всех областей
					$regions_list = $Address->GetRegionsList();
					$tpl->Assign('regions_list', $regions_list);
					$cities_count = count($Address->GetCitiesList());
					$tpl->Assign('cities_count', $cities_count);
					// Если у клиента уже сохранен его город
					if($customer['id_city'] > 0){
						// Получаем данные о городе
						$saved_city = $Address->GetCityById($customer['id_city']);
						$tpl->Assign('saved_city', $saved_city);
						// Получаем список городов по сохраненной области клиента
						$cities_list = $Address->GetCitiesList((int) $saved_city['id_region']);
						$tpl->Assign('cities_list', $cities_list);
					}
				}
				if($_POST['step'] > 2 && $_POST['step'] < 4){
					if(isset($saved_city)){
						$count = array(
							'warehouse' => 0,
							'courier' => 0
						);
						$data['city'] = $saved_city['title'];
						$saved_region = $Address->GetRegionById($saved_city['id_region']);
						$tpl->Assign('saved_region', $saved_region);
						$data['region'] = $saved_region['title'];
						//////////////////////////////////////////////////////////////////////
						// проверяем, есть ли в этом городе отделения транспортных компаний //
						//////////////////////////////////////////////////////////////////////
						$shiping_companies = $Address->GetShippingCompanies();
						foreach($shiping_companies as $company){
							if($company['courier'] == 1){
								$count['courier']++;
							}
							if($company['has_api'] == 1 && $company['api_key'] != ''){
								$city = $Address->UseAPI($company, 'getCity', $data);
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
				if(isset($_POST['id_user'])){
					$tpl->Assign('id_user', $_POST['id_user']);
				}
				if(isset($_POST['target_id_order'])){
					$tpl->Assign('target_id_order', $_POST['target_id_order']);
				}
				$tpl->Assign('step', $_POST['step']);
				$tpl->Assign('customer', $customer);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
				break;
			case 'complete_step':
				$echo = array('success' => false);
				if(isset($_POST['id_user'])){
					$echo['id_user'] = $_POST['id_user'];
				}
				if(isset($_POST['target_id_order'])){
					$echo['target_id_order'] = $_POST['target_id_order'];
				}
				switch($_POST['current_step']){
					case 1:
						if(isset($_POST['id_address'])){
							$echo['success'] = true;
							$echo['target_step'] = 4;
							if(isset($_POST['target_id_order'])){
								$id_order = $_POST['target_id_order'];
							}elseif(isset($_SESSION['member']['last_order'])){
								$id_order = $_SESSION['member']['last_order'];
							}
							if(isset($id_order)){
								$Orders->SetOrderAddress($id_order, $_POST['id_address']);
							}
						}else{
							if($Customers->UpdateCustomer($_POST)){
								$echo['success'] = true;
							}
						}
						break;
					case 2:
						$region = $Address->GetRegionByTitle($_POST['region']);
						$city = $Address->GetCityByTitle($_POST['city'], $region['id']);
						if(isset($_POST['id_user'])){
							$data['id_user'] = $_POST['id_user'];
						}
						$data['id_region'] = $city['id_region'];
						$data['id_city'] = $city['id'];
						if($Customers->UpdateCustomer($data)){
							$echo['success'] = true;
						}
						break;
					case 3:
						$data = $_POST;
						// Создаем клиенту адрес доставки
						$region = $Address->GetRegionByTitle($_POST['region']);
						$city = $Address->GetCityByTitle($_POST['city'], $region['id']);
						$delivery_company = $Address->GetShippingCompanyById($_POST['id_delivery_service']);
						$data['id_region'] = $city['id_region'];
						$data['id_city'] = $city['id'];
						$data['primary'] = 1;
						$data['title'] = $city['title'].', '.$delivery_company['title'].', '.($_POST['id_delivery']==1?$_POST['delivery_department']:$_POST['address']);
						if($id_address = $Address->AddAddress($data)){
							$echo['success'] = true;
						}
						if(isset($_POST['target_id_order'])){
							$id_order = $_POST['target_id_order'];
						}elseif(isset($_SESSION['member']['last_order'])){
							$id_order = $_SESSION['member']['last_order'];
						}
						if(isset($id_order)){
							$Orders->SetOrderAddress($id_order, $id_address);
						}
						break;
					default:
						$echo['msg'] = 'No one step was sent';
						break;
				}
				echo json_encode($echo);
				break;
		}
	}
	exit();
}
