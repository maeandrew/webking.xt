<?php
$SEO = new SEO();
unset($parsed_res);

if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
    $id = $GLOBALS['REQAR'][1];
}else{
    header('Location: '.$GLOBALS['URL_base'].'404/');
    exit();
}

$tpl->Assign('h1', 'Удаление формата сеотекста');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "формат сеотекстов";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotextformats/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление формата сеотекста";


if (!$SEO->de1SeotextFormats($id)) die('Ошибка при удалении формата сеотекста.');

$tpl->Assign('msg', 'Формат удален.');

$parsed_res = array(
    'issuccess' => true,
    'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
);
if(true == $parsed_res['issuccess']) $tpl_center .= $parsed_res['html'];