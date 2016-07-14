<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_GET['target'])){
		$_POST = $_GET;
	}
	print_r($_POST);
	if(isset($_POST['target']) && file_exists($GLOBALS['PATH_contr'].'ajax/'.$_POST['target'].'.php')){
		require 'ajax/'.$_POST['target'].'.php';
	}else{
		echo 'File doesn\'t exists.';
	}
}else{
	header('Location: '._base_url.'/404');
}