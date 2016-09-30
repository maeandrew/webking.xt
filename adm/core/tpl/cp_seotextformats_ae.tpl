<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="seotextformatae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
        <input hidden type="text" name="id" value="<?=isset($_POST['id'])?htmlspecialchars($_POST['id']):null?>">
        <input type="text" name="format" class="input-m" value="<?=isset($_POST['format'])?htmlspecialchars($_POST['format']):null?>">
        <input type="text" name="quantity" class="input-m" value="<?=isset($_POST['quantity'])?htmlspecialchars($_POST['quantity']):null?>">
        <select class="input-m" name="type">
            <option disabled value="0" selected>Выберите из списка</option>
            <option <?=isset($_POST['type'])&& $_POST['type'] == 1?'selected':''?> value="1">Города</option>
            <option <?=isset($_POST['type'])&& $_POST['type'] == 2?'selected':''?>  value="2">Предприятия</option>
            <option <?=isset($_POST['type'])&& $_POST['type'] == 3?'selected':''?>  value="3">Магазины</option>
        </select>
        <input name="smb" type="submit" id="form_submit1" class="save-btn btn-m-default" value="Сохранить">
    </form>
</div>
