<?php
if (!_acl::isAllow('catalog'))
	die("Access denied");

$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);

// ---- center ----
unset($parsed_res);

// --------------------------------------------------------------------------------------

$tpl->Assign('h1', 'Добавление категории');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление категории";

if (isset($_POST['smb'])){

	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

	list($err, $errm) = Cat_form_validate();
	if (!$err){
		$arr = array();
		$arr['name'] = mysql_real_escape_string(trim($_POST['name']));
		$arr['art'] = mysql_real_escape_string(trim($_POST['art']));
		$arr['content'] = mysql_real_escape_string(trim($_POST['content']));
		$arr['translit'] = G::StrToTrans($_POST['name']);
		$arr['pid'] = mysql_real_escape_string(trim($_POST['pid']));

		$arr['visible'] = 1;
		if (isset($_POST['visible']) && $_POST['visible'] == "on")
			$arr['visible'] = 0;
		if ($id = $dbtree->Insert($arr['pid'], '', $arr)){
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


if (!isset($_POST['smb'])){
	$_POST['id_category'] = 0;
	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['pid'] = $GLOBALS['REQAR'][1];
	}
}


$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat_ae.tpl'));


// --------------------------------------------------------------------------------------

if (TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}

// ---- right ----

?>