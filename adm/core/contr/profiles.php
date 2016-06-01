<?php
if(!_acl::isAllow('profiles')){
	die('Access denied');
}
$header = 'Профили пользователей';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

$Profiles = new Profiles();
$Profiles->SetList();
$tpl->Assign('list', $Profiles->list);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_profiles.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}