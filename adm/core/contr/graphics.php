<?php

	if (!_acl::isAllow('graphics'))
	die("Access denied");

	$Products = new Products();
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Графики";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	/*
	if ($Products->GetGraphList()){
		$tpl->Assign('data_graph', $Products->GetGraphList());
	}*/

	/*Pagination*/
	if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
		$GLOBALS['Limit_db'] = $_GET['limit'];
	}
	if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
		if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
			$_GET['page_id'] = $_POST['page_nbr'];
		}
		$cnt = count($Products->GetGraphList());
		$tpl->Assign('cnt', $cnt);
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}

	$data_graph = $Products->GetGraphList(false, false, $limit);
	foreach ($data_graph as $key => &$value) {
		$value['translit'] = $dbtree->GetTranslitById($value['id_category']);
		$value['name'] = $dbtree->GetNameById($value['id_category']);
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