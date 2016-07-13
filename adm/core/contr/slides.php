<?php
if(!_acl::isAllow('slides')){
	die("Access denied");
}
$Slides = new Slides();
unset($parsed_res);
$tpl->Assign('h1', 'Слайды');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Слайды";
if(isset($_GET['upload'])){
	$upload_handler = new UploadHandler(array(
		'download_via_php' => true,
		'upload_dir' => $_SERVER['DOCUMENT_ROOT'].'/images/slides/',
		'upload_url' => $_SERVER['DOCUMENT_ROOT'].'/images/slides/',
		'user_dirs' => false,
		'param_name' => 'img',
		'accept_file_types' => '/\.(gif|jpe?g|jpg|png)$/i'
	));
	exit(0);
}
$Slides->SlidesList(1);
$tpl->Assign('list', $Slides->list);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_slides.tpl'));
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}