<div class="header_wrapp">
	<div class="logo">
		<a href="<?=Link::Custom('main', null, array('clear' => true));?>"><img src="<?=_base_url.'/themes/default/img/_xt.svg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="header_right">
		<div class="search_wrap mdl-cell--hide-phone">
			<form name="search" action="<?=Link::Custom('search');?>" method="get">
				<i class="material-icons mob_s_btn">search</i>
				<div class="mdl-textfield mdl-js-textfield search">
					<input class="mdl-textfield__input btn_js" name="query" id="search" type="search" placeholder="Поиск..." data-name="header_js" value="<?=isset($_GET['query'])?htmlspecialchars($_GET['query']):null;?>">
				</div>
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label search_category hidden">
					<select id="search_category" name="search_category" class="mdl-selectfield__select">
						<option value="" data-id-category="0">По всем категориям</option>
						<?foreach($navigation as &$v){ ?>
							<option value="<?=$v['id_category']?>" data-id-category="<?=$v['id_category']?>"><?=$v['name']?></option>
						<?}?>
					</select>
				</div>
				<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-cell--hide-phone search_btn">Найти</button>
			</form>
		</div>
		<!-- <input class="category2search" name="category2search" type="hidden" value=""> -->
		<!-- <label class="mdl-textfield__label" for="search"><? if(!isset($_GET['query'])){ ?>Найти...<?} else { ?> <?}?></label> -->
		<!-- <i class="material-icons search_close" title="Закрыть поиск">close</i>				 -->
		<!-- <div class="select_category fright mdl-cell--hide-phone mdl-cell--hide-tablet imit_select">
			<button id="category-lower-right" class="mdl-button mdl-js-button mdl-button--icon">
				<?if(!G::isMobile()){?>
					<span class="selected_cat select_field">По всем категориям</span>
					<i class="material-icons">keyboard_arrow_down</i>
				<?}?>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect category_search" for="category-lower-right">
				<li data-id-category="0" class="mdl-menu__item cat_li">По всем категориям</li>
				<?foreach ($navigation as &$v){ ?>
					<li data-id-category="<?=$v['id_category']?>" class="mdl-menu__item cat_li <?=(isset($_GET['category2search']) && $_GET['category2search'] == $v['id_category'])?'active':null?> "><?=$v['name']?></li>
					<?if(isset($_GET['category2search']) && $_GET['category2search'] == $v['id_category']){ ?> <script> $('span.selected_cat').html("<?=$v['name']?>"); </script><?}?>
				<?}?>
			</ul>
		</div> -->
		<div class="cart_item ga-cart <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
			<div class="currentCartSum hidden"><?=isset($_SESSION['cart']['products_sum'][3])?$_SESSION['cart']['products_sum'][3]:null?></div>
			<a href="#" class="mdl-badge--overlap cart btn_js" data-name="cart"><i class="material-icons mdl-badge--overlap<?=!empty($_SESSION['cart']['products'])?' mdl-badge':null;?>" data-badge="<?=isset($_SESSION['cart']['products'])?count($_SESSION['cart']['products']):0;?>">shopping_cart</i><span class="mdl-cell--hide-tablet mdl-cell--hide-phone">Корзина</span></a>
		</div>
		<div class="random_page mdl-cell--hide-tablet mdl-cell--hide-phone">
			<?$rand = rand(0, count($list_menu)-1);?> 
			<a href="<?=Link::Custom('page', $list_menu[$rand]['translit']);?>"><?=$list_menu[$rand]['title']?></a>
		</div>
		<div class="pages_list">
			<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-cell--hide-phone navigation">
				<i class="material-icons">menu</i>
			</button>
			<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-cell--hide-tablet mdl-cell--hide-desktop btn_js" data-name="phone_menu">
				<i class="material-icons">menu</i>
			</button>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-cell--hide-phone" for="menu-lower-right">
				<?foreach($list_menu as $key => &$menu){?>				
					<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a>
				<?}?>
			</nav>
		</div>
		<div class="profile mdl-cell--hide-phone">
			<?if(G::IsLogged()){?>
				<button id="user_profile" class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect">
					<img src="/images/noavatar.png"/>
				</button>
			<?}else{?>
				<button id="user_profile" class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect cabinet_btn hidden">
					<!-- <i class="material-icons">account_circle</i> -->
				</button>
				<a href="#" class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect login_btn">Войти</a>
			<?}?>
			<div class="user_profile user_profile_js mdl-menu mdl-menu--bottom-right mdl-js-menu" for="user_profile">
				<?php if(G::IsLogged()){
					echo $user_profile;
				}?>
			</div>
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
						<a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent login_btn">Войти</a>
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
					<a href="tel:(063) 225-91-83">(063) 225-91-83</a>
					<a href="tel:(099) 228-69-38">(099) 228-69-38</a>
					<a href="tel:(093) 322-91-83">(093) 322-91-83</a>
				</li>
				<li class="parent_nav">
					<i class="material-icons">mail</i>
					<a href="mailto:administration@x-torg.com">administration@x-torg.com</a>
				</li>
				<li class="parent_nav">
					<i class="material-icons">location_on</i>
					<a href="https://www.google.com/maps/place/вул. Тюрінська, 130, Харків, Харківська+область, Україна" target="_blank">г. Харьков, ТЦ Барабашово, Площадка Свояк, Торговое Место 130</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<script>
	$(document).ready(function($) {
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

		$('.search_wrapp .mob_s_btn').click(function(){ 
			$('#header_js').addClass('opened').closest('.sidebar, .no-sidebar').addClass('active_bg').find('.search_wrapp input[type="search"]').focus();
		});
		$('.search_close').click(function(event) {
			$('.sidebar, .no-sidebar').removeClass('active_bg');
		});
		$('body > *:not(header)').click(function(event) {
			$('.sidebar, .no-sidebar').removeClass('active_bg');
		});
	});
</script>
