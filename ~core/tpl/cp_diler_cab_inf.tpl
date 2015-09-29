<style>

.errmsg{

	color: #f00;

	font-size: 12px;

}

</style>



<h2>Личные данные</h2>

<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><br><?}?>

<div>

	<form action="<?=_base_url?>/cabinet/info/" method="post" id="reg_form">

		<div class="line">

			<label for="name">Имя пользователя</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span>":null?>

			<input type="text" id="name" name="name" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" />

			<!--class="input_text"-->

		</div>

		<div class="line">

			<label>Email</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span>":null?>

			<input type="text" disabled value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>"/>

			<input type="hidden" id="email" name="email" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>" />

			<!--class="input_text"-->

		</div>

		<div class="line">

			<label for="discount">Коэфициент цен</label><?=isset($errm['discount'])?"<span class=\"errmsg\">".$errm['discount']."</span><br>":null?>

			<input type="text" name="discount" id="discount" size="20" value="<?=isset($_POST['discount'])?htmlspecialchars(1-$_POST['discount']/100):null?>" />

			<!--class="input_text"-->

		</div>

		<div class="line">

			<label>Контактная информация в прайсе<span></span> </label><?=isset($errm['address_ur'])?"<span class=\"errmsg\">".$errm['address_ur']."</span>":null?>

			<textarea name="address_ur" id="address_ur" rows="5" cols="55"><?=isset($_POST['address_ur'])?htmlspecialchars($_POST['address_ur']):null?></textarea>

			<!--class="input_text"-->

		</div>

		<div class="line">

			<input type="hidden" name="id_user" id="id_user" value="<?=isset($_POST['id_user'])?$_POST['id_user']:0?>">

			<input type="submit" name="smb" id="smb" class="confirm" value="Отправить" />

		</div>

	</form>

</div>