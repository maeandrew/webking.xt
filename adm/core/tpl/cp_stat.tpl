<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<div id="formae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="hidden">

		Дата
		от: <input type="date" style="width: 200px;" class="input-l" value="<?=isset($_POST['filter_target_date_start'])?htmlspecialchars($_POST['filter_target_date_start']):null?>" name="filter_target_date_start">
		до: <input type="date" style="width: 200px;" class="input-l" value="<?=isset($_POST['filter_target_date_end'])?htmlspecialchars($_POST['filter_target_date_end']):null?>" name="filter_target_date_end">

		<input style="margin: 5px 0px;" name="smb" type="submit" id="form_submit" class="button" value="Выбрать" />
    </form>
</div>

<?if(isset($rows)){?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list" style="overflow: scroll;font-size:12px;margin-top:20px;">
		<thead>
          <tr>
            <td class="left">Артикул</td>
            <td class="left">Название</td>
            <td class="left">Кол-во заказов</td>
            <td class="left">Кол-во шт.</td>
            <td class="left">Сумма</td>
          </tr>
        </thead>
		<tbody>
		<?if(count($rows)){$tigra=false;foreach ($rows as $i){?>
			<tr<?if($tigra == true){?>style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
				<td><?=$i['art']?></td>
				<td><?=$i['name']?></td>
				<td><?=$i['orders_cnt']?></td>
				<td><?=$i['total_qty']?></td>

				<td><?=$i['total_sum']?></td>
			</tr>
		<?}}else{?>
		<tr><td colspan=5>позиций нет</td></tr>
		<?}?>
		</tbody>
	</table>
	<a href="<?=$GLOBALS['URL_request']?>export">Экспорт в excel</a>
<?}?>