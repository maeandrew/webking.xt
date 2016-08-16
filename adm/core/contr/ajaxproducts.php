<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){

			case 'add_supplier':
				echo json_encode($Products->GetSupplierInfoByArticle($_POST['art']));
				break;


		}
	exit();
}