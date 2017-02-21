<?php
	if (!_acl::isAllow('configs'))
		die("Access denied");

	$Config = new Config();

	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Настройки";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if(isset($_POST['smb']) && isset($_POST['ord'])){
		$Config->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}

	if($Config->SetList()){
		$tpl->Assign('list', $Config->list);
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_config.tpl'));

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
	// ---- right ----
?>