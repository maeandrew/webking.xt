<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
if(isset($GLOBALS['Rewrite'])){
	if(!$Page->SetFieldsByRewrite($GLOBALS['Rewrite'])){
		header('Location: '._base_url.'/404/');
		exit();
	}
	$page = $Page->fields;
	if($page['sid'] == 0){
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: '._base_url);
		exit();
	}
	G::metaTags($page);
	$header = $page['title'];
	$tpl->Assign('header', $header);
	$tpl->Assign('data', $page);
	$tpl->Assign('indexation', $page['indexation']);
	$title = explode(' | ', $header);
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $title[0],
		'descr' => $header,
		'url' => Link::Custom('page', $page['translit'])
	);
	$template = 'cp_page.tpl';
}else{
	$header = 'Статьи оптового торгового центра xt.ua';
	$tpl->Assign('header', $header);
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'descr' => 'Подборка самых интересных статей от службы снабжения xt.ua. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей',
		'url' => Link::Custom('page')
	);
	if(!$pagelist = $Page->PagesListByType('katalog')){
		header('Location: '._base_url.'/404/');
		exit();
	}
	rsort($pagelist);
	$tpl->Assign('data', $pagelist);
	$template = 'cp_pages_list.tpl';
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].$template)
);
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}