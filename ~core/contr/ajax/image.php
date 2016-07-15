<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Images = new Images();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'upload':
				$path = isset($_POST['path'])?$GLOBALS['PATH_root'].$_POST['path']:$GLOBALS['PATH_root'].'/temp/';
				echo str_replace($GLOBALS['PATH_root'], '/', $Images->upload($_FILES, $path));
				break;
			case 'delete':
				echo json_encode(unlink($GLOBALS['PATH_root'].$_POST['path']));
				break;
			default:
				break;
		}
		exit();
	}
}
