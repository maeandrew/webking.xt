<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<col width="1%">
			<col width="80%">
			<col width="250px">
			<thead>
	          <tr>
	            <td class="left">ID</td>
	            <td class="left">Название</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr>
						<td><?=$i['id']?></td>
						<td><a href="<?=$GLOBALS['URL_base'].'adm/remitteredit/'.$i['id']?>"><?=$i['name']?></a></td>
						<td class="left actions">
							<nobr>
								<a href="<?=$GLOBALS['URL_base'].'adm/remitteredit/'.$i['id']?>" class="btn-l-green-inv">редактировать</a>
								<a href="<?=$GLOBALS['URL_base'].'adm/remitterdel/'.$i['id']?>" onclick="return confirm('Точно удалить?');" class="btn-l-red-inv">удалить</a>
							</nobr>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Стоянок нет</span></div>
<?}?>