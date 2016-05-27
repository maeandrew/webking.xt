<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
<?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="20%">
				<col width="60%">
				<col width="20%">
			</colgroup>
			<thead>
				<tr>
					<td class="left">Описание характеристики</td>
					<td class="left">Единицы измерения</td>
					<td class="left">Управление</td>
				</tr>
			</thead>
			<tbody>
				<?$tigra = false;
				foreach($list as $i){?>
					<tr <?if($tigra == true){?>class="tigra"<?$tigra = false;}else{$tigra = true;}?>>
						<td>
							<?=$i['caption']?>
						</td>
						<td>
							<?=$i['units']?>
						</td>
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