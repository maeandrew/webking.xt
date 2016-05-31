<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/orders/'
);
G::metaTags();

// Настройка панели действий ===============================
$list_controls = array('layout', 'sorting', 'filtering');
$tpl->Assign('list_controls', $list_controls);
// =========================================================
$Cart = new Cart();

if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}


if(isset($_GET['t']) && !empty($_GET['t']) && ($_GET['t'] == 'joactive' || $_GET['t'] == 'jocompleted')){
	$infoJO = $Cart->GetInfoJO($_GET['t']);
}
if($infoJO){
	if (isset($infoJO) && is_array($infoJO)){
		foreach($infoJO as &$prod){
			$prod['sum_prods'] = 0;
			foreach($prod['productsFromCarts'] as $v){
				$prod['sum_prods'] += $v['sum_prod'];// общая сумма в корзине по всем заказам
			}
			$prod['sum_prods'] = number_format($prod['sum_prods'],2,',','');
			if ($prod['sum_prods'] > 0 && $prod['sum_prods'] <= 500) {
				$prod['discount'] = 0;
			}elseif($prod['sum_prods'] > 500 && $prod['sum_prods'] <= 3000){
				$prod['discount'] = 10;
			}elseif($prod['sum_prods'] > 3000 && $prod['sum_prods'] < 10000){
				$prod['discount'] = 16;
			}elseif($prod['sum_prods'] >= 10000){
				$prod['discount'] = 21;
			}
		};
	}
	$tpl->Assign('infoJO', $infoJO);
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
	setcookie('sorting', serialize(array($GLOBALS['CurrentController'] => $sorting)), time()+3600*24*30, '/');
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
$orders = $Customer->GetOrders($orderby);
$order_statuses = $Order->GetStatuses();
//print_r($orders);

$Contragent = new Contragents();
foreach ($orders as &$order) {
	$Order->SetFieldsById($order['id_order']);

	$Contragent->SetFieldsById($Order->fields['id_contragent']);
	$order['contragent_info'] = $Contragent->fields;
}
$Citys = new Citys();
foreach ($orders as &$order) {
	$Order->SetFieldsById($order['id_order']);

	$Citys->SetFieldsById($Order->fields['id_city']);
	$order['city_info'] = $Citys->fields;

	$order['products'] = $Order->GetOrderForCustomer(array("o.id_order" => $order['id_order']));
}
$tpl->Assign('orders', $orders);

/*$arr = array();
foreach($orders as &$order_2){
	$arr = $Order->GetOrderForCustomer(array("o.id_order" => $order_2['id_order']));
}*/

//$tpl->Assign('products', $arr);

$User->SetUser($_SESSION['member']);

$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$tpl->Assign('order_statuses', $order_statuses);

$tpl->Assign('prod_list', $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl'));

$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_cooperative.tpl')
);

//


?>