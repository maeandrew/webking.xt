<h1><?=$h1?></h1>
<br>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		    <!--col width="80%"><col width=1%><col width="270px"-->
			<thead>
            <tr class="filter">
                <td id="id_seo_input"><input type="text" class="input-m" name="filter_id" value="<?=isset($_GET['filter_id'])?htmlspecialchars($_GET['filter_id']):null?>" placeholder="ID записи"></td>
                <td id="url_seo_input"><input  type="text" class="input-m" name="filter_url" value="<?=isset($_GET['filter_url'])?htmlspecialchars($_GET['filter_url']):null?>" placeholder="URL (полный)"></td>
                <td id="text_seo_input"></td>
                <td id="author_seo_input"><input  type="text" class="input-m" value="<?=isset($_GET['filter_contragent_name'])?htmlspecialchars($_GET['filter_contragent_name']):null?>" placeholder="Автор" name="filter_contragent_name"> </td>
				<td id="date_seo_input"></td>
				<td id="status_seo_input"></td>
                <td id="edit_seo_input" class="left">
                    <button id="button_seo" type="submit" name="smb" class="btn-m-default">Применить</button>
                    <button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
                </td>
            </tr>
	          <tr>
	            <td class="left">ID</td>
				<td class="left">URL</td>
				<td class="left">Текст</td>
				<td class="left">Автор</td>
				<td class="left">Дата</td>
	            <td class="center">Статус</td>
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
						<a href="/adm/seotextedit/<?=$i['id'];?>"><?=$i['url']?></a>
						<a class="icon-font btn-m-orange-inv watchSeoText" title="Посмотреть текст на странице" href="<?=$i['url']?>">v</a>
					</td>
					<td>
						<a href="/adm/seotextedit/<?=$i['id'];?>"><?=$i['text']?></a>
					</td>
					<td>
						<?=$i['username']?>
					</td>
					<td>
						<?=$i['creation_date']?>
					</td>
					<td class="center">
						<? if($i['visible']==1){?>Вкл<?}else{?>Откл<?}?>
					</td>
					<td class="left actions"><nobr>
						<a class="btn-m-green-inv" href="/adm/seotextedit/<?=$i['id'];?>">Редактировать</a>
						<a class="btn-m-red-inv" href="/adm/seotextdel/<?=$i['id'];?>" onclick="return confirm('Точно удалить?');">Удалить</a>
						</nobr>
					</td>
				</tr>
			<?}?>
			</tbody>
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">SEO-текста нет</span></div>
<?}?>