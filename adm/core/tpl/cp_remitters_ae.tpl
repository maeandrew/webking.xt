<h1><?=$h1?></h1>

<?if(isset($errm) && isset($msg)){?><div class="notification error"><span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"><span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="remittersae" class="grid">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Имя:</label>
					<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
					<label for="egrpou">ЕГРПОУ:</label>
					<input type="text" name="egrpou" id="egrpou" class="input-m" value="<?=isset($_POST['egrpou'])?htmlspecialchars($_POST['egrpou']):null?>">
					<label for="mfo">МФО:</label>
					<input type="text" name="mfo" id="mfo" class="input-m" value="<?=isset($_POST['mfo'])?htmlspecialchars($_POST['mfo']):null?>">
					<label for="bank">Банк:</label>
					<input type="text" name="bank" id="bank" class="input-m" value="<?=isset($_POST['bank'])?htmlspecialchars($_POST['bank']):null?>">
					<label for="rs">Р/с:</label>
					<input type="text" name="rs" id="rs" class="input-m" value="<?=isset($_POST['rs'])?htmlspecialchars($_POST['rs']):null?>">
					<label for="address">Адрес:</label>
					<input type="text" name="address" id="address" class="input-m" value="<?=isset($_POST['address'])?htmlspecialchars($_POST['address']):null?>">
					<input type="hidden" name="id" id="id" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
					<button name="smb" type="submit" id="form_s1ubmit" class="btn-l-default save-btn">Сохранить</button>
				</div>
			</div>
		</div>
    </form>
</div>