<?php
$nav = new Products;
$tpl->Assign('nav', $nav-> generateNavigation($navigation));
$tpl->Assign('sbheader', 'Каталог товаров');
$news = new News();
$tpl->Assign('news', $news->LastNews(1));
$post = new Post();
$tpl->Assign('post', $post->LastPost());

$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_nav.tpl')
);
?>