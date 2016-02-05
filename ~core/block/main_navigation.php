<?php
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
if($GLOBALS['CurrentController'] == 'products'){
	$curcat = $dbtree->CheckParent($GLOBALS['Rewrite'], array('id_category', 'name', 'translit', 'art', 'category_level', 'content', 'pid', 'filial_link'));
	if(!$curcat || empty($curcat)){
		header('Location: /404/');
		exit();
	}
	$tpl->Assign('curcat', $curcat);

	$id_category = $curcat['id_category'];
	$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category;
	$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'name', 'translit', 'art', 'pid', 'visible'));
	foreach($subcats as &$s){
		$subcats2 = count($dbtree->GetSubCats($s['id_category'], 'all'));
		$s['subcats'] = $subcats2;
	}
	$tpl->Assign('subcats', $subcats);

	$id = $id_category;
	while($id != 0){
		$res = $dbtree->CheckParent($id, array('id_category', 'pid'));
		$GLOBALS['current_categories'][] = $res['id_category'];
		$id = $res['pid'];
	}
	$GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] = isset($GLOBALS['current_categories']) && is_array($GLOBALS['current_categories'])?end($GLOBALS['current_categories']):0;
}

$navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
if(!empty($navigation)){
	foreach($navigation as &$l1){
		$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
		foreach($level2 as &$l2){
			$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
			$l2['subcats'] = $level3;
		}
		$l1['subcats'] = $level2;
	}
}
$tpl->Assign('navigation', $navigation);
unset($curcat, $navigation, $subcats, $level2, $level3, $id, $res, $id_category);
?>