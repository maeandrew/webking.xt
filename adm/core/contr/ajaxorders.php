<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{

	header('Content-Type: text/javascript; charset=utf-8');
	
	$order = new orders();
	ob_start();	
	if (isset($_POST['restore'])){
		$id_order = $_POST['id_order'];
		$order->RestoreDeleted($id_order);
	}
}

exit();
?>