<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
<?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="50%">
				<col width="50%">
				<col width="10%">
				<col width="250px">
			</colgroup>
			<thead>
				<tr>
					<td class="left">Название</td>
					<td class="left">Служебное название</td>
					<td class="left">Единицы измерения</td>
					<td class="left">Управление</td>
				</tr>
			</thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr>
						<td><a href="/adm/specification_values_list/<?=$i['id']?>"><?=$i['caption']?></a></td>
						<td><?=$i['service_caption']?></td>
						<td><?=$i['units']?></td>
						<td class="left actions">
							<nobr>
								<a class="btn-m-green-inv" href="/adm/specificationedit/<?=$i['id']?>">редактировать</a>
								<a class="btn-m-red-inv" href="/adm/specificationdel/<?=$i['id']?>" onclick="return confirm('Точно удалить? Удалив характеристику, вы также удалите ее из категорий и товаров!');">удалить</a>
							</nobr>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning">
		<span class="strong">Характеристик нет</span>
	</div>
<?}?>