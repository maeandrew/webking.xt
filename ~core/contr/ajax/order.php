<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$order = new Orders;
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "CancelOrder":
				echo json_encode($order->UpdateStatus($_POST['id_order'], 5));
				break;
			case "DeleteOrder":
				echo json_encode($order->OffUserOrder($_POST['id_order']));
				break;
			default:
				break;
		}
	}
}
exit();
?>