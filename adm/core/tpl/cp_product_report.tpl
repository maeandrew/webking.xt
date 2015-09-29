<?if(isset($list) == true){?>
	<h1><?='Разбежность <b>более '.$diff.'%</b> | Отобрано товаров: <b>'.count($list).'</b>'?></h1>
<?}else{?>
	<h1><?=$h1?></h1>
<?}?>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error"><span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"><span class="strong">Сделано!</span><?=$msg?></div>
<?}?>
<table width="1000px" border="0" cellspacing="0" cellpadding="0" class="list">
	<col width="1%" />
	<thead>
		<tr>
			<td class="left"><a href="<?=$sort_links['target_date']?>">Артикул</a></td>
			<td class="left">Название</td>
			<td class="left">Поставщик</td>
			<td class="left">Цена</td>
		</tr>
	</thead>
	<tbody>
	<?if(isset($list)){
		$tigra=false;
		foreach($list as $l){?>
			<tr <?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
				<td rowspan="<?=count($l['suppliers'])+1?>"><?=$l['art']?></td>
				<td rowspan="<?=count($l['suppliers'])+1?>"><?=$l['name']?></td>
			</tr>
			<?arsort($l['suppliers']);?>
			<?foreach($l['suppliers'] as $s){?>
				<tr <?if ($tigra==false){?> style="background-color:#f3f3f3;"<?}?>>
					<td><?=$s['article']?></td>
					<td><?=$s['price_mopt_otpusk']?></td>
				</tr>
			<?}
		}
	}else{?>
		<tr>
			<td colspan="4">Cписок пуст или введен некорректный коэффициент!</td>
		</tr>
	<?}?>
	</tbody>
</table>