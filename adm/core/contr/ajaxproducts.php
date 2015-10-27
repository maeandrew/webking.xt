<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$specification = new Specification();
	$products = new Products();
	$supplier = new Suppliers();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "specification_update":
				$products->UpdateProduct(array('id_product'=>$_POST['id_product']));
				if($_POST['id_spec_prod'] == ''){
					if($specification->AddSpecToProd($_POST, $_POST['id_product'])){
						echo json_encode('ok');
					}
				}else{
					if($specification->UpdateSpecsInProducts($_POST)){
						echo json_encode('ok');
					}
				}
			;
			break;
			case "update_translit":
				echo json_encode($products->UpdateTranslit($_POST['id_product']));
			;
			break;
			case "datalist":
				echo json_encode($products->GetIdOneRowArrayByArt($_POST['article']));
			;
			break;
			case "datalist_supplier":
				echo json_encode($supplier->GetIdOneRowArrayByArt($_POST['article']));
			;
			break;
			case "insert_related":
				echo json_encode($products->AddRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
			;
			break;
			case "remove_related":
				echo json_encode($products->DelRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
			;
			break;
			case "add_supplier":
				echo json_encode($products->GetSupplierInfoByArticle($_POST['art']));
			;
			break;
			default:
			;
			break;
		}
	exit();
}
?>