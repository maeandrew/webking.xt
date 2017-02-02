<h1><?=$h1?></h1>
<div class="grid sites_list">
    <?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
    <table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
        <thead>
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