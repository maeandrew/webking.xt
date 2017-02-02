<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="warehousesae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<label for="city_name">Название:</label><?=isset($errm['warehouse'])?"<span class=\"errmsg\">".$errm['warehouse']."</span><br>":null?>
		<input type="text" name="warehouse" id="city_name" class="input-m" value="<?=isset($_POST['warehouse'])?htmlspecialchars($_POST['warehouse']):null?>">
        <label for="id_region">Область</label>
        <select name="id_region" id="id_region" class="input-m">
            <?foreach($regions as $region) {?>
                <option value="<?=$region['id']?>" <?=isset($_POST['id_city']) && $cities[$_POST['id_city']]['id_region'] == $region['id']?'selected="selected"':null;?>><?=$region['title']?></option>
            <?}?>
        </select>
        <label for="id_city">Город</label>
        <select name="id_city" id="id_city" class="input-m">
            <?foreach($cities as $city) {?>
                <option value="<?=$city['id']?>" <?=isset($_POST['id_city']) && $_POST['id_city'] == $city['id']?'selected="selected"':null;?>><?=$city['title']?></option>
            <?}?>
        </select>
        <label for="id_shipping_company">Транспортная компания</label>
        <select name="id_shipping_company" id="id_shipping_company" class="input-m">
            <?foreach($shipping_companies as $shipping_company) {?>
                <option value="<?=$shipping_company['id']?>" <?=isset($_POST['id_shipping_company']) && $_POST['id_shipping_company'] == $shipping_company['id']?'selected="selected"':null;?>><?=$shipping_company['title']?></option>
            <?}?>
        </select>
        <label for="id_dealer">Транспортная компания</label>
        <select name="id_dealer" id="id_dealer" class="input-m">
            <?foreach($dealers as $dealer) {?>
                <option value="<?=$dealer['id']?>" <?=isset($_POST['id_dealer']) && $_POST['id_dealer'] == $dealer['id']?'selected="selected"':null;?>><?=$dealer['title']?></option>
            <?}?>
        </select>
		<input type="hidden" name="id" id="id_warehouse" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
		<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
    </form>
</div>
<script>
        $('#id_region').on('change', function(){
            var value = $(this).val();
            ajax('location', 'generateCitiesListByIdRegion', {id_region: value}, 'html').done(function(data){
                console.log(data)
            })
        });
</script>