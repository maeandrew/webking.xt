<?php

$Address = new Address();
unset($parsed_res);
if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}

$header = 'Города';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cities/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Удаление города';
$tpl->Assign('h1', $header);

if(!$Address->DeleteCity($id)) die('Ошибка при удалении.');

$tpl->Assign('msg', 'Удаление прошло успешно.');

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl');
