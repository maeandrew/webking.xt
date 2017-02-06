<h1><?=$h1?></h1>
<div class="grid sites_list">
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
    <table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr class="filter">
            <td>Фильтры:</td>
            <td></td>
            <td>
                <select name="id_region" id="id_region" class="input-m" form="submit_clear">
                    <?foreach($regions as $region) {?>
                        <option value="<?=$region['id']?>" <?=isset($_GET['id_region']) && $_GET['id_region'] == $region['id']?'selected="selected"':null;?>><?=$region['title']?></option>
                    <?}?>
                </select>
            </td>
            <td>
                <select name="id_city" id="id_city" class="input-m" form="submit_clear">
                    <option value="" selected="selected">Не выбран</option>
                    <?foreach($cities as $city) {?>
                        <option value="<?=$city['id']?>" <?=isset($_GET['id_region']) && $_GET['id_region'] == $city['id']?'selected="selected"':null;?>><?=$city['title']?></option>
                    <?}?>
                </select>
            </td>
            <td>
                <select name="id_shipping_company" id="id_shipping_company" class="input-m" form="submit_clear">
                    <option value="" selected="selected">Не выбрана</option>
                    <?foreach($shipping_companies as $company) {?>
                        <option value="<?=$company['id']?>" <?=isset($_GET['id_region']) && $_GET['id_region'] == $company['id']?'selected="selected"':null;?>><?=$company['title']?></option>
                    <?}?>
                </select>
            </td>
            <td></td>
            <td>
                <form action="" method="GET" id="submit_clear">
                    <button type="submit" name="smb" class="btn-m-default">Применить</button>
                    <button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
                </form>
            </td>

        </tr>
        <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Область</td>
            <td>Город</td>
            <td>Транспортная компания</td>
            <td>Дилер</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?if(!empty($list)){
            foreach($list as $item){?>
                <tr>
                    <td><?=$item['id']?></td>
                    <td><?=$item['warehouse']?></td>
                    <td><?=$regions[$cities[$item['id_city']]['id_region']]['title']?></td>
                    <td><?=$cities[$item['id_city']]['title']?></td>
                    <td><?=$shipping_companies[$item['id_shipping_company']]['title'];?></td>
                    <td><?=!$item['id_dealer']?'Не указан' : $dealers[$item['id_dealer']]['last_name'].' '.$dealers[$item['id_dealer']]['first_name'].' '.$dealers[$item['id_dealer']]['middle_name'];?></td>
                    <td>
                        <a href="/adm/warehousesedit/<?=$item['id']?>" class="btn-m-green">Редактировать</a>
                        <a href="/adm/warehousesdel/<?=$item['id']?>" class="btn-m-red">Удалить</a>
                    </td>
                </tr>
            <?}
        }else{?>
            <tr>
                <td colspan="3">Нет ни одного города, но его все-еще можно добавить <a href="/adm/warehousessadd/">здесь</a></td>
            </tr>
        <?}?>
        </tbody>
    </table>
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
</div>

<script>
    $('#id_region').on('change', function(){
        var value = $(this).val();
        ajax('location', 'generateCitiesListByIdRegion', {id_region: value}, 'html').done(function(data){
            $('#id_city').html(data);
        })
    });
</script>