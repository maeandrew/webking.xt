<?php

	$GLOBALS['__page_title'] = 'Сообщение';
	$GLOBALS['__page_description'] = 'Сообщение';
	$GLOBALS['__page_h1'] = 'Сообщение';

	// ---- center ----

	unset($parsed_res);
	include($GLOBALS['PATH_block'].'cp_msg.php');
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>