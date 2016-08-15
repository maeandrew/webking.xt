<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

	//header('Content-Type: text/javascript; charset=utf-8');
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	$specification = new Specification();
	if (isset($_POST['action'])){
		switch($_POST['action']){

		}
	}
	exit();
}