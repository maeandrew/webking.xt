<?php
	header("HTTP/1.0 404 Not Found");
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('header', '');
	$tpl->Assign('list_menu', $Page->list);
	// ---- center ----
	unset($parsed_res);
	require($GLOBALS['PATH_block'].'cp_404.php');
	if(TRUE == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
	// ---- right ----
?>