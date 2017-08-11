<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}
$header = 'Добавление пользователя';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Пользователи';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

// Обработка отправки формы
if(isset($_POST['smb'])){
	$skipped_fields = array('id_user');
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	switch($_POST['gid']){
		case _ACL_SUPPLIER_:
			$className = 'Suppliers';
			break;
		case _ACL_CONTRAGENT_:
			$className = 'Contragents';
			break;
		case _ACL_CUSTOMER_:
			$className = 'Customers';
			break;
		default:
			$className = 'Users';
			break;
	}
	$$className = new $className();
	
	/* Валидация введенных данных */
	$valudation_function = $className.'_form_validate';
	list($err, $errm) = $valudation_function($skipped_fields);

	/* Дополнительные проверки на уникальность */
	// Уникальность номера телефона
	if(!$errm['phone'] && !$Users->CheckPhoneUniqueness($_POST['phone'])){
		$err = 1;
		$errm['phone'] = 'Пользователь с таким телефоном уже зарегистрирован';
	}
	// Уникальность Email'а
	if(!$errm['email'] && !$Users->CheckEmailUniqueness($_POST['email'])){
		$err = 1;
		$errm['email'] = 'Пользователь с таким Email уже зарегистрирован';
	}
	switch($_POST['gid']){
		case _ACL_SUPPLIER_:
			// Уникальность артикула поставщика
			if(!$errm['article'] && !$Suppliers->CheckArticleUniqueness($_POST['article'])){
				$err = 1;
				$errm['article'] = 'Поставщик с таким артикулом уже существует';
			}
			break;
	}
	if(!$err){
		if($id = $$className->Create($_POST)){
			$tpl->Assign('msg', 'Пользователь добавлен.');
			header('Location: '.$GLOBALS['URL_base'].'adm/usersedit/'.$id);
			exit(0);
		}else{
			$tpl->Assign('errm', 1);
			$tpl->Assign('msg', 'Пользователь не добавлен.');
		}
	}
	if($err){
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('errm', $errm);
		$tpl->Assign('msg', 'Пользователь не добавлен!');
	}
	$Contragents = new Contragents();
	$Contragents->SetList();
	$tpl->Assign('managers_list', $Contragents->list);
	$tpl->Assign('additional_fields', file_exists($GLOBALS['PATH_tpl_global'].'profiles_additional_fields_'.$_POST['gid'].'.tpl')?$tpl->Parse($GLOBALS['PATH_tpl_global'].'profiles_additional_fields_'.$_POST['gid'].'.tpl'):'<div class="col-md-12">Нет</div>');
}

if(!isset($_POST['smb'])){
	// $_POST['id_user'] = 0;
}
	unset($_POST['id_user']);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_user_ae.tpl');
