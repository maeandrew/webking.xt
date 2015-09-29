<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$Post = new Post();
unset($parsed_res);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => 'Статьи',
	'descr' => 'Подборка самых интересных статей от оптового интернет-магазина ХарьковТОРГ. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей',
	'url' => '/posts/'
);
if(!$Post->SetFieldsById($GLOBALS['REQAR'][1])){
	header('Location: /404/');
	exit();
}
$post = $Post->fields;
$header = $post['title'];
$tpl->Assign('header', $header);
$tpl->Assign('data', $post);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => '/post/'.$post['id'].'/'.$post['translit'].'/'
);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_post.tpl')
);
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>