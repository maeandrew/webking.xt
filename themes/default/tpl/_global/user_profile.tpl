<div class="userContainer">
	<div class="UserInfBlock">
		<a href="<?=Link::Custom('cabinet', false, array('clear' => true));?>" class="edit_profile" title="Изменить профиль"><i class="material-icons">&#xE8B8;</i></a>
		<div class="avatar">
			<a href="<?=Link::Custom('cabinet', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<?if(G::IsLogged() && $_SESSION['member']['avatar']){?>
					<img class="image" src="<?=G::GetUserAvatarUrl()?>"/>
				<?}elseif(G::IsLogged() && !$_SESSION['member']['avatar']){?>
					<span class="image" style="background: <? printf( "#%s", $_SESSION['member']['personal_color']); ?>"><?=mb_substr(isset($_SESSION['member']['first_name'])?$_SESSION['member']['first_name']:$_SESSION['member']['name'], 0, 1); ?></span>
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
		<?if(_acl::isAdmin()){?>
			<a class="adm" href="<?=Link::Custom('adm', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<i class="material-icons">&#xE869;</i>Админ-панель</span>
			</a>
		<?}?>
		<a class="cabinet" href="<?=Link::Custom('cabinet', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE7FD;</i>Мой кабинет</span>
		</a>
		<a class="orderes_history<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet', 'orders?t=all', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE8B0;</i>Мои заказы</span>
		</a>
		<a class="userFavoritesList<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet','favorites', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE87D;</i>Избранное <span class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</span>
		</a>
		<a class="userWaitingList<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet','waitinglist', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE422;</i>Лист ожидания <span class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</span>
		</a>
		<a class="agent<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>" href="<?=Link::Custom('cabinet', 'agent', array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE227;</i>Уголок агента</span>
		</a>
		<a class="log_out" href="<?=Link::Custom('logout', false, array('clear' => true))?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<i class="material-icons">&#xE8AC;</i>Выйти</span>
		</a>
	</div>
</div>