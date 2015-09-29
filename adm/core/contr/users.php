<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}

$User = new Users();
$User->SetUser($_SESSION['member']) or exit('Ошибка пользователя.');

// ---- center ----
unset($parsed_res);

$tpl->Assign('h1', 'Пользователи');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";

$arr = false;
if(isset($_POST['smb'])){
	if($_POST['filter_name']!==''){
		$arr['name'] = mysql_real_escape_string($_POST['filter_name']);
	}
	if($_POST['filter_email']!==''){
		$arr['email'] = mysql_real_escape_string($_POST['filter_email']);
	}
	if($_POST['gid']!=='0'){
		$arr['gid'] = mysql_real_escape_string($_POST['gid']);
	}
}else{
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['gid'] = $GLOBALS['REQAR'][1];
		$arr['gid'] = mysql_real_escape_string($_POST['gid']);
		$_POST['smb'] = 1;
	}else{
		$_POST['gid'] = 0;
	}
}

if($User->UsersList(1, $arr)){
	$tpl->Assign('list', $User->list);
}

$groups = $User->GetGroups();
//print_r($groups);
$tpl->Assign('groups', $groups);

foreach($groups as &$g){
	if($g['name'] == 'moderator'){
		$g['name'] = 'admin';
	}
}
$tpl->Assign('g_forlinks', $groups);

//print_r($groups);die();
$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_users.tpl'));

if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>