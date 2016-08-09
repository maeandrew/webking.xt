<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="hidden">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
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
			<?foreach($list as $i){?>
				<tr>
					<td>
						<a href="<?=$GLOBALS['URL_base'].'adm/deliveryedit/'.$i['id_delivery']?>"><?=$i['name']?></a>
					</td>
					<td class="center np">
						<input type="text" name="ord[<?=$i['id_delivery']?>]" size="2" value="<?=$i['ord']?>">
					</td>
					<td class="left actions">
						<nobr>
							<a href="<?=$GLOBALS['URL_base'].'adm/deliveryedit/'.$i['id_delivery']?>" class="btn-l-green-inv">редактировать</a>
							<a href="<?=$GLOBALS['URL_base'].'adm/deliverydel/'.$i['id_delivery']?>" onclick="return confirm('Точно удалить?');" class="btn-l-red-inv">удалить</a>
						</nobr>
					</td>
				</tr>
			<?}?>
			</tbody>
			<tr><td>&nbsp;</td>
				<td class="center"><input type="submit" name="smb" id="form_submit" class="btn-l-default-inv" value="&uarr;&darr;"></td>
				<td>&nbsp;</td>
			</tr>

		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Видов доставки нет</span></div>
<?}?>