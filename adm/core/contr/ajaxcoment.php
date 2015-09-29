<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$News = new News();
	ob_start();
	if(isset($_POST['action'])){
		if(isset($_POST['Id_coment']) && checkNumeric($_POST, array('Id_coment'))){
			if($_POST['action'] == "show"){
				$News->ShowComent($_POST['Id_coment']);
			}elseif($_POST['action'] == "hide"){
				$News->HideComent($_POST['Id_coment']);
			}elseif($_POST['action'] == "drop"){
				$News->DropComent($_POST['Id_coment']);
			}else{
				exit();
			}
			$t = ob_get_clean();
			G::LogerE($t, "ajax.html", "w");
			/*				
			ob_start();
			print_r($_SESSION['Cart']);
			print_r($_POST);
			$t = ob_get_clean();
			G::LogerE($t, "ajax.html", "w");
			*/
			$arr['Id_coment'] = $_POST["Id_coment"];
			$txt = json_encode($arr);
			echo $txt;
			exit();
		}
	}
}
exit();

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