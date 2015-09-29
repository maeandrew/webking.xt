<?php

	$Manufacturers = new Manufacturers();
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Производители');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Производители";

	if (!$Manufacturers->ManufacturersList()) die('Ошибка при формировании списка.');

	$tpl->Assign('list', $Manufacturers->list);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manufacturers.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>