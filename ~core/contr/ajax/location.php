<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Cart = new Cart();
	$Region = new Regions();
	$City = new Citys();
	$DeliveryService = new DeliveryService();
	$Delivery = new Delivery();
	$Orders = new Orders();
	$Address = new Address();
	/*$Orders->Add($_POST['user_number']);*/
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "GetRegionsList":
				$Region->SetList();
				foreach($Region->list as $region){
					if($region['region'] != ''){?>
						<li class="mdl-menu__item" data-value="<?=$region['id_city']?>"><?=$region['region']?></li>
					<?}
				}
				break;
			case "GetCitiesList":
				$res = $City->SetFieldsByInput($_POST['input']);
				foreach($res as $city){
					if($city['name'] != ''){?>
						<li class="mdl-menu__item" data-value="<?=$city['id_city']?>"><?=$city['name']?></li>
					<?}
				}
				break;
			case "GetDeliveryServicesList":
				$DeliveryService->SetListByRegion($_POST['input']);
				foreach($DeliveryService->list as $key=>$ds){
					if($ds['shipping_comp'] != ''){
					}?>
					<div>
						<label class="mdl-radio mdl-js-radio">
							<input type="radio" name="service" class="mdl-radio__button" <?=isset($_POST['service']) && $_POST['service'] == $ds['shipping_comp']?'checked':null?> value="<?=$ds['shipping_comp']?>">
							<span class="mdl-radio__label">&quot;<?=$ds['shipping_comp']?>&quot;</span>
						</label>
					</div>
				<?}
				break;
			case "GetAddressListDepartmentByCity":
				if(isset($_POST['delivery_service']) && isset ($_POST['city'])){
					$DeliveryService->GetListDepartmentByCity($_POST['delivery_service'], $_POST['city']);

					foreach($DeliveryService->list as $addres){?>
						<li class="mdl-menu__item" data-value="<?=$addres['id_city']?>"><?=$addres['address']?></li>
					<?}
				}else{ ?>
					<li class="mdl-menu__item"> -- Служба доставки не выбрана -- </li>
				<?}
				break;
			case "GetDeliveryMethodsList":
				$DeliveryService->SetListByRegion($_POST['input']);
				$echo = '';
				foreach($DeliveryService->list as $key=>$ds){
					$echo .= '<div>
						<label class="mdl-radio mdl-js-radio">
							<input type="radio" name="service" class="mdl-radio__button" '.(isset($_POST['service']) && $_POST['service'] == $ds['shipping_comp']?'checked':null).' value="'.$ds['shipping_comp'].'">
							<span class="mdl-radio__label">'.$ds['shipping_comp'].'</span>
						</label>
					</div>';
				}
				break;
			// old code
			case 'addressSelect':
				$address = $Address->GetAddressById($_POST['address']);
				$res = '
					<div class="address">
						<ul>
							<li><b>Область: </b>'.$address['region_title'].'</li>
							<li><b>Город: </b>'.$address['city_title'].'</li>
							<li><b>Способ доставки: </b>'.$address['delivery_type_title'].'</li>
							<li><b>Транспортная компания: </b>'.$address['shipping_company_title'].'</li>'.
							($address['id_delivery'] == 1?'<li><b>Отделение: </b>'.$address['delivery_department'].'</li>':'<li><b>Адрес: </b>'.$address['address'].'</li>').'
						</ul>
					</div>';
				echo $res;
				break;
			case "regionSelect":
				$echo = '<option disabled selected>Выберите город</option>';
				$res = $Address->GetCitiesList($_POST['region']);
				foreach($res as $r){
					$echo .= '<option value="'.$r['title'].'">'.$r['title'].'</option>';
				}
				echo $echo;
				break;
			case "citySelect":
				$echo = '<option disabled selected>Выберите способ доставки</option>';
				// $res = $DeliveryService->SetFieldsByInput($_POST['city'], $_POST['region']);
				// $echo = '<option value="2">Передать автобусом</option><option value="1">Самовывоз</option>';
				// if($res){
					// $echo .= '<option value="3">Транспортные компании</option>';
				// }
				$count = array(
					'warehouse' => 0,
					'courier' => 0
				);

				//////////////////////////////////////////////////////////////////////
				// проверяем, есть ли в этом городе отделения транспортных компаний //
				//////////////////////////////////////////////////////////////////////
				$shipping_companies = $Address->GetShippingCompanies();
				foreach($shipping_companies as $company){
					if($company['courier'] == 1){
						$count['courier']++;
					}
					if($company['has_api'] == 1 && $company['api_key'] != ''){
						$city = $Address->UseAPI($company, 'getCity', $_POST);
						$count['warehouse'] += !empty($city)?1:0;
					}
				}
				// Если в городе есть хоть одно отделение какой-либо компании, выводим пункт Самовывоз
				if($count['warehouse'] > 0){
					$echo .= '<option value="1">Пункт выдачи</option>';
				}
				// Если в город возможна адресная доставка хоть одной компанией, выводим пункт Адресная доставка
				if($count['courier'] > 0){
					$echo .= '<option value="2">Адресная доставка</option>';
				}
				echo $echo;
				break;
			case "deliverySelect":
				$echo = '<option disabled selected>Выберите службу доставки</option>';
				if($_POST['id_delivery'] == 2){
					$shipping_companies = $Address->GetShippingCompanies(true);
					foreach($shipping_companies as $company){
						$echo .= '<option value="'.$company['id'].'">'.$company['title'].'</option>';
					}
				}else{
					$shipping_companies = $Address->GetShippingCompanies();
					foreach($shipping_companies as $company){
						if($company['has_api'] == 1 && $company['api_key'] != ''){
							$city = $Address->UseAPI($company, 'getCity', $_POST);
							if(!empty($city)){
								$echo .= '<option data-ref="'.htmlspecialchars($city['Ref']).'" value="'.$company['id'].'">'.$company['title'].'</option>';
							}
						}
					}
				}
				// Для доставки
				echo $echo;
				break;
			case "getCityId":
				$res = $DeliveryService->GetAnyCityId($_POST['city']);
				$echo = '<option selected value="'.$res['id_city'].'">'.$res['id_city'].'</option>';
				echo $echo;
				break;
			case "deliveryServiceSelect":
				// $echo = '<option disabled>Выберите отделение</option>';
				// if($Delivery->SetFieldsByInput($_POST['shipping_comp'], $_POST['city'], $_POST['region'])){
				// 	$res = $Delivery->list;
				// 	if(count($res) == 1){
				// 		foreach($res as $r){
				// 			$echo .= '<option selected="selected" value="'.$r['id_city'].'">'.$r['address'].'</option>';
				// 		}
				// 	}else{
				// 		$echo .= '<option selected="selected" disabled="disabled" class="color-sgrey">Отделение</option>';
				// 		foreach($res as $r){
				// 			$echo .= '<option value="'.$r['id_city'].'">'.$r['address'].'</option>';
				// 		}
				// 	}
				// }else{
				// 	$echo .= '<option selected="selected" disabled="disabled" class="color-sgrey">Отделение</option>';
				// }
				$echo = '';
				$warehouses = $Address->UseAPI($Address->GetShippingCompanyById($_POST['shipping_comp']), 'getWarehouses', $_POST);
				if(!empty($warehouses)){
					foreach($warehouses as $warehouse){
						$echo .= '<option data-ref="'.$warehouse['id'].'" value="'.htmlspecialchars($warehouse['name']).'">'.$warehouse['name'].'</option>';
					}
				}
				echo $echo;
				break;
			case 'getAddress':
				if(isset($_REQUEST['id'])){
					$address = $Address->GetAddressById($_REQUEST['id']);
				}
				echo json_encode($address);
			case 'deleteAddress':
				if(isset($_REQUEST['id'])){
					$Address->DeleteAddress($_REQUEST['id']);
				}
				echo json_encode(true);
				break;
			default:
				break;
		}
	}
	exit();
}