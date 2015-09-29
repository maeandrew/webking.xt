<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<col width="75%">
			<col width="1%">
			<col width="23%">
			<col width="1%">
			<thead>
			  <tr>
				<td class="left">Коментарий</td>
				<td class="left">Видимость</td>
				<td class="left">Товар</td>
				<td class="left"></td>
			  </tr>
			</thead>
			<tbody>
			<?foreach ($list as $i){?>
			<?$interval = date_diff(date_create(date("d.m.Y", strtotime($i['date_comment']))), date_create(date("d.m.Y")));?>
				<tr class="coment<?=$i['Id_coment']?> animate <?if(!$i['visible'] && $interval->format('%a') < 3){?>bg-lyellow<?}?>">
					<td><span class="date"><?=date("d.m.Y", strtotime($i['date_comment']))?></span> <?=!$i['visible']?'<span class="invisible">скрытый</span>':null?><br><?=$i['text_coment']?></td>
					<td class="center np"><input type="checkbox" id="pop_<?=$i['Id_coment']?>" name="pop_<?=$i['Id_coment']?>" <?if(isset($pops1[$i['Id_coment']])){?>checked="checked"<?}?> onchange="SwitchPops1(this, <?=$i['Id_coment']?>)"></td>
					<td><a href="<?='/product/'.$i['url_coment']?>"><?=$i['name']?></a></td>
					<td class="center np actions"><a class="icon-delete" onClick="if(confirm('Комментарий будет удален.\nПродолжить?') == true){dropComent(<?=$i['Id_coment']?>);};">t</a></td>
				</tr>
			<?}?>
				<tr>
					<td>&nbsp;</td>
					<td class="center"><input class="btn-l-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Новостей нет</span></div>
<?}?>

<script>
function SwitchPops1(obj, id){
	action = "show";
	if(!obj.checked){
		action = "hide";
	}
	$.ajax({
		url: URL_base+'ajaxcoment',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": action,
			"Id_coment": id
		}
	}).done(function(){
		location.reload();
	});
}
function dropComent(id){
	action = "drop";
	$.ajax({
		url: URL_base+'ajaxcoment',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": action,
			"Id_coment": id
		}
	}).done(function(){
		$('.coment'+id).remove();
	});
}
</script>