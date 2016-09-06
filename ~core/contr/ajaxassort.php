<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(!isset($_SESSION['Assort'])){
		$_SESSION['Assort']['products'] = array();
	}
	header('Content-Type: text/javascript; charset=utf-8');
	$Product = new Products();
	$Status = new Status();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case"add_product":
				if(isset($_POST['id_product'])){
					if(checkNumeric($_POST, array('id_product'))){
						$Product->AddToAssort($_POST['id_product'], isset($_POST['id_supplier'])?$_POST['id_supplier']:$_SESSION['member']['id_user']);
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