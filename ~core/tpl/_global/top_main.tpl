<section>
	<div class="logo">
		<p class="phrase">Оптовый торговый центр</p>
		<?if($GLOBALS['CurrentController'] == 'main'){?>
			<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/Logo-SVG3.svg')?_base_url.'/images/Logo-SVG3.svg':'/efiles/_thumb/nofoto.jpg'?>" alt="Оптовый торговый центр xt.ua" class="animate">
		<?}else{?>
			<a href="/"><img src="<?=file_exists($GLOBALS['PATH_root'].'/images/Logo-SVG3.svg')?_base_url.'/images/Logo-SVG3.svg':'/efiles/_thumb/nofoto.jpg'?>" alt="Оптовый торговый центр xt.ua" class="animate"></a>
		<?}?>
	</div>
	<div class="contacts">
		<div class="inform">
			<ul class="phones clearfix">
				<li><?=$GLOBALS['CONFIG']['phone1'];?></li>
				<li><?=$GLOBALS['CONFIG']['phone2'];?></li>
				<li><?=$GLOBALS['CONFIG']['phone3'];?></li>
				<li><?=$GLOBALS['CONFIG']['phone4'];?></li>
			</ul>
			<div id="consultation" class="clearfix">
				<a href="#" id="consultation_button" class="open_modal" data-target="consult-form" title="Заказать консультацию"><span class="icon-font">headset</span>Консультация</a>
				<form action="<?=_base_url?>/sendconsultrequest/" method="POST" id="consult-form" class="modal_hidden">
					<h4>Заказ обратного звонка</h4>
					<p>Укажите тему вашего вопроса, и соответствующий менеджер перезвонит Вам в течении рабочего дня.</p>
					<div class="mod_section">
						<label class="left required" for="name">Ваше имя:</label>
						<input class="right" type="text" id="name" name="name" required="required" autofocus/>
					</div>
					<div class="mod_section">
						<label class="left required" for="phone">Телефон:</label>
						<input class="right phone" type="text" id="phone" name="phone" required="required"/>
					</div>
					<div class="mod_section">
						<label class="left" for="topic">Тема вопроса:</label>
						<input class="right" type="text" id="topic" name="topic"/>
					</div>
					<button type="submit" class="btn-m-green fright" name="submit" id="SendConsultRequest">Отправить</button>
				</form>
			</div>
			<div id="favorites" class="clearfix">
				<?if(!isset($_SESSION['member'])){?>
					<a href="<?=_base_url?>/cabinet/favorites/" title="Перейти в избранные товары" class="<?=G::IsLogged()?null:' open_modal" data-target="login_form';?>"><span class="icon-font">favorites</span>Избранное (<span class="fav_count_js"><?=isset($_SESSION['member']['favorites'])?count($_SESSION['member']['favorites']):0;?></span>)</a>
				<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_CUSTOMER_){?>
					<a href="<?=_base_url?>/cabinet/favorites/" title="Перейти в избранные товары"><span class="icon-font">favorites</span>Избранное (<span class="fav_count_js"><?=isset($_SESSION['member']['favorites'])?count($_SESSION['member']['favorites']):0;?></span>)</a>
				<?}else{?>
					<a href="#" title="Перейти в избранные товары" class="disabled"><span class="icon-font">favorites</span>Избранное (<span class="fav_count_js"><?=isset($_SESSION['member']['favorites'])?count($_SESSION['member']['favorites']):0;?></span>)</a>
				<?}?>
			</div>
		</div>
		<!-- search -->
		<div class="search">
			<form action="<?=_base_url?>/search/" method="GET" id="search_form" class="clearfix">
				<div class="search_block">
					<input type="search" name="query" id="search" autocomplete="off" placeholder="Поиск" value="<?=isset($_GET['query']) && $_GET['query'] != ''?$_GET['query']:null;?>">
					<?if($GLOBALS['CONFIG']['search_engine'] == 'sphinx'){?><ul class="autocomplete"></ul><?}?>
					<select name="category2search" id="category2search">
						<option value="0">По всем категориям</option>
						<?foreach($navigation as $l){?>
							<option value="<?=$l['id_category'];?>"
							<?if(isset($_GET['category2search']) && ((isset($GLOBALS['GLOBAL_CURRENT_ID_CATEGORY']) && ($_GET['category2search'] == $GLOBALS['GLOBAL_CURRENT_ID_CATEGORY']) || $_GET['category2search'] == $l['id_category']))){?>selected<?}?>><?=$l['name'];?></option>
						<?}?>
					</select>
				</div>
				<button type="submit" class="btn-m-orange search_button animate">Найти</button>
			</form>
		</div>
		<!-- END search -->
	</div>
	<!--END contacts-->
	<div class="nav_head">
		<ul>
			<?if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){
				if(isset($list_menu)){
					foreach($list_menu as $k=>$l){
						if($k < 3){?>
							<li <?if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == $l['translit']){?>class="sel"<?}?>>
								<a href="<?=_base_url?>/page/<?=$l['translit']?>/"><span class="icon-font">clock</span><?=$l['title']?></a>
							</li>
						<?}
					}
				}
			}else{?>
				<!-- Если клиент с промокодом -->
				<li><a href="<?=_base_url?>/promo/" class="color-red" style="font-weight: bold;">Товары продавца</a></li>
				<?if(isset($list_menu)){
					foreach($list_menu as $l){?>
						<li <?if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == $l['translit']){?>class="sel"<?}?>>
							<a href="<?=_base_url?>/page/<?=$l['translit']?>/"><span class="icon-font">clock</span><?=$l['title']?></a>
						</li>
					<?}
				}
			}?>
		</ul>
		<div class="log_block">
			<!-- cart -->
			<div class="cart <?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?"full":"empty"?>">
				<?if(!isset($_SESSION['member']) || ($_SESSION['member']['gid'] != _ACL_SUPPLIER_ && $_SESSION['member']['gid'] != _ACL_ADMIN_ && $_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_)){?>
					<a href="<?=_base_url?>/cart/" class="btn_head<?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" title="Корзина">
						<span class="icon-font">shopping_cart</span>
						Корзина (<span class="order_cart"><?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?count($_SESSION['cart']['products']):'0';?></span>)
					</a>
				<?}else{?>
					<a href="#" class="btn_head disabled" title="Вы не можете использовать корзину">
						<span class="icon-font">shopping_cart</span>
						Корзина (<?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?count($_SESSION['cart']['products']):'0';?>)
					</a>
				<?}?>
			</div>
			<!-- END cart -->
			<div class="login_box">
				<?if(!G::IsLogged()){?>
					<a href="#" id="show_form_button" class="open_modal btn_head" data-target="login_form" title="Вход">
						<span class="icon-font">lock</span>
						<span class="indent">Авторизация</span>
					</a>
					<form action="<?=_base_url?>/login/" method="post" id="login_form" class="modal_hidden">
						<h4>Вход в личный кабинет</h4>
						<div class="input_block">
							<div class="mod_section">
								<label for="email">E-mail:</label>
								<input id="email" name="email" type="text" required autofocus/>
							</div>
							<div class="mod_section">
								<label for="passwd">Пароль:</label>
								<input id="passwd" name="passwd" type="password" required/>
							</div>
							<span class="error_msg"></span>
						</div>
						<div class="mod_block">
							<a href="<?=_base_url?>/remind/">Напомнить пароль</a>
							<a href="<?=_base_url?>/cart_anonim/">Заказ без регистрации</a>
						</div>
						<button type="submit" class="btn-m-orange fright">Войти</button>
						<div class="section_footer">
							<p><a href="<?=_base_url?>/register/" class="btn-m-green">Зарегистрироваться</a></p>
						</div>
					</form>
				<?}else{?>
					<?if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){?>
						<a href="<?=_base_url?>/cabinet/" title="Личный кабинет" class="btn_head"><span class="icon-font">account</span><span class="indent">Мой кабинет</span></a>
					<?}else{?>
						<a href="<?=_base_url?>/cabinet/" title="История заказов"><span class="icon-font">history</span>История заказов</a>
					<?}?>
					<div class="btn_hover">
						<p>
							<small>Вы вошли как:</small><br>
							<?=isset($_SESSION['member']['email'])?$_SESSION['member']['email']:null?>
						</p>
						<?if(isset($_COOKIE['sm_login'])){?>
							<a href="<?=_base_url?>/login/&email=sm@x-torg.com&passwd=0">Вернуться в SM</a>
						<?}?>
						<a href="<?=_base_url?>/logout/">Выход</a>
					</div>
					<!-- Если клиент с промокодом -->
					<?if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){?>
						<div class="<?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?"full":"empty"?> promo_cart" style="clear: both; float: right;">
							<div class="icon"></div>
							<a href="promo_cart/">
								<span id="cart_text"><?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?"В корзине":"Корзина пуста";?></span>
								<span class="order_cat"><?=(isset($_SESSION['cart']['products']) && count($_SESSION['cart']['products']) > 0)?count($_SESSION['cart']['products'])." ".(string)G::WordForNum(count($_SESSION['cart']['products']))." на ".number_format($_SESSION['cart']['sum_discount'], 2, ",", "")." грн.":"";?></span>
							</a>
						</div>
					<?}
				}?>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			<?if(isset($_GET['query']) && $_GET['query'] != ''){?>
				toggleSearchButton('show', '<?=$_GET['query']?>');
			<?}?>
			$('#category2search').on('change', function(){
				$('#search').focus();
			});
			$('#search').on('focus', function(){
				toggleSearchButton('show', $(this).val());
				$(this).on('keyup', function(){
					toggleSearchButton('show', $(this).val());
				});
				$(this).on('blur', function(){
					if($(this).val() == ''){
						toggleSearchButton('hide');
					}
				});
			});
			$('#login_form button').on('click', function(e){
				var form = $('#login_form');
				e.preventDefault();
				form.find('.input_block').addClass('ajax_loading');
				var login_email = form.find('#email').val();
				var login_passwd = form.find('#passwd').val();
				$.ajax({
					url: URL_base+'ajaxlogin',
					type: "POST",
					dataType : "json",
					data:({
						"action": 'login',
						"email": login_email,
						"passwd": login_passwd
					}),
				}).done(function(data){
					setTimeout(function(){
						if(data['errm'] == 0){
							form.find('.input_block').addClass('success');
							setTimeout(function(){
								location.reload();
							}, 100);
						}else{
							form.find('.input_block').removeClass('ajax_loading').find('.error_msg').text(data['msg']);

						}
					}, 1000);
				});
			});

			//Фиксация header
			var header = $("header");
	        $(window).scroll(function(){
	        	var height = $("header").height()+20;
	            if($(this).scrollTop() > 50 && header.hasClass("default")){
	                header.removeClass("default").addClass("fixed_panel");
	                $('#wrapper').css('margin-top', height);
	            }else if($(this).scrollTop() <= 50 && header.hasClass("fixed_panel")){
	                header.removeClass("fixed_panel").addClass("default");
	                $('#wrapper').css('margin-top', '0');
	            }
	        });//scroll

		});
	</script>
</section>