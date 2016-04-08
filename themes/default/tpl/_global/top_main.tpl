<div class="header_wrapp clearfix">
	<div class="logo">
		<a href="<?=Link::Custom('main')?>"><img src="<?=_base_url.'/themes/default/img/_xt.svg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="catalog_btn mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	<div class="search_wrapp">
		<form name="search" action="<?=Link::Custom('search');?>" method="get">
			<div class="mdl-textfield mdl-js-textfield search">
				<i class="material-icons mob_s_btn">search</i>
				<input class="mdl-textfield__input btn_js" name="query" type="search" id="search" data-name="header_js" value="<?if (isset($_GET['query'])) print_r($_GET['query']);?>">
				<input class="category2search" name="category2search" type="hidden" value="">
				<label class="mdl-textfield__label" for="search"><? if(!isset($_GET['query'])){ ?>Найти...<?} else { ?> <?}?></label>
				<i class="material-icons search_close" title="Закрыть поиск">close</i>
				
				<div class="select_category fright mdl-cell--hide-phone imit_select">
					<button id="category-lower-right"  class="mdl-button mdl-js-button mdl-button--icon">
						<span class="selected_cat select_field">По всем категориям</span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul  class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect category_search" for="category-lower-right">
						<li data-id-category="0" class="mdl-menu__item cat_li">По всем категориям</li>
						<?foreach ($navigation as &$v){ ?>
							<li data-id-category="<?=$v['id_category']?>" class="mdl-menu__item cat_li <?=(isset($_GET['category2search']) && $_GET['category2search'] == $v['id_category'])?'active':null?> "><?=$v['name']?></li>
							<?if(isset($_GET['category2search']) && $_GET['category2search'] == $v['id_category']){ ?> <script> $('span.selected_cat').html("<?=$v['name']?>"); </script><?}?>
						<?}?>
					</ul>
				</div>
			</div>
			<button class="mdl-button mdl-js-button mdl-cell--hide-phone search_btn">Найти</button>
		</form>
	</div>
	<ul class="header_nav">
		<li><a href="#" class="checkout btn_js" data-name="cart"><i class="material-icons">shopping_cart</i> Корзина</a></li>
		<li>
			<?$rand = rand(0, count($list_menu)-1);?>
			<a href="<?=Link::Custom('page', $list_menu[$rand]['translit']);?>"><?=$list_menu[$rand]['title']?></a>
		</li>
		<li>
			<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon navigation">
				<i class="material-icons">menu</i>
			</button>
			<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-lower-right">
				<?unset($list_menu[$rand]);?>
				<?foreach($list_menu as &$menu){?>
					<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a>
				<?}?>
			</nav>
		</li>
		<li class="user_profile">
			<?if(isset($_SESSION['member'])){ ?>

				<!-- <a href="#" id="tt4" class="mdl-button mdl-js-button cabinet_btn">Мой кабинет</a>
				<div class="mdl-tooltip" for="tt4" style="text-align:left">
					Имя: <?=$_SESSION['member']['contragent']['name_c']?><br>
					Email: <?=$_SESSION['member']['email']?><br>
					Телефон: <?=$_SESSION['member']['contragent']['phones']?><br>
					<?=$_SESSION['member']['promo_code']?>
				</div> -->

				<!-- Right aligned menu below button -->
				<button id="user_profile" class="mdl-button mdl-js-button mdl-button--icon">
					<i class="material-icons">account_circle</i>
				</button>

				<div class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-grid" for="user_profile">
					<div id="userPic" class="mdl-cell mdl-cell--5-col">
						<div class="avatarWrapp">
							<img src="/themes/default/images/noavatar.jpg"/>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--7-col mainUserInf">
						<div id="userNameBlock">
							<div id="userNameInf" class="listItems">
								<span class="user_name"><?=$_SESSION['member']['name']?></span>
							</div>
							<a id="editUserProf" class="material-icons" href="<?=Link::Custom('cabinet', 'personal')?>">create</a>
							<div class="mdl-tooltip" for="editUserProf">Изменить<br>профиль</div>
						</div>
						<div class="listItems <?=!isset($_SESSION['member']['email']) && $_SESSION['member']['email'] == ''?'hidden':null ?>">
							<i class="material-icons">mail_outline</i>
							<span class="user_email"><?=$_SESSION['member']['email']?></span>
						</div>
						
						<div class="listItems">
							<i class="material-icons">location_on</i>
							<span class="user_email">г. Харьков, Украина</span>
						</div>
					</div>
					
					<div class="mdl-grid <?=!is_array($_SESSION['member']['contragent'])?'hidden':null;?>">
						<div id="menuBorder" class="mdl-cell mdl-cell--12-col"></div>
						
						<div id="manager" class="mdl-cell mdl-cell--12-col">Ваш менеджер: <span class="user_contr"><?=$_SESSION['member']['contragent']['name_c']?></span>
						</div>
						
						<div class="manager_contacts mdl-cell mdl-cell--6-col">
							<a href="tel:+380667205488">
								<i class="material-icons .noLink">phone</i>
								<span class="user_contr_phones"><?=$_SESSION['member']['contragent']['phones']?></span>
							</a>
						</div>
						
						<div class="manager_contacts mdl-cell mdl-cell--6-col">
							<a href="mailto:manager@xt.ua" target="blank">
								<i class="material-icons">mail_outline</i>
								<span class="user_contr_phones">manager@xt.ua</span>
							</a>
						</div>
					</div>

					<div id="menuBorder" class="mdl-cell mdl-cell--12-col"></div>

					<div id="userFavoritesList" class="mdl-cell mdl-cell--6-col">
						<a href="#"><div class="favleft"><i class="material-icons">favorite</i></div>
						<div class="favright"><p>Избранные</p><p>(<?=count($_SESSION['member']['favorites'])?>)</p></div></a>
					</div>
					<div id="userWaitingList" class="mdl-cell mdl-cell--6-col">
						<a href="#"><div class="favleft"><i class="material-icons">trending_down</i></div>
						<div class="favright"><p>Лист<br> ожидания</p><p>(<?=count($_SESSION['member']['waiting_list'])?>)</p></div></a>
					</div>

					<div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>

					<button class="menuUserInfBtn mdl-cell mdl-cell--6-col" id="mycabMenuUserInfBtn"
					onclick="window.location.href='<?=Link::Custom('cabinet')?>'">Мой кабинет</button>

					<button class="menuUserInfBtn mdl-cell mdl-cell--6-col" onclick="window.location.href='<?=Link::Custom('logout')?>'">Выйти</button>
				</div>
				<!-- <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right">
					<li class="mdl-menu__item active">По рейтингу</li>
					<li class="mdl-menu__item">Новинки</li>
					<li class="mdl-menu__item">Популярные</li>
					<li class="mdl-menu__item">От дешевых к дорогим</li>
				</ul> -->
				<a href="#" class="mdl-button mdl-js-button hidden login_btn">Войти</a>
			<?}else{?>
				<!-- <a href="#" class="mdl-button mdl-js-button cabinet_btn hidden">Мой кабинет</a> -->
				<button id="demo-menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon cabinet_btn hidden">
					<i class="material-icons">account_circle</i>
				</button>
				<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right">
					<li disabled class="mdl-menu__item">Имя: <span class="user_name"></span></li>
					<li disabled class="mdl-menu__item">Email: <span class="user_email"></span></li>
					<li disabled class="mdl-menu__item">Ваш менеджер: <span class="user_contr"></span></li>
					<li disabled class="mdl-menu__item">Телефон: <span class="user_contr_phones"></span></li>
					<li disabled class="mdl-menu__item"><span class="user_promo"></span></li>
					<button class="mdl-button mdl-js-button mdl-button--raised" style="float: right;right: 5px;top:-10px">
						<a href="<?=Link::Custom('logout')?>">Выйти</a>
					</button>
					<button class="mdl-button mdl-js-button mdl-button--raised" style="float: right;right: 10px;top:-10px;background:#018B06;">
						<a href="<?=Link::Custom('cabinet')?>" style="color:#fff">Мой Кабинет</a>
					</button>
				</ul>
				<a href="#" class="mdl-button mdl-js-button login_btn login_btn_hum">Войти</a>
			<?}?>
		</li>
	</ul>
	<nav class="phone_menu">
		<span class="material-icons menu btn_js" data-name="phone_menu">menu</span>
		<a href="#" class="material-icons mdl-badge--overlap cart mdl-badge btn_js" data-badge="<?=!empty($_SESSION['cart']['products'])?count($_SESSION['cart']['products']):0;?>" data-name="cart">shopping_cart</a>
	</nav>	
</div>

<script>
	$(document).ready(function($) {
		if ($(document).width() < 900) {
			$('.login_btn_hum').addClass('mdl-button--icon').empty().append('<i class="material-icons">account_circle</i>');
		};
		
		var category = $('.category_search li.active').data('id-category');
		$('input[name="category2search"]').val(category);
		$('body').on('click', '.category_search li', function () {
			category = $('.category_search li.active').data('id-category');
			$('input[name="category2search"]').val(category);
		});

		if ($(document).width() < 500) {
			$('.search_wrapp label[for="search"]').empty();
			$('.header_nav li.user_profile').css('display', 'none');
		};

		$('.search_wrapp .mob_s_btn').click(function(){ 
			$('#header_js').addClass('opened').closest('.sidebar, .no-sidebar').addClass('active_bg').find('.search_wrapp input[type="search"]').focus();
		});
	});
</script>