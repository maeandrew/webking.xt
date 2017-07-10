<?
if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
	$name = $_SESSION['member']['name'];
}else{
	if(!empty($customer['last_name']) && !empty($customer['first_name']) && !empty($customer['middle_name'])){
		$name = $customer['last_name'].' '.$customer['first_name'].' '.$customer['middle_name'];
	}elseif(!isset($_SESSION['member']['name'])){
		$name = isset($_SESSION['member']['email']) && !empty($_SESSION['member']['email'])?substr($_SESSION['member']['email'], 0, strpos($_SESSION['member']['email'], "@")):'';
	}else{
		$name = $_SESSION['member']['name'];
	}
}?>
<div class="userContainer">
	<div class="UserInfBlock">
		<div class="avatar">
			<a href="<?=Link::Custom('cabinet')?>?t=contacts" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
				<span class="image" style="background: <? printf( "#%s", $_SESSION['member']['personal_color']); ?>"><?=mb_substr($name, 0, 1); ?></span>
				<?if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){?>
				<?}else{?>
					<!-- <img class="image" src="<?=G::GetUserAvatar($_SESSION['member']['id_user'])?>"/> -->
				<?}?>
			</a>
		</div>
		<div class="mainUserInf">
			<div class="userNameBlock">
				<div class="userNameInf listItems"><?=$name;?></div>
				<a id="eup" class="editUserProf material-icons" href="<?=Link::Custom('cabinet')?>?t=contacts" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>create</a>
				<div class="mdl-tooltip" for="eup">Изменить<br>профиль</div>
			</div>
			<div class="listItems">
				<i class="material-icons">mail_outline</i>
				<?=isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != ''?$_SESSION['member']['email']:"Регистрация без e-mail"?>
			</div>
			<div class="listItems">
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
	<div class="userChoice<?=$_SESSION['member']['gid'] == _ACL_SUPPLIER_?' hidden':null;?>">
		<a class="userFavoritesList" href="<?=Link::Custom('cabinet','favorites')?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<div class="favleft"><i class="material-icons">favorite</i></div>
			<div class="favright"><p>Избранные</p><p class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</p></div>
		</a>
		<a class="userWaitingList" href="<?=Link::Custom('cabinet','waitinglist')?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>
			<div class="favleft"><i class="material-icons">trending_down</i></div>
			<div class="favright"><p>Лист<br> ожидания</p><p class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</p></div>
		</a>
	</div>
	<div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>
	<a class="menuUserInfBtn" href="<?=_base_url.'/cabinet'?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>Мой кабинет</a>
	<a class="menuUserInfBtn" href="<?=Link::Custom('logout')?>" <?=$GLOBALS['CurrentController'] == 'product'?'rel="nofollow"':null;?>>Выйти</a>
</div>