<?php
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Кабинет";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cabinet/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])){
	$id_order = intval($_POST['id_order']);
}
$Contragent = new Contragents();
$GET_limit = "";
if(isset($_GET['limit']))
	$GET_limit = "limit".$_GET['limit'].'/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);

$Order = new Orders();
if(isset($_POST['change_client'])){
	$Order->SetNote_diler($_POST['order'], $_POST['client']);
}
if(isset($_POST['change_status'])){
	$Order->UpdateStatus($_POST['order'], $_POST['status'], isset($_POST['target_date'])?$_POST['target_date']:null);
}
if(isset($_POST['target'])){
	$target = $_POST['target'];
}else{
	$target = 100;
}
$Customer = new Customers();
$Customer->SetFieldsById($Users->fields['id_user']);
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

$tpl->Assign('current_customer', $Customer->fields);
$klients = $Customer->SetList($Users->fields['email']);
$tpl->Assign('klient', $klients);
$Contragent->SetFieldsById($Users->fields['id_user']);
$tpl->Assign("contragent", $Contragent->fields);


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

// Пагинатор ===============================================
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all' && !is_array($mass)) || !isset($_GET['limit'])){
	if(isset($GLOBALS['Page_id']) && is_numeric($GLOBALS['Page_id'])){
		$_GET['page_id'] = $GLOBALS['Page_id'];
	}
	$cnt = count($orders);
	$tpl->Assign('cnt', $cnt);
	$tpl->Assign('pages_cnt', ceil($cnt/$GLOBALS['Limit_db']));

	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	unset($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
// =========================================================


// Список заказов

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$orders = $Contragent->GetContragentOrdersByClient($orderby, $target, $Users->fields['id_user'], $GLOBALS['REQAR'][1], $limit);
	$tpl->Assign('filtered_client', $GLOBALS['REQAR'][1]);
}else{
	$orders = $Contragent->GetContragentOrders($orderby, $target, $Users->fields['id_user'], $limit, $order_number);
}
$Contragent->SetFieldsById($Users->fields['id_user']);
$tpl->Assign('contragent', $Contragent->fields);

$orders = $Customer->GetOrders($orderby);
$tpl->Assign('orders', $orders);

$tpl->Assign('current', $Users->fields);
$customers = $Customer->GetCustomersByContragent($Users->fields['id_user']);
$tpl->Assign('customers', $customers);

$order_statuses = $Order->GetStatuses();
$User->SetUser($_SESSION['member']);
$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$tpl->Assign('SavedCity', $SavedCity->fields);
$tpl->Assign('SavedContragent', $SavedContragent->fields);
$tpl->Assign('DeliveryMethod', $DeliveryMethod->list);
$tpl->Assign('SavedDeliveryMethod', $SavedDeliveryMethod->fields);
$tpl->Assign('order_statuses', $order_statuses);

$remitters = $Contragent->GetRemitterById($id);
$tpl->Assign('remitters', $remitters);

if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_promo_cab.tpl'));
}else{
	$parsed_res = array(
		'issuccess' => true,
		'html' => $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_cab_orders.tpl')
	);
}
?>