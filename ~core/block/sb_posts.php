<?php
$Post = new Post();
$Post->SetList();
$posts = $Post->list;
if(empty($posts)){
	$Page = new Page();
	$posts = $Page->PagesListByType('katalog');
}
$tpl->Assign('posts', $posts);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_posts.tpl')
);
?>