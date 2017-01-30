<?php
if(!_acl::isAllow('parser')){
	die('Access denied');
}
unset($parsed_res);
$header = 'Сайты дял парсинга';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Парсер';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '#';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$Parser = new Parser();
$tpl->Assign('sites', $Parser->GetSitesList());

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_parser_sites.tpl');