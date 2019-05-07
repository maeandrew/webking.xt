<?php
if(isset($GLOBALS['CURRENT_ID_CATEGORY'])){
	// // echo $GLOBALS['CURRENT_ID_CATEGORY'];
	// foreach($dbtree->GetTagsLevelsList($GLOBALS['CURRENT_ID_CATEGORY']) as $l){
	// 	$level[$l['tag_level']] = $l;
	// 	$level[$l['tag_level']]['tags'] = $dbtree->GetTagsList($GLOBALS['CURRENT_ID_CATEGORY'], $l['tag_level']);
	// }
	// if(isset($level)){
	// 	$tpl->Assign('level', $level);
	// }
	$tpl_sidebar_l .= $tpl->Parse($GLOBALS['PATH_tpl'].'sb_search_filters.tpl');
}
