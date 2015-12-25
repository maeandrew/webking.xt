<div class="header_wrapp clearfix">
	<div class="logo">
		<a href="<?=Link::Custom('main')?>"><img src="<?=file_exists($GLOBALS['PATH_root'].'/themes/default/img/Logo.svg')?_base_url.'/themes/default/img/Logo.svg':'/efiles/_thumb/nofoto.jpg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="catalog_btn mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	<div class="search_wrapp">
		<form action="">
			<div class="mdl-textfield mdl-js-textfield search">
					<i class="material-icons mob_s_btn">search</i>
					<input class="mdl-textfield__input btn_js" type="search" id="search" data-name="header_js">
					<label class="mdl-textfield__label" for="search">Найти...</label>
					<i class="material-icons search_close" title="Закрыть поиск">close</i>
				<div class="select_category fright mdl-cell--hide-phone imit_select">
					<button id="category-lower-right" class="mdl-button mdl-js-button mdl-button--icon">
						<span class="selected_cat select_fild">По всем категориям</span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="category-lower-right">
						<li class="mdl-menu__item active">По всем категориям</li>
						<li class="mdl-menu__item">Another Action</li>
						<li disabled class="mdl-menu__item">Disabled Action</li>
						<li class="mdl-menu__item">Yet Another Action</li>
						<li class="mdl-menu__item">Lorem ipsum dolor sit amet</li>
					</ul>
				</div>
			</div>
			<button class="mdl-button mdl-js-button mdl-cell--hide-phone search_btn">Найти</button>
		</form>
	</div>
	<ul class="header_nav mdl-cell--hide-phone">
		<li><a href="#" class="checkout btn_js" data-name="cart">Оформить заказ</a></li>
		<li><a href="#">Поставки магазинам</a></li>
		<li>
			<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon navigation">
				<i class="material-icons">menu</i>
			</button>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-lower-right">
				<?foreach ($list_menu as $menu ) : ?>
					<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a>
				<?endforeach?>
			</nav>
		</li>
		<li><button class="mdl-button mdl-js-button enter_btn">Войти</button></li>
	</ul>
	<nav class="phone_menu">
		<span class="material-icons menu btn_js" data-name="phone_menu">menu</span>
		<a href="#" class="material-icons mdl-badge mdl-badge--overlap cart btn_js" data-badge="0" data-name="cart">shopping_cart</a>
	</nav>
</div>