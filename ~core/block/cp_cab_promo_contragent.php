<?php
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][1]['title'] = "История заказов";
if(isset($_POST['id_order']) && !empty($_POST['id_order'])){
	$id_order = intval($_POST['id_order']);
}
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
$Order = new Orders();
if(isset($id_order)){
	$Order->SetFieldsById($id_order);
}
if(isset($_POST['smb_off'])){
	if($Order->OffUserOrder($id_order)){
		$tpl->Assign('msg', 'Заказ отменен контрагентом.');
		unset($_POST);
	}else{
		$tpl->Assign('msg', 'Информация не обновлена.');
	}
}
$fields = array('creation_date', 'target_date', 'id_order', 'status', 'pretense', 'pretense_status', 'return', 'return_status');
$f_assoc = array('creation_date'=>'o.creation_date', 'target_date'=>'o.target_date', 'id_order'=>'o.id_order', 'status'=>'o.id_order_status',
	'pretense'=>'o.id_pretense_status', 'pretense_status'=>'o.id_pretense_status',
	'return'=>'o.id_return_status', 'return_status'=>'o.id_return_status');
$orderby = "o.id_order desc";
$sort_links = array();
$GET_limit = "";
if(isset($_GET['limit'])){
	$GET_limit = "limit".$_GET['limit'].'/';
}
$tpl->Assign('sort_links', $sort_links);
$orders = $Customer->GetPromoOrders();
$tpl->Assign('orders', $orders);
$order_statuses = $Order->GetStatuses();
$User->SetUser($_SESSION['member']);
$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$tpl->Assign('order_statuses', $order_statuses);
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_promo_cab.tpl')
);
