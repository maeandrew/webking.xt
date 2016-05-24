<div class="header_wrapp">
	<div class="logo">
		<a href="<?=Link::Custom('main')?>"><img src="<?=_base_url.'/themes/default/img/_xt.svg'?>" alt="Оптовый торговый центр xt.ua"></a>
	</div>
	<div class="search_wrapp">
		<form name="search" action="<?=Link::Custom('search');?>" method="get">
			<div class="mdl-textfield mdl-js-textfield search">
				<i class="material-icons mob_s_btn">search</i>
				<input class="mdl-textfield__input btn_js" name="query" type="search" id="search" data-name="header_js" value="<?if (isset($_GET['query'])) print_r($_GET['query']);?>">
				<input class="category2search" name="category2search" type="hidden" value="">
				<label class="mdl-textfield__label" for="search"><? if(!isset($_GET['query'])){ ?>Найти...<?} else { ?> <?}?></label>
				<i class="material-icons search_close" title="Закрыть поиск">close</i>				
				<div class="select_category fright mdl-cell--hide-phone mdl-cell--hide-tablet imit_select">
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
				</div>
			</div>
			<button type="submit" class="mdl-button mdl-js-button mdl-cell--hide-phone search_btn">Найти</button>
		</form>
	</div>
	<div class="cart_item">
		<a href="#" class="mdl-badge--overlap cart btn_js" data-name="cart"><i class="material-icons mdl-badge--overlap<?=!empty($_SESSION['cart']['products'])?' mdl-badge':null;?>" data-badge="<?=isset($_SESSION['cart']['products'])?count($_SESSION['cart']['products']):0;?>">shopping_cart</i><span> Корзина</span></a>
	</div>
	<div class="pages_list_item">
		<?$rand = rand(0, count($list_menu)-1);?> 
		<a href="<?=Link::Custom('page', $list_menu[$rand]['translit']);?>"><?=$list_menu[$rand]['title']?></a>
	</div>
	<div class="pages_list">
		<button id="menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon navigation">
			<i class="material-icons">menu</i>
		</button>
		<span class="material-icons menu btn_js" data-name="phone_menu">menu</span>
		<nav class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-lower-right">
			<?foreach($list_menu as $key => &$menu){?>				
				<a class="mdl-menu__item" href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a>
			<?}?>
		</nav>
	</div>
	<div class="user_profile">
		<?if(isset($_SESSION['member'])){ ?>
			<button data-name="user_pro" id="user_profile" class="mdl-button mdl-js-button mdl-button--icon">
				<i class="material-icons">account_circle</i>
			</button>
			<!-- <a href="#" class="mdl-button mdl-js-button login_btn">Войти</a> -->
		<?}else{?>
			<button data-name="user_pro" id="user_profile" class="mdl-button mdl-js-button mdl-button--icon cabinet_btn hidden">
				<i class="material-icons">account_circle</i>
			</button>
			<a href="#" class="mdl-button mdl-js-button login_btn login_btn_hum">Войти</a>
		<?}?>
		<div data-type="panel" id="user_pro" class="mdl-menu mdl-menu--bottom-right mdl-js-menu " for="user_profile">
			<div class="userContainer" >
				<div class="UserInfBlock">
					<div id="userPic">
						<div class="avatarWrapp">
							<img src="/themes/default/images/noavatar.jpg"/>
						</div>
					</div>
					<div class="mainUserInf">
						<div id="userNameBlock">
							<div id="userNameInf" class="listItems">
								<?if ($_SESSION['member']['email']) {
									$etChar = strpos($_SESSION['member']['email'], "@");
									$userNameFromMail = substr($_SESSION['member']['email'], 0, $etChar);
								}?>
								<span class="user_name"><?
									if($_SESSION['member']['name']) { echo $_SESSION['member']['name']; }
									else { echo $userNameFromMail; } ?></span>
							</div>
							<a id="editUserProf" class="material-icons" href="<?=Link::Custom('cabinet', 'personal')?>">create</a>
							<div class="mdl-tooltip" for="editUserProf">Изменить<br>профиль</div>
						</div>
						<div class="listItems">
							<i class="material-icons">mail_outline</i>
							<span class="user_email"><?=isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != ''?$_SESSION['member']['email']:"Регистрация без e-mail"?></span>
						</div>

						<div class="listItems">
							<i class="material-icons">location_on</i>
							<span class="userlocation"></span>
						</div>
					</div>
				</div>
				<div class="contacts <?=isset($_SESSION['member']['contragent']) && empty($_SESSION['member']['contragent'])?'hidden':null;?>">
					<div id="manager">Ваш менеджер: <span class="user_contr"><?=$_SESSION['member']['contragent']['name_c']?></span>
					</div>
					<div class="manager_contacts">
						<a href="tel:+380667205488">
							<i class="material-icons .noLink">phone</i>
							<span class="user_contr_phones"><?=$_SESSION['member']['contragent']['phones']?></span>
						</a>
					</div>
					<div class="manager_contacts">
						<a href="mailto:manager@xt.ua" target="blank">
							<i class="material-icons">mail_outline</i>
							<span>manager@xt.ua</span>
						</a>
					</div>
				</div>
				<div class="userChoice <?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?'hidden':null;?>">
					<div id="userFavoritesList">
						<a href="<?=Link::Custom('cabinet','favorites')?>"><div class="favleft"><i class="material-icons">favorite</i></div>
						<div class="favright"><p>Избранные</p><p class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</p></div></a>
					</div>
					<div id="userWaitingList">
						<a href="<?=Link::Custom('cabinet','waitinglist')?>"><div class="favleft"><i class="material-icons">trending_down</i></div>
						<div class="favright"><p>Лист<br> ожидания</p><p class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</p></div></a>
					</div>
				</div>
				<div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>
				<button class="menuUserInfBtn" id="mycabMenuUserInfBtn"
				onclick="window.location.href='<?=Link::Custom('cabinet')?>'">Мой кабинет</button>
				<button class="menuUserInfBtn" onclick="window.location.href='<?=Link::Custom('logout')?>'">Выйти</button>
			</div>
		</div>
	</div>
	<div id="phone_menu" class="panel" data-type="panel">
		<ul class="phone_user_profile">			
			<div id="authorized" class="<?=!G::IsLogged()?'hidden':null;?>">
				<button class="mdl-button mdl-js-button mdl-button--icon" value="Авторизован">
					<i class="material-icons">account_circle</i>
				</button>
				<div>Профиль</div>
				<div class="more_cat"><i class="expand material-icons">expand_more</i></div>
			</div>
			<!-- <a href="#" class="mdl-button mdl-js-button hidden login_btn">Войти</a> -->		
			<button id="demo-menu-lower-right" value="Неавторизован" class="<?=G::IsLogged()?'hidden':null;?>">
				<a href="#" class="mdl-button mdl-js-button login_btn cabinet_btn" data-upgraded=",MaterialButton">Войти</a>
			</button>
			<!-- <a href="#" class="mdl-button mdl-js-button login_btn login_btn_hum">Войти</a> -->
			<div class="userContainer <?=!G::IsLogged()?'hidden':null;?>">
				<div id="userPic">
					<div class="avatarWrapp">
						<img src="/themes/default/images/noavatar.jpg"/>
					</div>
				</div>
				<div class="mainUserInf">
					<div id="userNameBlock">
						<div id="userNameInf" class="listItems">
							<span class="user_name"><?
									if($_SESSION['member']['name']) { echo $_SESSION['member']['name']; }
									else { echo $userNameFromMail; } ?></span>
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
						<span class="userlocation"></span>
					</div>
				</div>				
				<div class="contacts <?=!is_array($_SESSION['member']['contragent'])?'hidden':null;?>">
					<div id="manager" class="">Ваш менеджер: <span class="user_contr"><?=$_SESSION['member']['contragent']['name_c']?></span></div>
					<div class="manager_contacts">
						<a href="#">
							<i class="material-icons .noLink">phone</i>
							<span class="user_contr_phones"><?=$_SESSION['member']['contragent']['phones']?></span>
						</a>
					</div>
					<div class="manager_contacts">
						<a href="mailto:manager@xt.ua" target="blank">
							<i class="material-icons">mail_outline</i>
							<span class="user_contr_phones">manager@xt.ua</span>
						</a>
					</div>
				</div>
				<div class="userChoice">
					<div id="userFavoritesList" class="">
						<a href="#"><div class="favleft"><i class="material-icons">favorite</i></div>
						<div class="favright"><p>Избранные</p><p class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</p></div></a>
					</div>
					<div id="userWaitingList" class="">
						<a href="#"><div class="favleft"><i class="material-icons">trending_down</i></div>
						<div class="favright"><p>Лист<br> ожидания</p><p class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</p></div></a>
					</div>
				</div>
				<div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>
				<div class="btnContainer">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" onclick="window.location.href='<?=Link::Custom('cabinet')?>'">Мой кабинет</button>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="window.location.href='<?=Link::Custom('logout')?>'">Выйти</button>
				</div>
			</div>
			<script>
				$('#authorized, #demo-menu-lower-right').click(function(event) {
					$('.userContainer').slideToggle('fast', function() {
						if ($(this).is(':hidden')) {
							$('#authorized i.expand').css('transform', 'rotate(0deg)');
						} else {
							$('#authorized i.expand').css('transform', 'rotate(180deg)');
						}
						return false;
					});
				});
			</script>
		</ul>
		<ul class="phone_nav">
			<?foreach($list_menu as &$menu){?>
				<li><a href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a></li>				
			<?}?>
		</ul>		
		<ul class="phone_nav_contacts clearfix">
			<li class="parent_nav"><div class="material-icons">phone</div><a href="tel:(063) 225-91-83">(063) 225-91-83</a></li>
			<li><a href="tel:(099) 228-69-38">(099) 228-69-38</a></li>
			<li><a href="tel:(093) 322-91-83">(093) 322-91-83</a></li>
			<li class="parent_nav"><div class="material-icons">mail</div><a href="mailto:administration@x-torg.com">administration@x-torg.com</a></li>
			<li class="parent_nav"><div class="material-icons">location_on</div><span>г. Харьков, ТЦ Барабашово, Площадка Свояк, Торговое Место 130</span></li>
		</ul>
	</div>
</div>

<script>
	$(document).ready(function($) {
		if ($(document).width() < 900) {
			$('.login_btn_hum').addClass('mdl-button--icon').empty().append('<i class="material-icons">account_circle</i>');
			var select_category = $('.search_wrapp .select_category').detach();
		};
		
		var category = $('.category_search li.active').data('id-category');
		$('input[name="category2search"]').val(category);
		$('body').on('click', '.category_search li', function () {
			category = $('.category_search li.active').data('id-category');
			$('input[name="category2search"]').val(category);
		});

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
