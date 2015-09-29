<?php
	$ObjName = "contragents";
	$$ObjName = new Contragents();
	unset($parsed_res);
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Отправители";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/remitters/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление Отправителя";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if (!$$ObjName->DelRemitter($id)) die('Ошибка при удалении.');
	$tpl->Assign('msg', 'Удаление прошло успешно.');
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));
	if(TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>