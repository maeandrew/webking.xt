<?php

$segmentation = new Segmentation();

// ---- center ----
unset($parsed_res);

if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
    $id = $GLOBALS['REQAR'][1];
}else{
    header('Location: '.$GLOBALS['URL_base'].'404/');
    exit();
}

if (!$segmentation->SetFieldsById($id)) die('Ошибка при выборе сегмента.');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Сегменты";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/segmentations/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование сегмента";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

//Получение списка типов сегментаций
$tpl->Assign('typelist', $segmentation->GetSegmentationType());

if (isset($_POST['smb'])){

    require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

    list($err, $errm) = Specification_form_validate();

    if (!$err){
        if ($segmentation->Update($_POST)){
            $tpl->Assign('msg', 'Обновление данных прошло успешно.');
            unset($_POST);
            if (!$segmentation->SetFieldsById($id)) die('Ошибка при извлечении полей.');
        }else{
            $tpl->Assign('msg', 'При обновлении возникли ошибки.');
            $tpl->Assign('errm', 1);
        }
    }else{
        // показываем все заново но с сообщениями об ошибках
        $tpl->Assign('msg', 'При обновлении возникли ошибки!');
        $tpl->Assign('errm', $errm);
    }
}

if (!isset($_POST['smb'])){
    foreach ($segmentation->fields as $k=>$v){
        $_POST[$k] = $v;
    }
}

$parsed_res = array('issuccess' => TRUE,
    'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_segmentation_ae.tpl'));


if (TRUE == $parsed_res['issuccess']) {
    $tpl_center .= $parsed_res['html'];
}

// ---- right ----

?>