<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$Post = new Post();
$GLOBALS['IERA_LINKS'][] = array(
	'title' => 'Статьи',
	'descr' => 'Подборка самых интересных статей от службы снабжения xt.ua. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей',
	'url' => Link::Custom('post')
);

if(isset($GLOBALS['Rewrite'])){
	unset($parsed_res);
	if(!$Post->SetFieldsByRewrite($GLOBALS['Rewrite'])){
		header('Location: '._base_url.'/404/');
		exit();
	}
	$post = $Post->fields;
	$header = $post['title'];
	$tpl->Assign('header', $header);
	$tpl->Assign('data', $post);
	$tpl->Assign('indexation', $post['indexation']);
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => Link::Custom('post', $post['translit'])
	);
	$template = 'cp_post.tpl';
}else{
	$header = 'Статьи';
	$tpl->Assign('header', $header);
	$Post->SetList();
	$posts = $Post->list;
	if(!empty($posts)){
		rsort($posts);
	}
	$tpl->Assign('list', $posts);
	$template = 'cp_post.tpl';
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].$template)
);
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>