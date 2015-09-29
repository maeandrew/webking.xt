<?php

	



	// ---- center ----
	unset($parsed_res);





	$Customer = new Customers();

$header[id_tovara]="ID товара";
$header[art_tovar]="Артикул";
$header[nazvanie_tovar]="Название";
$header[opisanie]="Описание";
$header[zena_opt]="Цена оптовая";
$header[zena_mopt]="Цена мелкооптовая";
$header[jasik]="К-во в ящике";
$header[min_kol]="Мин. к-во по мелкому опту";
$header[kratnost]="Кратность";
$header[edinizi]="Един. измерения";
$header[rasdel]="Название раздела";
$header[art_rasdel]="Артикул раздела";
$header[filial]="Код филиала";



$tpl->Assign('header', $header);


	

	
	
	// Список заказов+

	$order3="";
          //print_r($date3);
	$katalog = $Customer->GetKatalog_export($order3);
          //print_r($katalog);
        $tpl->Assign('katalog', $katalog);
	




 



	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_katalog_export.tpl');

	exit(0);







	// ---- right ----

?>
