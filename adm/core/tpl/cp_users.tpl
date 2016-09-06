<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		    <col width="3%">
		    <col width="30%">
		    <col width="14%">
		    <col width="14%">
		    <col width="8%">
		    <col width="20%">
		    <col width="5%">
			<thead>
				<tr class="filter">
					<td>Фильтры: </td>
					<td><input type="text" value="<?=isset($_POST['filter_name'])?htmlspecialchars($_POST['filter_name']):null?>" name="filter_name" class="input-m" placeholder="Имя"></td>
					<td><input type="text" value="<?=isset($_POST['filter_email'])?htmlspecialchars($_POST['filter_email']):null?>" name="filter_email" class="input-m" placeholder="E-mail"></td>
					<td><select name="gid" class="input-m" onchange="this.form.submit();">
							<?foreach($groups as $k=>$item){?>
							<option <?=($item['gid']==$_POST['gid'])?'selected="true"':null?> value="<?=$item['gid']?>"><?=$item['caption']?></option>
							<?}?>
						</select>
					</td>
					<td></td>
					<td></td>
					<td><input type="hidden" name="smb" value=""><input type="submit" name="smb" class="btn-m-default-inv" value="Фильтровать"></td>
				</tr>
	        <tr>
				<?switch($_GET['order']){
					case 'asc':
						$order = 'desc';
						$mark = 'd';
						break;
					case 'desc':
						$order = '';
						$mark = 'u';
						break;
					default:
						$order = 'asc';
						$mark = '';
				}?>
	            <td class="left">Активность</td>
	            <td class="left"><a href="<?=$GLOBALS['URL_base']?>adm/users/<?=$GLOBALS['REQAR'][1]?>/?sort=u.name&order=<?=$_GET['sort']=='u.name'?$order:'asc';?>">Имя <?=$_GET['sort']=='u.name'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
	            <td class="left"><a href="<?=$GLOBALS['URL_base']?>adm/users/<?=$GLOBALS['REQAR'][1]?>/?sort=u.email&order=<?=$_GET['sort']=='u.email'?$order:'asc';?>">E-mail <?=$_GET['sort']=='u.email'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
				<td class="left">Группа</td>
				<td class="left"><a href="<?=$GLOBALS['URL_base']?>adm/users/<?=$GLOBALS['REQAR'][1]?>/?sort=s.currency_rate&order=<?=$_GET['sort']=='s.currency_rate'?$order:'asc';?>">USD <?=$_GET['sort']=='s.currency_rate'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
				<td class="left"><a href="<?=$GLOBALS['URL_base']?>adm/users/<?=$GLOBALS['REQAR'][1]?>/?sort=s.next_update_date&order=<?=$_GET['sort']=='s.next_update_date'?$order:'asc';?>">Последний рабочий день <?=$_GET['sort']=='s.next_update_date'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
				<td class="left">Управление</td>
	        </tr>
	        </thead>
			<tbody>
			<?if(isset($list)){
				foreach($list as $i){?>
				<tr class="animate">
					<td><?=!$i['active']?'<span class="invisible">нет</span>':'<span>да</span>'?></td>
					<td><a href="<?=$GLOBALS['URL_base'].'adm/usersedit/'.$i['id_user']?>"><?=$i['name']?></a></td>
					<td><?=$i['email']?></td>
					<td><?=$groups[$i['gid']]['caption']?></td>
					<td><?=$i['currency_rate']?></td>
					<td><?=$i['next_update_date']?></td>
					<td class="right actions">
						<nobr>
							<?if($i['gid'] == _ACL_SUPPLIER_){?>
								<a href="<?=$GLOBALS['URL_base'].'adm/assortment/'.$i['id_user']?>" class="btn-m-green-inv">ассортимент</a>
							<?}?>
							<?if($_SESSION['member']['gid'] != _ACL_MODERATOR_){?>
								<a href="<?=$GLOBALS['URL_base'].'adm/'.$g_forlinks[$i['gid']]['name'].'edit/'.$i['id_user']?>" class="btn-m-green-inv">редактировать</a>
								<a href="<?=$GLOBALS['URL_base'].'adm/'.$g_forlinks[$i['gid']]['name'].'del/'.$i['id_user']?>" onclick="return confirm('Точно удалить?');" class="btn-m-red-inv">удалить</a>
							<?}?>
						</nobr>
					</td>
				</tr>
			<?}}?>
			</tbody>
		</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>