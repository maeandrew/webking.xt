<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	//header('Content-Type: text/javascript; charset=utf-8');
	$products = new Products();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "sort":
				if($products->SortPriceLists($_POST['data'])){
					return true;
				}else{
					return false;
				}
			;
			break;
			
			case "add":
				$id = $products->AddPricelist($_POST);
				echo $id;
			;
			break;

			case "delete":
				if($products->DeletePriceList($_POST['id'])){
					echo $id;
				}else{
					return false;
				}
			;
			break;

			case "update":
				if($products->UpdatePriceList($_POST)){
					echo 'good';
				}else{
					return false;
				}
			;
			break;

			case "run":
				if($products->UpdateSetByOrder($_POST)){
					echo 'good';
				}else{
					return false;
				}
			;
			break;
			
			default:
			;
			break;
		}
	}
	exit();
}
?>