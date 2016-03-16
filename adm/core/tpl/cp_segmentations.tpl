<h1><?=$h1?></h1>
<br>
<?if(isset($list_types) && !empty($list_types)){?>
	<div id="second_navigation">
		<ul class="second_nav_manu">
			<?foreach ($list_types as $f){?>
				<li><a href="#nav_<?=$f['alias']?>"><?=$f['type_name']?></a></li>
			<?}?>
		</ul>
		<div class="tabs-panel">
			<?foreach ($list_types as $f){?>
				<div id="nav_<?=$f['alias']?>">
					<h2><?=$f['type_name']?></h2>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
						<?if($f['use_date'] == 0){?>
							<col width="100%">
						<?}else{?>
							<col width="80%">
							<col width="10%">
							<col width="10%">
						<?}?>
						<thead>
						  <tr>
							<td class="left">Название</td>
							<?if($f['use_date'] == 1){?>
								<td class="center">Дата</td>
								<td class="center">Кол-во дней</td>
							<?}?>
							<td class="left">Управление</td>
						  </tr>
						</thead>
						<tbody>
							<?foreach ($list as $value) {
								if($value['type'] == $f['id']){?>
									<tr>
										<td><?=$value['name']?></td>
										<?if($f['use_date'] == 1){?>
											<td class="center"><?=$value['date']?></td>
											<td class="center"><?=$value['count_days']?></td>
										<?}?>
										<td class="left actions">
											<nobr>
												<a class="btn-l-green-inv" href="/adm/segmentationedit/<?=$value['id']?>">редактировать</a>
												<a class="btn-l-red-inv" href="/adm/segmentationdel/<?=$value['id']?>" onclick="return confirm('Точно удалить? Удалив сегмент, вы также удалите его из категорий и товаров!');">удалить</a>
											</nobr>
										</td>
									</tr>
								<?}
							}?>
						</tbody>
					</table>
				</div>
			<?}?>
		</div>
	</div>
<?}else{?>
	<div class="notification warning">
		<span class="strong">Сегментаций нет</span>
	</div>
<?}?>
<script>
	$("#second_navigation").tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$("#second_navigation li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
</script>