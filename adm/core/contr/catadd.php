<?php
if(!_acl::isAllow('catalog')){
	die("Access denied");
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);

// ---- center ----
unset($parsed_res);

// --------------------------------------------------------------------------------------

$tpl->Assign('h1', 'Добавление категории');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление категории";

if(isset($_POST['smb'])){
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Cat_form_validate();
	if(!$err){
		$arr = array();
		$arr['name'] = trim($_POST['name']);
		$arr['translit'] = G::StrToTrans($_POST['name']);
		$arr['pid'] = ($_POST['pid'] != 1)?trim($_POST['pid']):0;
		$arr['visible'] = isset($_POST['visible']) && $_POST['visible'] == "on"?0:1;
		$arr['indexation'] = isset($_POST['indexation']) && $_POST['indexation'] == "on"?1:0;
		$arr['edit_user'] = $_SESSION['member'][id_user];
		if($id = $dbtree->Insert($arr['pid'], $arr)){
			$tpl->Assign('msg', 'Категория добавлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Ошибочка. Категория не добавлена.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Ошибка! Категория не добавлена.');
		$tpl->Assign('errm', $errm);
	}
}

$list = $dbtree->Full(array('id_category', 'category_level', 'name'));

$tpl->Assign('list', $list);

if(!isset($_POST['smb'])){
	$_POST['id_category'] = 0;
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['pid'] = $GLOBALS['REQAR'][1];
	}
}

$parsed_res = array(
	'issuccess' => true,
 	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat_ae.tpl')
 );

// --------------------------------------------------------------------------------------

if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
