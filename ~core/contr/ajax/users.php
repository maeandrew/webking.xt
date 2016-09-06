<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Users = new Users();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'check_email_uniqueness':
				$response = false;
				// Проверка уникальности email
				if($Users->CheckEmailUniqueness($_POST['email'])){
					$response = true;
				}
				echo $response;
				break;
			default:
				break;
		}
	}
}
exit(0);