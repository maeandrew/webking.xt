<?php

	



	// ---- center ----
	unset($parsed_res);

	//$Page = new Page();
	//$Page->PagesList();
	//$tpl->Assign('list_menu', $Page->list);

	//$GLOBALS['IERA_LINKS'] = array();
	//$GLOBALS['IERA_LINKS'][0]['title'] = "Каталог";
	//$GLOBALS['IERA_LINKS'][0]['url'] = $GLOBALS['URL_base'].'demo_order/';
       // $no_tpl='';



	$Customer = new Customers();

$header[date]="Дата заказа";
$header[nomer]="№ заказа";
$header[id_clienta]="ID клиен";
$header[id_marsr]="ID на маршрут";
$header[nakladna_cust]="Накладная покупателя";
$header[nakladna_cont]="Накладная контрагента";
$header[nakladna_fakt]="Накладная факт";
$header[primec]="Прим";
$header[klient]="Контактное лицо";
$header[telef]="Телефон клиентов";
$header[adres]="Адрес доставки";
$header[mail]="E-mail";
$header[sposob]="Способ доставки";
$header[slusba]="Служба доставки";
$header[otpusk]="Сумма заказа";
$header[zakupka]="Сумма закупки";
$header[kontragent]="Контрагент";
$header[filial]="Код филиала";




$tpl->Assign('header', $header);


	

	
	
	// Список заказов+

	$date3="";
          //print_r($date3);
	$orders = $Customer->GetOrders_export($date3);
        $tpl->Assign('orders', $orders);
	

//заготовка под экспорт
	//$Order = new Orders();


	//	if (in_array("export", $GLOBALS['REQAR'])){
		
	//	$Order->GenExcelOrdersManagFile($header, $header);

           // print_r($orders);
	//	exit(0);
		
	//}


 



	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_cab_export.tpl');

	exit(0);







	// ---- right ----

?>
