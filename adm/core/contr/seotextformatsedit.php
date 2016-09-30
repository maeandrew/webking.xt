<?php
if (!_acl::isAllow('seotextformatsedit'))
    die("Access denied");
$SEO = new SEO();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
    $id = $GLOBALS['REQAR'][1];
}else{
    header('Location: '.$GLOBALS['URL_base'].'404/');
    exit();
}
if(!$format_seo = $SEO->getFieldsFormatById($id)){
    die('Ошибка при выборе формата сеотекста.');
}
$tpl->Assign('h1', 'Редактирование формата сеотекста');
if (isset($_POST['smb'])) {
    if ($SEO->updateSeotextFormats($_POST)) {
        $tpl->Assign('msg', 'Редактирование прошло успешно.');
        $success = true;
        $tpl->Assign('success', $success);
        $format_seo = $SEO->getFieldsFormatById($id);
        unset($_POST);
    } else {
        unset($format_seo);
        $tpl->Assign('msg', 'Произошла ошибка! Повторите попытку.');
        $tpl->Assign('errm', 1);
    }
}
if(!empty($format_seo)) {
    foreach ($format_seo as $k => $format) {
        $_POST[$k] = $format;
    }
}
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "формат сеотекстов";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotextformats/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование формата сеотекста";

$tpl_center = $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotextformats_ae.tpl');