<?if($supplier['warehouse'] == 1){?>
	<form action="<?=_base_url?>/cabinet/assortment/" method="post">
		<button type="submit" class="btn-m-blue min_supplier_prices" name="SetMinSupplierPrices">Установить минимальные цены</button>
	</form>
<?}?>
<div class="sb_block">
	<h4>Информация</h4>
	<div class="sb_container supplier_info animate">
		<div class="line clearfix supplier_name">
			<!-- <div class="parameter fleft">Поставщик:</div> -->
			<div class="value fleft"><?=$supplier['name'];?></div>
		</div>
		<div class="line clearfix animate">
			<div class="fleft">Артикул:</div>
			<div class="value fright"><?=$supplier['article'];?></div>
		</div>
		<div class="line clearfix animate <?=strtotime($supplier['next_update_date'])-time() <= 60*60*24*7*8?'color-red':null;?>">
			<div class="fleft">Рабочие дни до:</div>
			<div class="value fright"><?=date("d.m.Y", strtotime($supplier['next_update_date']));?></div>
		</div>
		<?if(is_numeric($supplier['balance'])){?>
			<div class="line clearfix animate">
				<div class="fleft">Текущий баланс:</div>
				<div class="value fright"><?=number_format($supplier['balance'], 2, ",", "")?> грн.</div>
			</div>
		<?}?>
		<div class="line clearfix animate">
			<div class="fleft">Курс доллара:</div>
			<div class="value fright"><?=number_format($supplier['currency_rate'], 2, ",", "");?> грн.</div>
		</div>
		<div class="line clearfix animate">
			<div class="fleft">Всего товаров:</div>
			<div class="value fright"><?=$supplier['all_products_cnt'];?> шт.</div>
		</div>
		<div class="line clearfix animate">
			<div class="fleft">В наличии:</div>
			<div class="value fright"><?=$supplier['active_products_cnt'];?> шт.</div>
		</div>
		<div class="line clearfix animate">
			<div class="fleft">На модерации:</div>
			<div class="value fright"><?=$supplier['moderation_products_cnt'];?> шт.</div>
		</div>
	</div>
</div>
<div class="sb_block">
	<h4>Навигация</h4>
	<div class="sb_container">
		<ul class="cabinet_navigation">
			<li>
				<a href="<?=_base_url?>/cabinet/assortment/" <?=isset($cabinet_page) && $cabinet_page == 'assortment'?'class="active"':null;?>><span class="icon-font">view_list</span>Ассортимент</a>
			</li>
			<li>
				<a href="#" class="open_modal<?=isset($cabinet_page) && $cabinet_page == 'editproduct'?' active':null;?>" data-target="add_product_js" ><span class="icon-font">add</span>Добавить товар</a>
				<div id="add_product_js" class="modal_hidden">
					<p>Перед созданием нового товара, Мы рекомундуем проверить наличие похожего товара в каталоге, и если такой имеется, добавить его в свой ассортимент. Это существенно сэкономит Ваше время на заполнение информации о товаре.</p>
					<p>Если же в каталоге его нету, необходимо создать новый товар, заполнив всю необходимую информацию, а так же загрузить фото.</p>
					<span class="links">
						<a href="/">Добавить из каталога</a> или <a href="<?=_base_url?>/cabinet/editproduct/?type=new">Создать новый товар</a>?
					</span>
				</div>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/productsonmoderation/" <?=isset($cabinet_page) && $cabinet_page == 'productsonmoderation'?'class="active"':null;?>><span class="icon-font">check</span>Товары на модерации</a>
			</li>
			<!-- <li>
				<a href="<?=_base_url?>/cabinet/promo_orders/" <?=!isset($cabinet_page) || $cabinet_page == 'promo_orders'?'class="active"':null;?>><span class="icon-font">shopping_cart</span>Заказы</a>
			</li> -->
			<!-- <li>
				<a href="<?=_base_url?>/cabinet/promo_codes/" <?=isset($cabinet_page) && $cabinet_page == 'promo_codes'?'class="active"':null;?>><span class="icon-font">bonus</span>Промо-Коды</a>
			</li> -->
			<li>
				<a href="<?=_base_url?>/cabinet/settings/" <?=isset($cabinet_page) && $cabinet_page == 'settings'?'class="active"':null;?>><span class="icon-font">settings</span>Настройки</a>
			</li>
		</ul>
	</div>
</div>
<?if($supplier['balance'] != 0){?>
	<!-- <div class="sb_block">
		<div class="sb_container">
			<div class="customer_balance">
				<p>Баланс:
					<span class="value" <?if($supplier['balance']<0){?>style="color: #f00;"<?}?>>
						<?=$supplier['balance']!=0?number_format($supplier['balance'],2,",","").'<span class="unit"> грн</span>':'<span class="unit">-</span>'?>
					</span>
					<div class="clear"></div>
				</p>
				<?if(isset($supplier['discount']) && $supplier['discount'] != 0){?>
					<p>Персональная скидка:
						<span class="value">
							<?=$supplier['discount'];?><span class="unit">%</span>
						</span>
					</p>
				<?}?>
			</div>
		</div>
	</div> -->
<?}?>