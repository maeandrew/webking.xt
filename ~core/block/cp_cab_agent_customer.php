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

$Orders = new Orders();
$orders = $Users->GetAgentInfo($_SESSION['member']['id_user']);
$total_bonus = 0;
$percents = explode(';', $GLOBALS['CONFIG']['agent_bonus_percent']);
if(!empty($orders)){
	foreach($orders as &$order){
		$list = $Orders->GetOrderForCustomer(array('o.id_order' => $order['id_order']));
		$order['agent_total'] = 0;
		foreach($list as &$p){
			if($p['promo'] == 0){
				if($p['opt_qty'] > 0 ){
					$order['agent_total'] += (($p['contragent_qty']<=0?0:$p['contragent_qty'])-$p['return_qty'])*$p['site_price_opt'];
				}else{
					$order['agent_total'] += (($p['contragent_mqty']<=0?0:$p['contragent_mqty'])-$p['return_mqty'])*$p['site_price_mopt'];
				}
			}
		}
		if($order['agent_total'] < 1000){
			$coeff = $percents[0]*0.01;
		}elseif($order['agent_total'] < 5000){
			$coeff = $percents[1]*0.01;
		}elseif($order['agent_total'] < 10000){
			$coeff = $percents[2]*0.01;
		}else{
			$coeff = $percents[3]*0.01;
		}
		$order['agent_counted'] = round($order['agent_total']*$coeff, 2);
		if($order['id_order_status'] == 2){
			if(!isset($history[date('d.m.Y', $order['creation_date'])]['orders_sum'])){
				$history[date('d.m.Y', $order['creation_date'])]['orders_sum'] = $order['agent_counted'];
			}else{
				$history[date('d.m.Y', $order['creation_date'])]['orders_sum'] += $order['agent_counted'];
			}
			$total_bonus += $order['agent_counted'];
		}
		$history[date('d.m.Y', $order['creation_date'])]['orders'][$order['creation_date']] = $order;
	}
	krsort($history);
	foreach($history as &$action){
		krsort($action['orders']);
	}
	$tpl->Assign('history', $history);
}
$tpl->Assign('total_bonus', $total_bonus);
$agent_users = $Users->GetUsersByAgent($_SESSION['member']['id_user']);
$tpl->Assign('agent_users', $agent_users);
$tpl->Assign('msg', array('type' => 'info', 'text' => 'Бонус начисляется только при условии успешного выполнения и рассчитывается с фактической суммы заказа.'));

if(isset($_GET['t']) && $_GET['t'] == 'agent_gifts'){
	if(!empty($gifts = $Products->GetGiftsList())){
		foreach($gifts as &$gift){
			$gift['images'] = $Products->GetPhotoById($gift['id_product']);
		}
		$tpl->Assign('gifts', $gifts);
	}
	if(empty($selected_gifts = $Products->GetGiftsList('AG'.$_SESSION['member']['id_user']))){
		$selected_gifts = array();
	}else{
		foreach($selected_gifts as &$selected_gift){
			$selected_gift = $selected_gift['id_product'];
		}
	}
	$tpl->Assign('selected_gifts', $selected_gifts);
}

$Users->SetUser($_SESSION['member']);
$tpl->Assign('User', $Users->fields);
$tpl->Assign('content', $tpl->Parse($GLOBALS['PATH_tpl_global'].'cab_'.(isset($_GET['t'])?$_GET['t']:'agent_history').'.tpl'));
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_agent.tpl')
);