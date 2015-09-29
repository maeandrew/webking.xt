<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$specification = new Specification();
	$products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case"specification_update":
				$products->UpdateProduct(array('id_product'=>$_POST['id_product']));
				if($_POST['id_spec_prod'] == ''){
					if($specification->AddSpecToProd($_POST, $_POST['id_product'])){
						echo json_encode('ok');
					}
				}
				else {
					if($specification->UpdateSpecsInProducts($_POST)){
						echo json_encode('ok');
					}
				}
			;
			break;
			default:
			;
			break;
		}
	exit();
}
?>