<?php
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1])){
	// $GLOBALS['IERA_LINKS'][0]['title'] = $header;
	// $GLOBALS['IERA_LINKS'][0]['descr'] = 'Подборка самых интересных статей от оптового интернет-магазина ХарьковТОРГ. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей';
	// $GLOBALS['IERA_LINKS'][0]['url']   = _base_url.'/page/';
	if(!$Page->SetFieldsByTranslit($GLOBALS['REQAR'][1])){
		header('Location: '._base_url.'/404/');
		exit();
	}
	$page = $Page->fields;
	$header = $page['title'];
	$tpl->Assign('header', $header);
	$tpl->Assign('data', $page);
	$title = explode(' | ', $header);
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $title[0],
		'descr' => $header,
		'url' => _base_url.'/page/'.$page['translit'].'/'
	);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_page.tpl')
	);
}else{
	$header = 'Статьи оптового торгового центра xt.ua';
	$tpl->Assign('header', $header);
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'descr' => 'Подборка самых интересных статей от оптового интернет-магазина ХарьковТОРГ. Все самое полезное о покупках, оптовой торговли, особенностях выбора. Здесь Вы найдете рекомендации, полезные советы от специалистов и постоянных покупателей',
		'url' => _base_url.'/page/'
	);
	if(!$pagelist = $Page->PagesListByType('katalog')){
		header('Location: /404/');
		exit();
	}
	rsort($pagelist);
	$tpl->Assign('data', $pagelist);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_pages_list.tpl')
	);
}
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}
?>