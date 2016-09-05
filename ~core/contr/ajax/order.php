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
				echo json_encode($Orders->addAddress($_POST['id_order'], $_POST['id_address']));
				break;
			default:
				break;
		}
	}
}
exit();