<div class="login_box paper_shadow_1">
	<div class="box-header">
		<h1>Вход для администратора</h1>
	</div>
	<?if(isset($errm) && isset($msg)){?>
		<div class="notification error no-margin"> <span class="strong">Ошибка!</span><?=$msg?></div>
	<?}else{?>
		<div class="notification tip no-margin"> <span class="strong">Подсказка:</span> Введите email и пароль.</div>
	<?}?>
	<div class="box-content">
		<form method="post" class="grid" action="/adm/login/">
			<div class="row">
				<div class="col-md-4">
					<label for="email">E-mail:</label>
				</div>
				<div class="col-md-8">
					<input tabindex="1" type="text" id="email" name="email" title="Введите ваш email" class="input-m" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" autofocus/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="passwd">Пароль:</label>
				</div>
				<div class="col-md-8">
					<input tabindex="2" type="password" id="passwd" name="passwd" title="Введите ваш пароль" class="input-m"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" name="smb" class="btn-m-default fr">Войти</button>
				</div>
			</div>
		</form>
	</div>
</div>