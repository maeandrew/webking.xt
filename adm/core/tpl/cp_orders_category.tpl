<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"><span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"><span class="strong">Сделано!</span><?=$msg?></div><?}?>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
	<col width="5%"/>
	<col width="75%"/>
	<col width="5%"/>
	<col width="5%"/>
	<thead>
		<!-- <tr class="filter">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get" class="orders">
				<td>Фильтры:</td>
				<td>
					<input type="text" class="input-m" name="filter_id_order" value="<?=isset($_GET['filter_id_order'])?htmlspecialchars($_GET['filter_id_order']):null?>" placeholder="№ заказа">
				</td>
				<td>
					<select name="id_order_status" class="input-m" placeholder="Статус заказа">
						<option <?=$_GET['id_order_status'] == 0?'selected="true"':null?> value="0">-- Все --</option>
						<?foreach($order_statuses as $k=>$item){?>
							<option <?=$item['id_order_status'] == $_GET['id_order_status']?'selected="true"':null?> value="<?=$item['id_order_status'];?>"><?=$item['name'];?>
							</option>
						<?}?>
					</select>
				</td>
				<td>
					<input type="text" class="input-m" value="<?=isset($_GET['filter_contragent_name'])?htmlspecialchars($_GET['filter_contragent_name']):null?>" placeholder="Менеджер" name="filter_contragent_name">
				</td>
				<td>
					<input type="text" class="input-m" value="<?=isset($_GET['filter_customer_name'])?htmlspecialchars($_GET['filter_customer_name']):null?>" placeholder="Покупатель" name="filter_customer_name">
				</td>
				<td class="left">
					<input type="text" class="input-m" value="<?=isset($_GET['filter_email'])?htmlspecialchars($_GET['filter_email']):null?>" placeholder="E-mail" name="filter_email">
				</td>
				<td class="left">
					<button type="submit" name="smb" class="btn-m-default">Применить</button>
				</td>
				<td class="left">
					<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
				</td>
				<td class="left">&nbsp;</td>
			</form>
		</tr>-->
		<tr>
			<td class="left"><a href="<?=$sort_links['creation_date']?>">Дата</a></td>
			<td class="left"><a href="<?=$sort_links['id_order']?>">№ заказа</a></td>
			<td class="left">Категория</td>
			<td class="left"></td>
		</tr>
	</thead>
	<tbody>
		<?if(isset($list)){
			foreach($list as $i){?>
				<tr class="animate">
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<td><?=date("d.m.Y", $i['creation_date'])?></td>
						<td>
							<a href="/adm/order/<?=$i['id_order']?>"><?=$i['id_order']?></a>
							<input type="hidden" name="id_order" value="<?=$i['id_order']?>"/>
						</td>
						<td>
							<select name="category" class="input-m" required>
								<option disabled selected value="">Выберите категорию</option>
								<?foreach($categories as $category){?>
									<option <?=($category['id_category'] == $i['category'])?'selected':null?> value="<?=$category['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $category['category_level'])?><?=$category['name']?></option>
								<?}?>
							</select>
						</td>
						<td class="left">
							<input name="submit" type="submit" title="Перенести товары из заказа в выбранную категорию" class="btn-m-blue" value="Вперед">
						</td>
					</form>
				</tr>
			<?}
		}?>
	</tbody>
</table>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<script>
var restore = 0;
$('[name="restore"]').click(function(){
	var restore = 1;
	var id_order = $(this).val();
	ajax('order', 'restoreDeleted', {id_order: id_order, restore: restore}).done(function(){
		$(this).fadeOut(300);
	});
});
</script>