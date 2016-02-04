<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(!isset($_SESSION['Assort'])){
		$_SESSION['Assort']['products'] = array();
	}
	header('Content-Type: text/javascript; charset=utf-8');
	$Product = new Products();
	$Status = new Status();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case"update_assort":
				if(isset($_POST['opt']) && isset($_POST['id_product'])){
					$active = isset($_POST['active'])?$_POST['active']:1;
					if(checkNumeric($_POST, array('id_product', 'opt', 'price_otpusk', 'price_recommend', 'nacen', 'product_limit'))){
						$Product->UpdateAssort($_POST['id_product'], $_POST['opt'], $_POST['price_otpusk'], $_POST['price_recommend'], $_POST['nacen'], $_POST['product_limit'], $active, $_POST['sup_comment'], $_POST['inusd'], $_POST['currency_rate']);
					}else{
						exit();
					}
					$arr['id_product'] = $_POST["id_product"];
					$arr['error'] = false;
					$arr['opt'] = $_POST['opt'];
					$txt = json_encode($arr);
					exit();
				}
			;
			break;
			case"add_product":
				if(isset($_POST['id_product'])){
					if(checkNumeric($_POST, array('id_product'))){
						$Product->AddToAssort($_POST['id_product']);
						$arr['id_product'] = $_POST['id_product'];
						$arr['action'] = "add";
						echo json_encode($arr);
					}else{
						exit();
					}
				}
			;
			break;
			case"switchactive_product":
				if(isset($_POST['id_product']) && isset($_POST['active'])){
					if(checkNumeric($_POST, array('id_product','active'))){
						$Product->SwitchActiveEDInAssort($_POST['id_product'], $_POST['active']);
						$arr['id_product'] = $_POST['id_product'];
						$arr['active'] = $_POST['active'];
						echo json_encode($arr);
					}else{
						exit();
					}
				}
			;
			break;
			case"exclusive_product":
				if(isset($_POST['id_product']) && isset($_POST['active']) && isset($_POST['id_supplier'])){
					if(checkNumeric($_POST, array('id_product','active','id_supplier'))){
						$Product->SetExclusiveSupplier($_POST['id_product'], $_POST['id_supplier'], $_POST['active']);
						$arr['id_product'] = $_POST['id_product'];
						$arr['id_supplier'] = $_POST['id_supplier'];
						$arr['active'] = $_POST['active'];
						echo json_encode($arr);
					}else{
						exit();
					}
				}
			;
			break;
			case"sale_status":
				if($Status->UpdateStatus_Sale($_POST['id_product'], $_POST['status'])){
					$arr['id_product'] = $_POST['id_product'];
					$arr['id_status'] = $_POST['status'];
					echo json_encode($arr);
				}
			;
			break;
			case"inusd":
				if($Status->UpdateInUSD($_POST['id_product'], $_POST['inusd'], $_SESSION['member']['id_user'])){
					$arr['id_product'] = $_POST['id_product'];
					$arr['inusd'] = $_POST['inusd'];
					echo json_encode($arr);
				}
			;
			break;
			case"toggle_duplicate":
				if($Product->ToggleDuplicate($_POST['id_product'], $_POST['duplicate_user'], $_POST['duplicate_comment'])){
					echo json_encode('ok');
				}
			;
			break;
			default:
			;
			break;
		}
	exit();
}
function checkNumeric($arr, $fields){
	$fl = true;
	foreach ($fields as $f){
		if (!is_numeric($arr[$f]))
			$fl = false;
		}
	return $fl;
}
?>