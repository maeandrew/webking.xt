<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'GetProdList':
				unset($parsed_res);
				$Order = new Orders();
				$products = $Order->GetOrderForCustomer(array("o.id_order" => $_POST['id_order']));
				$tpl->Assign('products', $products);
				echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
			break;
		}
	}
}
exit();
?>