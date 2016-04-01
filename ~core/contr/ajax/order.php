<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "CancelOrder":
				echo json_encode(true);
				break;
			case "DeleteOrder":
				echo json_encode(true);
				break;
			default:
				break;
		}
	}
}
exit();
?>