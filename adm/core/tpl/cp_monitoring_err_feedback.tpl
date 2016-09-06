<div class="err_feedback">
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
	<?print_r($list['id_error']);?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="1%">
				<col width="25%">
				<col width="8%">
				<col width="7%">
				<col width="15%">
				<col width="15%">
				<col width="15%"> 
				<col width="8%">
			</colgroup>
			<thead>
				<tr class="filter center">
					<td>Фильтры:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="text" value="<?=isset($_POST['filter_user_name'])?htmlspecialchars($_POST['filter_user_name']):null?>" name="filter_user_name" class="input-m" placeholder="имя пользователя"></td>
					<td class="right"><input type="hidden" name="smb" value=""><button type="submit" name="smb" class="btn-m-default-inv">Фильтровать</button></td>
					<td class="center"><button type="submit" name="clear_filters" class="btn-m-red-inv">Сбросить</button></td>
				</tr>
				<tr>
					<td></td>
					<td class="center">Комментарий</td>
					<td class="center">Страница с ошибкой</td>
					<td class="center">Cкриншот</td>
					<td class="center">Агент</td>
					<td class="center">Имя</td>
					<td class="center">Email</td>
					<td class="center">Дата</td>
				</tr>
			</thead>
			<tbody>
				<?if(isset($list) && $list != ''){?>
					<?foreach($list as $i){?>
						<tr class="animate">
							<td><button type="submit" name="error_fix" class="icon-font btn-m-green" title="Отметить что ошибка исправлена" value="<?=$i['id_error']?>">y</button></td>
							<td class="left"><?=$i['comment']?></td>
							<td class="center">
								<?if (strpos($i['url'], 'cabinet') !== false) {?>
									Кабинет клиента
								<?}else{?>
									<a href="<?=$i['url']?>" target="_blank"><img src="/images/ic_launch_black_24px.svg" alt=""></a>
								<?}?>
							</td>
							<td class="center">
								<?if ($i['image'] != '') {?>
									<a class="small mr6 icon-font btn-m-lblue" title="Посмотреть скриншот" href="<?=$i['image']?>" target="_blank">v</a>
								<?}?>
							</td>
							<td class="center"><?=$i['user_agent']?></td>
							<td class="center"><?=(isset($i['name']))?$i['name']:'анонимно'?></td>
							<td class="center"><?=$i['email']?></td>
							<td class="center"><?=$i['create_date']?></td>
						</tr>
					<?}
				}?>
			</tbody>
		</table>
	</form>
	<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
</div>