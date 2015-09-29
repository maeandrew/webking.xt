<?php
$err="";
$Customer = new Customers();
$id_user = $User->fields['id_user'];
$success = false;
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	$nocheck[] = 'keystring';
	if(!$err){
		if($id = $Customer->UpdateCustomer($_POST)){
			$tpl->Assign('msg', 'Информация обновлена.');
			$success = true;
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
			if(mysql_errno() == 1062){
				$errm['email'] = "Такой email уже есть в базе."; 
				ini_set('display_errors',1);
				error_reporting(E_ALL);
				$tpl->Assign('errm', $errm);
			}
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Информация не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}
$User->SetFieldsById($id_user);
$Customer->SetFieldsById($id_user);
$_POST = $User->fields;
if(!isset($_POST['smb'])){
	foreach($Customer->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_cab_inf.tpl'));
?>