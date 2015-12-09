<?if(isset($errm) && isset($msg)){?><div class="msg-error"><p>Ошибка! <?=$msg?></p></div><?}?>
<div class="register_page row">
	<? if (isset($_GET['type']) && $_GET['type'] == 'success') {?>
		<div class="col-md-12">
			<div class="reg_success col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
				<h4>Спасибо за регистрацию!</h4>
				<a href="<?=$_SESSION['backlink']?>" class="btn-m-green fleft" title="Нажмите чтобы приступить к покупкам">Приступить к покупкам</a>
				<a href="<?=_base_url?>/cabinet/" class="btn-m-green fright" title="Нажмите чтобы перейти в личный кабинет">Перейти в личный кабинет</a>
			</div>
		</div>
	<?}else{?>
		<form id="reg_form" class="col-lg-6 col-md-8 col-sm-12 col-xs-12" action="<?=_base_url?>/register/" method="post">
			<div class="reg_section">
				<label for="name">Имя</label>
				<input type="text" name="name" id="regname" required="required"/>
				<div id="name_error"></div>
				<div class="error_description"></div>
			</div>
			<div class="reg_section">
				<label for="regemail">Email (логин)</label>
				<input required type="text" name="email" id="regemail"/>
				<div id="email_error"></div>
				<div class="error_description"></div>
			</div>
			<div class="reg_section">
				<label for="regpasswd">Пароль</label>
				<input required type="password" name="passwd" id="regpasswd"/>
				<div id="passstrength">
					<div id="passstrengthlevel"></div>
				</div>
				<div id="password_error"></div>
				<div class="error_description"></div>
			</div>
			<div class="reg_section">
				<label for="passwdconfirm">Подтверждение пароля</label>
				<input required type="password" name="passwdconfirm" id="passwdconfirm"/>
				<div id="passwdconfirm_error"></div>
				<div class="error_description"></div>
			</div>
			<div class="reg_section hidden">
				<label for="promo_code">Код дилера</label>
				<input required type="text" name="promo_code" id="promo_code"/>
				<div id="promo_code_error"></div>
				<div class="error_description"></div>
			</div>
			<p>
				<label for="confirmps">
					<input required type="checkbox" name="confirmps" id="confirmps" checked/> Я согласен с условиями
					<a href="<?=_base_url?>/page/Dogovor">Пользовательского соглашения</a>
				</label>
			</p>
			<p>
				<label for="news">
					<input type="checkbox" name="news" id="news" value="1" checked/> Подписаться на новостную рассылку
				</label>
			</p>
			<input type="hidden" name="smb" id="smb" value="true"/>
			<button type="submit" name="smb" id="smb" class="confirm_btn btn-m-green">Зарегистрироваться</button>
		</form>
	<?}?>
</div>
