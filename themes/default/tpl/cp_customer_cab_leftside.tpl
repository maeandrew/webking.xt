<div id="cab_left_bar">
	<h5>Личный кабинет</h5>
	<div class="my_orders">
		<i class="material-icons">shopping_cart</i>

	</div>
	<form>
		<ul>
			<li><span id="my_order"><a class="menus1" href="#">Мои заказы</a></span>
				<ul id="navi">
					<li>
						<a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=all">
							Все
						</a>
					</li>
					<li>
						<a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=working">
							Выполняются
						</a>
					</li>
					<li>
						<a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=completed">
							Выполенные
						</a>
					</li>
					<li>
						<a name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=canceled">
							Отмененные
						</a>
					</li>
					<li>
						<a name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>" href="<?=Link::Custom('cabinet')?>?t=drafts">
							Черновики
						</a>
					</li>
				</ul>
			</li>
		</ul>

	</form>
	<ul id="navi2">
		<li>
			<i class="material-icons">face</i>
			<a class="menus" href="#">Личные данные</a>
			<?if(isset($GLOBALS['Rewrite'])){ ?>
				<ul id="nav" <?=$GLOBALS['Rewrite'] == 'personal'?'class="active"':null;?>>
					<li class="child">
						<a name="t" value="contacts" <?=isset($_GET['t']) && $_GET['t'] == 'contacts'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','personal')?>?t=contacts">
							Основная информация
						</a>
					</li>
					<li>
						<a name="t" value="delivery" <?=isset($_GET['t']) && $_GET['t'] == 'delivery'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','personal')?>?t=delivery">
							Адрес доставки
						</a>
					</li>
				</ul>
			<?}?>
		</li>
		<li>
			<i class="material-icons">people</i>
			<a href="<?=Link::Custom('cabinet','personal')?>">Списки друзей</a>
		</li>
		<li>
			<i class="material-icons">settings</i>
			<a class="menus" href="#">Настройки</a>
			<?if(isset($GLOBALS['Rewrite'])){?>
				<ul id="nav" <?=$GLOBALS['Rewrite'] == 'settings'?'class="active"':null;?>>
					<li>
						<a name="t" value="basic" <?=isset($_GET['t']) && $_GET['t'] == 'basic'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=basic">Настройки</a>
					</li>
					<li>
						<a name="t" value="password" <?=isset($_GET['t']) && $_GET['t'] == 'password'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=password">Смена пароля</a>
					</li>
				</ul>
			<?}?>
		</li>
		<li>
			<i class="material-icons">add_shopping_cart</i>
			<a class="menus" href="#">Бонусная программа</a>
			<?if(isset($GLOBALS['Rewrite'])){ ?>
				<ul id="nav" <?=$GLOBALS['Rewrite'] == 'bonus'?'class="active"':null;?>>
					<li class="child">
						<a name="t" value="bonus_info" <?=isset($_GET['t']) && $_GET['t'] == 'bonus_info'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','bonus')?>?t=bonus_info">
							Мой бонусный счет
						</a>
					</li>
					<li>
						<a name="t" value="change_bonus" <?=isset($_GET['t']) && $_GET['t'] == 'change_bonus'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','bonus')?>?t=change_bonus">

						<?if(!$Customer['bonus_card']){?>
							Активация бонусной карты
						<?}else{?>
							Смена бонусной карты
						<?}?>
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