<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
		header('Content-Type: text/javascript; charset=utf-8');
		$config = new config();
		if(isset($_POST['action']))
			switch($_POST['action']){
				case "getOption":
					$config->SetFieldsByName($_POST['nameOption']);
					echo json_encode($config->fields);
				;
				break;
				case "updateOption":
					echo json_encode($config->UpdateByName($_POST['nameOption'],$_POST['valueOption']));
				;
				break;
				default:
				;
				break;
			}
	exit();
}
?>