<?php

$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);

// ---- center ----
unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_category = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}




	$tpl->Assign('h1', 'Удаление категории');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление категории";


	$res = $dbtree->DeleteAll($id_category);
	if ($res === true){
		$tpl->Assign('msg', 'Категория удалена.');

	}else{
	$tpl->Assign('msg', $res);
	$tpl->Assign('errm', 1);
	}



	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>