<div class="nocategory">
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
	<form action="" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>				
				<col width="5%">
				<col width="5%">
				<col width="75%">
				<col width="10%">
			</colgroup>
			<thead>
				<tr class="filter center">
					<td>Фильтры: </td>
					<td><input type="text" value="<?=isset($_POST['filter_art'])?htmlspecialchars($_POST['filter_art']):null?>" name="filter_art" class="input-m" placeholder="артикул"></td>
				<!-- 	<td><select name="gid" class="input-m" onchange="this.form.submit();">
							<?foreach($groups as $k=>$item){?>
							<option <?=($item['gid']==$_POST['gid'])?'selected="true"':null?> value="<?=$item['gid']?>"><?=$item['caption']?></option>
							<?}?>
						</select>
					</td> -->
					<!-- <td></td> -->
					<td class="right"><input type="hidden" name="smb" value=""><button type="submit" name="smb" class="btn-m-default-inv">Фильтровать</button></td>
					<td class="center"><button type="submit" name="clear_filters" class="btn-m-red-inv">Сбросить</button></td>
				</tr>
				<tr>
					<td class="center">Индексация</td>
					<td class="left">Артикул</td>
					<td class="left">Название товара</td>
					<td class="center">Управление</td>
				</tr>
			</thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr class="animate">
						<td class="center"><?=$i['indexation'] == 1?'Да':'Нет';?></td>
						<td	<?if($i['price_mopt'] <= 0 || $i['price_opt'] <= 0 ){?> class="" <?}?> ><?=$i['art']?></td>
						<td>
							<?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?><a href="<?=$GLOBALS['URL_base'].'adm/productedit/'.$i['id_product']?>"><?=$i['name']?></a>
						</td>
						<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
							<td class="left">
								<input type="checkbox" id="pop_<?=$i['id_product']?>" name="pop_<?=$i['id_product']?>" <?if(isset($pops[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>,0)">
								<input type="checkbox" id="popmain_<?=$i['id_product']?>" name="popmain_<?=$i['id_product']?>" <?if(isset($popsMain[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>, 1)">
							</td>
						<?}?>
						<td class="right">
							<a class="small mr6 icon-font btn-m-blue" title="Редактировать" href="/adm/productedit/<?=$i['id_product']?>" target="_blank">e</a>
							<a class="small mr6 icon-font btn-m-green" title="Посмотреть товар на сайте" href="/product/<?=$i['translit']?>" target="_blank">v</a>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</form>
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
</div>