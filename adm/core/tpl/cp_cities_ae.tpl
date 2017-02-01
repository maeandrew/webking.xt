<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="cityae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<label for="city_name">Название:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="city_name" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">
        <label for="id_region">Область</label>
        <select name="id_region" id="id_region" class="input-m">
            <?foreach ($regions as $region) {?>
                <option value="<?=$region['id']?>"><?=$region['title']?></option>
            <?}?>
        </select>
		<input type="hidden" name="id" id="id_city" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
		<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
    </form>
</div>