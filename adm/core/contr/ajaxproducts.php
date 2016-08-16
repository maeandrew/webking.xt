<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){

			case 'update_translit':
				echo json_encode($Products->UpdateTranslit($_POST['id_product']));
				break;
			case 'datalist':
				echo json_encode($Products->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'datalist_supplier':
				$Supplier = new Suppliers();
				echo json_encode($Supplier->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'insert_related':
				echo json_encode($Products->AddRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'remove_related':
				echo json_encode($Products->DelRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'add_supplier':
				echo json_encode($Products->GetSupplierInfoByArticle($_POST['art']));
				break;
			case 'get_segment_list':
				$Segmentation = new Segmentation();
				echo json_encode($Segmentation->GetSegmentation($_POST['type']));
				break;

			default:
				break;
		}
	exit();
}