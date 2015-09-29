<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/'
);
$tpl->Assign('header', $header);
$no_tpl = '';
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);

// Список заказов
$orders = $Customer->GetOrders_demo();
if(!$no_tpl){
	$tpl->Assign('orders', $orders);
}
$Order = new Orders();
$order_statuses = $Order->GetStatuses();
if(!$no_tpl){
	$tpl->Assign('order_statuses', $order_statuses);
}
if(!$no_tpl){
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_anonim_cab.tpl')
	);
}?>