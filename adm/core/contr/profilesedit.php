<?php
if(!_acl::isAllow('profilesedit')){
	die('Access denied');
}
if(!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$header = 'Редактирование профиля';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Профили пользователей';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/news/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

$id = (integer) $GLOBALS['REQAR'][1];
$Profiles = new Profiles();
if(isset($_POST['smb'])){
	$Profiles->Update($_POST);
}
$Profiles->SetFieldsByID($id);
foreach($Profiles->fields as $key => $value){
	$_POST[$key] = $value;
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_profiles_ae.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}