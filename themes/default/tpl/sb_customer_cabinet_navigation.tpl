<div id="cab_left_bar">
	<!-- <h5>Личный кабинет</h5> -->
	<ul>
		<li>
			<a href="#"><i class="material-icons">face</i>Личные данные</a>
			<ul class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
				<li class="child">
					<a name="t" value="contacts" <?=isset($_GET['t']) && $_GET['t'] == 'contacts'?'class="active"':null;?>  href="<?=Link::Custom('cabinet')?>?t=contacts">Основная информация</a>
				</li>
				<li>
					<a name="t" value="delivery" <?=isset($_GET['t']) && $_GET['t'] == 'delivery'?'class="active"':null;?>  href="<?=Link::Custom('cabinet')?>?t=delivery">Адрес доставки</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#"><i class="material-icons">shopping_cart</i>Мои заказы</a>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'?'active':null;?>">
				<li>
					<a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=all">Все</a>
				</li>
				<li>
					<a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=working">Выполняются</a>
				</li>
				<li>
					<a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=completed">Выполненные</a>
				</li>
				<li>
					<a name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=canceled">Отмененные</a>
				</li>
				<li>
					<a name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=drafts">Черновики</a>
				</li>
			</ul>
		</li>
		<!-- <li>
			<a href="#"><i class="material-icons">person_add</i>Совместные заказы</a>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'cabinet/cooperative'?'active':null;?>">
				<li>
					<a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=all">Все</a>
				</li>
				<li>
					<a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')? 'active' : null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=working">Выполняются</a>
				</li>
				<li>
					<a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=completed">Выполненные</a>
				</li>
			 </ul>
		</li> -->
		<li>
			<a href="#"><i class="material-icons">people</i>Списки друзей</a>
		</li>
		<li>
			<a href="#"><i class="material-icons">settings</i>Настройки</a>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings'?'active':null;?>">
				<li>
					<a name="t" value="basic" <?=(isset($_GET['t']) && $_GET['t']) == 'basic'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=basic">Настройки</a>
				</li>
				<li>
					<a name="t" value="password" <?=(isset($_GET['t']) && $_GET['t']) == 'password'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=password">Смена пароля</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#"><i class="material-icons">add_shopping_cart</i>Бонусная программа</a>
			<?if(isset($GLOBALS['Rewrite'])){ ?>
				<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'bonus'?'active':null;?>">
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
			<a href="<?=Link::Custom('cabinet','favorites')?>"><i class="material-icons">flag</i>Избраное</a>
		</li>
		<li>
			<a href="<?=Link::Custom('cabinet','waitinglist')?>"><i class="material-icons">timeline</i>Лист ожидания</a>
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