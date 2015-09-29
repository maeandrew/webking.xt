<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['action']))
	switch($_POST['action']) {
		case "validate":
			if(isset($_POST['code'])){
				$code = mysql_real_escape_string(trim($_POST['code']));
			}else{
				$code = '';
			}
			$Supplier = new Suppliers();
			if($Supplier->CheckCodeUniqueness($code) === true){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
		
		default:
		;
		break;
	}
	exit();
}?>
