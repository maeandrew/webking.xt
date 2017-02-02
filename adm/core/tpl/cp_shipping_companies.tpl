<h1><?=$h1?></h1>
<div class="grid sites_list">
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
    <table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <td>ID</td>
            <td>Логотип</td>
            <td>Название</td>
            <td>Курьерская доставка</td>
            <td>API</td>
            <td>Ключ API</td>
            <td>Префикс API</td>

            <td></td>
        </tr>
        </thead>
        <tbody>
        <?if(!empty($list)){
            print_r($list);
            foreach($list as $item){?>
                <tr>
                    <td><?=$item['id']?></td>
                    <td><img src="<?=$item['logo']?>" alt="Логотип"></td>
                    <td><?=$item['title']?></td>
                    <td><?=$item['courier'] == 1 ?'Есть' : 'Нет'?></td>
                    <td><?=!$item['has_api']?'Нет' : 'Да'?></td>
                    <td><?=$item['api_key'];?></td>
                    <td><?=!$item['api_prefix']?'Не указан' : $item[api_prefix];?></td>
                    <td>
                        <a href="/adm/shipping_companiesedit/<?=$item['id']?>" class="btn-m-green">Редактировать</a>
                        <a href="/adm/shipping_companiesdel/<?=$item['id']?>" class="btn-m-red">Удалить</a>
                    </td>
                </tr>
            <?}
        }else{?>
            <tr>
                <td colspan="3">Нет ни одной транспортной компании, но ее все-еще можно добавить <a href="/adm/shipping_companiesadd/">здесь</a></td>
            </tr>
        <?}?>
        </tbody>
    </table>
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
</div>