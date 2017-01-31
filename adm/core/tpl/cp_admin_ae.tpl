<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
<?}?>
<div id="adminae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Имя пользователя:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="email">E-mail пользователя:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
					<input type="text" name="email" id="email" class="input-m" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
				</div>
				<div class="col-md-12">
					<label for="passwd">Пароль пользователя:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
					<input type="password" name="passwd" id="passwd" class="input-m" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
				</div>
				<div class="col-md-12">
					<label>Принадлежность группе:</label><?=isset($errm['gid'])?"<span class=\"errmsg\">".$errm['gid']."</span><br>":null?>
					<select name="gid" id="gid" class="input-m">
						<?foreach ($groups as $g){if(in_array($g['gid'], array(_ACL_ADMIN_, _ACL_MODERATOR_))){?>
							<option <?=(isset($_POST['gid'])&&$_POST['gid']==$g['gid'])?'selected="true"':null?> value="<?=$g['gid']?>"><?=$g['caption']?></option>
						<?}}?>
					</select>
				</div>
				<div class="col-md-12">
					<label for="descr">Комментарий:</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
					<textarea name="descr" id="descr" class="input-m" rows="4" cols="80"><?=isset($_POST['descr'])?htmlspecialchars($_POST['descr']):null?></textarea>
				</div>
				<div class="col-md-12">
					<label for="active">Активность:</label><?=isset($errm['active'])?"<span class=\"errmsg\">".$errm['active']."</span><br>":null?>
					<select name="active" id="active" class="input-m">
						<option value="0" <?=isset($_POST['active']) && $_POST['active'] == '0'?'selected':null;?>>Отключен</option>
						<option value="1" <?=isset($_POST['active']) && $_POST['active'] == '1'?'selected':null;?>>Включен</option>
					</select>
				</div>
				<div class="col-md-12">
					<?if(isset($_POST['id_user'])){?>
						<input type="hidden" name="id_user" value="<?=$_POST['id_user']?>">
					<?}?>
					<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
				</div>
			</div>
		</div>
	</form>
</div>