 <div class="cart_info mdl-cell--hide-phone clearfix">
	<div class="your_discount">Ваша скидка</div>
	<div class="tabs_container">
		<ul>
			<!-- <li class="in_cart_block">
				<a href="#" class="btn_js" data-name="cart">
				<?php
					$str = count($_SESSION['cart']['products']). ' товар';
					$count = count($_SESSION['cart']['products']);
					if(substr($count,-1) == 1 && substr($count,-2) != 1)
						$str .= '';
					else if(substr($count,-1) >= 2 && substr($count,-1) <= 4)
						$str .= 'а';
					else
						$str .= 'ов';
				?>
				<div class="order_cart"><?=$str?></div>
				<span class="material-icons">shopping_cart</span></a>
			</li> -->
			<li onclick="ChangePriceRange(3, 0, 1)" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'active':null;?>">0%</li>
			<li onclick="ChangePriceRange(2, <?=500 - $_SESSION['cart']['products_sum'][3];?>, 1);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'active':null;?>">10%</li>
			<li onclick="ChangePriceRange(1, <?=3000 - $_SESSION['cart']['products_sum'][3];?>, 1);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'active':null;?>">16%</li>
			<li onclick="ChangePriceRange(0, <?=10000 - $_SESSION['cart']['products_sum'][3];?>, 1);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'active':null;?>">21%</li>
		</ul>
	</div>
	<div class="order_balance">
		<?switch ($_COOKIE['sum_range']) {
				case 3:
					?>Без скидки!<?
					break;
				case 2:
					if ($_COOKIE['manual'] == 1){
						if ((500 - $_SESSION['cart']['products_sum'][3]) < 0) {
							?>Заказано достаточно!<?
						}else{
							?>Дозаказать еще на: <span class="summ"><?=number_format(500 - $_SESSION['cart']['products_sum'][3], 2, ',', '');?></span> грн.<?
						}
					}else{
						?>До следующей скидки <span class="summ"><?=number_format(3000 - $_SESSION['cart']['products_sum'][3], 2, ',', '');?></span> грн.<?
					}
					break;
				case 1:
					if ($_COOKIE['manual'] == 1){
						if ((3000 - $_SESSION['cart']['products_sum'][3]) < 0) {
							?>Заказано достаточно!<?
						}else{
						?>Дзаказать еще на: <span class="summ"><?=number_format(3000 - $_SESSION['cart']['products_sum'][3], 2, ',', '')?></span> грн.<?
						}
					}else{
						?>До следующей скидки <span class="summ"><?=number_format(10000 - $_SESSION['cart']['products_sum'][3], 2, ',', '');?></span> грн.<?
					}
					break;
				case 0:
					if ((10000 - $_SESSION['cart']['products_sum'][3]) < 0) {
						?>Заказано достаточно!<?
					}else{
					?>Дозаказать еще на: <span class="summ"><?=number_format(10000 - $_SESSION['cart']['products_sum'][3], 2, ',', '')?></span> грн.<?
					}
					break;
			}
		?>
	</div>
	<div class="<?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'price_nav' : ''?> <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] != 'list' ? 'hidden' : ''?>"></div>
</div>

