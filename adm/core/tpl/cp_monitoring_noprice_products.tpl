<div class="noprice_block"></div>
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
	<!-- <?print_r($list);?> -->
		<form action="" method="post">
			<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
				<colgroup>
					<col width="10%">
					<col width="55%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="filter center">
						<td>Фильтры:</td>
						<td></td>
						<td><input type="text" value="<?=isset($_POST['filter_art'])?htmlspecialchars($_POST['filter_art']):null?>" name="filter_art" class="input-m" placeholder="артикул"></td>
						<td class="right"><input type="hidden" name="smb" value=""><button type="submit" name="smb" class="btn-m-default-inv">Фильтровать</button></td>
						<td class="center"><button type="submit" name="clear_filters" class="btn-m-red-inv">Сбросить</button></td>
					</tr>
					<tr>
						<td class="center" colspan="2">Название товара</td>
						<td class="center">Розница</td>
						<td class="center">Опт</td>
						<td class="center">Управление</td>
					</tr>
				</thead>
				<tbody>
					<?if(isset($list) && $list != ''){?>
						<?foreach($list as $i){?>
							<tr class="animate">
								<td colspan="2">
									<?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?><a href="<?=$GLOBALS['URL_base'].'adm/productedit/'.$i['id_product']?>"><?=$i['name']?></a>
								</td>
								<td class="center"><?=$i['price_mopt']?></td>
								<td class="center"><?=$i['price_opt']?></td>
								<td class="right">
									<a class="small mr6 icon-font btn-m-blue" title="Редактировать" href="/adm/productedit/<?=$i['id_product']?>" target="_blank">e</a>
									<a class="small mr6 icon-font btn-m-green" title="Посмотреть товар на сайте" href="/product/<?=$i['translit']?>" target="_blank">v</a>
								</td>
							</tr>
						<?}
					}?>
				</tbody>
			</table>
		</form>
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
</div>