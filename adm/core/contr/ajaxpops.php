<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{

	header('Content-Type: text/javascript; charset=utf-8');
	
	$Product = new Products();
	if (isset($_POST['action'])){

		if($_POST['action']=="clear"){
			$Product->ClearPopular();
		}
		if(isset($_POST['id_product']) && isset($_POST['id_category'])){

			if($_POST['action']=="add" && checkNumeric($_POST, array('id_product', 'id_category'))){
				$Product->SetPopular($_POST['id_product'], $_POST['id_category']);
			}elseif($_POST['action']=="del" && checkNumeric($_POST, array('id_product', 'id_category'))){
				$Product->DelPopular($_POST['id_product'], $_POST['id_category']);
			}else{
				exit();
			}
			$t = ob_get_clean();
			G::LogerE($t, "ajax.html", "w");
			/*				
			ob_start();
			$t = ob_get_clean();
			G::LogerE($t, "ajax.html", "w");
			*/
			$arr['id_product'] = $_POST["id_product"];
			$arr['id_category'] = $_POST["id_category"];
			
			$txt = json_encode($arr);
			echo $txt;
			exit();
		}
	}
}

exit();



function checkNumeric($arr, $fields){
	$fl = true;
	foreach ($fields as $f){
		if (!is_numeric($arr[$f]))
			$fl = false;
	}
	return $fl;
}
?>