<?php



	if (!G::IsLogged()){

		if (!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1]))

			$_SESSION['from'] = 'customer_order/'.$GLOBALS['REQAR'][1];

		header('Location: '. _base_url.'/login/');

    	exit();

	}



	if (!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){

		header('Location: '. _base_url.'/404/');

    	exit();

	}



	$id_order = $GLOBALS['REQAR'][1];





	if (isset($GLOBALS['REQAR'][2]) && $GLOBALS['REQAR'][2]=="pret"){

		$tpl->Assign('show_pretense', true);

	}else{

		$tpl->Assign('show_pretense', false);

	}



	// ---- center ----

	unset($parsed_res);



	$Page = new Page();

	$Page->PagesList();

	$tpl->Assign('list_menu', $Page->list);



	$GLOBALS['IERA_LINKS'] = array();

	$GLOBALS['IERA_LINKS'][0]['title'] = "Заказ";

	$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/m_diler_order/';



	$User = new Users();

	$User->SetUser($_SESSION['member']);



 if ($User->fields['gid'] == _ACL_M_DILER_){



 	$Order = new Orders();

 	$Order->SetFieldsById($id_order);

 	$tpl->Assign("order", $Order->fields);



















	$Customer = new Customers();

	$Customer->SetFieldsById($User->fields['id_user']);

	$tpl->Assign("Customer", $Customer->fields);



 	$arr = $Order->GetOrderForMdiler(array("o.id_order"=>$id_order));



 	$tpl->Assign("data", $arr);









	$parsed_res = array('issuccess' => TRUE,

 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_m_diler_order.tpl'));

 }else{

 	$tpl->Assign("msg", "Вы не можете просматривать заказы.");

 	$parsed_res = array('issuccess' => TRUE,

 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));

 }



	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];

	}



	// ---- right ----



?>