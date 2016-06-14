<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}
if(!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: /adm/404/');
}
$id_user = $GLOBALS['REQAR'][1];
$User = new Users();
unset($parsed_res);
$header = 'Редактирование пользователя';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$success = true;
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = User_form_validate(array('id_user', 'passwd'));
	if(!$err){
		if($id = $User->UpdateUser($_POST)){
			$tpl->Assign('msg', 'Пользователь обновлен.');
			unset($_POST);
			$success = true;
		}else{
			$tpl->Assign('msg', 'Пользователь не обновлен.');
			if($User->db->errno == 1062){
				$errm['email'] = "Такой email уже есть в базе."; 
				$tpl->Assign('errm', $errm);
			}
			$success = false;
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Пользователь не обновлен!');
		$tpl->Assign('errm', $errm);
		$success = false;
	}
}
if($success){
	$User->SetFieldsById($id_user);
	foreach($User->fields as $key => $value){
		$_POST[$key] = $value;
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_user_ae.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
