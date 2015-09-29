<?php

	$ObjName = "Region";	
	$$ObjName = new Regions();

	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Регионы";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb']) && isset($_POST['ord'])){
		$$ObjName->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}
	
	if ($$ObjName->SetList()){
		$tpl->Assign('list', $$ObjName->list);
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_regions.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>