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
if(!empty($orders)){
	foreach($orders as &$order){
		$list = $Orders->GetOrderForCustomer(array('o.id_order' => $order['id_order']));
			$coeff = 3;
		if($order['sum_discount'] > $GLOBALS['CONFIG']['retail_order_margin']){
			$coeff = 2;
		}
		if($order['sum_discount'] > $GLOBALS['CONFIG']['wholesale_order_margin']){
			$coeff = 1;
		}
		if($order['sum_discount'] > $GLOBALS['CONFIG']['full_wholesale_order_margin']){
			$coeff = 0;
		}
		$order['amount'] = $order['agent_counted'] = 0;
		foreach($list as &$p){	
				if($p['contragent_qty'] > 0 ){
					$order['amount'] += ($p['site_price_opt']>0?$p['contragent_qty']*$p['site_price_opt']:$p['contragent_qty']*$p['site_price_mopt']);
					if(!empty($p['agent_profits']) && $order['id_order_status'] == 2){
						$agent_profits = explode(';', $p['agent_profits']);
						$n_agent_profits = count($agent_profits);
						if($n_agent_profits == 8) {
							if($p['contragent_qty']>= $p['inbox_qty']) {
								$order['agent_counted']+=$p['contragent_qty']*$agent_profits[$coeff];
							}else{
								$order['agent_counted']+=(($p['contragent_qty']<=0?0:$p['contragent_qty']))*$agent_profits[$coeff+4];
							}		
						}					
					}
				}
				if($p['contragent_mqty'] > 0 ){
					$order['amount'] += ($p['site_price_mopt']>0?$p['contragent_mqty']*$p['site_price_mopt']:$p['contragent_mqty']*$p['site_price_opt']);
					if(!empty($p['agent_profits']) && $order['id_order_status'] == 2){
						$agent_profits = explode(';', $p['agent_profits']);	
						$n_agent_profits_mqty = count($agent_profits);
						if($n_agent_profits_mqty == 8) {
							if ($p['contragent_mqty']>= $p['inbox_qty']) {
								$order['agent_counted']+=$p['contragent_mqty']*$agent_profits[$coeff];
							}else{
								$order['agent_counted']+=(($p['contragent_mqty']<=0?0:$p['contragent_mqty']))*$agent_profits[$coeff+4];
							}
						}		
					}
				}
		}	
		$order['type'] = 'order';
		if($order['id_order_status'] == 2){
			if(!isset($history[strtotime(date('d.m.Y', $order['creation_date']))]['date_sum'])){
				$history[strtotime(date('d.m.Y', $order['creation_date']))]['date_sum'] = $order['agent_counted'];
			}else{
				$history[strtotime(date('d.m.Y', $order['creation_date']))]['date_sum'] += $order['agent_counted'];
			}
			$total_bonus += $order['agent_counted'];
		}else{

		}
		$history[strtotime(date('d.m.Y', $order['creation_date']))]['actions'][$order['creation_date']] = $order;
	}
}
$withdrawals = $Users->GetAgentWithdrawals($_SESSION['member']['id_user']);
if(!empty($withdrawals)){
	foreach ($withdrawals as $withdrawal){
		$withdrawal['type'] = 'withdrawal';
		if(!isset($history[strtotime(date('d.m.Y', strtotime($withdrawal['date'])))]['date_sum'])){
			$history[strtotime(date('d.m.Y', strtotime($withdrawal['date'])))]['date_sum'] = -$withdrawal['amount'];
		}else{
			$history[strtotime(date('d.m.Y', strtotime($withdrawal['date'])))]['date_sum'] -= $withdrawal['amount'];
		}
		$total_bonus -= $withdrawal['amount'];
		$history[strtotime(date('d.m.Y', strtotime($withdrawal['date'])))]['actions'][$withdrawal['date']] = $withdrawal;
	}
}

if(!empty($history)){
	krsort($history);
	foreach($history as &$action){
		krsort($action['actions']);

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