<?php
$title = "Кабинет терминального клиента";
$tpl->Assign('h1', $title);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][1]['title'] = $title;
$GLOBALS['IERA_LINKS'][1]['url'] =  _base_url.'/cabinet/';
$no_tpl = '';
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
$fields = array('date', 'id_order', 'status');
$f_assoc = array('date'=>'o.creation_date', 'id_order'=>'o.id_order', 'status'=>'o.id_order_status');
$orderby = "o.id_order desc";
// Список заказов
$orders = $Customer->GetOrdersTerminal($orderby);
if(!$no_tpl){
	$tpl->Assign('orders', $orders);
}
$Order = new Orders();
$order_statuses = $Order->GetStatuses();
if(!$no_tpl){
	$tpl->Assign('order_statuses', $order_statuses);
}
if(!$no_tpl){
	$parsed_res = array('issuccess' => TRUE,
						'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_terminal_cab.tpl'));
}?>