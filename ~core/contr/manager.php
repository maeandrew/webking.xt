<?php

//ini_set("display_errors",1);

//error_reporting(E_ALL);



	$Page = new Page();

	$Page->PagesList();

	$tpl->Assign('list_menu', $Page->list);



	if (!isset($GLOBALS['REQAR'][1])

		|| !is_numeric($GLOBALS['REQAR'][1])

		|| !isset($GLOBALS['REQAR'][2])){

		header('Location: '. _base_url.'/404/');

		exit();

	}



	$GLOBALS['IERA_LINKS'] = array();

	$GLOBALS['IERA_LINKS'][0]['title'] = "Профиль менеджера";

	$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/manager/';



	// ---- center ----

	unset($parsed_res);



	$id_manager = $GLOBALS['REQAR'][1];



	$Contragents = new Contragents();

	$manager = $Contragents->GetManagerInfoById($id_manager);

	if(!$manager){

		header('Location: '. _base_url.'/404/');

		exit();

	}



	$tpl->Assign('manager', $manager);



	$parsed_res = array('issuccess' => TRUE,

	 					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_public.tpl'));



	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];

	}

?>