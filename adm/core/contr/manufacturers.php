<?php

	$Manufacturers = new Manufacturers();

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Производители');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Производители";

	if (isset($_POST['smb']) && isset($_POST['ord'])){
		$Manufacturers->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}

	if (!$Manufacturers->ManufacturersList()) die('Ошибка при формировании списка.');
	$tpl->Assign('list', $Manufacturers->list);

	if (!$Manufacturers->ManufacturersListProductsCnt()) die('Ошибка при формировании списка.');
   	$tpl->Assign('list_cnt', $Manufacturers->list);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manufacturers.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>