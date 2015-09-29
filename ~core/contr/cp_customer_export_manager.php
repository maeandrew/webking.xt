<?php
unset($parsed_res);
$Customer = new Customers();
$header[id_clienta]="ID клиента";
$header[name]="Название клиента";
$header[telef]="Телефон клиентов";
$header[mail]="E-mail";
$header[cont_person]="Клиент";
$header[data_regist]="Дата регистрации";
$header[filial]="Код филиала";
$tpl->Assign('header', $header);
$date4="";
$customers = $Customer->GetCustomer_export($date4);
$tpl->Assign('customers', $customers);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_customer_export.tpl');
exit(0);
?>
