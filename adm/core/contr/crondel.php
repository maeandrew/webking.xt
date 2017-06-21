<?php
if(!_acl::isAllow('cron')){
	die("Access denied");
}
$Cron = new Cron();
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
if(!$Cron->SetFieldsById($id)){
	die('Ошибка при выборе задачи.');
}
$header = 'Удаление задачи CRON';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Задачи CRON';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/cron/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
if($Cron->Delete($id)){
	$tpl->Assign('msg', 'Удаление прошло успешно.');
	unlink(_root.'cron'.DIRSEP.$Cron->fields['alias'].'.php');
}else{
	$tpl->Assign('errm', 1);
	$tpl->Assign('msg', 'Не удалось удалить задачу.');
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl');
