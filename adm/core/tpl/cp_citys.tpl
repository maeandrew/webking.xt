<h1><?=$h1?></h1>

<?if(isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="hidden">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<col width="80%">
			<col width="1%">
			<col width="250px">
			<thead>
	          <tr>
	            <td class="left">Название города</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
			<? foreach($list as $i){?>
				<tr>
					<td>
						<a href="/adm/cityedit/<?=$i['id_city']?>"><?=$i['name']?></a>
					</td>
					<td class="left actions">
						<nobr>
							<a href="/adm/cityedit/<?=$i['id_city']?>"  class="btn-l-green-inv">редактировать</a>
							<a href="/adm/citydel/<?=$i['id_city']?>"  class="btn-l-red-inv" onclick="return confirm('Точно удалить?');">удалить</a>
						</nobr>
					</td>
				</tr>
			<?}?>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Городов нет</span></div>
<?}?>