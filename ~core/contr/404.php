<?php
header("HTTP/1.0 404 Not Found");
// header("HTTP/1.0 410 Gone");
$Page = new Page();
$Page->PagesList();
$tpl->Assign('header', '');
$tpl->Assign('list_menu', $Page->list);
// ---- center ----
G::metaTags(array('page_title' => 'Странице не найдена'));
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_404.tpl');
