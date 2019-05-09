<?php
unset($parsed_res);
$GLOBALS['__page_title'] = $GLOBALS['__page_description'] = $GLOBALS['__page_keywords'] = 'Накладная';
$Invoice = new Invoice();
$Orders = new Orders();
$Address = new Address();
if(isset($_REQUEST['orders'])){
	$orders = array();
	foreach($_REQUEST['orders'] as $id_order){
		// Проверяем наличие заказа в БД
		if($Orders->SetFieldsById($id_order)){
			$dealers[0]['orders'][$id_order] = $Orders->fields;
			$Customers->SetFieldsById($Orders->fields['id_customer']);
			$dealers[0]['orders'][$id_order]['customer'] = $Customers->fields;
			$dealers[0]['orders'][$id_order]['agent_total'] = 0;
			$dealers[0]['orders'][$id_order]['sum_total'] = 0;
			$Customers->SetFieldsById($_REQUEST['dealer'][0], 1, true);
			$tpl->Assign('dealer_info', $Customers->fields);
			// получаем данные об адресе доставки
			$dealers[0]['orders'][$id_order]['address'] = $Address->GetAddressById($Orders->fields['id_address']);
			// получаем список товаров каждого заказа
			$dealers[0]['orders'][$id_order]['products'] = $Invoice->GetOrderData($id_order);
			//Вибераем 
			$coeff = 3;
			if($Orders->fields['sum_discount'] > $GLOBALS['CONFIG']['retail_order_margin']){
				$coeff = 2;
			}
			if($Orders->fields['sum_discount'] > $GLOBALS['CONFIG']['wholesale_order_margin']){
				$coeff = 1;
			}
			if($Orders->fields['sum_discount'] > $GLOBALS['CONFIG']['full_wholesale_order_margin']){
				$coeff = 0;
			}
			$order['amount'] = $order['agent_counted'] = 0;
			foreach($dealers[0]['orders'][$id_order]['products'] as &$p){	
				if($p['contragent_qty'] > 0 ){
					$p['price_prod'] = ($p['site_price_opt']>0?$p['site_price_opt']:$p['site_price_mopt']);
					$p['sum_prod'] = $p['price_prod']*$p['contragent_qty'];					
					$agent_profits = explode(';', $p['agent_profits']);
					$n_agent_profits = count($agent_profits);
					if($n_agent_profits == 8) {
						if($p['contragent_qty']>= $p['inbox_qty']) {
							$p['agent_bonus']  =$agent_profits[$coeff];
							$p['agent_prod'] = $p['contragent_qty']*$agent_profits[$coeff];
							$p['qty'] = $p['contragent_qty'];
						}else{
							$p['agent_bonus'] = $agent_profits[$coeff+4];
							$p['agent_prod'] = ($p['contragent_qty']<=0?0:$p['contragent_qty'])*$agent_profits[$coeff+4];
							$p['qty'] = ($p['contragent_qty']<=0?0:$p['contragent_qty']);
						}		
					}					
				}
				if($p['contragent_mqty'] > 0 ){					
					$p['price_prod'] = ($p['site_price_mopt']>0?$p['site_price_mopt']:$p['site_price_opt']);
					$p['sum_prod'] = $p['price_prod'] * $p['contragent_mqty'];
					$agent_profits = explode(';', $p['agent_profits']);	
					$n_agent_profits_mqty = count($agent_profits);
					if($n_agent_profits_mqty == 8) {
						if ($p['contragent_mqty']>= $p['inbox_qty']) {
							$p['agent_bonus'] = $agent_profits[$coeff];
							$p['agent_prod'] = $p['contragent_mqty']*$agent_profits[$coeff];
							$p['qty'] = $p['contragent_mqty'];
						}else{
							$p['agent_bonus'] = $agent_profits[$coeff+4];
							$p['agent_prod'] = ($p['contragent_mqty']<=0?0:$p['contragent_mqty'])*$agent_profits[$coeff+4];
							$p['qty'] = ($p['contragent_mqty']<=0?0:$p['contragent_mqty']);
						}
					}		
				}
				if(!isset($p['qty'])){
					$p['qty'] = 0;
					$p['agent_bonus'] = '';
					$p['agent_prod'] = '';
					$p['price_prod'] = '';
					$p['sum_prod'] = '';
				}

				$dealers[0]['orders'][$id_order]['agent_total'] += $p['agent_prod'];
				$dealers[0]['orders'][$id_order]['sum_total'] += $p['sum_prod'];
			}	
		}
	}

	$tpl->Assign('dealers', $dealers);
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_agent.tpl');