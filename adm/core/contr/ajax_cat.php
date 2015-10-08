<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	ob_start();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "sort_category":
				//Обработка сортировки категорий
				$order = $_GET['item'];
				//Записывает изменения в базу
				foreach ($order as $k => $value) {
					$dbtree->UpdateCatPosition($k,$value);
				}
				$txt = json_encode('ok');
				echo $txt;
			;
			break;
			default:
			;
			break;
		}
		exit();
	}
}

?>