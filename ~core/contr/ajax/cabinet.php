<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'GetProdList':
				$Order = new Orders();
				$products = new Products();
				$list = $Order->GetOrderForCustomer(array("o.id_order" => $_POST['id_order']));
				foreach($list as &$p){
					$p['images'] = $products->GetPhotoById($p['id_product']);
				}
				$tpl->Assign('list', $list);
				echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				break;
			case 'GetProdListForCart':
				$Cart = new Cart();
				$list = $Cart->GetProductsForCart($_POST['id_cart']);
				$tpl->Assign('list', $list);
				echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				break;
			case 'GetRating':
				$C = new Contragents();
				$res = $C->GetRating($_POST);
				echo json_encode($res);


			break;
			case 'ChangeInfoUser':
				require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
				list($err, $errm) = Change_Info_validate();
				if(!$err){
					$Customers = new Customers();
					$_POST['cont_person'] = (isset($_POST['first_name'])?trim($_POST['first_name']):null) . ' ' . (isset($_POST['middle_name'])?trim($_POST['middle_name']):null) . ' ' . (isset($_POST['last_name'])?trim($_POST['last_name']):null);
					if($Customers->updateCustomer($_POST)) echo json_encode(true);


				}else{
					print_r($errm);
				}

				break;
		}
	}
}
exit();
?>