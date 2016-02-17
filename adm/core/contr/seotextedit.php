<?php
$Seo = new SEO();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
if(!$Seo->SetFieldsById($id, 1)){
	die('Ошибка при выборе Seo-текста.');
}
$tpl->Assign('h1', 'Редактирование Seo-текста');
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Seotext_form_validate();
	if(!$err){
		if($Seo->UpdateSeoText($_POST)){
			$tpl->Assign('msg', 'Seo-текст обновлен.');
			unset($_POST);
			if(!$Seo->SetFieldsById($id, 1)) die('Ошибка при выборе новости.');
		}else{
			$tpl->Assign('msg', 'Ошибка при обновлении Seo-текста.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		if(isset($_POST['date'])&&!isset($errm['date'])){
			list($d,$m,$y) = explode(".", trim($_POST['date']));
			$_POST['date'] = mktime(0, 0, 0, $m , $d, $y);
		}
		$tpl->Assign('msg', 'Seo-текст не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}

if(!isset($_POST['smb'])){
	foreach($Seo->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotext_ae.tpl')
);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Seo-текст";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotext/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование Seo-текста";
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>