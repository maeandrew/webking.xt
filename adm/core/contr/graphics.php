<?php
	if (!_acl::isAllow('specifications'))
		die("Access denied");

	$ObjName = "Specification";
	$$ObjName = new Specification();

	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Характеристики";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb']) && isset($_POST['ord'])){
		$$ObjName->Reorder($_POST);
		$tpl->Assign('msg', 'Сортировка выполнена успешно.');
	}


	if (true){
		$tpl->Assign('data_graph', $products->GetGraphList());
	}
	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl_global'].'graph.tpl'));

	/*$data_graph = $products->GetGraphList($id_category);
	$tpl->Assign('data_graph', $data_graph);
	$tpl_graph .= $tpl->Parse($GLOBALS['PATH_tpl_global'].'graph.tpl');*/


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>