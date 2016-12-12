<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/agent/'
);

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}
if(isset($_REQUEST['confirm_agent']) && !G::isAgent() && $Users->ConfirmAgent()){
	header('Location: '.Link::Custom('cabinet', 'agent', array('clear' => true)));
}

$orders = $Users->GetAgentInfo($_SESSION['member']['id_user']);
foreach($orders as $order){
	if($order['id_order_status'] == 2){
		if(!isset($history[date('d.m.Y', $order['creation_date'])]['orders_sum'])){
			$history[date('d.m.Y', $order['creation_date'])]['orders_sum'] = $order['sum_discount'];
		}else{
			$history[date('d.m.Y', $order['creation_date'])]['orders_sum'] += $order['sum_discount'];
		}
	}
	$history[date('d.m.Y', $order['creation_date'])]['orders'][] = $order;
}
krsort($history);
$tpl->Assign('history', $history);
$tpl->Assign('msg', array('type' => 'info', 'text' => 'Бонус начисляется только при условии успешного выполнения и рассчитывается с фактической суммы заказа.'));

$Users->SetUser($_SESSION['member']);
$tpl->Assign('User', $Users->fields);

$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_agent.tpl')
);