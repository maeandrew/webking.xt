<div class="cart_info clearfix">
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
			<li onclick="ChangePriceRange(3, 0)" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'active':null;?>">0%</li>
			<li onclick="ChangePriceRange(2, <?=500 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'active':null;?>">10%</li>
			<li onclick="ChangePriceRange(1, <?=3000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'active':null;?>">16%</li>
			<li onclick="ChangePriceRange(0, <?=10000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'active':null;?>">21%</li>
		</ul>
	</div>
	<div class="order_balance">
		<?if($_COOKIE['sum_range'] == 3) {;?>
			Готово!
		<?}elseif($_COOKIE['sum_range'] == 2){?>
			Еще заказать на <span class="summ"><?=number_format(500 - $_SESSION['cart']['cart_sum'], 2, ',', '');?></span> грн.
		<?}elseif($_COOKIE['sum_range'] == 1){?>
			Еще заказать на <span class="summ"><?=number_format(3000 - $_SESSION['cart']['cart_sum'], 2, ',', '')?></span> грн.
		<?}elseif($_COOKIE['sum_range'] == 0){?>
			Еще заказать на <span class="summ"><?=number_format(10000 - $_SESSION['cart']['cart_sum'], 2, ',', '')?></span> грн.
		<?}?>
	</div>
	<div class="price_nav"></div>
</div>