<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(!isset($_SESSION['Cart'])){
		$_SESSION['Cart']['products'] = array();
		$_SESSION['Cart']['sum'] = (float) 0;
	}
	header('Content-Type: text/javascript; charset=utf-8');
	$personal_discount = 0;
	if(isset($_SESSION['member'])){
		$User = new Users();
		$User->SetUser($_SESSION['member']);
		$Customer = new Customers();
		$Customer->SetFieldsById($User->fields['id_user']);
		$personal_discount = $Customer->fields['discount'];
	}
	$cart = new Cart();
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "update_qty":
				if(isset($_GET['opt']) && isset($_GET['id_product'])){
					$note_opt = mysql_real_escape_string(isset($_GET['opt_note'])?$_GET['opt_note']:"");
					$note_mopt = mysql_real_escape_string(isset($_GET['mopt_note'])?$_GET['mopt_note']:"");
					if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
						if(checkNumeric($_GET, array('id_product', 'opt', 'order_mopt_qty', 'order_mopt_sum'))){
							$cart->UpdatePromoProduct($_GET['id_product'], $_GET['opt'], null, $_GET['order_mopt_qty'], $_GET['order_mopt_sum'], $note_opt, $note_mopt, null, null, isset($_GET['mopt_basic_price'])?$_GET['mopt_basic_price']:null);
						}else{
							exit();
						}
					}else{
						if($_GET['opt'] == 1){
							if(checkNumeric($_GET, array('id_product', 'opt', 'order_box_qty', 'order_opt_qty', 'order_opt_sum'))){
								$cart->UpdateProduct($_GET['id_product'], $_GET['opt'], $_GET['order_box_qty'], $_GET['order_opt_qty'], $_GET['order_opt_sum'], $note_opt, $note_mopt, null, $_GET['opt_correction'], $_GET['opt_basic_price']);
							}else{
								exit();
							}
						}else{
							if(checkNumeric($_GET, array('id_product', 'opt', 'order_mopt_qty', 'order_mopt_sum'))){
								$cart->UpdateProduct($_GET['id_product'], $_GET['opt'], null, $_GET['order_mopt_qty'], $_GET['order_mopt_sum'], $note_opt, $note_mopt, null, $_GET['mopt_correction'], $_GET['mopt_basic_price']);
							}else{
								exit();
							}
						}
					}
					$cart->SetTotalQty();
					$cart->SetAllSums();


					//	ob_start();
					//	print_r($_SESSION['Cart']);
					//	print_r($_GET);
					//	$t = ob_get_clean();
					//	G::LogerE($t, "ajax.html", "w");
					$arr = array();
					$arr['id_product'] = $_GET["id_product"];
					$arr['error'] = false;
					$arr['opt'] = $_GET['opt'];
					$arr['sum'] = $_SESSION['Cart']['sum'];
					/***********************************************************/
					isset($note_opt)	?	$arr['note_opt'] = $note_opt	:	null;
					isset($note_mopt)	?	$arr['note_mopt'] = $note_mopt	:	null;
					if(isset($_SESSION['Cart']['sum'])){
						$cart->SetPersonalDiscount($personal_discount);
						$cart->SetSumDiscount();
						$cart->SetAllSums();
						$arr['sum_discount'] = $_SESSION['Cart']['sum_discount'];
					}
					/***********************************************************/
					$arr['string'] = $cart->GetString();
					$arr['total_quantity'] = $_SESSION['Cart']['prod_qty'];
					/***********************************************************/
					$arr['order_opt_sum'] = round($_SESSION['Cart']['order_opt_sum_default'], 2);
					$arr['order_mopt_sum'] = round($_SESSION['Cart']['order_mopt_sum_default'], 2);
					$arr['order_sum'] = $_SESSION['Cart']['order_sum'];
					/***********************************************************/
					$txt = json_encode($arr);
					echo $txt;
					exit();
				}
			;
			break;
			case "update_cart_qty":

				$_SESSION['cart']['products'][$_GET['id_product']]['note'] = isset($_GET['note'])?$_GET['note']:'';
				$res = $cart->UpdateCartQty($_GET);
				$res = $cart->MyCart();
				print_r($res);
				echo json_encode($res);
				exit();
			;
			break;
			case "get_cart":
				echo json_encode($_SESSION['cart']);
			;
			break;
			case "remove_from_cart":
				$res = $cart->RemoveFromCart($_GET['id_product']);
				echo json_encode($res);
				exit();
			;
			break;
			case "update_note":
				if(isset($_SESSION['cart']['products'][$_GET['id_product']]) && !empty($_SESSION['cart']['products'][$_GET['id_product']])){
					$_SESSION['cart']['products'][$_GET['id_product']]['note'] = $_GET['note'];
					$txt = 'ok';
				}else{
					$txt = 'not';
				}
				echo json_encode($txt);
				exit();
			;
			break;
			default:
			;
			break;
		}
	}
	exit();
}?>