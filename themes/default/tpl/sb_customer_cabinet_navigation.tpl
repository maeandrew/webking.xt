<div id="cab_left_bar">
	<!-- <h5>Личный кабинет</h5> -->
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
		<!-- <li>
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
		</li> -->
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
<!-- <ul>
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
</ul> -->