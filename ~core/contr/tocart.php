<?php
if(1 || $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{G::LogerE("12321");
	header('Content-Type: text/javascript; charset=utf-8');
	$_GET = $_POST;
	if (isset($_GET['type']) && isset($_GET['id_product']) && is_numeric($_GET['id_product'])){
		G::LogerE("12321");
		if ($_GET['type'] == "opt"){G::LogerE("---");
			//$arr['id_product']
			//json_encode($arr);
			$txt =  
			'{
			  "id_product": "'.$_GET["id_product"].'",
			  "errors": "false",
			  "opt_qty:" "3"
			}';
			G::LogerE($txt);
		}else{
			$txt = '{"mopt": "'.$_GET['id_product'].'"}';
		}
		echo $txt;
	}
	
	exit();
}

?>