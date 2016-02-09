<?php

	if (!_acl::isAllow('specifications'))
	die("Access denied");

	$ObjName = "Products";
	$$ObjName = new Products();
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Графики";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

/*
	if ($$ObjName->GetGraphList()){
		$tpl->Assign('data_graph', $$ObjName->GetGraphList());
	}*/

	$data_graph = $$ObjName->GetGraphList();
	foreach ($data_graph as $key => &$value) {
		$value['translit'] = $dbtree->GetTranslitById($value['id_category']);
	}
	$tpl->Assign('data_graph', $data_graph);
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