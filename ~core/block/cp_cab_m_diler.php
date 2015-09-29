<?php





	$GLOBALS['IERA_LINKS'] = array();

	$GLOBALS['IERA_LINKS'][0]['title'] = "Кабинет";

	$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cabinet/';







	$GET_limit = "";

	if (isset($_GET['limit']))

		$GET_limit = "limit".$_GET['limit'].'/';



   if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);



	$Customer = new Customers();

	$Customer->SetFieldsById($User->fields['id_user']);







	$klients=$Customer->SetList($User->fields['email']);

		$tpl->Assign('klient', $klients);



		//print_r($User->fields['email']);

	//$Customer->SetList();

        //$tpl->Assign("customer", $Customer);

		//print_r($Customer);



















	$tpl->Assign('sort_links', $sort_links);









	// Список заказов



	$orders = $Customer->GetOrders_m_diler($orderby);

$tpl->Assign('orders', $orders);

		//print_r($orders);die();



	$Order = new Orders();

	$order_statuses = $Order->GetStatuses();

$tpl->Assign('order_statuses', $order_statuses);



$parsed_res = array('issuccess' => TRUE, 'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_m_diler_cab.tpl'));



?>