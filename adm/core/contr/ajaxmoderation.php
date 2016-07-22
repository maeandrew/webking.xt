<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	// header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "decline":
				$Products->SetModerationStatus($_POST['id'], $_POST['status'], nl2br($_POST['comment']));
				break;
			case "accept":
				$_POST['art'] = $Products->CheckArticle($Products->GetLastArticle());
				$id = $Products->AcceptProductModeration($_POST);
				$Products->UpdateProductCategories($id, $_POST['category'], 1);
				$Products->RecalcSitePrices(array($id));
				$Products->SetModerationStatus($_POST['id'], $_POST['status']);
				break;
			default:
				break;
		}
	}
	exit();
}?>