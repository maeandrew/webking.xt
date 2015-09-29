<?php
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$id_category = isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;
$dbtree->Ajar($id_category, array('id_category', 'category_level', 'name', 'translit'), array('and'=>array('visible=1')));
$list = array();
while($item = $dbtree->NextRow()){
	$list[] = $item;
}
//print_r($list);die();
$tpl->Assign('list', $list);
$parsed_res = array(
	'issuccess'	=> true,
 	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_navigation.tpl')
);
?>