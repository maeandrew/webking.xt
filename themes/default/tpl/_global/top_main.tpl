<div class="header_wrapp">
	<div class="logo">
		<a href="<?=Link::Custom('main', null, array('clear' => true));?>" rel="nofollow"><img src="<?=_base_url.'/themes/default/img/_xt.svg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="search_wrap">
		<form name="search" action="<?=Link::Custom('search');?>" method="get">
			<label class="search_query_input" for="search">
				<input class="btn_js" name="query" id="search" type="search" required="required" placeholder="Поиск..." data-name="header_js" value="<?=isset($_GET['query'])?htmlspecialchars($_GET['query']):null;?>">
			</label>
			<label class="search_category_input mdl-cell--hide-tablet mdl-cell--hide-phone" for="search_category">
				<select id="search_category" name="search_category">
					<option value="" data-id-category="0">По всем категориям</option>
					<?foreach($navigation as &$v){ ?>
						<option value="<?=$v['id_category']?>" data-id-category="<?=$v['id_category']?>"><?=$v['name']?></option>
					<?}?>
				</select>
			</label>
			<button type="submit" class="search_btn">Найти</button>
			<button class="mdl-button mdl-js-button mdl-button--icon header_search_input_toggle_js header_search_input_hide">
				<i class="material-icons">&#xE5CD;</i>
			</button>
		</form>
	</div>
	<div class="header_right">
		<div class="search_toggle_button">
			<a href="#" class="header_search_input_toggle_js header_search_input_show">
				<i class="material-icons">&#xE8B6;</i>
			</a>
		</div>
		<div class="random_page mdl-cell--hide-tablet mdl-cell--hide-phone hidden">
			<?$rand = rand(0, count($list_menu)-1);?>
			<a href="<?=Link::Custom('page', $list_menu[$rand]['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><?=$list_menu[$rand]['title']?></a>
		</div>
		<div class="pages_list">
			<a href="#" id="menu-lower-right" class="mdl-cell--hide-phone navigation">
				<i class="material-icons">&#xE5D2;</i>
			</a>
			<a href="#" class="mdl-cell--hide-tablet mdl-cell--hide-desktop navigation btn_js" data-name="phone_menu">
				<i class="material-icons">&#xE5D2;</i>
			</a>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu  mdl-cell--hide-phone" for="menu-lower-right">
				<?foreach($list_menu as $key => &$menu){?>
					<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><?=$menu['title']?></a>
				<?}?>
				<a class="mdl-menu__item" href="<?=Link::Custom('price');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>Прайс-листы</a>
			</nav>
		</div>
		<div class="cart_item ga-cart <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
			<div class="currentCartSum hidden"><?=isset($_SESSION['cart']['products_sum'][3])?$_SESSION['cart']['products_sum'][3]:null?></div>
			<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-badge--overlap cart btn_js <?=$_SESSION['cart']['cart_sum'] == 0?'for_hidden_js':null;?>" data-name="cart"><i class="material-icons mdl-badge--overlap<?=!empty($_SESSION['cart']['products'])?' mdl-badge':null;?>" data-badge="<?=isset($_SESSION['cart']['products'])?count($_SESSION['cart']['products']):0;?>">&#xE8CC;</i><span class="mdl-cell--hide-tablet mdl-cell--hide-phone"><span>Корзина</span><span>:</span><br><span class="total_cart_summ_js">
			<?print_r(number_format($_SESSION['cart']['cart_sum'], 2, ',', ''));?>
			грн.</span></span></a>
		</div>
		<div class="profile mdl-cell--hide-phone">
			<?if(G::IsLogged()){?>
				<a href="#" id="user_profile" class="cabinet_btn">
					<?if($_SESSION['member']['avatar']){?>
						<img class="image" src="<?=G::GetUserAvatarUrl()?>"/>
					<?}else{?>
						<span class="image" style="background: <?printf( "#%s", $_SESSION['member']['personal_color']); ?>"><?=mb_substr($_SESSION['member']['name'], 0, 1); ?></span>
					<?}?>
					<span class="name mdl-cell--hide-tablet mdl-cell--hide-phone"><?=isset($_SESSION['member']['first_name'])?$_SESSION['member']['first_name']:$_SESSION['member']['name'];?></span>
					<i class="material-icons">&#xE313;</i>
				</a>
			<?}else{?>
				<a href="#" id="user_profile" class="cabinet_btn hidden">
					<img class="image" src="/images/noavatar.png"/>
					<span class="name mdl-cell--hide-tablet mdl-cell--hide-phone"></span>
					<i class="material-icons">&#xE313;</i>
				</a>
				<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-button mdl-js-button mdl-button--colored mdl-button--outline login_btn">Войти</a>
			<?}?>
			<div class="user_profile user_profile_js mdl-menu mdl-menu--bottom-right mdl-js-menu" for="user_profile">
				<?php if(G::IsLogged()){
					echo $user_profile;
				}?>
			</div>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu" for="user_profile2">
				<a href="<?=Link::Custom('cabinet', false, array('clear' => true));?>" class="mdl-menu__item"><i class="material-icons">&#xE7FD;</i>Личный кабинет</a>
				<a href="<?=Link::Custom('cabinet', 'orders', array('clear' => true));?>" class="mdl-menu__item mdl-menu__item--full-bleed-divider"><i class="material-icons">&#xE889;</i>История заказов</a>
				<a href="<?=Link::Custom('cabinet', false, array('clear' => true));?>" class="mdl-menu__item"><i class="material-icons">&#xE8AC;</i>Выйти</a>
			</nav>
		</div>
	</div>
	<div id="phone_menu" data-type="panel" data-position="right" class="phone_menu mdl-cell--hide-tablet mdl-cell--hide-desktop">
		<div class="panel_container">
			<div class="user_profile user_profile_js">
				<?php if(G::IsLogged()){
					echo $user_profile;
				}else{?>
					<div class="loginButton">
						<p>Войдите в свой личный кабинет на xt.ua или создайте новый</p>
						<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent login_btn">Войти</a>
					</div>
				<?}?>
			</div>
			<ul class="phone_nav">
				<?foreach($list_menu as &$menu){?>
					<li><a href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a></li>
				<?}?>
			</ul>
			<ul class="phone_nav_contacts">
				<li class="parent_nav">
					<i class="material-icons">phone</i>
					<a href="tel:(050) 309-84-20" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>(050) 309-84-20</a>
					<a href="tel:(067) 574-10-13" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>(067) 574-10-13</a>
					<a href="tel:(057) 780-38-61" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>(057) 780-38-61</a>
					<a href="tel:(099) 563-28-17" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>(099) 563-28-17</a>
					<a href="tel:(063) 425-91-83" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>(063) 425-91-83</a>
				</li>
				<li class="parent_nav">
					<i class="material-icons">mail</i>
					<a href="mailto:administration@xt.ua" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>administration@xt.ua</a>
				</li>
				<li class="parent_nav">
					<i class="material-icons">location_on</i>
					<a href="https://www.google.com/maps/place/проспект+Ювілейний,+54А,+Харків,+Харківська+область,+Україна" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank">г. Харьков, просп. Юбилейный, 54А</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<script>
	$(function(){
		// if ($(document).width() < 900) {
		// 	$('.login_btn_hum').addClass('mdl-button--icon').empty().append('<i class="material-icons">account_circle</i>');
		// 	var select_category = $('.search_wrapp .select_category').detach();
		// }

		// var category = $('.category_search li.active').data('id-category');
		// $('input[name="category2search"]').val(category);
		// $('body').on('click', '.category_search li', function () {
		// 	category = $('.category_search li.active').data('id-category');
		// 	$('input[name="category2search"]').val(category);
		// });

		// $('.search_wrapp .mob_s_btn').click(function(){
		// 	$('#header_js').addClass('opened').closest('.sidebar, .no-sidebar').addClass('active_bg').find('.search_wrapp input[type="search"]').focus();
		// });
		// $('.search_close').click(function(event) {
		// 	$('.sidebar, .no-sidebar').removeClass('active_bg');
		// });
		$('body > *:not(header)').click(function(event) {
			$('.sidebar, .no-sidebar').removeClass('active_bg');
		});
		$('body').on('click', '.header_search_input_toggle_js', function(event){
			event.preventDefault();
			$(this).closest('.header_wrapp').toggleClass('active_search');
		});
	});
</script>
