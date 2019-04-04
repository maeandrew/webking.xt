<div id="cab_left_bar" class="cab_left_bar_js" data-lvl="1">
	<!-- <h5>Личный кабинет</h5> -->
	<ul>
		<li id="icon_face" class="<?=(isset($_GET['t']) && ($_GET['t']=='delivery' || $_GET['t']=='contacts' || $_GET['t']=='')) || (isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='')?'active':null;?>">
			<span class="link_wrap">
				<a href="#"><i class="material-icons">&#xE7FD;</i><span class="textInALink">Личные данные</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
			</span>
			<ul class="nav <?=!isset($GLOBALS['Rewrite'])?'active show':null;?>">
				<li class="child <?=!isset($_GET['t']) || $_GET['t']=='contacts'?'active':null;?>">
					<a name="t" value="contacts" <?=!isset($_GET['t']) || $_GET['t'] == 'contacts'?'class="active"':null;?>  href="<?=Link::Custom('cabinet', null, array('clear' => true))?>?t=contacts">Основная информация</a>
				</li>
				<li class="<?=isset($_GET['t']) && $_GET['t']=='delivery'?'active':null;?>">
					<a name="t" value="delivery" <?=isset($_GET['t']) && $_GET['t'] == 'delivery'?'class="active"':null;?>  href="<?=Link::Custom('cabinet', null, array('clear' => true))?>?t=delivery">Адрес доставки</a>
				</li>
			</ul>
		</li>
		<li id="icon_shopping_cart" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='orders'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="#"><i class="material-icons">&#xE8B0;</i><span class="textInALink">Мои заказы</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'?'active show':null;?>">
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="all" class="all <?=(isset($_GET['t']) && $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders', array('clear' => true))?>?t=all">Все</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders', array('clear' => true))?>?t=working">Выполняются</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders', array('clear' => true))?>?t=completed">Выполненные</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders', array('clear' => true))?>?t=canceled">Отмененные</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders', array('clear' => true))?>?t=drafts">Черновики</a>
				</li>
			</ul>
		</li>
<!-- 		<li id="icon_person_add" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='cooperative'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="#"><i class="material-icons"><i class="material-icons">&#xE7F0;</i></i><span class="textInALink">Совместные заказы</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'cooperative'?'active show':null;?>">
				<li class="active_order_js">
					<a name="t" value="joactive" class="working <?=(isset($_GET['t']) && $_GET['t']=='joactive')? 'active' : null;?>" href="<?=Link::Custom('cabinet', 'cooperative', array('clear' => true))?>?t=joactive">Активный</a>
				</li>
				<li>
					<a name="t" value="joinwork" class="inwork <?=(isset($_GET['t']) && $_GET['t']=='joinwork')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative', array('clear' => true))?>?t=joinwork">В обработке</a>
				</li>
				<li>
					<a name="t" value="jocompleted" class="completed <?=(isset($_GET['t']) && $_GET['t']=='jocompleted')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative', array('clear' => true))?>?t=jocompleted">Выполненные</a>
				</li>
			 </ul>
		</li>
		<li id="icon_people" class="hidden">
			<span class="link_wrap">
				<a href="#"><i class="material-icons">people</i><span class="textInALink">Списки друзей</span></a>
			</span>
		</li> -->
		<li id="icon_settings" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="#"><i class="material-icons">settings</i><span class="textInALink">Настройки</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
				<div class="mdl-tooltip" for="icon_settings">Настройки</div>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings'?'show':null;?>">
				<li class="<?=isset($_GET['t']) && $_GET['t'] == 'basic'?'active':null;?>">
					<a name="t" value="basic" class="<?=isset($_GET['t']) && $_GET['t'] == 'basic'?'active':null;?>" href="<?=Link::Custom('cabinet', 'settings', array('clear' => true))?>?t=basic">Настройки</a>
				</li>
				<li class="<?=isset($_GET['t']) && $_GET['t'] == 'password'?'active':null;?>">
					<a name="t" value="password" class="<?=isset($_GET['t']) && $_GET['t'] == 'password'?'active':null;?>" href="<?=Link::Custom('cabinet', 'settings', array('clear' => true))?>?t=password">Смена пароля</a>
				</li>
			</ul>
		</li>
		<li id="icon_add_shopping_cart" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'bonus'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="#"><i class="material-icons">&#xE8B1;</i><span class="textInALink">Бонусная программа</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
				<div class="mdl-tooltip" for="icon_add_shopping_cart">Бонусная программа</div>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'bonus'?'active show':null;?>">
				<li class="child <?=isset($_GET['t']) && $_GET['t'] == 'bonus_info'?'active':null;?>">
					<a name="t" value="bonus_info" class="<?=isset($_GET['t']) && $_GET['t'] == 'bonus_info'?'active':null;?>" href="<?=Link::Custom('cabinet', 'bonus', array('clear' => true))?>?t=bonus_info">Мой бонусный счет</a>
				</li>
				<li class="child <?=isset($_GET['t']) && $_GET['t'] == 'change_bonus'?'active':null;?>">
					<a name="t" value="change_bonus" class="<?=isset($_GET['t']) && $_GET['t'] == 'change_bonus'?'active':null;?>" href="<?=Link::Custom('cabinet', 'bonus', array('clear' => true))?>?t=change_bonus">
						<?=!empty($_SESSION['member']['bonus']['bonus_card']) ? 'Смена бонусной карты' : 'Активация бонусной карты';?>

					</a>
				</li>
			</ul>
		</li>
		<li id="icon_flag" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'favorites'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="<?=Link::Custom('cabinet', 'favorites', array('clear' => true))?>"><i class="material-icons">&#xE87D;</i><span class="textInALink">Избраное</span></a>
			</span>
		</li>
		<li id="icon_timeline" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'waitinglist'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="<?=Link::Custom('cabinet', 'waitinglist', array('clear' => true))?>"><i class="material-icons">&#xE422;</i><span class="textInALink">Лист ожидания</span></a>
			</span>
		</li>
		<li id="icon_people" <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'agent'?'class="active"':null;?>>
			<span class="link_wrap">
				<a href="#"><i class="material-icons">&#xE227;</i><span class="textInALink">Уголок агента</span></a>
				<span class="more_cat"><i class="material-icons">&#xE315;</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'agent'?'active show':null;?>">
				<?if(G::IsAgent()){?>
					<li class="child <?=!isset($_GET['t']) || $_GET['t'] == 'agent_history'?'active':null;?>">
						<a class="<?=!isset($_GET['t']) || $_GET['t'] == 'agent_history'?'active':null;?>" href="<?=Link::Custom('cabinet', 'agent', array('clear' => true))?>?t=agent_history">История</a>
					</li>
					<li class="child <?=isset($_GET['t']) && $_GET['t'] == 'agent_clients'?'active':null;?>">
						<a class="<?=isset($_GET['t']) && $_GET['t'] == 'agent_clients'?'active':null;?>" href="<?=Link::Custom('cabinet', 'agent', array('clear' => true))?>?t=agent_clients">Список клиентов</a>
					</li>
					<li class="child <?=isset($_GET['t']) && $_GET['t'] == 'agent_gifts'?'active':null;?>">
						<a class="<?=isset($_GET['t']) && $_GET['t'] == 'agent_gifts'?'active':null;?>" href="<?=Link::Custom('cabinet', 'agent', array('clear' => true))?>?t=agent_gifts">Подарки клиентам</a>
					</li>
				<?}?>
				<li class="child <?=isset($_GET['t']) && $_GET['t'] == 'agent_license'?'active':null;?>">
					<a class="<?=isset($_GET['t']) && $_GET['t'] == 'agent_license'?'active':null;?>" href="<?=Link::Custom('cabinet', 'agent', array('clear' => true))?>?t=agent_license">Условия соглашения</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
<script>
	$(document).ready(function() {
		$('.cab_left_bar_js').on('click','.link_wrap', function(){
			var parent = $(this).closest('li'),
				parent_active = parent.hasClass('active');
			$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp().css('opacity', '0');
			if($(document).outerWidth() < 1150){
				parent.closest('.page_content_js').removeClass('posZIndex');
			}
			if(!parent_active){
				parent.addClass('active').find('> ul').stop(true, true).slideDown().css('opacity', '1');
				if ($(document).outerWidth() < 1150) {
					parent.closest('.page_content_js').addClass('posZIndex');
				}
			}
		});
		if($(document).outerWidth() > 1150){
			$('.show').slideDown();
		}
		$('body').on('click', '.posZIndex div:not(.cab_left_bar_js)', function(){
			$('.cab_left_bar_js > ul > li.active').removeClass('active').find('ul').stop(true, true).slideUp().css('opacity', '0');
		});
	});
</script>