<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	//header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "sort":
				if($Products->SortPriceLists($_POST['data'])){
					return true;
				}else{
					return false;
				}
			;
			break;

			case "add":
				$id = $Products->AddPricelist($_POST);
				echo $id;
			;
			break;

			case "delete":
				if($Products->DeletePriceList($_POST['id'])){
					echo $id;
				}else{
					return false;
				}
			;
			break;

			case "update":
				if($Products->UpdatePriceList($_POST)){
					echo 'good';
				}else{
					return false;
				}
			;
			break;

			case "run":
				if($Products->UpdateSetByOrder($_POST)){
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
