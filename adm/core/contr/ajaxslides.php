<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	//header('Content-Type: text/javascript; charset=utf-8');
	$slides = new Slides();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "sort":
				if($slides->SortSlides($_POST['data'])){
					return true;
				}else{
					return false;
				}
			;
			break;
			
			case "add":
				$id = $slides->AddSlide($_POST);
				echo $id;
			;
			break;

			case "delete":
				if($slides->DeleteSlide($_POST['id'])){
					echo $id;
				}else{
					return false;
				}
			;
			break;

			case "update":
				if($slides->UpdateSlide($_POST)){
					echo 'good';
				}else{
					return false;
				}
			;
			break;

			case "run":
				if($slides->UpdateSetByOrder($_POST)){
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