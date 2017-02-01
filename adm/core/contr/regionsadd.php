<?php
$Address = new Address();

// ---- center ----
unset($parsed_res);

$haeder = 'Области';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/regions/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Добавление Области';
$tpl->Assign('h1', $header);

if (isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Region_form_validate();
    if (!$err){
    	if ($id = $$ObjName->Add($_POST)){
			$tpl->Assign('msg', 'Добавление прошло успешно.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'При добавлении возникли ошибки.');
			$tpl->Assign('errm', 1);
		}
    }else{
    	// показываем все заново но с сообщениями об ошибках
    	$tpl->Assign('msg', 'При добавлении возникли ошибки!');
        $tpl->Assign('errm', $errm);
    }
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_regions_ae.tpl');