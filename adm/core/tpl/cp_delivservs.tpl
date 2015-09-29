<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="hidden">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
			<col width="80%">
			<col width="1%">
			<col width="250px">
			<thead>
	          <tr>
	            <td class="left">Название</td>
	            <td class="center">&uarr; &darr;</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
			<?foreach ($list as $i){?>
				<tr>
					<td>
						<a href="<?=$GLOBALS['URL_base'].'adm/delivservedit/'.$i['id_delivery_service']?>"><?=$i['name']?></a>
					</td>
					<td class="center np">
						<input type="text" name="ord[<?=$i['id_delivery_service']?>]" value="<?=$i['ord']?>">
					</td>
					<td class="left actions">
						<nobr>
							<a href="<?=$GLOBALS['URL_base'].'adm/delivservedit/'.$i['id_delivery_service']?>" class="btn-l-green-inv">редактировать</a>
							<a href="<?=$GLOBALS['URL_base'].'adm/delivservdel/'.$i['id_delivery_service']?>" onclick="return confirm('Точно удалить?');" class="btn-l-red-inv">удалить</a>
						</nobr>
					</td>
				</tr>
			<?}?>
			</tbody>
			<tr><td>&nbsp;</td>
				<td class="center">
					<input type="submit" name="smb" id="form_submit" value="&uarr;&darr;" class="btn-l-default-inv">
				</td>
				<td>&nbsp;</td>
			</tr>

		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Регионов нет</span></div>
<?}?>