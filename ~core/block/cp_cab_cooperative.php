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

$promo = 'aaa';
if($promo) {
    $Cart = new Cart();
    $infoCarts = $Cart->GetInfoForPromo('aaa');
    if ($infoCarts) {
        foreach ($infoCarts as &$infoCart) {
            switch ($infoCart['status']) {
                case 20:
                    $infoCart['title_status'] = "<div style='color: #FAA523;'>" . $infoCart['title_stat'] . "</div>";
                    break;
                case 21:
                    $infoCart['title_status'] = "<div style='color: #1DC300;'>" . $infoCart['title_stat'] . "</div>";
                    break;
                default:
                    $infoCart['title_status'] = "<div>" . $infoCart['title_stat'] . "</div>";
            }
        }
    }
    $tpl->Assign('infoCarts', $infoCarts);

    $productsFromCarts = $Cart->GetCartForPromo($promo);
    $tpl->Assign('prodsCarts', $productsFromCarts);

	$details = array(); $sum_prods = 0;
	foreach($productsFromCarts as $prod){
		$sum_prods += $prod['sum_prod'];// общая сумма в корзине по всем заказам
	};
	$details['sum_prods'] = number_format($sum_prods,2,',','');
	if ($details['sum_prods'] > 0 && $details['sum_prods'] <= 500) {
		$details['discount'] = 0;
	}elseif($details['sum_prods'] > 500 && $details['sum_prods'] <= 3000){
		$details['discount'] = 10;
	}elseif($details['sum_prods'] > 3000 && $details['sum_prods'] < 10000){
		$details['discount'] = 16;
	}elseif($details['sum_prods'] >= 10000){
		$details['discount'] = 21;
	}

	$tpl->Assign('details', $details);
//		print_r($infoCarts);
//		var_dump($productsFromCarts);

}



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

$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_cooperative.tpl')
);

//


?>