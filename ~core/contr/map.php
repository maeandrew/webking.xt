<?php

	// ---- center ----

	$GLOBALS['MainTemplate'] = 'empty.tpl';

	$AddrNar = new AddrNar();


	unset($parsed_res);
	require($GLOBALS['PATH_block'].'cp_map.php');
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

?>