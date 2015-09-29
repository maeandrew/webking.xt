<?php
$GLOBALS['__page_title'] = 'e-comments';
$GLOBALS['__page_description'] = 'e-comments';
$GLOBALS['__page_h1'] = 'e-comments';
unset($parsed_res);
include($GLOBALS['PATH_block'].'cp_404.php');
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}
?>