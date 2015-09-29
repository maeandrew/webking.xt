<h1><?=$h1?></h1>
<br>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		    <col width="80%"><col width=1%><col width="270px">
			<thead>
	          <tr>
	            <td class="left">Заголовок статьи</td>
	            <td class="center">&uarr; &darr;</td>
	            <td class="left">Управление</td>
	          </tr>
	        </thead>
			<tbody>
			<?$tigra=false;
			foreach($list as $i){?>
				<tr <?if($tigra == true){?>class="tigra"<?$tigra = false;}else{$tigra = true;}?>>
					<td><?=!$i['visible']?'<span class="invisible">(скрытая) </span>':null?><a href="/adm/postedit/<?=$i['id'];?>"><?=$i['title']?></a></td>
					<td class="center np">
						<input type="text" name="ord[<?=$i['id']?>]" class="input-s" value="<?=$i['ord']?>"/>
					</td>
					<td class="left actions"><nobr>
						<a class="btn-l-green-inv" href="/adm/postedit/<?=$i['id'];?>">редактировать</a>
						<a class="btn-l-green-inv" href="/posts/<?=$i['id'].'/'.$i['translit'];?>/">смотреть</a>
						<a class="btn-l-red-inv" href="/adm/postdel/<?=$i['id'];?>" onclick="return confirm('Точно удалить?');">удалить</a>
						</nobr>
					</td>
				</tr>
			<?}?>
			</tbody>
			<tr>
				<td>&nbsp;</td>
				<td class="center">
					<input class="btn-l-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"/>
				</td>
				<td>&nbsp;</td>
			</tr>

		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Статей нет</span></div>
<?}?>