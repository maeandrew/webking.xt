<h1>Дубли товаров</h1>
<br>
<?if (isset($errm) && isset($msg)){?>
	<div class="notification error">
		<span class="strong">Ошибка!</span><?=$msg?>
	</div>
<?}elseif(isset($msg)){?>
	<div class="notification success">
		<span class="strong">Сделано!</span><?=$msg?>
	</div>
<?}?>
<br>
<?if(!empty($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="duplicates_form">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
					<col width="10%">
					<col width="60%">
					<col width="30%">
			</colgroup>
			<tbody>
				<?$tigra = false;
				foreach($list as $i){?>
					<tr class="animate">
						<td><img src="http://x-torg.com<?=G::GetImageUrl($i['img_1'], 'medium')?>" alt="фото" width="100px"></td>
						<td>
							<?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?>
							<?=$i['name']?>
							<br>
							<?=$i['art']?>
							<br>
							<a href="/product/<?=$i['id_product'].'/'.$i['translit']?>" class="btn-m-green">на сайте</a>
							<a href="/adm/productedit/<?=$i['id_product']?>" class="btn-m-blue">в админке</a>
						</td>
						<td class="left">
							Отметил: <?=$i['email']?>
							<br>
							Комментарий: <?=$i['duplicate_comment']?>
							<br>
							Дата: <?=$i['duplicate_date']?>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</form>
<?}?>