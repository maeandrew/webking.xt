<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Customer = new Customers();
	$User->SetUser($_SESSION['member']);
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "del_favorite":
				// Удаление Избранного товара
				if(isset($_POST['id_product'])){
					$Customer->DelFavorite($User->fields['id_user'], $_POST['id_product']);
					foreach($_SESSION['member']['favorites'] as $key => $value){
						if($value == $_POST['id_product']){
							unset($_SESSION['member']['favorites'][$key]);
						}
					}
					$txt = json_encode('ok');
					echo $txt;
				}
			;
			break;
			case "del_from_watinglist":
				// Удаление Из списка ожидания
				if(isset($_POST['id_product'])){
					$Customer->DelFromWatingList($User->fields['id_user'], $_POST['id_product']);
					if (isset($_SESSION['member'])) {
						foreach($_SESSION['member']['wating_list'] as $key => $value){
							if($value == $_POST['id_product']){
								unset($_SESSION['member']['wating_list'][$key]);
							}
						}
					}
					$txt = json_encode('ok');
					echo $txt;
				}
			;
			break;
			default:
			;
			break;
		}
	exit();
}?>