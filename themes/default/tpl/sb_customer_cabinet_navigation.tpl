<div class="sb_block">
	<h4>Личный кабинет</h4>
	<div class="sb_container">
		<ul class="cabinet_navigation">
			<li>
				<a href="<?=_base_url?>/cabinet/orders/" <?=(!isset($cabinet_page) || $cabinet_page == 'orders')?'class="active"':null;?>><span class="icon-font">shopping_cart</span>Мои заказы</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/personal/" <?=(isset($cabinet_page) && $cabinet_page == 'personal')?'class="active"':null;?>><span class="icon-font">profile_card</span>Личные данные</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/settings/" <?=(isset($cabinet_page) && $cabinet_page == 'settings')?'class="active"':null;?>><span class="icon-font">settings</span>Настройки</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/bonus/" <?=(isset($cabinet_page) && $cabinet_page == 'bonus')?'class="active"':null;?>><span class="icon-font">bonus</span>Бонусная программа</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/favorites/" <?=(isset($cabinet_page) && $cabinet_page == 'favorites')?'class="active"':null;?>><span class="icon-font">favorites</span>Избранное</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/waitinglist/" <?=(isset($cabinet_page) && $cabinet_page == 'waitinglist')?'class="active"':null;?>><span class="icon-font">Line</span>Лист ожидания</a>
			</li>
			<li class="hidden">
				<a href="<?=_base_url?>/cabinet/feedback/" <?=(isset($cabinet_page) && $cabinet_page == 'feedback')?'class="active"':null;?>><span class="icon-font">headset</span>Обратная связь</a>
			</li>
		</ul>
	</div>
</div>
<div class="sb_block">
	<div class="sb_container">
		<?if($Customer['balance'] != 0){?>
			<div class="customer_balance">
				<p>Остаток на счету:
					<span class="value <?=$Customer['balance']<0?'color-red':null?>">
						<?=$Customer['balance']!=0?number_format($Customer['balance'],2,",","").'<span class="unit"> грн</span>':'<span class="unit">-</span>'?>
					</span>
				</p>
				<?if($Customer['discount']!=0){?>
					<p>Персональная скидка:
						<span class="value">
							<?=$Customer['discount']!=0?$Customer['discount']:0?><span class="unit">%</span>
						</span>
					</p>
				<?}?>
			</div>
		<?}?>
		<?if(!$Customer['bonus_card']){?>
			<div class="bonus_balance">
				<p>Чтобы открыть бонусный счет, <a href="<?=_base_url?>/cabinet/bonus/?t=change_bonus">активируйте бонусную карту</a></p>
			</div>
		<?}else{?>
			<div class="bonus_balance">
				<p>Бонусный баланс:
					<span class="value">
						<?=$Customer['bonus_balance']!=null?number_format($Customer['bonus_balance'],2,",",""):"20,00"?><span class="unit"> грн</span>
					</span>
				</p>
				<p>Бонусный Процент:
					<span class="value">
						<?=$Customer['bonus_discount']!=null?$Customer['bonus_discount']:1?><span class="unit">%</span>
					</span>
				</p>
				<hr>
				<a href="<?=_base_url?>/page/Skidki/">Условия бонусной программы.</a>
			</div>
		<?}?>
	</div>
</div>