<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Cart = new Cart();
	$Region = new Regions();
	$City = new Citys();
	$DeliveryService = new DeliveryService();
	$Delivery = new Delivery();
	$Orders = new Orders();
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
			case "regionSelect":
				$res = $City->SetFieldsByInput($_POST['region']);
				foreach($res as $r){?>
					<option value="<?=$r['name']?>"><?=$r['name']?></option>
				<?}
				break;
			case "citySelect":
				$echo = '';
				// $res = $DeliveryService->SetFieldsByInput($_POST['city'], $_POST['region']);
				// $echo = '<option value="2">Передать автобусом</option><option value="1">Самовывоз</option>';
				// if($res){
					// $echo .= '<option value="3">Транспортные компании</option>';
				// }
				 
				
				//////////////////////////////////////////////////////////////////////
				// проверяем, есть ли в этом городе отделения транспортных компаний //
				//////////////////////////////////////////////////////////////////////
				// Новая почта
				$NP = new NovaPoshtaApi2('45a3b980c25318193c40f7b10f7d0663');
				$city = $NP->getCity($_POST['city'], $_POST['region']);
				if(!empty($city['errors'])){
					$echo .= '<option data-ref="'.$city['Ref'].'" value="1">Новая почта</option>';
				}
				echo $echo;
				break;
			case "deliverySelect":
				$res = $DeliveryService->SetFieldsByInput($_POST['city'], $_POST['region']);
				$echo = '';
				if(count($res) == 1){
					$echo = '<option selected="selected" value="'.$res[0]['shipping_comp'].'">'.$res[0]['shipping_comp'].'</option>';
				}else{
					foreach($res as $r){
						$echo .= '<option value="'.$r['shipping_comp'].'">'.$r['shipping_comp'].'</option>';
					}
				}
				echo $echo;
				break;
			case "getCityId":
				$res = $DeliveryService->GetAnyCityId($_POST['city']);
				$echo = '<option selected value="'.$res['id_city'].'">'.$res['id_city'].'</option>';
				echo $echo;
				break;
			case "deliveryServiceSelect":
				if($Delivery->SetFieldsByInput($_POST['shipping_comp'], $_POST['city'], $_POST['region'])){
					$res = $Delivery->list;?>
					<?if(count($res) == 1){
						foreach($res as $r){?>
							<option selected="selected" value="<?=$r['id_city']?>"><?=$r['address']?></option>
						<?}
					}else{?>
						<option selected="selected" disabled="disabled" class="color-sgrey">Отделение</option>
						<?foreach($res as $r){?>
							<option value="<?=$r['id_city']?>"><?=$r['address']?></option>
						<?}
					}
				}else{?>
					<option selected="selected" disabled="disabled" class="color-sgrey">Отделение</option>
				<?}
				break;
			default:
				break;
		}
	}
	exit();
}