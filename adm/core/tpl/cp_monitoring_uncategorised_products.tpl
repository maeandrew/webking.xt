<div class="nocategory">
	<form action="" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
					<col width="10%">
					<col width="100%">
					<col width="50px">
					<col width="50px">
					<col width="5%">
				<?}else{?>
					<col width="5%">
					<col width="85%">
					<!-- <col width="5%"> -->
					<col width="15%">
				<?}?>
			</colgroup>
			<thead>
				<tr>
					<td class="left">Артикул</td>
					<td class="left">Название товара</td>
					<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
						<td class="left">Поп Гл</td>
					<?}?>
					<!-- <td class="left">&uarr; &darr;</td> -->
					<td class="right">Управление</td>
				</tr>
			</thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr class="animate">
						<td	<?if($i['price_mopt'] <= 0 || $i['price_opt'] <= 0 ){?> class="sold" <?}?> ><?=$i['art']?></td>
						<td>
							<?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?><a href="<?=$GLOBALS['URL_base'].'adm/productedit/'.$i['id_product']?>"><?=$i['name']?></a>
						</td>
						<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
							<td class="left">
								<input type="checkbox" id="pop_<?=$i['id_product']?>" name="pop_<?=$i['id_product']?>" <?if(isset($pops[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>,0)">
								<input type="checkbox" id="popmain_<?=$i['id_product']?>" name="popmain_<?=$i['id_product']?>" <?if(isset($popsMain[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>, 1)">
							</td>
						<?}?>
						<!-- <td class="left">
							<input type="edit" name="ord[<?=$i['id_product']?>]" class="input-s" value="<?=$i['ord']?>">
						</td> -->
						<td class="right">
							<a class="small mr6 icon-font btn-m-blue" title="Редактировать" href="/adm/productedit/<?=$i['id_product']?>" target="_blank">e</a>
							<a class="small mr6 icon-font btn-m-green" title="Посмотреть товар на сайте" href="/product/<?=$i['translit']?>" target="_blank">v</a>
						</td>
					</tr>
				<?}?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
						<td>&nbsp;</td>
					<?}?>
					<td class="center">
						<input type="submit" name="smb" id="form_submit" class="btn-m-default-inv" value="&uarr;&darr;">
					</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>