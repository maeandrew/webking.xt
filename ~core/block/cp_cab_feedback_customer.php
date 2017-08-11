<?php

	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/feedback/'
	);

	$Customer = new Customers();

	$success = false;

	$Customer->SetFieldsById($Users->fields['id_user']);

	$Users->SetUser($_SESSION['member']);

	$tpl->Assign('User', $Users->fields);
	$tpl->Assign('Customer', $Customer->fields);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_feedback.tpl'));

?>
