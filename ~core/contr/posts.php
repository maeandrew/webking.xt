<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$Post = new Post();
$header = 'Статьи';
$tpl->Assign('header', $header);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'descr' => 'Подборка самых интересных статей от оптового интернет-магазина ХарьковТОРГ. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей',
	'url' => Link::Custom('post')
);
if(!$Post->SetList()){
	header('Location: '._base_url.'/404/');
	exit();
}
$posts = $Post->list;
rsort($posts);
$tpl->Assign('data', $posts);
$template = 'cp_posts.tpl';
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_posts.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>