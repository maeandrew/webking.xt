<?php
	if (!_acl::isAllow('segmentations')){
		die("Access denied");
	}


	$segmentation = new Segmentation();

	// // ---- center ----
	unset($parsed_res);
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Сегментации";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	$tpl->Assign('list_types', $segmentation->GetSegmentationType());
	$tpl->Assign('list', $segmentation->GetSegmentation());

	$parsed_res = array(
		'issuccess' => TRUE,
 		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_segmentations.tpl')
 	);

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

?>
