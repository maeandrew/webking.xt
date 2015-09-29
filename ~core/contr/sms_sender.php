<?php
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_GET['reciever']) && isset($_GET['text'])){
		if(strlen($_GET['reciever']) == 12 && trim($_GET['text']) != ''){
			$Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
			$res = $Gateway->execCommad(
				'sendSMS',
				array(
					'sender' => $GLOBALS['CONFIG']['invoice_logo_text'],
					'text' => trim($_GET['text']),
					'phone' => $_GET['reciever'],
					'datetime' => null,
					'sms_lifetime' => 0
				)
			);
			echo '<h1>Успех!</h1>На номер <b>'.$_GET['reciever'].'</b> отправлено сообщение: ';
			echo '"<b>'.$_GET['text'].'</b>"';
			echo '<br><br>Теперь можно закрыть окно.';
		}else{
			echo '<h1>Ой, что-то пошло не так!</h1>Сообщение <b style="color:#f00;">не отправлено</b> по следующим причинам:';
			if(strlen($_GET['reciever']) != 12){
				echo "<br>\t - Некорректный номер получателя (<b>".$_GET['reciever']."</b>);";
			}
			if(trim($_GET['text']) == ''){
				echo "<br>\t - Отсутствует текст сообщения;";
			}
		}
	}else{
		echo '<h1>Ой, что-то пошло не так!</h1>Сообщение <b style="color:#f00;">не отправлено</b> по следующим причинам:';
		if(!isset($_GET['reciever'])){
			echo "<br>\t - Отсутствует номер получателя;";
		}
		if(!isset($_GET['text'])){
			echo "<br>\t - Отсутствует текст сообщения;";
		}
	}
	exit();
?>