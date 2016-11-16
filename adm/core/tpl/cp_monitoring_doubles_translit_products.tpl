<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
				<colgroup>
					<col width="5%">
					<col width="5%">
					<col width="45%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<td class="center">id</td>
						<td class="center">арт.</td>
						<td class="center">Название</td>
						<td class="center"></td>
					</tr>
				</thead>
			<?if(!empty($list)){
				foreach($list as $i){?>
					<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
						<colgroup>
							<col width="5%">
							<col width="5%">
							<col width="45%">
							<col width="5%">
						</colgroup>
						<thead>
							<tr class="translit_title"><td colspan="4"><?=$i[0]['translit']?></td></tr>
						</thead>
						<tbody>
							<?foreach($i as $k){?>
								<tr class="animate">
									<td class="center"><?=$k['id_product']?></td>
									<td class="center"><?=$k['art']?></td>
									<td class="left"><?=!$k['visible']?'<span class="invisible">(скрыт) </span>':null?><?=$k['name']?></td>
									<td class="right"><a class="small mr6 icon-font btn-m-blue" title="Редактировать" href="/adm/productedit/<?=$k['id_product']?>" target="_blank">e</a></td>
								</tr>
							<?}?>
						</tbody>
					</table>
				<?}
			}else{?>
				<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
					<thead>
						<tr class="translit_title">
							<td colspan="4">Все ок! Дубли товаров не найдены!</td>
						</tr>
					</thead>
				</table>
			<?}?>
		</table>
	</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>