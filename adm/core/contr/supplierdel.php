<?php

	if (!_acl::isAllow('users'))
		die("Access denied");

	$User = new Users();
	$Supplier = new Suppliers();

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_user = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	$tpl->Assign('h1', 'Удаление поставщика');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление поставщика";

	if (!$Supplier->DelSupplier($id_user)) die('Ошибка при удалении поставщика.');

	$tpl->Assign('msg', 'Поставщик удален.');

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>