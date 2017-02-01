<h1><?=$h1?></h1>
<div class="grid sites_list">
    <table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <td>ID</td>
                <td>Название</td>
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
                        <td>
                            <a href="/adm/regionsedit/<?=$item['id']?>" class="btn-m-green">Редактировать</a>
                            <a href="/adm/regionsdel/<?=$item['id']?>" class="btn-m-red">Удалить</a>
                        </td>
                    </tr>
                <?}
            }else{?>
                <tr>
                    <td colspan="3">Нет ни одной области, но еe все-еще можно добавить <a href="/adm/regionsadd/">здесь</a></td>
                </tr>
            <?}?>
        </tbody>
    </table>
</div>