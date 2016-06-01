<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="customerae" class="grid">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Логин:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="email">E-mail:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
					<input type="text" name="email" id="email" class="input-m" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
				</div>
				<div class="col-md-12">
					<label for="phone">Телефон:</label><?=isset($errm['phone'])?"<span class=\"errmsg\">".$errm['phone']."</span><br>":null?>
					<input type="text" name="phone" id="phone" class="input-m" required placeholder="+3801234567878" value="<?=isset($_POST['phones'])?htmlspecialchars($_POST['phones']):null?>">
				</div>
				<div class="col-md-12">
					<label for="passwd">Пароль:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
					<input type="text" name="passwd" id="passwd" required class="input-m" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
				</div>
				<div class="col-md-12">
					<label for="gid">Профиль:</label><?=isset($errm['gid'])?"<span class=\"errmsg\">".$errm['gid']."</span><br>":null?>
					<select name="gid" id="gid" class="input-m">
						<?foreach($GLOBALS['profiles'] as $key => $value){?>
							<option value="<?=$value['id_profile'];?>"><?=$value['caption'] == ''?$value['name']:$value['caption'];?></option>
						<?}?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
		</div>
    </form>
</div>