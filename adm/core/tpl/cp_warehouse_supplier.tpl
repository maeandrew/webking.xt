<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
	<script>setTimeout(function(){location.replace("<?=$GLOBALS['URL_base']?>adm/warehouse_supplier/");}, 1500);</script>
<?}?>
<?if($warehouses){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
	<col width="100%">
	<thead>
		<tr>
			<td class="left">Имя</td>
			<td class="left">Управление</td>
		</tr>
	</thead>
	<tbody>
		<? foreach($warehouses as $w){?>
			<tr>
				<td>
					<a href="<?=$GLOBALS['URL_base'].'adm/supplieredit/'.$w['id_supplier']?>"><?=$w['name']?></a>
				</td>
				<td class="right actions">
					<nobr>
						<a href="<?=$GLOBALS['URL_base'].'adm/warehousedel/'.$w['id_supplier']?>" onclick="return confirm('Точно удалить?');" class="btn-m-red-inv">удалить</a>
					</nobr>
				</td>
			</tr>
		<?}?>
	</tbody>
</table>
<?}else{?>
	<h4>Складских поставщиков нету</h4>
<?}?>