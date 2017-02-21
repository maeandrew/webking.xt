<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="configs_list">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="10%">
				<col width="100%">
				<col width="100px">
				<col width="50px">
				<col width="100px">
			</colgroup>
			<thead>
	          <tr>
	            <td class="left">Name</td>
	            <td class="left">Название</td>
	            <td class="left">Значение</td>
				<td>&uarr; &darr;</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr>
						<td>
							<a href="<?=$GLOBALS['URL_base'].'adm/configedit/'.$i['id_config']?>"><?=$i['name']?></a>
						</td>
						<td><?=htmlspecialchars($i['caption']);?></td>
						<td class="left value"><div class="<?=strlen($i['value'])>150?'overflow':null;?>"><?=htmlspecialchars($i['value']);?></div></td>
						<td class="center np">
							<input type="text" name="ord[<?=$i['id_config']?>]" class="input-s" value="<?=$i['ord']?>"/>
						</td>
						<td class="left actions">
							<nobr>
								<a href="<?=$GLOBALS['URL_base'].'adm/configedit/'.$i['id_config']?>"  class="btn-m-green-inv">редактировать</a>
							</nobr>
						</td>
					</tr>
				<?}?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="center">
						<input class="btn-m-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"/>
					</td>
					<td>&nbsp;</td>
				</tr>
		 	</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning">
		<span class="strong">Видов доставки нет</span>
	</div>
<?}?>