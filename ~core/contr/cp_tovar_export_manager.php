<?php

	



	// ---- center ----
	unset($parsed_res);





	$Customer = new Customers();

$header[id_stroka]="№ строки";
$header[id_zakaz]="№ заказа";
$header[art_tovar]="Артикул товара";
$header[n_opt]="Количество по опту";
$header[n_mopt]="Количество";
$header[zena_opt]="ID поставщика";
$header[zena_mopt]="Цена по сайту";
$header[zena__zak_opt]="Цена закупки по опту";
$header[zena__zak_mopt]="Цена закупки";
$header[n_opt_fakt]="Количество факт по опту";
$header[n_mopt_fakt]="Количество факт";
$header[zena_mopt5000]="Цена 5000 грн";
$header[filial]="Код филиала";



$tpl->Assign('header', $header);


	

	
	
	// Список заказов+

	$order2="";
          //print_r($date3);
	$tovar = $Customer->GetTovar_export($order2);
          //print_r($tovar);
        $tpl->Assign('tovar', $tovar);
	




 



	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_tovar_export.tpl');

	exit(0);







	// ---- right ----

?>
