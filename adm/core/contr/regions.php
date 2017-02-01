<?php
$Address = new Address();

$header = 'Области';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);

$tpl->Assign('list', $Address->GetRegionsList());

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_regions.tpl');
