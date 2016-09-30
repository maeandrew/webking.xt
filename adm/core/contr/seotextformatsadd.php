<?php
if (!_acl::isAllow('seotextformats'))
    die("Access denied");
$SEO = new SEO();
unset($parsed_res);

$tpl->Assign('h1', 'Добавление формата сеотекста');
if(isset($_POST['smb'])){
    if($SEO->addSeotextFormats($_POST)){
        $tpl->Assign('msg', 'Новый формат добавлен.');
        unset($_POST);
    }else{
        $tpl->Assign('msg', 'Формат не добавлен.');
        $tpl->Assign('errm', 1);
    }
}
if(!isset($_POST['smb'])){
    $_POST['id'] = 0;
}
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Формат сеотекстов";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotextformats/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление формата сеотекста";

$tpl_center = $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotextformats_ae.tpl');

