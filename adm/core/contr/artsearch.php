<?php
$Products = new Products();
if(isset($_POST['art'])){
	$art = $_POST['art'];
	if(($Products->GetIdByArt($art,$arrp['id_product']) == false) or ($art == 0)){
		header('Location: '.$GLOBALS['URL_base'].'adm/?err=404');
	}else{
		header('Location: '.$_SERVER['REQUEST_URL'].'productedit/'.$Products->GetIdByArt($art,$arr['id_product']).'');
	}
}
?>