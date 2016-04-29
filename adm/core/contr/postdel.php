<?php
$Post = new Post();
// ---- center ----
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
    $id_post = $GLOBALS['REQAR'][1];
}else{
    header('Location: '.$GLOBALS['URL_base'].'404/');
    exit();
}
$tpl->Assign('h1', 'Удаление новости');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Статьи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/posts/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление статьи";
if(!$Post->DelPage($id_post)) die('Ошибка при удалении статьи.');
$tpl->Assign('msg', 'Новость удалена.');
$parsed_res = array(
	'issuccess' => true,
    'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
);
if(true == $parsed_res['issuccess']) {
    $tpl_center .= $parsed_res['html'];
}