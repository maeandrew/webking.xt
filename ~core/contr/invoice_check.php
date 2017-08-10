<?php
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1]) && !isset($GLOBALS['REQAR'][2]) && !isset($_POST['orders'])){
	header('Location: '. _base_url.'/404/');
	exit();
}
if(isset($_POST['orders']) || isset($_GET['orders'])){
	if(isset($_GET['orders'])){
		$orders = $_GET['orders']; // Получаем id контрагента
		isset($_GET['filial'])? $filial = $_GET['filial']:null;
	}else{
		$orders = $_POST['orders']; //Сюда приходит список всех задействованых заказов
	}
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');
	$Supplier = new Suppliers();
	if(isset($filial) == true){
		$tpl->Assign('filial', $Supplier->GetFilialById($filial));
	}
	$products = array();
	foreach($orders as $id_order){
		$Orders = new Orders();
		$Orders->SetFieldsById($id_order);
		$ord = $Orders->fields;
		$tpl->Assign("order", $ord);
		$Invoice = new Invoice();
		$User = new Users();
		// Получить данные покупателя
		$id_customer = $ord['id_customer'];
		$Customer = new Customers();
		$Customer->SetFieldsById($id_customer);
		// Получить данные контрагента
		$id_contragent = $ord['id_contragent'];
		$Contragent = new Contragents();
		$Contragent->SetFieldsById($id_contragent);
		$tpl->Assign("Customer", $Customer->fields);
		$tpl->Assign("Contragent", $Contragent->fields);
		$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
		$tpl->Assign("id_order", $ord['id_order']);
		$Cities = new Cities();
		$city = $Cities->SetFieldsById($ord['id_city']);
		if($ord['id_delivery'] == 1){ // самовывоз
			$addr_deliv = "Самовывоз<br>".$ord['descr'];
		}elseif($ord['id_delivery'] == 2){ // Передать автобусом
			$addr_deliv = "Передать автобусом - ".$city['names_regions']."<br>".$ord['descr'];
		}elseif($ord['id_delivery'] == 3){ // служба доставки
			$addr_deliv = "Служба доставки - ".$city['shipping_comp']."<br>".$city['names_regions']."<br>".$city['address'];
			if(isset($ord['descr'])){
				$addr_deliv.="<br>".$ord['descr'];
			}
		}
		$tpl->Assign("addr_deliv", $addr_deliv);
		$arr = $Invoice->GetOrderData($id_order);
		$tpl->Assign("sum_discount", $arr[0]['sum_discount']);
		$order2[$ord['id_order']] = array(
			'id_order' => $ord['id_order'],
			'sum' => $arr[0]['sum_discount'],
			'id_delivery' => $ord['id_delivery'],
			'ds' => $city['shipping_comp']
		);
		$positions = array();
		$Sertificates = array();
		if(empty($arr) == false){
			if($Orders->GetSuppliers($id_order)){
				$suppliers = $Orders->list;
				foreach($suppliers as $k=>&$s){
					if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
					$Orders->SetListBySupplier($s['id_supplier'], $id_order);
					$sum = 0;
					$sum_mopt = 0;
					foreach($Orders->list as $product){
						if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])
							$sum = round(($sum + $product['opt_sum']),2);
						if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])
							$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
						if($product['sertificate']!='' && $ord['need_sertificate']!=0){
							$Sertificates[] = $product['sertificate'];
						}
					}
					$suppliers[$k]['sum'] = $sum+$sum_mopt;
				}
				$i = 0;
				foreach($arr as $v){
					$v['specifications'] = $Products->GetSpecificationList($v['id_product']);
					if($v['mopt_qty'] > 0){
						$positions[$v['article_mopt']][$i] = $v;
						$positions[$v['article_mopt']][$i]['opt_qty'] = 0;
						$i++;
					}
					if($v['opt_qty'] > 0){
						$positions[$v['article']][$i] = $v;
						$positions[$v['article']][$i]['mopt_qty'] = 0;
						$i++;
					}
				}
				ksort($positions);
				$i = 0;
				$pos = array('opened'=>array(), 'closed'=>array());
				foreach($positions as $k=>&$a){
					foreach($a as &$v){
						// if($v['contragent_mqty'] > 0 || $v['contragent_qty'] > 0 || strstr($v['note_mopt'], 'Отмена#') == true || strstr($v['note_opt'], 'Отмена#') == true){
						// 	$pos['closed'][$k][$i] = $v;
						// 	$pos['closed'][$k][$i]['contragent_mqty'] = strstr($v['note_mopt'], 'Отмена#') == false ? $v['contragent_mqty'] : 0 ;
						// 	$pos['closed'][$k][$i]['contragent_qty'] = strstr($v['note_opt'], 'Отмена#') == false ? $v['contragent_qty'] : 0 ;
						// }else{
							if(!isset($order2[$ord['id_order']]['note2'])){
								$order2[$ord['id_order']]['note2'] = $v['note2'];
							}
							$pos['opened'][$k][$i] = $order2[$ord['id_order']]['invoice_data'] = $v;
						//	$pos['opened'][$k][$i]['contragent_mqty'] = -1;
						//	$pos['opened'][$k][$i]['contragent_qty'] = -1;
						// }
						$i++;
					}
				}
				$tpl->Assign('suppliers', $suppliers);
				$tpl->Assign('Sertificates', $Sertificates);
				if(!empty($pos['opened'])){
					foreach($pos as $key=>&$array){
						if(count($array) > 0){
							foreach($array as &$a){
								foreach($a as &$i){
									if($i['opt_qty'] > 0){
										if(($i['volume'] <= 0 || $i['weight'] <= 0) && !in_array($i['id_product'], $products)){
											array_push($products, $i['id_product']);
											$i['out'] = 1;
										}else{
											$i['out'] = 0;
										}
									}
									if($i['mopt_qty'] > 0){
										if(($i['volume'] <= 0 || $i['weight'] <= 0) && !in_array($i['id_product'], $products)){
											array_push($products, $i['id_product']);
											$i['out'] = 1;
										}else{
											$i['out'] = 5;
										}
									}
								}
							}
						}
					}
				}
				$tpl->Assign("products", $products);
				$tpl->Assign("arr", $pos);
				$tpl->Assign("document", $_GET['document']);
			}
			echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_check.tpl');
		}
	}
}else{
	$id_order = $GLOBALS['REQAR'][1];
	unset($parsed_res);
	require($GLOBALS['PATH_model'].'invoice_c.php');
	$Orders = new Orders();
	$Orders->SetFieldsById($id_order);
	if(!isset($_POST['orders'])){
		if($Orders->fields['skey'] != $GLOBALS['REQAR'][2]){
			echo "Доступ запрещен.";
			exit();
		}
	}
	$ord = $Orders->fields;
	$tpl->Assign("order", $ord);
	$Invoice = new Invoice();
	$User = new Users();
	// Получить данные покупателя
	$id_customer = $ord['id_customer'];
	$Customer = new Customers();
	$Customer->SetFieldsById($id_customer);
	// Получить данные контрагента
	$id_contragent = $ord['id_contragent'];
	$Contragent = new Contragents();
	$Contragent->SetFieldsById($id_contragent);
	$tpl->Assign("Customer", $Customer->fields);
	$tpl->Assign("Contragent", $Contragent->fields);
	$tpl->Assign("date", date("d.m.Y",$ord['target_date']));
	$tpl->Assign("id_order", $ord['id_order']);
	$Cities = new Cities();
	$city = $Cities->SetFieldsById($ord['id_city']);
	if($ord['id_delivery'] == 1){ // самовывоз
		$addr_deliv = "Самовывоз<br>".$ord['descr'];
	}elseif($ord['id_delivery'] == 2){ // Передать автобусом
		$addr_deliv = "Передать автобусом - ".$city['names_regions']."<br>".$ord['descr'];
	}elseif($ord['id_delivery'] == 3){ // служба доставки
		$addr_deliv = "Служба доставки - ".$city['shipping_comp']."<br>".$city['names_regions']."<br>".$city['address'];
		if(isset($ord['descr'])){
			$addr_deliv.="<br>".$ord['descr'];
		}
	}
	$tpl->Assign("addr_deliv", $addr_deliv);
	$arr = $Invoice->GetOrderData($id_order);
	$tpl->Assign("sum_discount", $arr[0]['sum_discount']);
	$order2[$ord['id_order']] = array(
		'id_order' => $ord['id_order'],
		'sum' => $arr[0]['sum_discount'],
		'id_delivery' => $ord['id_delivery'],
		'ds' => $city['shipping_comp']
	);
	$Sertificates = array();
	if($Orders->GetSuppliers($id_order)){
		$suppliers = $Orders->list;
		foreach($suppliers as $k=>&$s){
			if($s['id_supplier'] == 0) $s['name'] = "Прогноз";
			$Orders->SetListBySupplier($s['id_supplier'], $id_order);
			$sum = 0;
			$sum_mopt = 0;
			foreach($Orders->list as $product){
				if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier'])
					$sum = round(($sum + $product['opt_sum']),2);
				if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier'])
					$sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
				if($product['sertificate']!='' && $ord['need_sertificate']!=0){
					$Sertificates[] = $product['sertificate'];
				}
			}
			$suppliers[$k]['sum'] = $sum+$sum_mopt;
		}
		$i = 0;
		foreach($arr as $v){
			if($v['mopt_qty'] > 0){
				$positions[$v['article_mopt']][$i] = $v;
				$positions[$v['article_mopt']][$i]['opt_qty'] = 0;
				$i++;
			}
			if($v['opt_qty'] > 0){
				$positions[$v['article']][$i] = $v;
				$positions[$v['article']][$i]['mopt_qty'] = 0;
				$i++;
			}
		}
		ksort($positions);
		$i = 0;
		$pos = array('opened'=>array(), 'closed'=>array());
		foreach($positions as $k=>&$a){
			foreach($a as $v){
				// if($v['contragent_mqty'] > 0 || $v['contragent_qty'] > 0 || strstr($v['note_mopt'], 'Отмена#') == true || strstr($v['note_opt'], 'Отмена#') == true){
				// 	$pos['closed'][$k][$i] = $v;
				// 	$pos['closed'][$k][$i]['contragent_mqty'] = strstr($v['note_mopt'], 'Отмена#') == false ? $v['contragent_mqty'] : 0;
				// 	$pos['closed'][$k][$i]['contragent_qty'] = strstr($v['note_opt'], 'Отмена#') == false ? $v['contragent_qty'] : 0;
				// }else{
					if(!isset($order2[$ord['id_order']]['note2'])){
						$order2[$ord['id_order']]['note2'] = $v['note2'];
					}
					$pos['opened'][$k][$i] = $order2[$ord['id_order']]['invoice_data'] = $v;
				//	$pos['opened'][$k][$i]['contragent_mqty'] = -1;
				//	$pos['opened'][$k][$i]['contragent_qty'] = -1;
				// }
				$i++;
			}
		}
		$tpl->Assign('suppliers', $suppliers);
		$tpl->Assign('Sertificates', $Sertificates);
		$tpl->Assign("arr", $pos);
		$tpl->Assign("document", $_GET['document']);
	}
	echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_check.tpl');
}?>
<div style="page-break-after: always; clear: both; width: 877px; padding-top: 10px;"></div>
<?if($_GET['document'] == 'numbers'){
	foreach($order2 as $k=>$order){
		if(isset($order['invoice_data']) && count($order['invoice_data']) > 0){?>
			<div style="width: 877px; border-bottom: 1px dashed #aaa; clear: both; position: relative;">
				<p style="margin-left: 200px; font-size: 100px; font-weight: bold; display: inline; text-align: right; position: absolute; bottom: 0; color: #777;"><?=substr($order['id_order'], 0, strlen($order['id_order'])-3)?></p>
				<p style="float: right; font-size: 250px; font-weight: bold; display: inline; text-align: left; line-height: 190px; width: 500px;"><?=substr($order['id_order'], -3)?></p>
				<p style="float: right; font-size: 14px; font-weight: bold; display: inline; text-align: center; line-height: 20px; width: 700px;"><?=$order['note2'];?></p>
				<ul style="float: left; position: absolute; width: 162px; list-style: none; border-right: 1px solid #aaa; padding-left: 10px;">
					<li style="font-size: 30px; font-weight: bold; text-align: center; line-height: 69px; color: #777; border-bottom: 1px dashed #aaa;">
						<?if($order['id_delivery'] == 1){?>
							Сам
						<?}elseif($order['id_delivery'] == 2){?>
							Авт
						<?}else{?>
							<?if($order['ds'] == 'Ваша почта'){?>
								ВП
							<?}elseif($order['ds'] == 'Новая почта'){?>
								НП
							<?}elseif($order['ds'] == 'Деливери'){?>
								Дел
							<?}elseif($order['ds'] == 'Интайм'){?>
								Инт
							<?}elseif($order['ds'] == 'Гюнсел'){?>
								Г
							<?}elseif($order['ds'] == 'Централизованная доставка xt.ua'){?>
								ХТ
							<?}?>
						<?}?>
					</li>
					<li style="font-size: 30px; font-weight: bold; text-align: center; line-height: 69px; color: #777; border-bottom: 1px dashed #aaa;"><?=count($order['invoice_data']);?></li>
					<li style="font-size: 30px; font-weight: bold; text-align: center; line-height: 69px; color: #777;"><?=number_format($order['sum'], 2, ",", "");?></li>
				</ul>
				<div style="clear: both;"></div>
			</div>
		<?}
	}
}?>
<?exit(0);?>