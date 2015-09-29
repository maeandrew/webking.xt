
<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
$success = false;
$header = "Восстановление пароля";
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/remind/'
);
$tpl->Assign('header', $header);
$User = new Users();
if(isset($_POST['smb']) && isset($_POST['email'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Remind_form_validate();
	if(!$err){
		$email = $_POST['email'];
		if($User->IsUserEmail($email)){
			$key = $User->SetPwdChangeKey($email);
			$success = 'prechange';
			$to = $email;
			$title = "Восстановление доступа на ".$_SERVER['SERVER_NAME'];
			$subj = '=?utf8?B?' . base64_encode($title) . '?=';
			$msg = "Вы получили это письмо потому, что запросили восстановление пароля вашего аккаунта на сайте ".$GLOBALS['CONFIG']['invoice_logo_text'].".<br/>
			Если же вы этого не делали - просто проигнорируйте это письмо.<br/>
			Для подтверждения смены пароля перейдите по ссылке:<br/>
			<a href=\"".$_SERVER['SERVER_NAME']."/remind/".$key."/\">http://".$_SERVER['SERVER_NAME']."/remind/".$key."/</a>";
			$headers  = "Content-type: text/html; charset=UTF-8";
			$headers .= "From: ".$GLOBALS['CONFIG']['invoice_logo_text'];
			@mail($to, $subj, $msg, $headers);
		}else{
			$tpl->Assign('msg_type', "error");
			$tpl->Assign('msg', 'Мы не нашли пользователя с таким<br>E-mail.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg_type', "error");
		$tpl->Assign('msg', 'Недействительный E-mail адрес.');
		$tpl->Assign('errm', 1);
	}
}elseif(isset($GLOBALS['REQAR'][1])){
	if($email = $User->CheckPwdChangeKey($GLOBALS['REQAR'][1])){
		$newpwd = $User->ChangePwd($email);
		$success = 'changed';
		$to = $email;
		$title = "Новый пароль для вашего аккаунта на ".$_SERVER['SERVER_NAME'];
		$subj = '=?utf8?B?' . base64_encode($title) . '?=';
		$msg = "Доступ для аккаунта ".$email." был восстановлен.<br/>
		Для входа на сайт ".$GLOBALS['CONFIG']['invoice_logo_text']." используйте новый пароль: <b>".$newpwd."</b><br/>";
		$headers  = "Content-type: text/html; charset=UTF-8";
		$headers .= "From: ".$GLOBALS['CONFIG']['invoice_logo_text'];
		@mail($to, $subj, $msg, $headers);
	}else{
		$tpl->Assign('msg_type', "error");
		$tpl->Assign('msg', 'Неправильный ключ.');
		$tpl->Assign('errm', 1);
	}
}
if($success == 'changed'){
	$tpl->Assign('msg_type', "success");
	$tpl->Assign('msg', "Пароль был успешно изменен и отправлен на указанный Вами E-mail.");
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remind.tpl')
	);
}elseif($success == 'prechange'){
	$tpl->Assign('msg_type', "success");
	$tpl->Assign('msg', "Мы отпрвили на указанный Вами E-mail письмо для подтверждения восстановления доступа.");
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remind.tpl')
	);
}else{
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remind.tpl')
	);
}
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>