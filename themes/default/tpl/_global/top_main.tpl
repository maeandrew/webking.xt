<div class="header_wrapp">
	<div class="logo">
		<a href="<?=Link::Custom('main', null, array('clear' => true));?>" rel="nofollow"><img src="<?=_base_url.'/themes/default/img/_xt.svg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="header_right">
		<div class="search_wrap">
			<form name="search" action="<?=Link::Custom('search');?>" method="get">
				<button type="submit" class="mdl-cell--hide-phone search_btn">Найти</button>
				<!-- <i class="material-icons mob_s_btn mob_search_btn_js">&#xE8B6;</i> -->
				<!-- <label for="search" class="hidden">Поиск</label> -->
				<label class="search_query_input" for="search">
					<input class="btn_js" name="query" id="search" type="search" placeholder="Поиск..." data-name="header_js" value="<?=isset($_GET['query'])?htmlspecialchars($_GET['query']):null;?>">
				</label>
				<!-- <label for="search_category" class="hidden">Категория для поиска</label> -->
				<!-- <select id="search_category" name="search_category">
					<option value="" data-id-category="0">По всем категориям</option>
					<?foreach($navigation as &$v){ ?>
						<option value="<?=$v['id_category']?>" data-id-category="<?=$v['id_category']?>"><?=$v['name']?></option>
					<?}?>
				</select> -->
				<i class="material-icons mdl-cell--hide-tablet mdl-cell--hide-desktop header_search_close_js header_search_close">&#xE5CD;</i>
				<i class="material-icons mdl-cell--hide-tablet mdl-cell--hide-desktop header_search_close_js header_search_close">&#xE8B6;</i>
			</form>
		</div>
		<div class="cart_item ga-cart <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
			<div class="currentCartSum hidden"><?=isset($_SESSION['cart']['products_sum'][3])?$_SESSION['cart']['products_sum'][3]:null?></div>
			<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-badge--overlap cart btn_js <?=$_SESSION['cart']['cart_sum'] == 0?'for_hidden_js':null;?>" data-name="cart"><i class="material-icons mdl-badge--overlap<?=!empty($_SESSION['cart']['products'])?' mdl-badge':null;?>" data-badge="<?=isset($_SESSION['cart']['products'])?count($_SESSION['cart']['products']):0;?>">&#xE8CC;</i><span class="mdl-cell--hide-tablet mdl-cell--hide-phone"><span>Корзина</span><span>:</span><br><span class="total_cart_summ_js">
			<?print_r(number_format($_SESSION['cart']['cart_sum'], 2, ',', ''));?>
			грн.</span></span></a>
		</div>
		<div class="random_page mdl-cell--hide-tablet mdl-cell--hide-phone">
			<?$rand = rand(0, count($list_menu)-1);?>
			<a href="<?=Link::Custom('page', $list_menu[$rand]['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><?=$list_menu[$rand]['title']?></a>
		</div>
		<div class="pages_list">
			<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon  mdl-cell--hide-phone navigation">
				<i class="material-icons">&#xE5D2;</i>
			</button>
			<button class="mdl-button mdl-js-button mdl-button--icon  mdl-cell--hide-tablet mdl-cell--hide-desktop btn_js" data-name="phone_menu">
				<i class="material-icons">&#xE5D2;</i>
			</button>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu  mdl-cell--hide-phone" for="menu-lower-right">
				<?foreach($list_menu as $key => &$menu){?>
					<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><?=$menu['title']?></a>
				<?}?>
				<a class="mdl-menu__item" href="<?=Link::Custom('price');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>Прайс-листы</a>
			</nav>
		</div>
		<div class="profile mdl-cell--hide-phone">
			<?if(G::IsLogged()){?>
				<button id="user_profile" class="mdl-button mdl-js-button mdl-button--icon ">
					<img src="<?=G::GetUserAvatar($_SESSION['member']['id_user'])?>"/>
				</button>
			<?}else{?>
				<button id="user_profile" class="mdl-button mdl-js-button mdl-button--icon cabinet_btn hidden">
                    <img src="/images/noavatar.png"/>
				</button>
				<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-button mdl-js-button mdl-button--colored login_btn">Войти</a>
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
