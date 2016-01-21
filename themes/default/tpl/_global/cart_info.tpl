<div class="cart_info clearfix">
<?
$cart_sum = $_SESSION['cart']['products_sum']['3'];
if($cart_sum >= 0 && $cart_sum < 500) {
	$percent = 0;
}elseif($cart_sum >= 500 && $cart_sum < 3000) {
	$percent = 10;
}elseif($cart_sum >= 3000) {
	$percent = 16;
}else{
	$percent = 21;
};
?>
	<div id="perc_cont">
		<div class="your_discount" style="color: #000;">Ваша скидка <?=round($cart_sum * ($percent/100),2)?> грн (<?=$percent?>%)</div>
		<div class="order_balance">
			<table id="percent">
				<tr <?=$percent == 0 ? : "style='display:none'"?>>
					<td>Добавь:</td>
					<td><?=round(500-$cart_sum,2)?>грн</td>
					<td>Получи скидку:</td>
					<td>50грн (10%)</td>
				</tr>
				<tr <?=($percent == 0 || $percent == 10)? : "style='display:none'"?>>
					<td>Добавь:</td>
					<td><?=round(3000-$cart_sum,2)?>грн</td>
					<td>Получи скидку:</td>
					<td>300грн (16%)</td>
				</tr>
				<tr <?=($percent == 0 || $percent == 10 || $percent == 16)? : "style='display:none'"?>>
					<td>Добавь:</td>
					<td><?=round(10000-$cart_sum,2)?>грн</td>
					<td>Получи скидку:</td>
					<td>2100грн (21%)</td>
				</tr>
			</table>
		</div>
	</div>
	<form action="#">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="sample7">
			<label class="mdl-textfield__label" for="sample7">Промокод</label>
			<lable type="button" class="mdl-button mdl-js-button mdl-button--raised">Применить</lable>
		</div>


	</form>
	<div class="price_nav"></div>
</div>

<script type="text/javascript">

	if($('#percent tr:eq(0)').is(':visible')){
		$('#percent tr:eq(0)').css('color', '#000');
	}
//	if($('#percent tr:eq(0)').is(':hidden')){
//		$('#percent tr:eq(1)').css('color', '#000');
//	}
//	if($('#percent tr:eq(1)').is(':hidden')){
//		$('#percent tr:eq(2)').css('color', '#000');
//	}

</script>

<!-- <div class="cart_info clearfix">
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
			</li>
			<li onclick="ChangePriceRange(3, 0)" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'active':null;?>">0%</li>
			<li onclick="ChangePriceRange(2, <?=500 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'active':null;?>">10%</li>
			<li onclick="ChangePriceRange(1, <?=3000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'active':null;?>">16%</li>
			<li onclick="ChangePriceRange(0, <?=10000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'active':null;?>">21%</li>
		</ul>
	</div>
	<div class="order_balance">
		<?if($_COOKIE['sum_range'] == 3) { ?>
			Готово!
		<?}elseif($_COOKIE['sum_range'] == 2){ ?>
			Еще заказать на <span class="summ"><?=number_format(500 - $_SESSION['cart']['cart_sum'], 2, ',', '');?></span> грн.
		<?}elseif($_COOKIE['sum_range'] == 1){ ?>
			Еще заказать на <span class="summ"><?=number_format(3000 - $_SESSION['cart']['cart_sum'], 2, ',', '')?></span> грн.
		<?}elseif($_COOKIE['sum_range'] == 0){ ?>
			Еще заказать на <span class="summ"><?=number_format(10000 - $_SESSION['cart']['cart_sum'], 2, ',', '')?></span> грн.
		<?}?>
	</div>
	<div class="price_nav"></div>
</div>-->

