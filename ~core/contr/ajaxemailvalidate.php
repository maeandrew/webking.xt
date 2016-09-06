<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_GET['action']))
	switch($_GET['action']) {
		case "validate":
			if(isset($_GET['email'])){
				$email = trim($_GET['email']);
			}else{
				$email = '';
			}
			$Users = new Users();
			if($Users->ValidateEmail($email)){
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
