<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Orders = new Orders;
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "CancelOrder":
				echo json_encode($Orders->UpdateStatus($_POST['id_order'], 5));
				break;
			case "DeleteOrder":
				echo json_encode($Orders->OffUserOrder($_POST['id_order']));
				break;
			case "restoreDeleted":
				echo json_encode($Orders->RestoreDeleted($_POST['id_order']));
				break;
			case 'addAddress':
				if($Orders->addAddress($_POST['id_order'], $_POST['id_address'])){
					$Address = new Address();
					$res = $Address->getAddressOrder($_POST['id_order']);
					$addr = '<div class="servise_logo">
								<img src="/images/noavatar.png" alt="avatar" />
							</div>
							<div class="delivery_details">
								<div class="line">
									<span class="label">Название:</span>
									<span class="value">'.$res['title'].'</span>
								</div>
								<div class="line">
									<span class="label">Компания доставки:</span>
									<span class="value">'.$res['shipping_company'].'</span>
								</div>
								<div class="line">
									<span class="label">Область:</span>
									<span class="value">'.$res['region'].'</span>
								</div>
								<div class="line">
									<span class="label">Город:</span>
									<span class="value">'.$res['city'].'</span>
								</div>
								<div class="line">
									<span class="label">Тип доставки:</span>
									<span class="value">'.$res['delivery'].'</span>
								</div>
								<div class="line '.(empty($res['delivery_department'])?'hidden':null).'">
									<span class="label">Отделение:</span>
									<span class="value">'.$res['delivery_department'].'</span>
								</div>
								<div class="line '.(empty($res['address'])?'hidden':null).'">
									<span class="label">Адрес:</span>
									<span class="value">'.$res['address'].'</span>
								</div>
							</div>';
					echo $addr;
				}
				break;
			default:
				break;
		}
	}
}
exit();