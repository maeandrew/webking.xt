<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_REQUEST['target']) && file_exists($GLOBALS['PATH_contr'].'ajax/'.$_REQUEST['target'].'.php')){
		require 'ajax/'.$_REQUEST['target'].'.php';
	}else{
		echo 'File doesn\'t exists.';
	}
}else{
	header('Location: '._base_url.'/404');
}
exit(0);
