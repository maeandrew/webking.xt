<?php
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
if($GLOBALS['CurrentController'] == 'products'){
	$current_category = $dbtree->CheckParent($GLOBALS['Rewrite'], array('id_category'));
	if(!$current_category || empty($current_category)){
		header('Location: /404/');
		exit();
	}

	$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category = $current_category['id_category'];
	$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'name', 'translit', 'pid', 'visible'));
	foreach($subcats as &$s){
		$s['subcats'] = count($dbtree->GetSubCats($s['id_category'], 'all'));
	}
	$tpl->Assign('subcats', $subcats);
	$GLOBALS['current_categories'] = GetParents((int) $id_category);
	$GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] = isset($GLOBALS['current_categories']) && is_array($GLOBALS['current_categories'])?end($GLOBALS['current_categories']):0;
}
	// print_r(G::getmicrotime() - $s_time);die();
$navigation = $dbtree->GetCategories(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
foreach($navigation as &$l1){
	$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
	foreach($level2 as &$l2){
		$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
		$l2['subcats'] = $level3;
	}
	$l1['subcats'] = $level2;
}
$tpl->Assign('navigation', $navigation);
unset($current_category, $subcats, $level2, $level3, $id, $res, $id_category);
function GetSubCategories($id_category){
	return true;
}

function GetParents($id_category, $parents = false){
	global $dbtree;
	$parent = $dbtree->CheckParent($id_category, array('id_category', 'pid'));
	if($parent['id_category'] != 0){
		$parents[] = (int) $parent['id_category'];
		$parents = GetParents((int) $parent['pid'], $parents);
	}
	return $parents;
}
