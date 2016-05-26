<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="customerae" class="grid">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Название фирмы:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="email">E-mail:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
					<input type="text" name="email" id="email" class="input-l" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
				</div>
				<div class="col-md-12">
					<label for="passwd">Пароль:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
					<input type="password" name="passwd" id="passwd" class="input-l" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<label for="address_ur">Юридический адрес:</label><?=isset($errm['address_ur'])?"<span class=\"errmsg\">".$errm['address_ur']."</span><br>":null?>
			<textarea name="address_ur" id="address_ur" rows="8" cols="80" class="input-l"><?=isset($_POST['address_ur'])?htmlspecialchars($_POST['address_ur']):null?></textarea>
		</div>
		<div class="col-md-4">
			<label for="cont_person">Доверенное лицо:</label><?=isset($errm['cont_person'])?"<span class=\"errmsg\">".$errm['cont_person']."</span><br>":null?>
			<input type="text" name="cont_person" id="cont_person" class="input-l" value="<?=isset($_POST['cont_person'])?htmlspecialchars($_POST['cont_person']):null?>">
		</div>
		<div class="col-md-12">
			<label for="phones">Телефоны:</label><?=isset($errm['phones'])?"<span class=\"errmsg\">".$errm['phones']."</span><br>":null?>
			<textarea name="phones" id="phones" rows="3" cols="80" class="input-l"><?=isset($_POST['phones'])?htmlspecialchars($_POST['phones']):null?></textarea>
		</div>
		<div class="col-md-12">
			<label for="descr">Контактная информация:</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
			<textarea name="descr" id="descr" rows="8" cols="80" class="input-l"><?=isset($_POST['descr'])?htmlspecialchars($_POST['descr']):null?></textarea>
		</div>
		<div class="col-md-4">
			<label for="discount">Скидка:</label><?=isset($errm['discount'])?"<span class=\"errmsg\">".$errm['discount']."</span><br>":null?>
			<input type="text" name="discount" id="discount" class="input-l" value="<?=isset($_POST['discount'])?htmlspecialchars($_POST['discount']):null?>">
		</div>
		<div class="col-md-12">
			<label for="active">Отключить покупателя &nbsp;
				<input type="checkbox"  name="active" id="active" <?=isset($_POST['active'])&&(!$_POST['active'])?'checked="checked" value="on"':null?>>
			</label>
			<input type="hidden" name="gid" id="gid" value="<?=isset($_POST['gid'])?$_POST['gid']:0?>">
			<input type="hidden" name="id_user" id="id_user" value="<?=isset($_POST['id_user'])?$_POST['id_user']:0?>">
			<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Сохранить</button>
		</div>
    </form>
</div>