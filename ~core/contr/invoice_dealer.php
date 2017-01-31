<?php
unset($parsed_res);
require($GLOBALS['PATH_model'].'invoice_c.php');
$GLOBALS['__page_title'] = $GLOBALS['__page_description'] = $GLOBALS['__page_keywords'] = 'Накладная';

$Invoice = new Invoice();
$Orders = new Orders();
$Address = new Address();
$percents = explode(';', $GLOBALS['CONFIG']['agent_bonus_percent']);
if(isset($_REQUEST['orders'])){
	$orders = array();
	foreach($_REQUEST['orders'] as $id_order){
		// Проверяем наличие заказа в БД
		if($Orders->SetFieldsById($id_order)){

			$dealers[0]['orders'][$id_order] = $Orders->fields;
			$Customers->SetFieldsById($Orders->fields['id_customer']);
			$dealers[0]['orders'][$id_order]['customer'] = $Customers->fields;
			$dealers[0]['orders'][$id_order]['agent_total'] = 0;
			// получаем данные об адресе доставки
			$dealers[0]['orders'][$id_order]['address'] = $Address->GetAddressById($Orders->fields['id_address']);
			var_dump($dealers[0]['orders'][$id_order]['address']);

			// получаем список товаров каждого заказа
			$dealers[0]['orders'][$id_order]['products'] = $Invoice->GetOrderData($id_order);
			foreach($dealers[0]['orders'][$id_order]['products'] as &$p){
				$p['images'] = $Products->GetPhotoById($p['id_product']);
				if($p['promo'] == 0){
					if($p['opt_qty'] > 0){
						$p['agent_total'] = ($p['contragent_qty']<=0?0:$p['contragent_qty'])*$p['site_price_opt'];
					}else{
						$p['agent_total'] = ($p['contragent_mqty']<=0?0:$p['contragent_mqty'])*$p['site_price_mopt'];
					}
				}else{
					$p['agent_total'] = 0;
				}
				$dealers[0]['orders'][$id_order]['agent_total'] += $p['agent_total'];
				if(isset($dealers[0]['products'][$p['id_product']])){
					$dealers[0]['products'][$p['id_product']]['contragent_qty'] += $p['contragent_qty'];
					$dealers[0]['products'][$p['id_product']]['contragent_mqty'] += $p['contragent_mqty'];
				}else{
					$dealers[0]['products'][$p['id_product']] = $p;
				}
			}
			if($dealers[0]['orders'][$id_order]['agent_total'] < 1000){
				$coeff = $percents[0]*0.01;
			}elseif($dealers[0]['orders'][$id_order]['agent_total'] < 5000){
				$coeff = $percents[1]*0.01;
			}elseif($dealers[0]['orders'][$id_order]['agent_total'] < 10000){
				$coeff = $percents[2]*0.01;
			}else{
				$coeff = $percents[3]*0.01;
			}
			$dealers[0]['orders'][$id_order]['coeff'] = $coeff;
			$dealers[0]['orders'][$id_order]['agent_counted'] = round($dealers[0]['orders'][$id_order]['agent_total']*$coeff, 2);
		}
	}
	$tpl->Assign('dealers', $dealers);
}




$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_dealer.tpl');