<?php
$products = new Products();
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['action'])){
		switch ($_POST['action']){
			case "switchtab":
				$_SESSION['ActiveTab'] = $_POST['activetab']==1?1:0;
				exit();
			break;
			case "send_interview_result":
				$Mailer = new Mailer();
				$Mailer->SendInterviewResult($_POST['html']);
				exit();
			break;
			case "save_interview_result":
				$Customers = new Customers();
				$arr = explode('&', $_POST['string']);
				foreach($arr as $a){
					$part = explode('=', $a);
					if(isset($part[1])){
						if($part[0] == 'categories'){
							$substring = str_replace('<br>', '', $part[1]);
							$res[$part[0]] = $substring;
						}else{
							$res[$part[0]] = $part[1];
						}
					}
				}
				$Customers->SaveInterviewResults($res);
				exit();
			break;
			case "count_views_products":
				$products->UpdateViewsProducts($_POST['count_views'], $_POST['id_product']);
			;
			break;
			default:
				;
			break;
		}
	}
	exit();
}
?>