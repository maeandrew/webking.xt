<?php
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Кабинет";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cabinet/';

$GET_limit = "";
if (isset($_GET['limit']))
	$GET_limit = "limit".$_GET['limit'].'/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);

$Order = new Orders();

if(isset($_POST['id_klient'])){
	$Order->SetNote_diler($_POST['id_order'], $_POST['id_klient']);
}

$Customer = new Customers();

$Customer->SetFieldsById($User->fields['id_user']);

$klients=$Customer->SetList($User->fields['email']);

$tpl->Assign('klient', $klients);

$fields = array('date', 'id_order', 'status', 'pretense', 'pretense_status', 'return', 'return_status', 'note');
$f_assoc = array('date'=>'o.creation_date', 'id_order'=>'o.id_order', 'status'=>'o.id_order_status',
				 'pretense'=>'o.id_pretense_status', 'pretense_status'=>'o.id_pretense_status',
				 'return'=>'o.id_return_status', 'return_status'=>'o.id_return_status', 'customer'=>'u.id_user');
$orderby = "o.creation_date desc, o.id_order desc";
$sort_links = array();

$ii = count($GLOBALS['IERA_LINKS'])-1;

foreach ($fields as $f){
	$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
	if (in_array("ord", $GLOBALS['REQAR']) && in_array($f, $GLOBALS['REQAR'])){
		if (in_array("asc", $GLOBALS['REQAR'])){
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
			$orderby = "{$f_assoc[$f]} asc";
		}else{
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/asc";
			$orderby = "{$f_assoc[$f]} desc";
		}
	}
}

$tpl->Assign('sort_links', $sort_links);

// Список заказов
$orders = $Customer->GetOrders_diler($orderby);
$tpl->Assign('orders', $orders);

$order_statuses = $Order->GetStatuses();
$tpl->Assign('order_statuses', $order_statuses);

$parsed_res = array(
	'issuccess' => true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_diler_cab.tpl'));