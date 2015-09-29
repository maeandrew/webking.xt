<?php



	$Page = new Page();

	$Page->PagesList();

	$tpl->Assign('list_menu', $Page->list);



	// ---- center ----

	unset($parsed_res);



	$ii = count($GLOBALS['IERA_LINKS']);

	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Распродажа";

	$GLOBALS['IERA_LINKS'][$ii++]['url'] =  _base_url.'/';



	$items = new Items();



	$items->SetItemsList(array('sale'=>1, 'visible'=>1));



	$tpl->Assign('list', $items->list);





	$parsed_res = array('issuccess' => TRUE,

 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_sale.tpl'));





	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];

	}



	// ---- right ----





?>