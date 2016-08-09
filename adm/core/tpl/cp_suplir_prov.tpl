	<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<thead>
			<tr>
				<td class="left">ID</td>
				<td class="left">Поставщик</td>
				<td class="left">Позиций в продаже (без учета рабочих дней)</td>
				<td class="left">Курс</td>
				<td class="left">Работает</td>
				<td class="left">ОПТ </td>
				<td class="left">Мелкий ОПТ</td>
			</tr>
		</thead>
		<tbody>
		<?if(isset($list1)){
			foreach ($list1 as $i){?>
				<tr>
					<td><?=htmlspecialchars($i['id_user'])?></td>
					<td><?=htmlspecialchars($i['name'])?></td>
					<td><?=htmlspecialchars($i['cnt'])?></td>
					<td><?=htmlspecialchars($i['currency_rate'])?></td>
					<td><?=htmlspecialchars($i['work_day'])?></td>	
					<td><?=htmlspecialchars($i['koef_nazen_opt'])?></td>	
					<td><?=htmlspecialchars($i['koef_nazen_mopt'])?></td>					
				</tr>
			<?}
		}?>
		</tbody>
	</table>
</form>