<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/orders/'
);

// Настройка панели действий ===============================
$list_controls = array('layout', 'sorting', 'filtering');
$tpl->Assign('list_controls', $list_controls);
// =========================================================

if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}

$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);

$Order = new Orders();
if(isset($id_order)){
	$Order->SetFieldsById($id_order);
}

if(isset($_POST['smb_cancel'])){
	if($Order->CancelCustomerOrder($id_order)){
		 $tpl->Assign('msg', 'Заказ отменен.');
		 unset($_POST);
	}else{
		 $tpl->Assign('msg', 'Информация не обновлена.');
	}
}
if(isset($_POST['smb_off'])){
	if($Order->OffUserOrder($id_order)){
		$tpl->Assign('msg', 'Заказ отменен контрагентом.');
		unset($_POST);
	}else{
		$tpl->Assign('msg', 'Информация не обновлена.');
	}
}

// Сортировка ==============================================
if(!isset($sorting)){
	$sorting = array(
		'value' => 'id_order',
		'direction' => 'desc'
	);
	// $mc->set('sorting', array($GLOBALS['CurrentController'] => $sorting));
	setcookie('sorting', json_encode(array($GLOBALS['CurrentController'] => $sorting)), time()+3600*24*30, '/');
}
$orderby = 'o.'.$sorting['value'].' '.$sorting['direction'];
$available_sorting_values = array(
	'id_order'				=> 'по номеру заказа',
	'creation_date'			=> 'по дате',
	'id_order_status'		=> 'по статусу'
);
$tpl->Assign('sorting', $sorting);
$tpl->Assign('available_sorting_values', $available_sorting_values);
// =========================================================

// Фильтрация ==============================================
if(!isset($filters)){
	$filters[] = 'all';
}
$available_filter_values = array(
	'group1'	=>	array(
		'all'		=>	'Все',
		'working'	=>	'Выполняются',
		'completed'	=>	'Выполенные',
		'canceled'	=>	'Отмененные',
		'drafts'	=>	'Черновики'
	)
);
$tpl->Assign('available_filter_values', $available_filter_values);
$tpl->Assign('filters', $filters);
// =========================================================

$status ='';
if (isset($_GET['t']) && !empty($_GET['t']) ){
	switch($_GET['t']){
		case 'working':
			$status = ' AND id_order_status IN (1,6)';
			break;
		case 'completed':
			$status = ' AND id_order_status = 2';
			break;
		case 'canceled':
			$status = ' AND id_order_status IN (5,4)';
			break;
		case 'drafts':
			$status = ' AND id_order_status = 3';
			break;
		default:
			$status= false;
			break;
	}
}

$fields = array('creation_date', 'target_date', 'id_order', 'status', 'pretense', 'pretense_status', 'return', 'return_status');
$f_assoc = array(
	'creation_date'		=>'o.creation_date',
	'target_date'		=>'o.target_date',
	'id_order'			=>'o.id_order',
	'status'			=>'o.id_order_status',
	'pretense'			=>'o.id_pretense_status',
	'pretense_status'	=>'o.id_pretense_status',
	'return'			=>'o.id_return_status',
	'return_status'		=>'o.id_return_status'
);

$GET_limit = "";
if(isset($_GET['limit'])){
	$GET_limit = "limit ".$_GET['limit'].'/';
}

// if(isset($_GET['filter'])){
// 	$mc->set("filters", array($_GET['q']=>$_GET['filter']));
// }else{
// 	if(!isset($mc->get("filters")[$_GET['q']])){
// 		$mc->set("filters", array($_GET['q']=>'all'));
// 	}
// }
// Список заказов
$GLOBALS['Limit_db'] = 10; // кол-во заказов на одной странице
$cnt = count($Customer->GetOrders( false, false, $status));
$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
// print_r(' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db']);
// die();
$limit = isset($GLOBALS['Start'])?(' LIMIT '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db']):"";
// var_dump($limit);
$orders = $Customer->GetOrders($orderby, $limit, $status);
// die();
$order_statuses = $Order->GetStatuses();

$Contragent = new Contragents();
$Address = new Address();
foreach ($orders as &$order) {
	$Order->SetFieldsById($order['id_order']);
	$Contragent->SetFieldsById($Order->fields['id_contragent']);
	$order['contragent_info'] = $Contragent->fields;
	$order['address_info'] = $Address->getAddressOrder($order['id_order']);
}
$Citys = new Citys();
foreach ($orders as &$order) {
	$Order->SetFieldsById($order['id_order']);

	$Citys->SetFieldsById($Order->fields['id_city']);
	$order['city_info'] = $Citys->fields;

	$order['products'] = $Order->GetOrderForCustomer(array("o.id_order" => $order['id_order']));
}
$tpl->Assign('orders', $orders);

$address_list = $Address->GetListByUserId($User->fields['id_user']);
$tpl->Assign('address_list', $address_list);

/*$arr = array();
foreach($orders as &$order_2){
	$arr = $Order->GetOrderForCustomer(array("o.id_order" => $order_2['id_order']));
}*/

//$tpl->Assign('products', $arr);
$tpl->Assign('msg', array('type' => 'info', 'text' => 'Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").'));
$tpl->Assign('msg_address', array('type' => 'info', 'text' => 'В данном заказе отсутствует адрес доставки. Вы можете выбрать его выше.'));

$User->SetUser($_SESSION['member']);

$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$tpl->Assign('order_statuses', $order_statuses);

$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders.tpl')
);
?>