<div id="cab_left_bar" class="cab_left_bar_js" data-lvl="1">
	<!-- <h5>Личный кабинет</h5> -->
	<ul>
		<li class="<?=$_GET['t']=='delivery' || $_GET['t']=='contacts' || $_GET['t']==''?'active':null;?>">
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">face</i>Личные данные</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
			</span>
			<ul class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
				<li class="child <?=$_GET['t']=='contacts' || $_GET['t']==''?'active':null;?>">
					<a name="t" value="contacts" <?=isset($_GET['t']) && $_GET['t'] == 'contacts'?'class="active"':null;?>  href="<?=Link::Custom('cabinet')?>?t=contacts">Основная информация</a>
				</li>
				<li class="<?=$_GET['t']=='delivery'?'active':null;?>">
					<a name="t" value="delivery" <?=isset($_GET['t']) && $_GET['t'] == 'delivery'?'class="active"':null;?>  href="<?=Link::Custom('cabinet')?>?t=delivery">Адрес доставки</a>
				</li>
			</ul>
		</li>
		<li class="<?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='orders'?'active':null;?>">
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">shopping_cart</i>Мои заказы</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'?'active':null;?>">
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=all">Все</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=working">Выполняются</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=completed">Выполненные</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=canceled">Отмененные</a>
				</li>
				<li class="nav <?=!isset($GLOBALS['Rewrite'])?'active':null;?>">
					<a name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>" href="<?=Link::Custom('cabinet', 'orders')?>?t=drafts">Черновики</a>
				</li>
			</ul>
		</li>
		<li class="<?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='cooperative'?'active':null;?>">
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">person_add</i>Совместные заказы</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'cabinet/cooperative'?'active':null;?>">
				<li>
					<a name="t" value="joall" class="all <?=(!isset($_GET['t']) || $_GET['t']=='joall')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=joall">Все</a>
				</li>
				<li class="active_order_js">
					<!--<input type="hidden" data-idcart="<?=$_SESSION['cart']['id']?>" data-iduser="<?=$_SESSION['member']['id_user']?>" data-promo="<?=$_SESSION['cart']['promo']?>" />
					<a class="working <?=(isset($_GET['t']) && $_GET['t']=='working')? 'active' : null;?>" >Активный</a>-->
					<a name="t" value="joactive" class="working <?=(isset($_GET['t']) && $_GET['t']=='joactive')? 'active' : null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=joactive">Активный</a>
				</li>
				<li>
					<a name="t" value="jocompleted" class="completed <?=(isset($_GET['t']) && $_GET['t']=='jocompleted')?'active':null;?>" href="<?=Link::Custom('cabinet', 'cooperative')?>?t=jocompleted">Выполненные</a>
				</li>
			 </ul>
		</li>
		<li>
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">people</i>Списки друзей</a>
				<!-- <span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span> -->
			</span>
		</li>
		<li class="<?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='settings'?'active':null;?>">
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">settings</i>Настройки</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
			</span>
			<ul class="nav <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings'?'active':null;?>">
				<li class="<?=$_GET['t']=='basic'?'active':null;?>">
					<a name="t" value="basic" <?=(isset($_GET['t']) && $_GET['t']) == 'basic'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=basic">Настройки</a>
				</li>
				<li class="<?=$_GET['t']=='password'?'active':null;?>">
					<a name="t" value="password" <?=(isset($_GET['t']) && $_GET['t']) == 'password'?'class="active"':null;?>  href="<?=Link::Custom('cabinet','settings')?>?t=password">Смена пароля</a>
				</li>
			</ul>
		</li>
		<li>
			<span class="link_wrapp">
				<a href="#"><i class="material-icons">add_shopping_cart</i>Бонусная программа</a>
				<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span>
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
	$(document).ready(function() {
		$('.cab_left_bar_js').on('click','.link_wrapp', function() {
			var parent = $(this).closest('li'),
				parent_active = parent.hasClass('active');
			$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();

			if(!parent_active){
				parent.addClass('active').find('> ul').stop(true, true).slideDown();
			}
		});
		/*$('.cab_left_bar_js').on('click','.active_order_js', function() {
			var id_cart = $(this).find('input').data('idcart'),
				id_user = $(this).find('input').data('iduser'),
				promo = $(this).find('input').data('promo');
			data = {id_cart:id_cart, id_user:id_user, promo:promo, condition:'active'};
			ajax('cabinet','GetJOCart', data).done(function(){
				console.log(1);
			}).fail(function(){
				console.log(2);
			});
		});*/
	});
</script>