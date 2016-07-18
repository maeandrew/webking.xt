<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
<?print_r($list)?>
	<form action="" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="5%">
				<col width="15%">
				<col width="45%">
				<col width="15%">				
				<col width="5%">				
			</colgroup>
			<thead>
				<!-- <tr class="filter center">
					<td>Фильтры:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="text" value="<?=isset($_POST['filter_user_name'])?htmlspecialchars($_POST['filter_user_name']):null?>" name="filter_user_name" class="input-m" placeholder="имя пользователя"></td>
					<td class="right"><input type="hidden" name="smb" value=""><button type="submit" name="smb" class="btn-m-default-inv">Фильтровать</button></td>
					<td class="center"><button type="submit" name="clear_filters" class="btn-m-red-inv">Сбросить</button></td>
				</tr> -->
				<tr>
					<td class="center">id</td>
					<td class="center">арт.</td>
					<td class="center">Название</td>
					<td class="center"></td>
				</tr>
			</thead>
			<tbody>
				<?if(isset($list) && $list != ''){?>
					<?foreach($list as $i){?>
						<tr class="animate">
							<td class="center"><?=$i['id_product']?></td>
							<td class="center"><?=$i['art']?></td>
							<td class="left"><?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?><?=$i['name']?></td>
							<td class="right"><a class="small mr6 icon-font btn-m-blue" title="Редактировать" href="/adm/productedit/<?=$i['id_product']?>" target="_blank">e</a></td>
						</tr>
					<?}
				}?>
			</tbody>
		</table>
	</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>