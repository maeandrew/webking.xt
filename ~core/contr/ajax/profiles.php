<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "getAdditionalFields":
				$tpl->Assign('id_profile', $_POST['id_profile']);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'profiles_additional_fields.tpl');
				break;
			default:
				break;
		}
	}
}
exit();