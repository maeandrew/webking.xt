<?php
if (!_acl::isAllow('catalog'))
	die("Access denied");

$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);

// ---- center ----
unset($parsed_res);

// --------------------------------------------------------------------------------------

if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_category = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}

$category = $dbtree->Full(array('id_category', 'category_level', 'name', 'translit', 'art', 'pid', 'content', 'visible'), array('and' => array('id_category = '.$id_category)));

$tpl->Assign('h1', 'Редактирование тегов категории');

$dbtree->Parents($id_category, array('id_category', 'name', 'category_level'));
if (!empty($dbtree->ERRORS_MES)) {
    print_r($dbtree->ERRORS_MES);die();
}
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';

$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование тегов категории";
foreach($dbtree->GetTagsLevelsList($id_category) as $k=>$l){
	$level[$l['tag_level']] = $l; 
	$level[$l['tag_level']]['tags'] = $dbtree->GetTagsList($id_category, $l['tag_level']);
}
$tpl->Assign('level', $level);

if (!isset($_POST['smb'])){
	foreach ($category as $v){
		$_POST = $v;
	}
}
//print_r($_POST);die();

$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat_tag_ae.tpl'));


// --------------------------------------------------------------------------------------

if (TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}

// ---- right ----

?>