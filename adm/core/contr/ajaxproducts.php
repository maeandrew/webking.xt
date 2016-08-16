<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case 'datalist':
				echo json_encode($Products->GetIdOneRowArrayByArt($_POST['article']));
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