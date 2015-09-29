<?php

	// ---- center ----

	unset($parsed_res);
	require($GLOBALS['PATH_block'].'cp_msg.php');
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>