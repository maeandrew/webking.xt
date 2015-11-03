<?php
	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Характеристики";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/segmentations/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление сегментации";

	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_segmentation_ae.tpl'));

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>