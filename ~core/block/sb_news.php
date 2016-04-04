<?php
if(!isset($News)){
	$News = new News();
}
if($News->NewsList(0, 3)){
	$tpl->Assign('list', $News->list);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_news.tpl')
);?>