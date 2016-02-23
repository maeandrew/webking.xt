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
		$arr['name'] = $_POST['filter_name'];
	}
	if($_POST['filter_email']!==''){
		$arr['email'] = $_POST['filter_email'];
	}
	if($_POST['gid']!=='0'){
		$arr['gid'] = $_POST['gid'];
	}
}else{
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['gid'] = $GLOBALS['REQAR'][1];
		$arr['gid'] = $_POST['gid'];
		$_POST['smb'] = 1;
	}else{
		$_POST['gid'] = 0;
	}
}
//Paginator
$User->UsersList(1, $arr);
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = count($User->list);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
if($User->UsersList(1, $arr, $limit)){
	$tpl->Assign('list', $User->list);
}
$groups = $User->GetGroups();
$tpl->Assign('groups', $groups);

foreach($groups as &$g){
	if($g['name'] == 'moderator'){
		$g['name'] = 'admin';
	}
}
$tpl->Assign('g_forlinks', $groups);
$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_users.tpl'));
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>