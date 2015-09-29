<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<p class="notification info">Раздел временно закрыт</p>
<form action="<?=$GLOBALS['URL_request']?>" method="post" class="hidden">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
	    <col width="80%">
	    <col width='1%'>
	    <col width="270px">
		<thead>
          <tr>
            <td class="left">Имя производителя</td>
            <td class="center">&uarr; &darr;</td>
            <td class="right">Управление</td>
          </tr>
        </thead>
	<?foreach ($list as $i){?>
		<tr>
			<td>
				<a href="<?=$GLOBALS['URL_base'].'adm/manufactureredit/'.$i['manufacturer_id']?>" onmouseover="ShowLogo(<?=$i['manufacturer_id']?>)" onmouseout="HideLogo(<?=$i['manufacturer_id']?>)"><?=$i['name']?></a>
				<span class="color-sgrey"> (<?=$list_cnt[$i['manufacturer_id']]?>)</span>
				<div id="logo_<?=$i['manufacturer_id']?>" class="hidden">
					<img src="<?=$i['m_image']?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['m_image'])):"/efiles/_thumb/image/nofoto.jpg"?>">
				</div>
			</td>
			<td class="center np">
				<input type="text" name="ord[<?=$i['manufacturer_id']?>]" class="input-s" value="<?=$i['ord']?>">
			</td>
			<td class="left actions">
				<nobr>
					<a href="<?=$GLOBALS['URL_base'].'adm/manufactureredit/'.$i['manufacturer_id']?>" class="btn-l-green-inv">редактировать</a>
					<a href="<?=$GLOBALS['URL_base'].'adm/manufacturerdel/'.$i['manufacturer_id']?>" onclick="return confirm('Точно удалить?');" class="btn-l-red-inv">удалить</a>
				</nobr>
			</td>
		</tr>
	<?}?>
		<tr><td>&nbsp;</td>
				<td class="center"><input class="btn-l-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
				<td>&nbsp;</td>
		</tr>
	</table>
</form>
<script language="JavaScript">
	function ShowLogo(id){
		document.getElementById("logo_"+id).style.display = "block";
	}
	function HideLogo(id){
		document.getElementById("logo_"+id).style.display = "none";
	}

</script>