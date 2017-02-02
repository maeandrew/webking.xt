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
                    <form action="" method="GET" id="submit_clear">
                        <button type="submit" name="smb" class="btn-m-default">Применить</button>
                        <button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
                    </form>
                </td>
            </tr>
        </thead>
        <thead>
        <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Область</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?if(!empty($list)){
            foreach($list as $item){

                ?>
                <tr>
                    <td><?=$item['id']?></td>
                    <td><?=$item['title']?></td>
                    <td><?=$regions[$item['id_region']]['title']?></td>
                    <td>
                        <a href="/adm/citiesedit/<?=$item['id']?>" class="btn-m-green">Редактировать</a>
                        <a href="/adm/citiesdel/<?=$item['id']?>" class="btn-m-red">Удалить</a>
                    </td>
                </tr>
            <?}
        }else{?>
            <tr>
                <td colspan="3">Нет ни одного города, но его все-еще можно добавить <a href="/adm/citiessadd/">здесь</a></td>
            </tr>
        <?}?>
        </tbody>
    </table>
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
</div>