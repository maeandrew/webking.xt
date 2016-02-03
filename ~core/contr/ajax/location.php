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
				$DeliveryService->GetListDepartmentByCity($_POST['delivery_service'], $_POST['city']);
				
				foreach($DeliveryService->list as $addres){?>
					<li class="mdl-menu__item" data-value="<?=$addres['id_city']?>"><?=$addres['address']?></li>
				<?}
				break;

			case "GetDeliveryMethodsList":
				$DeliveryService->SetListByRegion($_POST['input']);
				foreach($DeliveryService->list as $key=>$ds){
					if($ds['shipping_comp'] != ''){
					}?>
					<div>
						<label class="mdl-radio mdl-js-radio">
							<input type="radio" name="service" class="mdl-radio__button" <?=isset($_POST['service']) && $_POST['service'] == $ds['shipping_comp']?'checked':null?> value="<?=$ds['shipping_comp']?>">
							<span class="mdl-radio__label"><?=$ds['shipping_comp']?></span>
						</label>
					</div>
				<?}
			break;

			// old code
			case "regionSelect":
				$res = $City->SetFieldsByInput($_POST['region']);?>
				<option selected="selected" disabled="disabled" class="color-sgrey">Город</option>
				<?foreach($res as $r){?>
					<option value="<?=$r['names_regions']?>"><?=$r['name']?></option>
				<?}
			;
			break;

			case "citySelect":
				$res = $DeliveryService->SetFieldsByInput($_POST['city']);?>
				<option selected="selected" disabled="disabled" class="color-sgrey">Способ доставки</option>
				<option value="2">Передать автобусом</option>
				<option value="1">Самовывоз</option>
				<?if($res){?>
					<option value="3">Транспортные компании</option>
				<?}
			;
			break;

			case "deliverySelect":
				$res = $DeliveryService->SetFieldsByInput($_POST['city']);?>
				<?if(count($res) == 1){?>
					<option selected="selected" value="<?=$res[0]['shipping_comp']?>"><?=$res[0]['shipping_comp'];?></option>
				<?}else{?>
					<option selected="selected" disabled="disabled" class="color-sgrey">Служба доставки</option>
					<?foreach($res as $r){?>
						<option value="<?=$r['shipping_comp']?>"><?=$r['shipping_comp'];?></option>
					<?}
				}
			;
			break;

			case "getCityId":
				$res = $DeliveryService->GetAnyCityId($_POST['city']);?>
				<option selected value="<?=$res['id_city']?>"><?=$res['id_city']?></option>
				<?
			;
			break;
			case "deliveryServiceSelect":
				if($Delivery->SetFieldsByInput($_POST['shipping_comp'], $_POST['city'])){
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
			;
			break;

			default:
			;
			break;
		}
	}
	exit();
}
?>