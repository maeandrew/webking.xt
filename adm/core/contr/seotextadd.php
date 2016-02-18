<?php
if(!_acl::isAllow('seotext')){
	die("Access denied");
}
$SEO = new SEO();
unset($parsed_res);
$tpl->Assign('h1', 'Добавление Seo-текста');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Seo-текст";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/seotext/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление Seo-текста";
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Seotext_form_validate();
	if(!$err){
		if($id = $SEO->AddSeoText($_POST)){
			$tpl->Assign('msg', 'Seo-текст добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Seo-текст не добавлен.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		if(isset($_POST['date'])&&!isset($errm['date'])){
			list($d,$m,$y) = explode(".", trim($_POST['date']));
			$_POST['date'] = mktime(0, 0, 0, $m , $d, $y);
		}
		$tpl->Assign('msg', 'Seo-текст не добавлен.');
		$tpl->Assign('errm', $errm);
	}
}
if(!isset($_POST['smb'])){
	$_POST['id'] = 0;
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotext_ae.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
?>