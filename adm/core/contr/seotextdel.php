<?php

	$Seo = new Seo();

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	$tpl->Assign('h1', 'Удаление Seo-текста');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Seo-текст";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotext/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление Seo-текста";


	if (!$Seo->DelSeoText($id)) die('Ошибка при удалении Seo-текста.');

	$tpl->Assign('msg', 'Seo-текст удален.');

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>