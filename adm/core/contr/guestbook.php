<?php
if (!_acl::isAllow('guestbook'))
    die("Access denied");

// ---- center ----
unset($parsed_res);

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Комментарии из гостевой книги";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

/*Pagination*/
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
    $GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
    if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
        $_GET['page_id'] = $_POST['page_nbr'];
    }
    $cnt = count(G::GetInfoGuestBook());
    $tpl->Assign('cnt', $cnt);
    $GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
    $limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
    $GLOBALS['Limit_db'] = 0;
    $limit = '';
}
$list = G::GetInfoGuestBook($limit);
$tpl->Assign('list', $list);
$parsed_res = array('issuccess' => TRUE,
    'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_guestbook.tpl'));

if (TRUE == $parsed_res['issuccess']) {
    $tpl_center .= $parsed_res['html'];
}
