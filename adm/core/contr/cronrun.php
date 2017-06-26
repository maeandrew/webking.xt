<?php
if(!_acl::isAllow('cron'))
	die("Access denied");
$Cron = new Cron();
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$header = 'Ручное выполнение задачи CRON';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Задачи CRON';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/cron/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
if(!$Cron->SetFieldsById($id)){
	$tpl->Assign('errm', 1);
	$tpl->Assign('msg', 'Невозможно выполнить задачу. ID '.$id.' не существует');
}else{
	$task = $Cron->fields;
	$Cron->Run($task);
	$tpl->Assign('msg', 'Ручное выполнение задачи завершено успешно.');
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl');
