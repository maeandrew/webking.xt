<?php
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Кабинет";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cabinet/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])){
	$id_order = intval($_POST['id_order']);
}
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
$SavedCity = new Citys();
$SavedCity->GetSavedFields($Customer->fields['id_city']);
$SavedContragent = new Contragents();
$SavedContragent->GetSavedFields($Customer->fields['id_contragent']);
$DeliveryMethod = new Delivery();
$DeliveryMethod->SetDeliveryList();
$SavedDeliveryMethod = new Delivery();
$SavedDeliveryMethod->GetSavedFields($Customer->fields['id_delivery']);
$Region = new Regions();
if($Region->SetList()){
	$tpl->Assign('regions', $Region->list);
}
$City = new Citys();
if($City->SetList()){
	$tpl->Assign('citys', $City->list);
}
$Contragent = new Contragents();
if($Contragent->GetContragentList()){
	$tpl->Assign('manager', $Contragent->GetContragentList());
}
$DeliveryService = new DeliveryService();
$Deliverys = new Delivery();
if(isset($SavedCity->fields)){
	if($DeliveryService->SetListByRegion($SavedCity->fields['names_regions'])){
		$tpl->Assign('delivery_services', $DeliveryService->list);
	}
	if($Deliverys->SetFieldsByInput($SavedCity->fields['shipping_comp'], $SavedCity->fields['names_regions'])){
		$tpl->Assign('delivery', $Deliverys->list);
	}
}else{
	if($DeliveryService->SetList()){
		$tpl->Assign('delivery_services', $DeliveryService->list);
	}
	if($Deliverys->SetList()){
		$tpl->Assign('delivery', $Deliverys->list);
	}
}
if(isset($_POST['apply'])){
	$Customer -> updateContPerson($_POST['cont_person']);
	$Customer -> updatePhones($_POST['phones']);
	$Customer -> updateContragent($_POST['id_manager']);
	$Customer -> updateCity($_POST['id_delivery_department']);
	$Customer -> updateDelivery($_POST['id_delivery']);
	$Customer -> updateBonus($_POST['bonus_card'], $_POST['sex'], $_POST['learned_from'], $_POST['birthday'], $_POST['buy_volume']);
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
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
$ii = count($GLOBALS['IERA_LINKS'])-1;
foreach($fields as $f){
	$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
	if(in_array("ord", $GLOBALS['REQAR']) && in_array($f, $GLOBALS['REQAR'])){
		if(in_array("asc", $GLOBALS['REQAR'])){
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
			$orderby = "{$f_assoc[$f]} asc";
		}else{
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/asc";
			$orderby = "{$f_assoc[$f]} desc";
		}
	}
}
$tpl->Assign('sort_links', $sort_links);


if(isset($_POST['show_order'])){
	$order_number = ' AND o.id_order = '.$_POST['order_number'];
} else {
	$order_number = '';
}

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$orders = $Contragent->GetContragentOrdersByClient($orderby, $target, $Users->fields['id_user'], $GLOBALS['REQAR'][1]);
}else{
	$orders = $Contragent->GetContragentOrders($orderby, $target, $Users->fields['id_user'], false, $order_number);
}


// Список заказов

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$orders = $Contragent->GetContragentOrdersByClient($orderby, $target, $Users->fields['id_user'], $GLOBALS['REQAR'][1], $limit);
	$tpl->Assign('filtered_client', $GLOBALS['REQAR'][1]);
}else{
	$orders = $Contragent->GetContragentOrders($orderby, $target, $Users->fields['id_user'], $limit, $order_number);
}

$orders = $Customer->GetOrders($orderby);
$tpl->Assign('orders', $orders);
$order_statuses = $Order->GetStatuses();
$User->SetUser($_SESSION['member']);
$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$tpl->Assign('SavedCity', $SavedCity->fields);
$tpl->Assign('SavedContragent', $SavedContragent->fields);
$tpl->Assign('DeliveryMethod', $DeliveryMethod->list);
$tpl->Assign('SavedDeliveryMethod', $SavedDeliveryMethod->fields);
$tpl->Assign('order_statuses', $order_statuses);
if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_promo_cab.tpl'));
}else{
	$parsed_res = array(
		'issuccess' => true,
		'html' => $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_cab.tpl')
	);
}
?>