<?php
// ini_set('memory_limit', '384M');
if(isset($_GET['orders']) && isset($_GET['id_contragent'])){
	$orders = $_GET['orders'];
	$id_contragent = $_GET['id_contragent']; // Получаем id контрагента
	isset($_GET['type'])? $type = $_GET['type']:null;
	isset($_GET['filial'])? $filial = $_GET['filial']:null;
	isset($_GET['id_supplier'])? $id_supplier = $_GET['id_supplier']:null;
}else{
	$orders = $_POST['orders']; //Сюда приходит список всех задействованых заказов
	if(isset($_POST['id_contragent']) == true){
		$id_contragent = $_POST['id_contragent']; // Получаем id контрагента
	}
}
unset($parsed_res);
require($GLOBALS['PATH_model'].'invoice_c.php');
$contragents = array();
$orders_data = array(); //Тут будем хранить данные о каждом заказе
$supplier_order = array();
$processed_orders = array();
//Собираем информацию по каждому заказу
foreach($orders as $order_id){
	$Order = new Orders();
	$Order->SetFieldsById($order_id);
	$orders_data[$order_id] = $Order->fields;
	$User = new Users();
	//Получаем клиента
	$id_customer = $orders_data[$order_id]['id_customer'];
	$Customer = new Customers();
	$Customer->SetFieldsById($id_customer);
	//Получаем контрагента
	$Contragent = new Contragents();
	$Contragent->SetFieldsById(isset($id_contragent)?$id_contragent:null);
	//Получаем поля о пользователе и контрагенте
	$customer_data = $Customer->fields;
	$contragent_data = $Contragent->fields;
	//и ривязываем их к данным о заказе
	$orders_data[$order_id]['customer_data'] = $customer_data;
	$orders_data[$order_id]['contragent_data'] = $contragent_data;
	//Форматируем дату
	$orders_data[$order_id]['date'] = date('d.m.Y', $orders_data[$order_id]['target_date']);
	$Citys = new Citys();
	$city = $Citys->SetFieldsById($orders_data[$order_id]['id_city']);
	// Варианты доставки
	if($orders_data[$order_id]['id_delivery'] == 1){ // самовывоз
		$orders_data[$order_id]['addr_deliv'] = 'Самовывоз';
		$orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
	}elseif($orders_data[$order_id]['id_delivery'] == 2){ // Передать автобусом
		$orders_data[$order_id]['addr_deliv'] = 'Передать автобусом - '.$city['names_regions'];
		$orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
	}elseif($orders_data[$order_id]['id_delivery'] == 3){ // служба доставки
		$orders_data[$order_id]['ds'] = $city['shipping_comp'];
		$orders_data[$order_id]['addr_deliv'] = $city['names_regions'].'<br>'.$city['address'];
		$orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
	}
	$orders_data[$order_id]['name_c'] = $Contragent->GetContragentServiceById($orders_data[$order_id]['id_contragent']);
	if(!isset($contragents[$orders_data[$order_id]['id_contragent']])){
		$contragents[$orders_data[$order_id]['id_contragent']] = array('name' => $orders_data[$order_id]['name_c'], 'orders' => array());
	}
	$Invoice = new Invoice();
	$orders_data[$order_id]['invoice_data'] = $Invoice->GetOrderData($order_id);
	if(!($orders_data[$order_id]['invoice_data']) || count($orders_data[$order_id]['invoice_data']) == 0){
		unset($orders_data[$order_id]);
	}
	//Получаем поставщиков
	$Supplier = new Suppliers();
	$Order->GetSuppliers($order_id); // Выбираем поставщиков, задействованых в заказе
	$suppliers = $Order->list;
	$sumsum = 0;
	foreach($suppliers as $k=>$s){
		if((isset($id_supplier) && $s['id_supplier'] == $id_supplier) || !isset($id_supplier)){
			if($s['id_supplier'] == 0){
				// Если нету поставщика - присваиваем имя "Прогноз"
				$s['name'] = 'Прогноз';
			}
			$Order->SetListBySupplier($s['id_supplier'], $order_id, null, isset($type)?$type:null, isset($filial)?$filial:null);
			$sum						= 0;
			$sum_mopt					= 0;
			$sum_otpusk					= 0;
			$sum_mopt_otpusk			= 0;
			if(!isset($suppliers_data[$k])){
				$suppliers[$k]['sweight'] = 0;
				$suppliers[$k]['svolume'] = 0;
			}else{
				$suppliers[$k]['sweight'] = $suppliers_data[$k]['sweight'];
				$suppliers[$k]['svolume'] = $suppliers_data[$k]['svolume'];
			}
			$supplier_order[$k][$order_id]['order_otpusk'] = 0;
			if(!isset($suppliers_data[$k]['sum_otpusk'])){
				$suppliers_data[$k]['sum_otpusk'] = 0;
			}
			if(!isset($suppliers_data[$k]['sum'])){
				$suppliers_data[$k]['sum'] = 0;
			}
			foreach($Order->list as $key=>$product){
				if(!isset($suppliers_data[$k]['orders'][$key])){
					$suppliers_data[$k]['orders'][$order_id][$key] = $product;
					if($product['checked'] == 0){
						$suppliers_data[$k]['orders'][$order_id][$key]['weight'] = 0;
						$suppliers_data[$k]['orders'][$order_id][$key]['volume'] = 0;
					}
				}else{
					$suppliers_data[$k]['orders'][$key][$order_id]['supplier_quantity_mopt']	= $product['supplier_quantity_mopt'];
					$suppliers_data[$k]['orders'][$key][$order_id]['supplier_quantity_opt']	= $product['supplier_quantity_opt'];
					$suppliers_data[$k]['orders'][$key][$order_id]['box_qty']	+= $product['box_qty'];
					$suppliers_data[$k]['orders'][$key][$order_id]['opt_sum']	+= $product['opt_sum'];
					$suppliers_data[$k]['orders'][$key][$order_id]['mopt_sum']	+= $product['mopt_sum'];
				}
				if($product['supplier_quantity_opt'] > 0 && $product['supplier_quantity_mopt'] > 0 && $product['id_supplier'] == $s['id_supplier'] && $product['id_supplier_mopt'] == $s['id_supplier']){
					$sum_mopt					= $product['site_price_mopt']*$product['supplier_quantity_mopt'];
					$sum						= $product['site_price_opt']*$product['supplier_quantity_opt'];
					$sum_mopt_otpusk			= $product['price_mopt_otpusk']*$product['supplier_quantity_mopt'];
					$sum_otpusk					= $product['price_opt_otpusk']*$product['supplier_quantity_opt'];
					if($product['checked'] == 1){
						$suppliers[$k]['sweight']	+= round($product['weight']*$product['supplier_quantity_opt'], 2);
						$suppliers[$k]['svolume']	+= round($product['volume']*$product['supplier_quantity_opt'], 2);
						$suppliers[$k]['sweight']	+= round($product['weight']*$product['supplier_quantity_mopt'], 2);
						$suppliers[$k]['svolume']	+= round($product['volume']*$product['supplier_quantity_mopt'], 2);
					}
				}elseif($product['supplier_quantity_opt'] > 0 && $product['id_supplier'] == $s['id_supplier']){
					if($product['supplier_quantity_mopt'] != 0){
						$product['supplier_quantity_mopt'] = 0;
						$sum_mopt_otpusk = 0;
					}
				}elseif($product['supplier_quantity_mopt'] > 0 && $product['id_supplier_mopt'] == $s['id_supplier']){
					if($product['supplier_quantity_opt'] != 0){
						$product['supplier_quantity_opt'] = 0;
						$sum_otpusk = 0;
					}
				}
				$sum_mopt							= $product['site_price_mopt']*$product['supplier_quantity_mopt'];
				$sum								= $product['site_price_opt']*$product['supplier_quantity_opt'];
				$sum_mopt_otpusk					= $product['price_mopt_otpusk']*$product['supplier_quantity_mopt'];
				$sum_otpusk							= $product['price_opt_otpusk']*$product['supplier_quantity_opt'];
				if($product['checked'] == 1){
					$suppliers[$k]['sweight']			+= round($product['weight']*$product['supplier_quantity_opt'], 2);
					$suppliers[$k]['svolume']			+= round($product['volume']*$product['supplier_quantity_opt'], 2);
					$suppliers[$k]['sweight']			+= round($product['weight']*$product['supplier_quantity_mopt'], 2);
					$suppliers[$k]['svolume']			+= round($product['volume']*$product['supplier_quantity_mopt'], 2);
				}
				$suppliers_data[$k]['sum_otpusk']	+= ($sum_mopt_otpusk + $sum_otpusk);
				$suppliers_data[$k]['sum']			+= ($sum_mopt + $sum);
				$supplier_order[$k][$order_id]['order_otpusk'] += ($sum_mopt_otpusk + $sum_otpusk);
			}
			$suppliers_data[$k]['dn']				= $Supplier->GetDNByDate($s['id_supplier'], $orders_data[$order_id]['target_date']);
			$suppliers_data[$k]['sweight']			= $suppliers[$k]['sweight'];
			$suppliers_data[$k]['svolume']			= $suppliers[$k]['svolume'];
			$suppliers_data[$k]['name']				= $suppliers[$k]['name'];
			$suppliers_data[$k]['art']				= $suppliers[$k]['article'];
			$suppliers_data[$k]['id_supplier']		= $s['id_supplier'];

			$suppliers_data[$k]['make_csv']			= $suppliers[$k]['make_csv'];
			$suppliers_data[$k]['send_mail_order']	= $suppliers[$k]['send_mail_order'];
			$suppliers_data[$k]['real_email']		= $suppliers[$k]['real_email'];
			$suppliers_data[$k]['real_phone']		= $suppliers[$k]['real_phone'];
			$suppliers_data[$k]['phone']			= $suppliers[$k]['phones'];
			$suppliers_data[$k]['place']			= $suppliers[$k]['place'];

			$suppliers_data[$k]['is_partner']		= $suppliers[$k]['is_partner'];
			$suppliers_data[$k]['icq']				= $suppliers[$k]['icq'];
			$suppliers_data[$k]['balance']			= $suppliers[$k]['balance'];
			$suppliers_data[$k]['personal_message']	= $suppliers[$k]['personal_message'];
			$suppliers_data[$k]['example_sum']		= $suppliers[$k]['example_sum'];

			$suppliers_data[$k]['pickers']			= $suppliers[$k]['pickers'];
			$suppliers_data[$k]['area']				= $suppliers[$k]['area'];
			$suppliers_data[$k]['currency_rate']	= $suppliers[$k]['currency_rate'];
			$suppliers_data[$k]['inusd']			= $suppliers[$k]['inusd'];
		}
	}
}
function basort (&$array, $key) {
	$sorter = array();
	$ret = array();
	reset($array);
	foreach($array as $ii => $va) {
		$sorter[$ii]=$va[$key];
	}
	asort($sorter, SORT_STRING);
	foreach($sorter as $ii => $va) {
		$ret[$ii]=$array[$ii];
	}
	$array=$ret;
}
basort($orders_data, 'addr_deliv');
foreach($suppliers_data as $sup_key=>$supplier){
	$num_orders = 0;
	$order_supplier= array();
	if(!empty($supplier['orders'])){
		foreach($supplier['orders'] as $order){
			foreach($order as $product){
				$current_order = $product['id_order'];
				if(!isset($order_supplier[$current_order][$sup_key]['otpusk_sum'])){
					$order_supplier[$current_order][$sup_key]['otpusk_sum'] = 0;
				}
				if(!isset($order_supplier[$current_order][$sup_key]['site_sum'])){
					$order_supplier[$current_order][$sup_key]['site_sum'] = 0;
				}
				if(!isset($processed_orders[$sup_key])){
					$processed_orders[$sup_key] = array();
				}
				if(!in_array($current_order, $processed_orders[$sup_key])){
					array_push($processed_orders[$sup_key], $current_order);
					$supplier_order[$sup_key][$current_order]['order_num'] = $current_order.'-'.$supplier['art'];
					$num_orders++;
				}
				$suppliers_data[$sup_key]['num_orders'] = $num_orders;
				if($product['supplier_quantity_opt'] > 0 && $product['supplier_quantity_mopt'] > 0 && $product['id_supplier'] == $sup_key && $product['id_supplier_mopt'] == $sup_key){
					$sum_mopt							= $product['site_price_mopt']*$product['supplier_quantity_mopt'];
					$sum								= $product['site_price_opt']*$product['supplier_quantity_opt'];
					$sum_mopt_otpusk					= $product['price_mopt_otpusk']*$product['supplier_quantity_mopt'];
					$sum_otpusk							= $product['price_opt_otpusk']*$product['supplier_quantity_opt'];
				}elseif($product['supplier_quantity_opt'] > 0 && $product['id_supplier'] == $sup_key){
					if($product['supplier_quantity_mopt'] != 0){
						$product['supplier_quantity_mopt'] = 0;
						$sum_mopt_otpusk = 0;
					}
					$sum_mopt							= $product['site_price_mopt']*$product['supplier_quantity_mopt'];
					$sum								= $product['site_price_opt']*$product['supplier_quantity_opt'];
					$sum_mopt_otpusk					= $product['price_mopt_otpusk']*$product['supplier_quantity_mopt'];
					$sum_otpusk							= $product['price_opt_otpusk']*$product['supplier_quantity_opt'];
				}elseif($product['supplier_quantity_mopt'] > 0 && $product['id_supplier_mopt'] == $sup_key){
					if($product['supplier_quantity_opt'] != 0){
						$product['supplier_quantity_opt'] = 0;
						$sum_otpusk = 0;
					}
					$sum_mopt							= $product['site_price_mopt']*$product['supplier_quantity_mopt'];
					$sum								= $product['site_price_opt']*$product['supplier_quantity_opt'];
					$sum_mopt_otpusk					= $product['price_mopt_otpusk']*$product['supplier_quantity_mopt'];
					$sum_otpusk							= $product['price_opt_otpusk']*$product['supplier_quantity_opt'];
				}
				$order_supplier[$current_order][$sup_key]['otpusk_sum']		+= ($sum_mopt_otpusk + $sum_otpusk);
				$order_supplier[$current_order][$sup_key]['site_sum']		+= ($sum + $sum_mopt);
				$order_supplier[$current_order][$sup_key]['sup_name']		= $supplier['name'];
				$order_supplier[$current_order][$sup_key]['phone']			= $supplier['phone'];
				$order_supplier[$current_order][$sup_key]['place']			= $supplier['place'];
				$order_supplier[$current_order][$sup_key]['art']			= $supplier['art'];
				$order_supplier[$current_order][$sup_key]['icq']			= $supplier['icq'];
				$contragents[$orders_data[$current_order]['id_contragent']]['orders'][$current_order] = $current_order;
			}
		}
	}
}
foreach($orders_data as $key=>$value){
	$orders_data[$key]['tvolume'] = 0;
	$orders_data[$key]['tweight'] = 0;
	if(!isset($type)){
		$orders_data[$key]['otpusk_prices_sum'] = 0;
	}
	foreach($value['invoice_data'] as $v){
		if($v['checked'] == 1){
			$orders_data[$key]['tvolume'] += $v['volume'];
			$orders_data[$key]['tweight'] += $v['weight'];
		}
		if(!isset($type)){
			if($v['contragent_qty'] <= 0 && $v['supplier_quantity_opt'] > 0){
				$orders_data[$key]['otpusk_prices_sum'] += round($v['price_opt_otpusk']*$v['supplier_quantity_opt'],2);
			}
			if($v['contragent_qty'] <= 0 && $v['supplier_quantity_mopt'] > 0){
				$orders_data[$key]['otpusk_prices_sum'] += round($v['price_mopt_otpusk']*$v['supplier_quantity_mopt'],2);
			}
		}
	}
}
$tpl->Assign('os', $order_supplier);
$tpl->Assign('sorders', $supplier_order);
$tpl->Assign('orders', $orders_data);
basort($orders_data, 'id_order');
$tpl->Assign('contragent', $contragent_data);
$tpl->Assign('contragents', $contragents);
function aasort(&$array, $key){
	$sorter = array();
	$ret = array();
	reset($array);
	foreach($array as $ii => $va){
		$sorter[$ii]=$va[$key];
	}
	asort($sorter, SORT_STRING);
	foreach($sorter as $ii => $va){
		$ret[$ii]=$array[$ii];
	}
	$array = $ret;
}
aasort($suppliers_data, 'art');
$volume = 0;
$Mailer = new Mailer();
foreach($suppliers_data as $id_supplier=>$s){
	if($s['send_mail_order'] == 1 && !empty($s['orders'])){
		if($s['make_csv'] == 1 && !isset($_POST['send_mail'])){
			foreach($supplier_order[$id_supplier] AS $k=>$so){
				$res[] = $k;
			}
			$Mailer->GenerateCSVForSupplier($res, $id_supplier, $s['real_phone']);
		}
		if(isset($_POST['send_mail'])){
			// $Mailer->SendOrdersToSuppliers($suppliers_data[$id_supplier], $id_supplier, $orders_data, $contragent_data, $supplier_order);
			$Mailer->SuppleirsInvoiceNotification($suppliers_data[$id_supplier], $id_supplier, $orders_data, $contragent_data, $supplier_order);
			$Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
			if(isset($s['real_phone']) && $s['real_phone'] != ''){
				$res = $Gateway->execCommad(
					'sendSMS',
					array(
						'sender' => $GLOBALS['CONFIG']['invoice_logo_sms'],
						'text' => 'На ваш e-mail отправлен заказ от '.$GLOBALS['CONFIG']['invoice_logo_text'],
						'phone' => $s['real_phone'],
						'datetime' => null,
						'sms_lifetime' => 0
					)
				);
			}
		}
	}
}
$City = new Citys();
$City->SetList();
$city = $City->list;
aasort($suppliers_data, 'icq');
$tpl->Assign('suppliers', $suppliers_data);
$suppliers_altern = array();
$Order->GetSuppliersAltern($order_id);
$suppliers_altern = $Order->list;
$tpl->Assign('suppliers_altern', $suppliers_altern);
if(isset($type)){
	$tpl->Assign('type', $type);
}
if(isset($filial) == true){
	$tpl->Assign('filial', $Supplier->GetFilialById($filial));
}
// print_r(memory_get_peak_usage());
echo $tpl->Parse($GLOBALS['PATH_tpl'].'composed_invoice.tpl');
// ini_set('memory_limit', '256M');
exit(0);
?>