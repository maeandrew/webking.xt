<div class="row">
	<div class="login_page col-md-5">
		<?=isset($errm) && isset($msg)?'<div class="msg-'.$msg_type.'"><p>'.$msg.'</p></div>':null;?>
		<form action="<?=_base_url?>/login/" method="post">
			<div class="line">
				<label for="login_email">Email</label>
				<input required type="text" id="login_email" name="email" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null;?>" />
				<div id="email_error"></div>
			</div>
			<div class="line">
				<label for="login_passwd">Пароль</label>
				<input required type="password" name="passwd" id="login_passwd"/>
				<div class="password_error"></div>
			</div>
			<div class="line clearfix">
				<p class="login_block">
					<a href="<?=_base_url?>/remind/">Напомнить пароль</a>
					<a href="<?=_base_url?>/register/">Регистрация</a>
				</p>
				<button type="submit" name="smb" id="smb" class="login_submit btn-m-orange fright">Войти</button>
			</div>
		</form>
		<hr>
		<form action="<?=_base_url?>/cart_anonim/" method="post" class="lgn_form">
			<div class="line">
				<button type="submit" name="smb" id="smb" class="login_submit btn-m-green">Заказ без регистрации</button>
			</div>
		</form>
	</div>
</div>