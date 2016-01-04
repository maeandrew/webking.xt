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
				$txt = json_encode($Region->list);
				echo $txt;
			;
			break;

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