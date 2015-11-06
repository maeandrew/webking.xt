<?php
	// ---- center ----
	unset($parsed_res);
	$segmentation = new Segmentation();

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Сегментации";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/segmentations/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление сегментации";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	//Получение списка типов сегментаций
	$tpl->Assign('typelist', $segmentation->GetSegmentationType());

	if(isset($_POST['smb'])){
		//Добавление Сигмантации
		if($segmentation->AddSegmentation($_POST)){
			$tpl->Assign('msg', 'Сегментация успешно добавлена.');
			echo "<script Language=\"JavaScript\">setTimeout(\"document.location='".$GLOBALS['URL_base'].$_SERVER['REQUEST_URI']."'\", 2000);</script>";
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Сегментация не добавлена.');
			$tpl->Assign('errm', 'Error');
		}

	}

	$parsed_res = array(
		'issuccess' => TRUE,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_segmentation_ae.tpl')
	);

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>