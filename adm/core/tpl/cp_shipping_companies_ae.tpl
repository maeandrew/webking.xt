<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="warehousesae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
        <label for="shipping_company_name">Название:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
        <input type="text" name="title" id="shipping_company_name" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">
        <label for="courier">Курьерская доставка</label>
        <select name="courier" id="courier" class="input-m">
            <option value="0" <?=isset($_POST['courier']) && $_POST['courier'] == 0?'selected="selected"':null;?>>Нет</option>
            <option value="1" <?=isset($_POST['courier']) && $_POST['courier'] == 1?'selected="selected"':null;?>>Есть</option>
        </select>
        <label for="has_api">API</label>
        <select name="has_api" id="has_api" class="input-m">
            <option value="0" <?=isset($_POST['has_api']) && $_POST['has_api'] == 0?'selected="selected"':null;?>>Нет</option>
            <option value="1" <?=isset($_POST['has_api']) && $_POST['has_api'] == 1?'selected="selected"':null;?>>Да</option>
        </select>
        <div class="hidden" id="api__box">
            <label for="api_key">Ключ API</label>
            <input type="text" name="api_key" id="api_key" class="input-m" value="<?=isset($_POST['api_key'])?htmlspecialchars($_POST['api_key']):null?>">
            <label for="api_prefix">Префикс API</label>
            <input type="text" name="api_prefix" id="api_prefix" class="input-m" value="<?=isset($_POST['api_prefix'])?htmlspecialchars($_POST['api_prefix']):null?>">
        </div>
        <input type="hidden" name="id" id="id_shipping_company" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
        <button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
    </form>
</div>
<script>
         $('#has_api').on('change', function () {
             var value = $('#has_api').val();
             toggleApiBox(value)
         });
         toggleApiBox(<?=$_POST['has_api']?>)
    function toggleApiBox(value)  {
        if (value == 1)  {
            $('#api__box').removeClass('hidden');
        }else {
            $('#api__box').addClass('hidden');
        }
    }
</script>