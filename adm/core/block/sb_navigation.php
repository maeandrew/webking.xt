<?php
if(!$Page->PagesList(2)) die('Ошибка при добавлении страницы.');
$Page->PagesListSubCatsOne();
$tpl->Assign('list', $Page->list);
$tpl->Assign('page_fields', $Page->fields);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_navigation.tpl')
);?>