<div id="cab_left_bar" class="cab_left_bar_js" data-lvl="1">
	<!-- <h5>Личный кабинет</h5> -->
	<ul>
		<li>
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">face</i>Личные данные</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
			</span>
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
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">shopping_cart</i>Мои заказы</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
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
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">people</i>Списки друзей</a>
				<!-- <span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span> -->
			</span>
		</li>
		<li>
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">settings</i>Настройки</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
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
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">add_shopping_cart</i>Бонусная программа</a>
				<!-- <span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span> -->
			</span>
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
			<span class="link_wrapp">
				<a href="<?=Link::Custom('cabinet','favorites')?>"><i class="material-icons">flag</i>Избраное</a>
				<!-- <span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span> -->
			</span>
		</li>
		<li>
			<span class="link_wrapp">
				<a href="<?=Link::Custom('cabinet','waitinglist')?>"><i class="material-icons">timeline</i>Лист ожидания</a>
				<!-- <span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span> -->
			</span>
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
<script>
	$('.cab_left_bar_js').on('click','.more_cat', function() {
		var lvl = $(this).closest('ul').data('lvl'),
			parent = $(this).closest('li'),
			parent_active = parent.hasClass('active');
		$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();
		 // $(this).closest('ul').find('.material-icons').addClass('rotate');

		if(!parent_active){
			parent.addClass('active').find('> ul').stop(true, true).slideDown();
			// $(this).find('.material-icons').addClass('rotate');
		}
	});
</script>