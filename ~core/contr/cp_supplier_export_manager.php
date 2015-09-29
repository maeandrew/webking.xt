<?php

	



	// ---- center ----
	unset($parsed_res);





	$Customer = new Customers();


$header[id_clienta]="ID клиента";
$header[name]="Артикул";
$header[cont_person]="Телефон";
$header[mail]="Адрес";
$header[telef]="Название";
$header[data_regist]="E-mail";
$header[filial]="Код филиала";





$tpl->Assign('header', $header);


	

	
	
	// Список заказов+

	$date5="";
          //print_r($date3);
	$supplier = $Customer->GetSupplier_export($date5);
          //print_r($customers);
        $tpl->Assign('supplier', $supplier);
	




 



	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_supplier_export.tpl');

	exit(0);







	// ---- right ----

?>
