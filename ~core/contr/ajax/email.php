<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Mailer = new Mailer();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'testEmail':
				$Mailer->testEmail();
				echo json_encode(true);
				break;
			default:
				break;
		}
	}
}
exit();
