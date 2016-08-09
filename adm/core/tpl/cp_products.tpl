<h1>Товары категории "<?=$catname?>"</h1>
<br>
<div class="addproduct">
	<a id="form_submit" class="btn-m-default" href="<?=$GLOBALS['URL_base'].'adm/productadd/'.$id_category?>">Добавить товар</a>
</div>
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
<?if (count($subcats)){?>
	<div class="catrc">
		<?$size=count($subcats);$aa=0; for ($ii=0; $ii<3 && isset($subcats[$aa]); $ii++){?>
			<ul>
				<? for ($jj=($size/3); $jj>0 && isset($subcats[$aa]); $jj--){?>
					<li><a href="<?=$GLOBALS['URL_base'].'adm/products/'.$subcats[$aa]['id_category'].'/'.$subcats[$aa]['translit']?>/"><?=$subcats[$aa++]['name']?></a></li>
				<?}?>
			</ul>
		<?}?>
	</div>
<?}?>
<?if(count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
					<col width="10%">
					<col width="100%">
					<col width="50px">
					<col width="50px">
					<col width="5%">
				<?}else{?>
					<col width="5%">
					<col width="100%">
					<col width="5%">
					<col width="5%">
				<?}?>
			</colgroup>
			<thead>
				<tr>
					<td class="left">Артикул</td>
					<td class="left">Название товара</td>
					<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
						<td class="left">Поп Гл</td>
					<?}?>
					<td class="left">&uarr; &darr;</td>
					<td class="left">Управление</td>
				</tr>
			</thead>
			<tbody>
				<?foreach($list as $i){?>
					<tr class="animate">
						<td	<?if($i['price_mopt'] <= 0 || $i['price_opt'] <= 0 ){?> class="sold" <?}?> ><?=$i['art']?></td>
						<td>
							<?=!$i['visible']?'<span class="invisible">(скрыт) </span>':null?><a href="<?=$GLOBALS['URL_base'].'adm/productedit/'.$i['id_product']?>"><?=$i['name']?></a>
						</td>
						<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
							<td class="left">
								<input type="checkbox" id="pop_<?=$i['id_product']?>" name="pop_<?=$i['id_product']?>" <?if(isset($pops[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>,0)">
								<input type="checkbox" id="popmain_<?=$i['id_product']?>" name="popmain_<?=$i['id_product']?>" <?if(isset($popsMain[$i['id_product']])){?>checked="checked"<?}?> onchange="SwitchPops(this, <?=$i['id_product']?>, 1)">
							</td>
						<?}?>
						<td class="left">
							<input type="edit" name="ord[<?=$i['id_product']?>]" class="input-s" value="<?=$i['ord']?>">
						</td>
						<td class="right">
							<a class="small mr6" title="Редактировать" href="/adm/productedit/<?=$i['id_product']?>">
								<img alt="Редактировать" src="/adm/images/edit.png" width="16" height="16">
							</a>
							<a class="small mr6" title="Посмотреть товар на сайте" href="/product/<?=$i['translit']?>">
								<img alt="Посмотреть на сайте" src="/adm/images/globe.png" width="16" height="16">
							</a>
							<!--<a class="small mr6" title="Отвязать товар от категории" href="/adm/productdel/<?=$i['id_product']?>">
								<img alt="Удалить товар" src="/adm/images/delete.png" width="16" height="16">
							</a>-->
						</td>
					</tr>
				<?}?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<?if($_SESSION['member']['gid'] == _ACL_SEO_){?>
						<td>&nbsp;</td>
					<?}?>
					<td class="center">
						<input type="submit" name="smb" id="form_submit" class="btn-m-default-inv" value="&uarr;&darr;">
					</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
	<div class="fr">
		<p><img src="/adm/images/edit.png" width="16" height="16"> — редактировать	<img src="/adm/images/globe.png" width="16" height="16"> — посмотреть на сайте	<!--<img src="/adm/images/delete.png" width="16" height="16"> — удалить</p> -->
	</div>
	<div class="addproduct">
		<a id="form_submit" class="btn-m-default" href="<?=$GLOBALS['URL_base'].'adm/productadd/'.$id_category?>">Добавить товар</a>
	</div>
	<?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_ADMIN_ || $_SESSION['member']['gid'] == _ACL_MODERATOR_)){?>
		<div style="padding-top: 20px;">
			<a href="<?=$GLOBALS['URL_request']?>/exportactive">Экспорт товаров, светящихся на сайте</a>
		</div>
		<div style="padding-top: 10px;">
			<a href="<?=$GLOBALS['URL_request']?>/export">Экспорт в excel</a>
		</div>
		<div style="padding-top: 10px;">
			<a href="<?=$GLOBALS['URL_request']?>/export_sup_prices">Экспорт в excel c поставщиками и ценами</a>
		</div>
	<?}else{?>
		<div class="notification warning">
			<span class="strong">Товаров нет</span>
		</div>
	<?}?>
<?}?>
<br>
<?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_ADMIN_)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
		<input type="file" name="import_file" class="input-m" style="width: auto;">
		<input type="submit" name="smb_check" class="btn-m-red" value="Импорт">
		<!-- <input type="submit" name="smb_import" class="btn-m-default" value="Импорт"> -->
	</form>
<?}?>
<?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_ADMIN_)){?>
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<p style="margin-top:25px">Введите ID поставщика для выгрузки позиций:</p>
		<input type="text" name="supl" id="supl" class="input-m" style="width: auto;">
 		<input style="margin: 0 0 20px 0;" name="smb" type="submit" id="form_submi1t" class="btn-m-default" value="Выгрузить позиции" />
    </form>
<?}?>
<?if(isset($total_added)){?>
	<br><b>Добавлено:</b> <?=$total_added?>
<?}?>
<?if(isset($total_updated)){?>
	<br><b>Обновлено:</b> <?=$total_updated?>
<?}?>
<?if(isset($res_check)){?>
	<br><b>Найдено дублей арт. ( <?=count(explode(',', $res_check))?> ):</b> <?=$res_check?>
<?}?>
<script>
	function SwitchPops(obj,id, main){
		action = "add";
		if (!obj.checked){
			action = "del";
		}
		id_category = 0;
		if (main==0){
			id_category = <?=$id_category?>;
		}
		$.ajax({
			url: URL_base+'ajaxpops',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": action,
				"id_product": id,
				"id_category": id_category
			}
		});
	}
</script>