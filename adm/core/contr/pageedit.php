<?php
$Page = new Page();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_page = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
print_r($id_page);
if(!$Page->SetFieldsById($id_page, 1)){
	die('Ошибка при выборе страницы.');
}
$tpl->Assign('h1', 'Редактирование страницы');
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Page_form_validate();
	if(!$err){
		if($id = $Page->UpdatePage($_POST)){
			$tpl->Assign('msg', 'Страница обновлена.');
			unset($_POST);
			if(!$Page->SetFieldsById($id_page, 1)){
				die('Ошибка при выборе страницы.');
			}
		}else{
			$tpl->Assign('msg', 'Ошибка при обновлении страницы.');
		}
    }else{
    	// показываем все заново но с сообщениями об ошибках
    	$tpl->Assign('msg', 'Ошибка! Страница не обновлена.');
        $tpl->Assign('errm', $errm);
    }
}
if(!$Page->PagesList(1)){
	die('Ошибка при добавлении страницы.');
}
$tpl->Assign('list', $Page->list);
$tpl->Assign('ptypes', $Page->GetPagesTypesList());
if(!isset($_POST['smb'])){
	foreach($Page->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_page_ae.tpl')
);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Страницы";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/pages/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование страницы";
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}
?>