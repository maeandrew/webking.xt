<div class="sb_block">
	<h6>Личный кабинет</h6>
	<div class="sb_container">
		<ul class="cabinet_navigation">
			<li>
				<a href="<?=_base_url?>/cabinet/orders/" <?=(!isset($cabinet_page) || $cabinet_page == 'orders')?'class="active"':null;?>><span class="font_icons">o</span>Мои заказы</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/personal/" <?=(isset($cabinet_page) && $cabinet_page == 'personal')?'class="active"':null;?>><span class="font_icons">p</span>Личные данные</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/settings/" <?=(isset($cabinet_page) && $cabinet_page == 'settings')?'class="active"':null;?>><span class="font_icons">s</span>Настройки</a>
			</li>
			<li>
				<a href="<?=_base_url?>/cabinet/bonus/" <?=(isset($cabinet_page) && $cabinet_page == 'bonus')?'class="active"':null;?>><span class="font_icons">b</span>Бонусная программа</a>
			</li>
			<li style="display: none;">
				<a href="<?=_base_url?>/cabinet/feedback/" <?=(isset($cabinet_page) && $cabinet_page == 'feedback')?'class="active"':null;?>><span class="font_icons">f</span>Обратная связь</a>
			</li>
		</ul>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
<div class="sb_block" style="border-top: 1px solid #aaa;margin-top: 20px">
	<div class="sb_container">
		<?if($Customer['balance']!=0){?>
			<div class="customer_balance">
				<p>Остаток на счету:
					<span class="value" <?if($Customer['balance']<0){?>style="color: #f00;"<?}?>>
						<?=$Customer['balance']!=0?number_format($Customer['balance'],2,",","").'<span class="unit"> грн</span>':'<span class="unit">-</span>'?>
					</span>
					<div class="clear"></div>
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
				<a href="/page/Skidki/">Условия бонусной программы.</a>
			</div>
		<?}?>
		<div class="clear"></div>
	</div>
</div>
<div style="margin-bottom: 30px;"></div>