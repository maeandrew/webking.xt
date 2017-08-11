<?php

$orders = $_POST['orders'];
$id_contragent = $_POST['id_contragent'];
//print_r($orders);

// ---- center ----
unset($parsed_res);

require($GLOBALS['PATH_model'].'invoice_c.php');

$orders_data = array(); //Тут будем хранить данные о каждом заказе

foreach($orders as $order_id)
{
        $Order = new Orders();
        $Order->SetFieldsById($order_id);

    $orders_data[$order_id] = $Order->fields;


    //Получаем клиента
        $id_customer = $orders_data[$order_id]['id_customer'];
        $Customer = new Customers();
        $Customer->SetFieldsById($id_customer);

    //Получаем контрагента
        // $id_contragent = $orders_data[$order_id]['id_contragent'];
         $Contragent = new Contragents();
          $Contragent->SetFieldsById($id_contragent)->list;



    //Получаем поля и присоединяем к данным о заказе
        $customer_data = $Customer->fields;
        $contragent_data = $Contragent->fields;

    $orders_data[$order_id]['customer_data']=$customer_data;
        $orders_data[$order_id]['contragent_data']=$contragent_data;


    //Форматируем дату
        $orders_data[$order_id]['date']=date("d.m.Y", $orders_data[$order_id]['target_date']);

	$Cities = new Cities();
    	$city = $Cities->SetFieldsById($orders_data[$order_id]['id_city']);

    	// Варианты доставки
        if ($orders_data[$order_id]['id_delivery'] == 1){ // самовывоз
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

        //**GetContragentServiceById
            $orders_data[$order_id]['name_c']  = $Contragent->GetContragentServiceById($orders_data[$order_id]['id_contragent']);
            //
        $Invoice = new Invoice();
        $orders_data[$order_id]['invoice_data'] = $Invoice->GetOrderData_m_diler($order_id);
    //print_r($orders_data[$order_id]['invoice_data']);


    //Получаем поставщиков
        $Supplier = new Suppliers();
        $Order->GetSuppliers($order_id);
        $suppliers = $Order->list;


   


}
 //asort($orders_data);




$supplier_order = array();
$processed_orders = array();










$tpl->Assign("os", $order_supplier);
$tpl->Assign("sorders", $supplier_order);
$tpl->Assign("orders", $orders_data);
$tpl->Assign("contragent", $contragent_data);








$suppliers_altern = array();
$Order->GetSuppliersAltern($order_id);
$suppliers_altern = $Order->list;
$tpl->Assign('suppliers_altern', $suppliers_altern);


echo $tpl->Parse($GLOBALS['PATH_tpl'].'composed_invoice_diler.tpl');

//  echo "<pre>";
//  print_r($supplier_order);
//  echo "</pre>";

exit(0);

// ---- right ----

?>
