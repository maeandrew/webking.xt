 <div class="cart_info <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?> mdl-cell--hide-phone">
	<span class="your_discount">Ваша скидка</span>
	<ul class="tabs_container">
		<li onclick="ChangePriceRange(3, 1)" class="sum_range sum_range_3 <?=isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3?'active':null;?>">0%</li>
		<li onclick="ChangePriceRange(2, 1);" class="sum_range sum_range_2 <?=isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2?'active':null;?>">10%</li>
		<li onclick="ChangePriceRange(1, 1);" class="sum_range sum_range_1 <?=isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1?'active':null;?>">16%</li>
		<li onclick="ChangePriceRange(0, 1);" class="sum_range sum_range_0 <?=isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0?'active':null;?>">21%</li>
	</ul>
	<span class="order_balance">
		<?switch($_COOKIE['sum_range']){
			case 3:
				echo 'Без скидки!';
				break;
			case 2:
				if(isset($_COOKIE['manual']) && $_COOKIE['manual'] == 1){
					if((500 - $_SESSION['cart']['products_sum'][3]) < 0){
						echo 'Заказано достаточно!';
					}else{
						echo 'Дозаказать еще на: <span class="summ">'.number_format(500 - $_SESSION['cart']['products_sum'][3], 2, ',', '').'</span> грн.';
					}
				}else{
					echo 'До следующей скидки <span class="summ">'.number_format(3000 - $_SESSION['cart']['products_sum'][3], 2, ',', '').'</span> грн.';
				}
				break;
			case 1:
				if(isset($_COOKIE['manual']) && $_COOKIE['manual'] == 1){
					if((3000 - $_SESSION['cart']['products_sum'][3]) < 0){
						echo 'Заказано достаточно!';
					}else{
						echo 'Дзаказать еще на: <span class="summ">'.number_format(3000 - $_SESSION['cart']['products_sum'][3], 2, ',', '').'</span> грн.';
					}
				}else{
					echo 'До следующей скидки <span class="summ">'.number_format(10000 - $_SESSION['cart']['products_sum'][3], 2, ',', '').'</span> грн.';
				}
				break;
			case 0:
				if((10000 - $_SESSION['cart']['products_sum'][3]) < 0){
					echo 'Заказано достаточно!';
				}else{
					echo 'Дозаказать еще на: <span class="summ">'.number_format(10000 - $_SESSION['cart']['products_sum'][3], 2, ',', '').'</span> грн.';
				}
				break;
		}?>
	</span>
	<div class="hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'price_nav' : ''?> <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] != 'list' ? 'hidden' : ''?>"></div>
</div>
