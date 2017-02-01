<?php
$Address = new Address();

$header = 'Города';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);

$tpl->Assign('list', $Address->GetCitiesList());

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cities.tpl');
