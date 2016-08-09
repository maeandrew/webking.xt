	<h1><?=$h1?></h1>
	<br>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="5%">
				<col width="20%">
				<col width="60%">
				<col width="15%">
			</colgroup>
			<thead>
	          <tr>
	          	<td class="left">id</td>
	            <td class="left">xt.ua</td>
	            <td class="left">prom.ua</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr>
						<td>
							<?=$i['id']?>
						</td>
						<td>
							<?=$i['unit_xt']?>
						</td>
						<td>
							<?=$i['unit_prom']?>
						</td>
						<td class="left actions">
							<nobr>
								<a href="/adm/unitedit/<?=$i['id']?>" class="btn-l-green-inv">редактировать</a>
							</nobr>
						</td>
					</tr>
				<?}?>
		 	</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning">
		<span class="strong">Единиц измерения нет</span>
	</div>
<?}?>