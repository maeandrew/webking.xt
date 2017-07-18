<div class="userContainer">
	<div class="UserInfBlock">
		<a href="<?=Link::Custom('cabinet', false, array('clear' => true));?>" class="edit_profile" title="Изменить профиль"><i class="material-icons">&#xE8B8;</i></a>
		<div class="avatar">
			<a href="<?=Link::Custom('cabinet', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<?if(G::IsLogged() && $_SESSION['member']['avatar']){?>
					<img class="image" src="<?=G::GetUserAvatarUrl()?>"/>
				<?}elseif(G::IsLogged() && !$_SESSION['member']['avatar']){?>
					<span class="image" style="background: <?printf( "#%s", $_SESSION['member']['personal_color']); ?>"><?=mb_substr($_SESSION['member']['name'], 0, 1); ?></span>
				<?}else{?>
					<img class="image" src="/images/noavatar.png">
				<?}?>
			</a>
		</div>
		<div class="mainUserInf">
			<div class="userNameBlock">
				<div class="userNameInf listItems"><?=$_SESSION['member']['name'];?></div>
			</div>
			<div class="listItems up_email">
				<?=isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != ''?$_SESSION['member']['email']:"Регистрация без e-mail"?>
			</div>
			<div class="listItems hidden">
				<i class="material-icons">phone</i>
				<?=isset($_SESSION['member']['phone']) && $_SESSION['member']['phone'] != ''?$_SESSION['member']['phone']:"Регистрация без телефона"?>
			</div>
			<!-- <script>GetLocation();</script>
			<div class="listItems">
				<i class="material-icons">location_on</i>
				<span class="userlocation"></span>
			</div> -->
		</div>
	</div>
	<div class="ContragentContacts hidden <?=!isset($_SESSION['member']['contragent']) || empty($_SESSION['member']['contragent'])?' hidden':null;?>">
		<div id="manager">Ваш менеджер: <span class="user_contr"><?=$_SESSION['member']['contragent']['name_c']?></span>
		</div>
		<div class="manager_contacts">
			<a href="tel:+380667205488" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<i class="material-icons .noLink">phone</i>
				<span class="user_contr_phones"><?=$_SESSION['member']['contragent']['phones']?></span>
			</a>
		</div>
		<div class="manager_contacts">
			<a href="mailto:manager@xt.ua" target="blank" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<i class="material-icons">mail_outline</i>
				<span>manager@xt.ua</span>
			</a>
		</div>
	</div>
	<div class="userChoice">
		<a class="userFavoritesList<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet','favorites', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">favorite</i>Избранное <span class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</span>
		</a>
		<a class="userWaitingList<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet','waitinglist', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">trending_down</i>Лист ожидания <span class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</span>
		</a>
		<a class="cabinet<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet', 'orders?t=all', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE889;</i>История заказов</span>
		</a>
		<a class="cabinet" href="<?=Link::Custom('cabinet', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE7FD;</i>Личный кабинет</span>
		</a>
		<a class="log_out" href="<?=Link::Custom('logout', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE8AC;</i>Выйти</span>
		</a>
	</div>
	<!-- <div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>
	<a class="menuUserInfBtn" href="<?=_base_url.'/cabinet'?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>Мой кабинет</a>
	<a class="menuUserInfBtn" href="<?=Link::Custom('logout')?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>Выйти</a> -->
</div>