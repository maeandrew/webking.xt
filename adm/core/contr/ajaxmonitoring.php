<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'ChangeSpecificationValue':
				$specification = new Specification();
				if($specification->UpdateSpecsValueMonitoring($_POST)){
					echo "ok";
				}else{
					echo "error";
				}
				break;
			default:
				break;
		}
	}
}
exit();
?>