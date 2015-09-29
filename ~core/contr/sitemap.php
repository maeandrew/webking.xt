<?php



	// ---- center ----

	unset($parsed_res);



	$Page = new Page();

	$Page->PagesList();

	$tpl->Assign('list_menu', $Page->list);



	$items = new Items();

	$dbtree = new dbtree('im_cat', 'cat', $db);

	$Manufacturers = new Manufacturers();



	$dbtree->Full(array('cat_id', 'cat_level', 'name', 'translit'), array('and'=>array('visible=1')));

	while ($item = $dbtree->NextRow()) {

		$list[] = $item;

	}

	$tpl->Assign('cat_list', $list);



	$tpl->Assign('pages_list', $Page->list);



	$Manufacturers->ManufacturersList();

	$tpl->Assign('mans_list', $Manufacturers->list);





	$GLOBALS['SITEMAP_URLS'][] =  _base_url;



	$parsed_res = array('issuccess' => TRUE,

 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_sitemap.tpl'));





	$items->SetItemsList(array('visible'=>1));

	$tpl->Assign('items_list', $items->list);



	foreach ($items->list as $li){

		$GLOBALS['SITEMAP_URLS'][] =  _base_url.'/item/'.$li['item_id'].'/'.$li['translit'].'/';

	}



	$GLOBALS['SITEMAP_URLS'][] =  _base_url.'/search/';

	$GLOBALS['SITEMAP_URLS'][] =  _base_url.'/sitemap.xml';



	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$first = true;

	foreach ($GLOBALS['SITEMAP_URLS'] as $url){

		$priority = $first?"1":"0.8";

		$sitemap .= "

<url>

	<loc>$url</loc>

	<lastmod>".date("d.m.Y", time())."</lastmod>

	<changefreq>monthly</changefreq>

	<priority>$priority</priority>

</url>";

		$first = false;

	}



	$sitemap .= '</urlset>';



	$fp = fopen("sitemap.xml", "w");

	fputs($fp, $sitemap);

	fclose($fp);







	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];

	}



	// ---- right ----



	$ii = count($GLOBALS['IERA_LINKS']);

	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Карта сайта";

	$GLOBALS['IERA_LINKS'][$ii++]['url'] =  _base_url.'/sitemap/';





?>