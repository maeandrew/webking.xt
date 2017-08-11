<?php
$orders = $_POST['orders'];
unset($parsed_res);
require($GLOBALS['PATH_model'].'invoice_c.php');
$orders_data = array(); //Тут будем хранить данные о каждом заказе
foreach($orders as $order_id){
    $Order = new Orders();
    $Order->SetFieldsById($order_id);
    $orders_data[$order_id] = $Order->fields;
    //Получаем клиента
    $id_customer = $orders_data[$order_id]['id_customer'];
    $Customer = new Customers();
    $Customer->SetFieldsById($id_customer);
    //Получаем контрагента
    $id_contragent = $orders_data[$order_id]['id_contragent'];
    $Contragent = new Contragents();
    $Contragent->SetFieldsById($id_contragent);
    //Получаем поля и присоединяем к данным о заказе
    $customer_data = $Customer->fields;
    $contragent_data = $Contragent->fields;
    $orders_data[$order_id]['customer_data'] = $customer_data;
    $orders_data[$order_id]['contragent_data'] = $contragent_data;
    //Форматируем дату
    $orders_data[$order_id]['date'] = date("d.m.Y", $orders_data[$order_id]['target_date']);
   	$Cities = new Cities();
  	$city = $Cities->SetFieldsById($orders_data[$order_id]['id_city']);
   	// Варианты доставки
    if($orders_data[$order_id]['id_delivery'] == 1){ // самовывоз
        $orders_data[$order_id]['addr_deliv'] = "Самовывоз";
        $orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
    }elseif($orders_data[$order_id]['id_delivery'] == 2){ // Передать автобусом
        $orders_data[$order_id]['addr_deliv'] = "Передать автобусом - ".$city['names_regions'];
        $orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
    }elseif($orders_data[$order_id]['id_delivery'] == 3){ // служба доставки
        $orders_data[$order_id]['ds'] = $city['shipping_comp'];
        $orders_data[$order_id]['addr_deliv'] = $city['names_regions']."<br>".$city['address'];
        $orders_data[$order_id]['addr_descr'] = $orders_data[$order_id]['descr'];
    }
    $Invoice = new Invoice();
    $orders_data[$order_id]['invoice_data'] = $Invoice->GetOrderData($order_id);
    //Получаем поставщиков
    $Supplier = new Suppliers();
    $Order->GetSuppliers($order_id);
    $suppliers = $Order->list;
    foreach($suppliers as $k=>&$s){
        if($s['id_supplier'] == 0){
            $s['name'] = "Прогноз";
        }
        $Order->SetListBySupplier($s['id_supplier'], $order_id);
        $sum = 0;
        $sum_mopt = 0;
        $sum_otpusk = 0;
        $sum_mopt_otpusk  = 0;
        if(!isset($suppliers_data[$k])){
            $suppliers[$k]['sweight'] = 0;
            $suppliers[$k]['svolume'] = 0;
        }else{
            $suppliers[$k]['sweight'] = $suppliers_data[$k]['sweight'];
            $suppliers[$k]['svolume'] = $suppliers_data[$k]['svolume'];
        }
        foreach($Order->list as $key=>$product){
            if(!isset($suppliers_data[$k]['orders'][$key])){
                $suppliers_data[$k]['orders'][$order_id][$key]=$product;
            }else{
                $suppliers_data[$k]['orders'][$key][$order_id]['mopt_qty']+=$product['mopt_qty'];
                $suppliers_data[$k]['orders'][$key][$order_id]['box_qty']+=$product['box_qty'];
                $suppliers_data[$k]['orders'][$key][$order_id]['opt_sum']+=$product['opt_sum'];
                $suppliers_data[$k]['orders'][$key][$order_id]['mopt_sum']+=$product['mopt_sum'];
            }
            if($product['opt_qty']>0 && $product['id_supplier']==$s['id_supplier']){
                $sum = round(($sum + $product['opt_sum']),2);
                $sum_otpusk = round(($sum_otpusk + $product['price_opt_otpusk']*$product['opt_qty']),2);
                $suppliers[$k]['sweight'] += round($product['weight']*$product['opt_qty'],2);
                $suppliers[$k]['svolume'] += round($product['volume']*$product['opt_qty'],2);
            }
            if($product['mopt_qty']>0 && $product['id_supplier_mopt']==$s['id_supplier']){
                $sum_mopt = round(($sum_mopt + $product['mopt_sum']),2);
                $sum_mopt_otpusk = round(($sum_mopt_otpusk + $product['price_mopt_otpusk']*$product['mopt_qty']),2);
                $suppliers[$k]['sweight'] += round($product['weight']*$product['mopt_qty'],2);
                $suppliers[$k]['svolume'] += round($product['volume']*$product['mopt_qty'],2);
            }
        }
        if(!isset($suppliers_data[$k]['sum'])){
            $suppliers_data[$k]['sum'] = $sum+$sum_mopt;
        }else{
            $suppliers_data[$k]['sum'] += $sum+$sum_mopt;
        }
        if(!isset($suppliers_data[$k]['sum_otpusk'])){
            $suppliers_data[$k]['sum_otpusk'] = $sum_otpusk+$sum_mopt_otpusk;
        }else{
            $suppliers_data[$k]['sum_otpusk'] +=  $sum_otpusk+$sum_mopt_otpusk;
        }
        $suppliers_data[$k]['dn'] = $Supplier->GetDNByDate($s['id_supplier'],  $orders_data[$order_id]['target_date']);
        $suppliers_data[$k]['sweight'] = $suppliers[$k]['sweight'];
        $suppliers_data[$k]['svolume'] = $suppliers[$k]['svolume'];
        $suppliers_data[$k]['name'] = $suppliers[$k]['name'];
        $suppliers_data[$k]['art'] = $suppliers[$k]['article'];
        $suppliers_data[$k]['phone'] = $suppliers[$k]['phones'];
        $suppliers_data[$k]['place'] = $suppliers[$k]['place'];
        $suppliers_data[$k]['is_partner'] = $suppliers[$k]['is_partner'];
    }
}
$supplier_order = array();
$processed_orders = array();
foreach($suppliers_data as $sup_key=>$supplier){
    $num_orders = 0;
    foreach($supplier['orders'] as $order){
        foreach($order as $product){
            $current_order = $product['id_order'];
            $soprice = $product['site_price_opt'];
            $smprice = $product['site_price_mopt'];
            $ooprice = $product['price_opt_otpusk'];
            $omprice = $product['price_mopt_otpusk'];
            $oq = $product['opt_qty'];
            $mq = $product['mopt_qty'];
            if(!isset($processed_orders[$sup_key])){
                $processed_orders[$sup_key] = array();
            }
            if(!in_array($current_order, $processed_orders[$sup_key])){
                array_push($processed_orders[$sup_key], $current_order);
                $supplier_order[$sup_key][$current_order]['site_sum'] = ($soprice*$oq) + ($smprice*$mq);
                $supplier_order[$sup_key][$current_order]['otpusk_sum'] = ($ooprice*$oq) + ($omprice*$mq);
                $supplier_order[$sup_key][$current_order]['order_num'] = $current_order.'-'.$supplier['art'];
                $num_orders ++;
            }else{
                $supplier_order[$sup_key][$current_order]['site_sum'] += ($soprice*$oq) + ($smprice*$mq);
                $supplier_order[$sup_key][$current_order]['otpusk_sum'] += ($ooprice*$oq) + ($omprice*$mq);
            }
        }
    }
    $suppliers_data[$sup_key]['num_orders'] = $num_orders;
}
foreach($suppliers_data as $sup_key => $supplier){
    foreach($supplier['orders'] as $order){
        foreach($order as $product){
            $current_order = $product['id_order'];
            $soprice = $product['site_price_opt'];
            $smprice = $product['site_price_mopt'];
            $ooprice = $product['price_opt_otpusk'];
            $omprice = $product['price_mopt_otpusk'];
            $oq = $product['opt_qty'];
            $mq = $product['mopt_qty'];
            if(!isset($order_supplier[$current_order][$sup_key]['site_sum'])){
                $order_supplier[$current_order][$sup_key]['site_sum'] = ($soprice*$oq) + ($smprice*$mq);
            }else{
                $order_supplier[$current_order][$sup_key]['site_sum'] += ($soprice*$oq) + ($smprice*$mq);
            }
            if(!isset($order_supplier[$current_order][$sup_key]['otpusk_sum'])){
                $order_supplier[$current_order][$sup_key]['otpusk_sum'] = ($ooprice*$oq) + ($omprice*$mq);
            }else{
                $order_supplier[$current_order][$sup_key]['otpusk_sum'] += ($ooprice*$oq) + ($omprice*$mq);
            }
            $order_supplier[$current_order][$sup_key]['order_num'] = $current_order.'-'.$supplier['art'];
            $order_supplier[$current_order][$sup_key]['sup_name'] = $supplier['name'];
            $order_supplier[$current_order][$sup_key]['phone'] = $supplier['phone'];
            $order_supplier[$current_order][$sup_key]['place'] = $supplier['place'];
            $order_supplier[$current_order][$sup_key]['art'] = $supplier['art'];
        }
    }
}
$tpl->Assign("os", $order_supplier);
$tpl->Assign("sorders", $supplier_order);
$tpl->Assign("orders", $orders_data);
$tpl->Assign("contragent", $contragent_data);
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
    $array=$ret;
}
aasort($suppliers_data,"art");
$tpl->Assign('suppliers', $suppliers_data);
$suppliers_altern = array();
$Order->GetSuppliersAltern($order_id);
$suppliers_altern = $Order->list;
$tpl->Assign('suppliers_altern', $suppliers_altern);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'composed_invoice.tpl');
exit(0);?>