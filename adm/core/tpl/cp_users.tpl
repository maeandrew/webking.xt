<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		    <col width="40%">
		    <col width="200px">
		    <col width="200px">
		    <col width="1%">
			<thead>
				<tr class="filter">
					<td>Фильтры: <input type="text" value="<?=isset($_POST['filter_name'])?htmlspecialchars($_POST['filter_name']):null?>" name="filter_name" class="input-m" placeholder="Имя"></td>
					<td><input type="text" value="<?=isset($_POST['filter_email'])?htmlspecialchars($_POST['filter_email']):null?>" name="filter_email" class="input-m" placeholder="E-mail"></td>
					<td><select name="gid" class="input-m" onchange="this.form.submit();">
						<?foreach($groups as $k=>$item){?>
							<option <?=($item['gid']==$_POST['gid'])?'selected="true"':null?> value="<?=$item['gid']?>"><?=$item['caption']?></option>
				 		<?}?>
						</select>
					</td>
					<td><input type="hidden" name="smb" value=""><input type="submit" name="smb" class="btn-m-default-inv" value="Фильтровать"></td>
				</tr>
	        <tr>
	            <td class="left">Имя</td>
	            <td class="left">E-mail</td>
	            <td class="left">Группа</td>
	            <td class="left">Управление</td>
	        </tr>
	        </thead>
			<tbody>
			<?if(isset($list)){foreach($list as $i){?>
				<tr class="animate">
					<td><?=!$i['active']?'<span class="invisible">(отключен) </span>':null?><a href="<?=$GLOBALS['URL_base'].'adm/'.$g_forlinks[$i['gid']]['name'].'edit/'.$i['id_user']?>"><?=$i['name']?></a></td>
					<td><?=$i['email']?></td>
					<td><?=$groups[$i['gid']]['caption']?></td>
					<td class="right actions">
						<nobr>
							<a href="<?=$GLOBALS['URL_base'].'adm/assortment/'.$i['id_user']?>" class="btn-m-green-inv">ассортимент</a>
							<a href="<?=$GLOBALS['URL_base'].'adm/'.$g_forlinks[$i['gid']]['name'].'edit/'.$i['id_user']?>" class="btn-m-green-inv">редактировать</a>
							<a href="<?=$GLOBALS['URL_base'].'adm/'.$g_forlinks[$i['gid']]['name'].'del/'.$i['id_user']?>" onclick="return confirm('Точно удалить?');" class="btn-m-red-inv">удалить</a>
						</nobr>
					</td>
				</tr>
			<?}}?>
			</tbody>
		</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>