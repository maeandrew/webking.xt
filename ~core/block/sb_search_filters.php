<?php
foreach($dbtree->GetTagsLevelsList($id_category) as $l){
	$level[$l['tag_level']] = $l; 
	$level[$l['tag_level']]['tags'] = $dbtree->GetTagsList($id_category, $l['tag_level']);
}
if(isset($level)){
	$tpl->Assign('level', $level);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_search_filters.tpl')
);
?>