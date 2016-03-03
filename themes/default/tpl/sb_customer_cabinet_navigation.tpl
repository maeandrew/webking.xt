<!-- <div class="sb_block">
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
</div> -->




<div id="cab_left_bar">
	<h5>Личный кабинет</h5>
    <ul>
        <li>
            <i class="material-icons">shopping_cart</i>
            <a class="menus" href="#">Мои заказы</a>
            <ul class="nav">
                <li>
                    <a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=all">Все</a>
                </li>
                <li>
                    <a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=working">Выполняются</a>
                </li>
                <li>
                    <a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=completed">Выполненные</a>
                </li>
                <li>
                    <a name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=canceled">Отмененные</a>
                </li>
                <li>
                    <a name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=drafts">Черновики</a>
                </li>
            </ul>
        </li>
		<li>
			<i class="material-icons">person_add</i>
			<a class="menus"  href="#">Совместные заказы</a>
            <ul class="nav <?=(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'cabinet/cooperative') ? active : null;?>">
                <li>
                    <a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=all">Все</a>
                </li>
                <li>
                    <a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')? active : null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=working">Выполняются</a>
                </li>
                <li>
                    <a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=completed">Выполненные</a>
                </li>
             </ul>
		</li>
		<li>
			<i class="material-icons">face</i>
			<a class="menus" href="#">Личные данные</a>
				<ul class="nav <?=(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'personal') ? active : null;?>">
					<li class="child">
						<a name="t" value="contacts" <?=isset($_GET['t']) && $_GET['t'] == 'contacts'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','personal')?>?t=contacts">Основная информация</a>
					</li>
					<li>
						<a name="t" value="delivery" <?=isset($_GET['t']) && $_GET['t'] == 'delivery'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','personal')?>?t=delivery">Адрес доставки</a>
					</li>
				</ul>
		</li>
		<li>
			<i class="material-icons">people</i>
			<a href="#">Списки друзей</a>
		</li>
		<li>
			<i class="material-icons">settings</i>
			<a class="menus" href="#">Настройки</a>
				<ul class="nav <?=(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings') ? active : null;?>">
					<li>
						<a name="t" value="basic" <?=(isset($_GET['t']) && $_GET['t']) == 'basic'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=basic">Настройки</a>
					</li>
					<li>
						<a name="t" value="password" <?=(isset($_GET['t']) && $_GET['t']) == 'password'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=password">Смена пароля</a>
					</li>
				</ul>
		</li>
		<li>
			<i class="material-icons">add_shopping_cart</i>
			<a class="menus" href="#">Бонусная программа</a>
			<?if(isset($GLOBALS['Rewrite'])){ ?>
				<ul class="nav <?=(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'bonus') ? active : null;?>">
					<li class="child">
						<a name="t" value="bonus_info" <?=(isset($_GET['t']) && $_GET['t']) == 'bonus_info'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','bonus')?>?t=bonus_info">Мой бонусный счет</a>
					</li>
					<li>
						<a name="t" value="change_bonus" <?=(isset($_GET['t']) && $_GET['t']) == 'change_bonus'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','bonus')?>?t=change_bonus">
                            <?=isset($Customer['bonus_card']) ? 'Смена бонусной карты' : 'Активация бонусной карты';?>
						</a>
					</li>
				</ul>
			<?}?>
		</li>
		<li>
			<i class="material-icons">flag</i>
			<a href="<?=Link::Custom('cabinet','favorites')?>">Избраное</a>
		</li>
		<li>
			<i class="material-icons">timeline</i>
			<a href="<?=Link::Custom('cabinet','waitinglist')?>">Лист ожидания</a>
		</li>
	</ul>
</div>
<ul>
	<li><a href=""></a></li>
	<li><a href=""></a></li>
	<li>
		<a href=""></a>
		<ul>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
			<li><a href=""></a></li>
		</ul>
	</li>
	<li><a href=""></a></li>
	<li><a href=""></a></li>
</ul>