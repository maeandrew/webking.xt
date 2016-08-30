<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1 comment_list">
			<col width="85%">
			<col width="15%">
			<thead>
			  <tr>
				<td class="left">Информация о комментарии</td>
				<td class="left"></td>
				<td></td>
				<td></td>
			  </tr>
			</thead>
			<tbody>
			<?foreach ($list as $i){?>
				<?$interval = date_diff(date_create(date("d.m.Y", strtotime($i['date_comment']))), date_create(date("d.m.Y")));?>
					<tr class="coment<?=$i['Id_coment']?> animate <?if(!$i['visible'] && $interval->format('%a') < 3){?>bg-lyellow<?}?>">
						<td>
							<div><a href="/product/<?=$i['translit']?>">#<?=$i['Id_coment']?></a></div>
							<div>Клиент: <?=$i['name_author']?></div>
							<div class="date"><?=date("d.m.Y", strtotime($i['date_comment']))?></div>
							<div><?=$i['text_coment']?></div>
							<div>Товар: <?=$i['name']?></div><!-- <a href="<?='/adm/productedit/'.$i['url_coment']?>">Товар: <?=$i['name']?></a> -->
							<div class="btn_wrap"><a class="btn-m-green btn_answer" href="#">Ответить</a><a class="small mr6 icon-font btn-m-blue" title="Посмотреть товар на сайте" href="/adm/productedit/<?=$i['id_product']?>" target="_blank">e Перейти к товару</a></div>
						</td>
						<td class="right np actions">
							<?=!$i['visible']?'<span class="invisible">скрытый</span>':null?>
							<div>Оценка: 3/5 <?=$i['rating']?></div>
							Видимость <input type="checkbox" id="pop_<?=$i['Id_coment']?>" name="pop_<?=$i['Id_coment']?>" <?if(isset($pops1[$i['Id_coment']])){?>checked="checked"<?}?> onchange="SwitchPops1(this, <?=$i['Id_coment']?>)">
							<div class="del_btn_wrap"><a class="icon-delete btn-m" onClick="if(confirm('Комментарий будет удален.\nПродолжить?') == true){dropComent(<?=$i['Id_coment']?>);};">t Удалить</a></div>
						</td>
						<td></td>
						<td></td>
					</tr>
				<?}?>
				<tr>
					<td>&nbsp;</td>
					<td class="center"><input class="btn-m-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Комментариев нет</span></div>
<?}?>
