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
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "update_qty":
				if(isset($_POST['opt']) && isset($_POST['id_product'])){
					$note_opt = mysql_real_escape_string(isset($_POST['opt_note'])?$_POST['opt_note']:"");
					$note_mopt = mysql_real_escape_string(isset($_POST['mopt_note'])?$_POST['mopt_note']:"");
					if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
						if(checkNumeric($_POST, array('id_product', 'opt', 'order_mopt_qty', 'order_mopt_sum'))){
							$cart->UpdatePromoProduct($_POST['id_product'], $_POST['opt'], null, $_POST['order_mopt_qty'], $_POST['order_mopt_sum'], $note_opt, $note_mopt, null, null, isset($_POST['mopt_basic_price'])?$_POST['mopt_basic_price']:null);
						}else{
							exit();
						}
					}else{
						if($_POST['opt'] == 1){
							if(checkNumeric($_POST, array('id_product', 'opt', 'order_box_qty', 'order_opt_qty', 'order_opt_sum'))){
								$cart->UpdateProduct($_POST['id_product'], $_POST['opt'], $_POST['order_box_qty'], $_POST['order_opt_qty'], $_POST['order_opt_sum'], $note_opt, $note_mopt, null, $_POST['opt_correction'], $_POST['opt_basic_price']);
							}else{
								exit();
							}
						}else{
							if(checkNumeric($_POST, array('id_product', 'opt', 'order_mopt_qty', 'order_mopt_sum'))){
								$cart->UpdateProduct($_POST['id_product'], $_POST['opt'], null, $_POST['order_mopt_qty'], $_POST['order_mopt_sum'], $note_opt, $note_mopt, null, $_POST['mopt_correction'], $_POST['mopt_basic_price']);
							}else{
								exit();
							}
						}
					}
					$cart->SetTotalQty();
					$cart->SetAllSums();
					//	ob_start();
					//	print_r($_SESSION['Cart']);
					//	print_r($_POST);
					//	$t = ob_get_clean();
					//	G::LogerE($t, "ajax.html", "w");
					$arr = array();
					$arr['id_product'] = $_POST["id_product"];
					$arr['error'] = false;
					$arr['opt'] = $_POST['opt'];
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
				$_SESSION['cart']['products'][$_POST['id_product']]['note'] = isset($_POST['note'])?$_POST['note']:'';
				$res = $cart->UpdateCartQty($_POST);
				echo json_encode($res);
				exit();
			;
			break;
			case "get_cart":
				echo json_encode($_SESSION['cart']);
			;
			break;
			case "remove_from_cart":
				$res = $cart->RemoveFromCart($_POST['id_product']);
				echo json_encode($res);
			;
			break;
			case "update_note":
				if(isset($_SESSION['cart']['products'][$_POST['id_product']]) && !empty($_SESSION['cart']['products'][$_POST['id_product']])){
					$_SESSION['cart']['products'][$_POST['id_product']]['note'] = $_POST['note'];
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