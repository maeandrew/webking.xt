<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	//header('Content-Type: text/javascript; charset=utf-8');
	$Slides = new Slides();
	if(isset($_POST['action'])){
		switch($_POST['action']){


			case "run":
				if($Slides->UpdateSetByOrder($_POST)){
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