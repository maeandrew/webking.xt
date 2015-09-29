<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Wishes = new Wishes();
	ob_start();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "switch_visible":
				// Переключение видимости
				$Wishes->SwitchVisibleWishes($_POST['id_wishes'],$_POST['visible']);
				$txt = json_encode('ok');
				echo $txt;
			;
			break;
			case "del_wishes":
				// Удаление пожелания
				$Wishes->DeleteWishes($_POST['id_wishes']);
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

	function checkNumeric($arr, $fields){
		$fl = true;
		foreach ($fields as $f){
			if(!is_numeric($arr[$f])){
				$fl = false;
			}
		}
		return $fl;
	}
?>