<?php
$Page = new Page();
// ---- center ----
unset($parsed_res);
$tpl->Assign('h1', 'Добавление страницы');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Страницы";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/pages/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление страницы";
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Page_form_validate();
    if(!$err){
    	if($id = $Page->AddPage($_POST)){
			$tpl->Assign('msg', 'Страница добавлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Страница не добавлена.');
		}
    }else{
    	// показываем все заново но с сообщениями об ошибках
    	$tpl->Assign('msg', 'Страница не добавлена.');
        $tpl->Assign('errm', $errm);
    }
}
//if (!$Page->PagesList(1)) die('Ошибка при добавлении страницы.');
//$tpl->Assign('list', $Page->list);
$tpl->Assign('ptypes', $Page->GetPagesTypesList());
if(!isset($_POST['smb'])){
	$_POST['id_page'] = 0;
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_page_ae.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>