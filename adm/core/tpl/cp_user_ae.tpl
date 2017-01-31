<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error">
		<span class="strong">Ошибка!</span>
		<?=$msg?>
	</div>
<?}elseif(isset($msg)){?>
	<div class="notification success">
		<span class="strong">Сделано!</span>
		<?=$msg?>
	</div>
<?}?>
<div id="customerae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Логин:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="email">E-mail:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
					<input type="text" name="email" id="email" class="input-m" pattern="(^([\w\.-]+)@([\w-]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
				</div>
				<div class="col-md-12">
					<label for="phone">Телефон:</label><?=isset($errm['phone'])?"<span class=\"errmsg\">".$errm['phone']."</span><br>":null?>
					<input type="text" name="phone" id="phone" class="input-m" placeholder="+380123456787" value="<?=isset($_POST['phone'])?htmlspecialchars($_POST['phone']):null?>">
				</div>
				<div class="col-md-12">
					<label for="passwd">Пароль:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
					<input type="text" name="passwd" id="passwd" <?=$GLOBALS['REQAR'][0] == 'useradd'?'required':null;?> class="input-m" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
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
					<label for="gid">Профиль пользователя:</label><?=isset($errm['gid'])?"<span class=\"errmsg\">".$errm['gid']."</span><br>":null?>
					<select name="gid" id="gid" class="input-m">
						<?foreach($GLOBALS['profiles'] as $key => $value){?>
							<option value="<?=$value['id_profile'];?>" <?=isset($_POST['gid']) && $_POST['gid'] == $value['id_profile']?'selected':null;?>><?=$value['caption'] == ''?$value['name']:$value['caption'];?></option>
						<?}?>
					</select>
				</div>
				<div class="col-md-12">
					<div class="additional_fields additional_fields_js"></div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
		</div>
	</form>
</div>
<script>
$(function(){
	$('#gid').on('change', function(){
		$('.additional_fields_js').html('');
		ajax('profiles', 'getAdditionalFields', {id_profile: $(this).val()}, 'html').done(function(data){
			$('.additional_fields_js').html(data);
		});
	});
});
</script>