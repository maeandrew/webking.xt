<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$suppliers = new Suppliers();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "toggle_single_price":
				// Переключение единой цены у поставщика
				if(isset($_POST['single_price']) && isset($_POST['id_supplier'])){
					$suppliers->UpdateSinglePrice($_POST['id_supplier'], $_POST['single_price']);

					$txt = json_encode('ok');
					exit();
				}
			;
			break;
			default:
			;
			break;
		}
	exit();
}?>