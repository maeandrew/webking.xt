<?php
	if (!_acl::isAllow('units'))
		die("Access denied");

	$ObjName = "Unit";	
	$$ObjName = new Unit();

	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Единицы измерения";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb']) && isset($_POST['ord'])){
		$$ObjName->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}
	
	if ($$ObjName->SetList()){
		$tpl->Assign('list', $$ObjName->list);
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_unit.tpl'));
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>