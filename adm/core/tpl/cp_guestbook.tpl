<div class="guest_book_container">
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		<form action="" method="post">
			<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
				<colgroup>
					<col width="1%">
					<col width="5%">
					<col width="35%">
					<col width="15%">
					<col width="15%">
					<col width="5%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<td class="center"></td>
						<td class="center">Пожелания/Замечания</td>
						<td class="center">Сообщение</td>
						<td class="center">Имя</td>
						<td class="center">Email</td>
						<td class="center">Номер<br>телефона</td>
						<td class="center">Дата<br>создания</td>
					</tr>
				</thead>
				<tbody>
					<?if(isset($list) && $list != ''){?>
						<?foreach($list as $i){?>
							<tr class="animate">
								<td class="center"><?=$i['id']?></td>
								<td class="center <?=$i['issue'] == 0?'issue_false':'issue_true';?>"><?=$i['issue'] == 0?'пожелания':'замечания';?></td>
								<td class="left"><?=$i['comment']?></td>
								<td class="center"><?=(isset($i['name']))?$i['name']:'гость'?></td>
								<td class="center"><?=$i['email']?></td>
								<td class="center"><?=$i['phone']?></td>
								<td class="center"><?=$i['date']?></td>
							</tr>
						<?}
					}?>
				</tbody>
			</table>
		</form>
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
</div>