<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<div class="hidden">
	<?if(isset($list) && count($list)){?>
		<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
				<col width="80%">
				<col width="5%">
				<col width="15%">
				<thead>
		          <tr>
		            <td class="left">Название</td>
		            <td class="center">&uarr; &darr;</td>
		            <td class="left">Управление</td>
		          </tr>
		        </thead>
				<tbody>
				<?foreach($list as $i){?>
					<tr class="animate">
						<td><a href="<?=$GLOBALS['URL_base'].'adm/parkingedit/'.$i['id_parking']?>"><?=$i['name']?></a></td>
						<td class="center np"><input type="text" name="ord[<?=$i['id_parking']?>]" size="2" value="<?=$i['ord']?>"></td>
						<td class="left actions"><nobr>
							<a class="btn-l-green-inv" href="<?=$GLOBALS['URL_base'].'adm/parkingedit/'.$i['id_parking']?>">редактировать</a>
							<a class="btn-l-red-inv" href="<?=$GLOBALS['URL_base'].'adm/parkingdel/'.$i['id_parking']?>" onclick="return confirm('Точно удалить?');">удалить</a>
							</nobr>
						</td>
					</tr>
				<?}?>
				</tbody>
				<tr><td>&nbsp;</td>
					<td class="center"><input class="btn-l-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
					<td>&nbsp;</td>
				</tr>

			</table>
		</form>
	<?}else{?>
		<div class="notification warning"> <span class="strong">Стоянок нет</span></div>
	<?}?>
</div>