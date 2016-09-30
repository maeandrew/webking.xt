<h1><?=$h1?></h1>
<br>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>
<?if(isset($seotext_formats) && count($seotext_formats)){?>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
<!--col width="80%"><col width=1%><col width="270px"-->
<thead>
<tr class="filter">
<td></td>
<td></td>
<td></td>
<td>
<select class="input-m" name="filter_type">
<option disabled value="0" selected>Выберите из списка</option>
<option <?=isset($_POST['filter_type'])&& $_POST['filter_type'] == 1?'selected':''?> value="1">Города</option>
<option <?=isset($_POST['filter_type'])&& $_POST['filter_type'] == 2?'selected':''?>  value="2">Предприятия</option>
<option <?=isset($_POST['filter_type'])&& $_POST['filter_type'] == 3?'selected':''?>  value="3">Магазины</option>
</select>
<td>
<button id="button_seo" type="submit" name="smb" class="btn-m-default">Применить</button>
<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
</td>
</tr>
<tr>
<td class="left">ID</td>
<td class="left">Формат</td>
<td class="left">Количество</td>
<td class="left">Тип</td>
</tr>
</thead>
<tbody>
<?foreach($seotext_formats as $i){?>
<tr>
<td>
<?=$i['id']?>
</td>
<td>
<?=$i['format']?>
</td>
<td>
<?=$i['quantity']?>
</td>
<td>
<?=$i['type']==1?'Города':($i['type']==2?'Предприятия':'Магазины');?>
</td>
<td>
<td class="left actions"><nobr>
<a class="btn-m-green-inv" href="/adm/seotextformatsedit/<?=$i['id'];?>">Редактировать</a>
<a class="btn-m-red-inv" href="/adm/seotextformatsdel/<?=$i['id'];?>" onclick="return confirm('Точно удалить?');">Удалить</a>
</nobr>
</td>
</tr>
<?}?>
</tbody>
</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
<?}else{?>
<div class="notification warning"> <span class="strong">SEO-текста нет</span></div>
<?}?>