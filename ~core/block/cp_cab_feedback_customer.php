<?php

	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/feedback/'
	);

	$Customer = new Customers();

	$success = false;

	$Customer->SetFieldsById($User->fields['id_user']);

	$User->SetUser($_SESSION['member']);

	$tpl->Assign('User', $User->fields);
	$tpl->Assign('Customer', $Customer->fields);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_feedback.tpl'));

?>
