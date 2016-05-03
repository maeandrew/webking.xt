<div class="userContainer">
	<div class="UserInfBlock">
		<div id="userPic">
			<div class="avatarWrapp">
				<img src="/themes/default/images/noavatar.jpg"/>
			</div>
		</div>
		<div class="mainUserInf">
			<div id="userNameBlock">
				<div id="userNameInf" class="listItems">
					<?$userNameFromMail = isset($_SESSION['member']['email']) && !empty($_SESSION['member']['email'])?substr($_SESSION['member']['email'], 0, strpos($_SESSION['member']['email'], "@")):'';?>
					<span class="user_name"><?=isset($_SESSION['member']['name']) && !empty($_SESSION['member']['name'])?$_SESSION['member']['name']:$userNameFromMail;?></span>
				</div>
				<a id="editUserProf" class="material-icons" href="<?=Link::Custom('cabinet', 'personal')?>">create</a>
				<div class="mdl-tooltip" for="editUserProf">Изменить<br>профиль</div>
			</div>
			<div class="listItems">
				<i class="material-icons">mail_outline</i>
				<span class="user_email"><?=isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != ''?$_SESSION['member']['email']:"Регистрация без e-mail"?></span>
			</div>
			<script>GetLocation();</script>
			<div class="listItems">
				<i class="material-icons">location_on</i>
				<span class="userlocation"></span>
			</div>
		</div>
	</div>
	<div class="contacts<?=!isset($_SESSION['member']['contragent']) || empty($_SESSION['member']['contragent'])?' hidden':null;?>">
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
	<button class="menuUserInfBtn" id="mycabMenuUserInfBtn" onclick="window.location.href='<?=Link::Custom('cabinet')?>'">Мой кабинет</button>
	<button class="menuUserInfBtn" onclick="window.location.href='<?=Link::Custom('logout')?>'">Выйти</button>
</div>