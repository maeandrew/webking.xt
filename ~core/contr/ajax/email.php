<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Mailer = new Mailer();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'testEmail':
				// $Mailer->testEmail();
				$Mailer->SendCustomEmail('alexparhomenko67@gmail.com', 'Тест'.date("d.m.Y H:i:s", time()), 'Содержимое '.date("d.m.Y H:i:s", time()));
				echo json_encode(true);
				break;
			default:
				break;
		}
	}
}
exit();
