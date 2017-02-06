<?php
$Address = new Address();

$header = 'Транспортные компании';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);
$qwr=$Address->GetShippingCompaniesList();

$tpl->Assign('list', $Address->GetShippingCompaniesList());

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_shipping_companies.tpl');
