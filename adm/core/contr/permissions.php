<?php
if(!_acl::isAllow('permissions')){
	die('Access denied');
}
$header = 'Права доступа';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

$current_id_profile = 0;
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$current_id_profile = $GLOBALS['REQAR'][1];
}

$Profiles = new Profiles();
$Profiles->SetList();
$profiles_list = $Profiles->list;

$tpl->Assign('profiles_list', $profiles_list);
$Profiles->SetFieldsById($current_id_profile);
$tpl->Assign('current_profile', $Profiles->fields);
$controllers = G::GetControllers($GLOBALS['PATH_contr']);
foreach($controllers as $val){
	$list[] = preg_replace('/(?:edit|del|add)$/', '', $val);
}

$tpl->Assign('list', array_unique($list));
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_permissions.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}