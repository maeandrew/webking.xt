<h1><?=$h1?></h1>
<div class="grid sites_list">
    <table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
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
                    <td><?=$item['title']?>
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
</div>