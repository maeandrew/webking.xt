<div class="remind_overlay"></div>
<section class="remind">
	<h1>Восстановление пароля</h1>
	<?if(isset($msg)){?><div class="msg-<?=$msg_type?>"><p><?=$msg?><?=isset($errm['email'])?$errm['email']:null?></p></div><?}?>
	<?if(isset($msg_type) && $msg_type == 'success'){?>
	<?}else{?>
		<form action="<?=_base_url?>/remind/" method="post">
			<label for="email">E-mail:</label>
			<input type="text" id="email" name="email" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>" />
			<button type="submit" name="smb" id="smb" class="btn-m-green">Получить новый пароль</button>
		</form>
	<?}?>
	<hr>
	<a href="<?=_base_url?>" class="backlink"><span class="icon-font">left</span> Вернуться на сайт</a>
</section>