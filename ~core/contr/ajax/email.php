<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Mailer = new Mailer();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'testEmail':
				// $Mailer->testEmail();
				$Mailer->SendCustomEmail('alexparhomenko67@gmail.com', date("d.m.Y H:i:s", time()), 'Динамическое содержимое '.date("d.m.Y H:i:s", time()));
				$Mailer->SendCustomEmail('kmkmedia@gmail.com', date("d.m.Y H:i:s", time()), 'Динамическое содержимое '.date("d.m.Y H:i:s", time()));
				echo json_encode(true);
				break;
			default:
				break;
		}
	}
}
exit();
