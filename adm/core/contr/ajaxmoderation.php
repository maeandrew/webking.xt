<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	// header('Content-Type: text/javascript; charset=utf-8');
	$products = new Products();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "decline":
				$products->SetModerationStatus($_POST['id'], $_POST['status'], nl2br($_POST['comment']));
			;
			break;
			case "accept":
				$_POST['art'] = $products->CheckArticle((int) $GLOBALS['CONFIG']['last_manual_product_article'] + 1);
				if($id = $products->AcceptProductModeration($_POST)){
					$GLOBALS['CONFIG']['last_manual_product_article'] = $_POST['art'];
					$config = new Config();
					$config->UpdateByName('last_manual_product_article', $GLOBALS['CONFIG']['last_manual_product_article']);
				};
				$products->UpdateProductCategories($id, $_POST['category']);
				$products->RecalcSitePrices(array($id));
				$products->SetModerationStatus($_POST['id'], $_POST['status']);
			;
			break;

			default:
			;
			break;
		}
	}
	exit();
}?>