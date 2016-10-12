<h1><?=$h1?></h1>
<div id="assortment" class="grid">
	<div class="row">
		<div class="col-md-12">
			<p>Имя: <?=$supplier['name']?></p>
			<p>Телефоны: <?=$supplier['phones']?></p>
			<p>Контактный телефон: <?=$supplier['real_phone']?></p>
			<p>Контактный email: <?=$supplier['real_mail']?></p>
			<p>Адрес: <?=$supplier['place']?></p>
			<form class="suppliers_activity_form" method="post" action="<?=$_SERVER['REQUEST_URI']?>">
				<input name="supplier_activ" hidden value="<?=$supplier['active'] == 1?'on':'off'?>">
				<span class="current_supplier <?=$supplier['active'] == 1?'active_supplier':'inactive_supplier'?>">Поставщик <?=$supplier['active'] == 0?'не ':null?>активен</span>
				<button type="submit" name="suppliers_activity" class="btn-m-default <?=$supplier['active'] == 1?'btn-m-red-inv disable_supplier_js':'btn-m-green-inv'?>"><?=$supplier['active'] == 1?'Выкл':'Вкл'?></button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<table class="list">
				<thead>
					<tr>
						<td colspan="2">Акты сверки</td>
					</tr>
				</thead>
				<tr class="animate">
					<td>Акт сверки цен поставщика</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>/" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Новая с ценами</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>/?type=new&price=true" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Новая без цен</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>/?type=new&price=false" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Сверх-новая с ценами</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>/?type=wide" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Многоразовая без цен</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>/?type=multiple" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-lg-2 col-md-3 col-sm-8 col-xs-12 infoBlock sb_block">
			<div class="sb_container supplier_info animate">
				<div class="infoTitle tac textBold">Информация</div>
				<div class="line clearfix supplier_name">
					<!-- <div class="parameter fleft">Поставщик:</div> -->
					<div class="value tac textBold"><?=$supplier['name'];?></div>
				</div>
				<div class="line clearfix animate">
					<div class="fleft">Артикул:</div>
					<div class="value fright textBold"><?=$supplier['article'];?></div>
				</div>
				<!-- <div class="line clearfix animate <?=strtotime($supplier['next_update_date'])-time() <= 60*60*24*7*8?'color-red':null;?>">
					<div class="fleft">Рабочие дни до:</div>
					<div class="value fright textBold"><?=date("d.m.Y", strtotime($supplier['next_update_date']));?></div>
				</div> -->
				<?if(is_numeric($supplier['balance'])){?>
					<div class="line clearfix animate">
					<div class="fleft">Текущий баланс:</div>
					<div class="value fright textBold"><?=number_format($supplier['balance'], 2, ",", "")?> грн.</div>
					</div>
				<?}?>
				<div class="line clearfix animate">
					<div class="fleft">Курс доллара:</div>
					<div class="value fright textBold"><?=number_format($supplier['currency_rate'], 2, ",", "");?> грн.</div>
				</div>
				<div class="line clearfix animate">
					<div class="fleft">Всего товаров:</div>
					<div class="value fright textBold"><?=$supplier['all_products_cnt'];?> шт.</div>
				</div>
				<div class="line clearfix animate">
					<div class="fleft">В наличии:</div>
					<div class="value fright textBold"><?=$supplier['active_products_cnt'];?> шт.</div>
				</div>
				<div class="line clearfix animate">
					<div class="fleft">На модерации:</div>
					<div class="value fright textBold"><?=$supplier['moderation_products_cnt'];?> шт.</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-9 col-sm-8 col-xs-12 sb_block">
			<div class="cabinet_block">
				<div class="redBlock">
					<div class="dollar">
						<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" onsubmit="RecalcSupplierCurrency($(this));return false;">
							<label for="currency_rate">Личный курс доллара</label><br>
							<div class="flexWrap">
								<input type="text" name="currency_rate" id="currency_rate" value="<?=$supplier['currency_rate']?>">
								<button class="btn-m-lblue">Пересчитать</button>
							</div>
							<input type="hidden" name="old_currency_rate" value="<?=$supplier['currency_rate']?>">
							<input type="hidden" name="id_supplier" value="<?=$supplier['id_user']?>">
						</form>
						<p class="checksum">Контрольная сумма: <b><?=$check_sum['checksum']?> грн</b></p>
					</div>
				<!--<div class="calendar clearfix">
						<label>Дата последней отметки о рабочем дне:
									<span id="next_update_date">
										<?if($supplier['next_update_date']){
											$tarr = explode("-",$supplier['next_update_date']);
											echo $tarr[2].".".$tarr[1].".".$tarr[0];
										}else{
											echo "Нет";
										}?>
									</span>
						</label>
						<button type="button" id="kalendar" name="update_calendar1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Отправить</button>
						<button type="button" class="btn-m-lblue fr btn_js" data-name="kalendar_content">Календарь</button>
					</div>-->
				</div>
				<!-- <form class="work_days_add" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
					<label for="start_date" class="fleft">С даты:
						<input type="date" name="start_date" id="start_date" value="<?=date("Y-m-d", time());?>"/>
					</label>
					<label for="num_days" class="fleft">Количество дней (от 10 до 90):
						<input type="number" name="num_days" id="num_days" min="10" max="90" value="90" pattern="[0-9]{2}"/>
					</label>
					<button type="submit" name="update_calendar1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Отправить</button>
				</form> -->
			</div>
			<div class="excelBlock">
				<div class="row">
					<div class="add_functions col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="add_items1">
							<p>Цены в гривнах, &#8372;</p>

							<form action="<?=$_SERVER['REQUEST_URI']?>/?export" method="post">
								<button type="submit" class="export_excel btn-m-blue">Экспортировать в Excel</button>
							</form>

							<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
								<button type="submit" name="smb_import" class="import_excel btn-m-blue">Импортировать</button><br>
								<input type="file" name="import_file" required="required" class="file_select">
							</form>
						</div>
					</div>
					<div class="add_functions col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="add_items1">
							<p>Цены в долларах, $</p>

							<form action="<?=$_SERVER['REQUEST_URI']?>/?export_usd" method="post">
								<button type="submit" class="export_excel btn-m-green">Экспортировать в Excel</button>
							</form>

							<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
								<button type="submit" name="smb_import_usd" class="import_excel btn-m-green">Импортировать</button><br>
								<input type="file" name="import_file" required="required" class="file_select">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<h2>Ассортимент</h2>
	<div class="product_list row">
		<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		<div class="col-md-12">
			<?if(isset($cnt) && $cnt >= 30){?>
				<div class="sort_page">
					<a href="<?=$GLOBALS['URL_base']?>adm/assortment/<?=$id_supplier?>/?limit=all"<?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
				</div>
			<?}?>
			<div class="switch_price_container">
				<span>Единая цена</span>
				<label for="switch_price">
					<input type="checkbox" id="switch_price" class="price_switcher_js" <?=(isset($supplier['single_price']) && $supplier['single_price'] == 1)?'checked':null?> >
				</label>
			</div>
		</div>
		<div class="col-md-12">
			<table class="list">
				<col width="5%">
				<col width="8%">
				<col width="35%">
				<col width="8%">
				<col width="8%">
				<col width="12%">
				<col width="12%">
				<col width="8%">
				<col width="4%">
				<thead>
					<tr class="filter">
						<form action="<?=$_SERVER['REQUEST_URI']?>/" method="get">
							<td>Фильтры:</td>
							<td class="center">
								<input type="text" class="input-m" value="<?=isset($_GET['filter_art'])?htmlspecialchars($_GET['filter_art']):null?>" placeholder="Артикул товара" name="filter_art">
							</td>
							<td class="center">
							</td>
							<td>
								<select name="filter_active" class="input-m" placeholder="Наличие">
									<option value="" <?=!isset($_GET['filter_active']) || $_GET['filter_active'] == ''?'selected':null?>>-- Все --</option>
									<option <?=isset($_GET['filter_active']) && $_GET['filter_active'] == 1?'selected':null?> value="1">Есть</option>
									<option <?=isset($_GET['filter_active']) && $_GET['filter_active'] == 0?'selected':null?> value="0">Нет</option>
								</select>
							</td>
							<td></td>
							<td></td>
							<td class="center">
								<select name="filter_inusd" class="input-m" placeholder="Доллар">
									<option value="" <?=!isset($_GET['filter_inusd']) || $_GET['filter_inusd'] == ''?'selected':null?>>-- Все --</option>
									<option <?=isset($_GET['filter_inusd']) && $_GET['filter_inusd'] == 1?'selected':null?> value="1">Да</option>
									<option <?=isset($_GET['filter_inusd']) && $_GET['filter_inusd'] == 0?'selected':null?> value="0">Нет</option>
								</select>
							</td>
							<td class="right">
								<button type="submit" name="smb" class="btn-m-default">Применить</button>
								<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
							</td>
						</tr>
					</form>
					<tr class="animate">
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
						<td colspan="3">Название</td>
						<td><a href="<?=$GLOBALS['URL_base']?>adm/assortment/<?=$id_supplier?>/?sort=a.active&order=<?=$_GET['sort']=='a.active'?$order:'asc';?>">Наличие <?=$_GET['sort']=='a.active'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
						<td>Минимальное кол-во</td>
						<td class="price_mopt_title_js">Цена розн.</td>
						<td class="price_opt_title_js">Цена опт</td>
						<td><a href="<?=$GLOBALS['URL_base']?>adm/assortment/<?=$id_supplier?>/?sort=a.inusd&order=<?=$_GET['sort']=='a.inusd'?$order:'asc';?>">USD <?=$_GET['sort']=='a.inusd'?'<span class="icon-font">'.$mark.'</span>':null;?></a></td>
						<td>Арт. поставщика</td>
					</tr>
				</thead>
				<tbody>
					<?$wh = 'width="90px" height="90px"';
					foreach($list as $item){?>
						<tr class="animate" data-id="<?=$item['id_product'];?>">
							<td>
								<span class="icon-remove animate">n</span>
							</td>
							<td>
								<?if(!empty($item['images'])){?>
									<img <?=$wh?> class="lazy" src="/images/nofoto.png" alt="" data-original="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>" alt="<?=htmlspecialchars($item['name'])?>">
									<noscript>
										<img <?=$wh?> src="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>" alt="<?=htmlspecialchars($item['name'])?>">
									</noscript>
								<?}else{?>
									<img <?=$wh?> class="lazy" src="/images/nofoto.png" alt="<?=htmlspecialchars($item['name'])?>" data-original="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
									<noscript>
										<img <?=$wh?> src="<?=G::GetImageUrl($item['img_1'], 'medium')?>" alt="<?=htmlspecialchars($item['name'])?>"/>
									</noscript>
								<?}?>
							</td>
							<td>
								<a href ="<?=$GLOBALS['URL_base']?>adm/productedit/<?=$item['id_product']?>"><p><?=$item['name'];?></p>
								<p>Арт. <?=$item['art'];?></p></a>
								<p>Изменение ассортимента: <b><?=$item['edited_time']?date('d.m.Y', strtotime($item['edited_time'])).' в '.date('H:i', strtotime($item['edited_time'])):'Н/д';?></b></p>
								<p>Редактирование товара: <b><?=$item['edit_date']?date('d.m.Y', strtotime($item['edit_date'])).' в '.date('H:i', strtotime($item['edit_date'])):'Н/д'?></b></p>
								<p>Редактор: <b><?=$item['edit_username']?$item['edit_username']:'Н/д'?></b></p>
								<?//print_r($item)?>
							</td>
							<td class="center"><input type="checkbox" class="active" <?=$item['active']>0?'checked':null;?>></td>
							<td class="center"><?=$item['min_mopt_qty'];?><?=$item['units'];?></td>
							<td class="center price_1">
								<input type="number" id="price_opt_otpusk_<?=$item['id_product']?>" step="0.01" min="0" class="input-m price" data-mode="mopt" value="<?=$item['inusd'] == 1?$item['price_mopt_otpusk_usd']:$item['price_mopt_otpusk'];?>">
							</td>
							<td class="center price_2">
								<input type="number" id="price_opt_otpusk_<?=$item['id_product']?>" step="0.01" min="0" class="input-m price" data-mode="opt" value="<?=$item['inusd'] == 1?$item['price_opt_otpusk_usd']:$item['price_opt_otpusk'];?>">
							</td>
							<td class="center"><input type="checkbox" <?=$item['inusd'] == 1?'checked':null;?> class="currency"></td>
							<td class="center">
								<input type="text" class="input-m comment" data-mode="opt" value="<?=$item['sup_comment'];?>">
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
			<?if(isset($cnt) && $cnt >= 30){?>
			<div class="sort_page">
				<a href="<?=$GLOBALS['URL_base']?>adm/assortment/<?=$id_supplier?>/?limit=all"<?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
			</div>
			<?}?>
			<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		</div>
	</div>
</div>
<script>
	var id_supplier = <?=$id_supplier;?>;
	<?=$supplier['single_price']==0?'TogglePriceColumns("Off");':'TogglePriceColumns("On");';?>

	$(function(){
		/* Новый переключатель обьедения цены */
		$('.price_switcher_js').on('change', function(){
			var single_price;
			if ($(this).prop("checked")){
				if(window.confirm('Для каждого товара, вместо двух цен, будет установлена единая цена.\nПроверьте, пожалуйста, цены после выполнения.')){
					TogglePriceColumns('On');
					single_price = 1;
				}else{
					$( ".price_switcher_js" ).prop( "checked", false);
				}
			}else{
				TogglePriceColumns('Off');
				single_price = 0;
			}
			var id_supplier = '<?=$supplier['id_user'];?>';
			ajax('supplier', 'toggleSinglePrice', {id_supplier: id_supplier, single_price: single_price}, 'json');
		});

		$('.disable_supplier_js').on('click', function(){
			if (!confirm('Убедитесь что вы сохранили ассортимент в файл Excel')){
				return false;
			}
		});

		// Переключение активности записи ассортимента
		$('.active').on('change', function(){
			var parent = $(this).closest('tr'),
				active = 0,
				product_limit = 0;
			if(this.checked){
				active = 1;
				product_limit = 10000000;
			}
			var data = {
				id_product: parent.data('id'),
				id_supplier: id_supplier,
				active: active,
				product_limit: product_limit
			};
			ajax('product', 'UpdateAssort', data, 'json').done(function(data){
			});
		});
		// Переключение валюты
		$('.currency').on('change', function(){
			var parent = $(this).closest('tr'),
				inusd = 0;
			if(this.checked){
				inusd = 1;
			}
			var data = {
				id_product: parent.data('id'),
				id_supplier: id_supplier,
				inusd: inusd
			};
			ajax('product', 'UpdateAssort', data, 'json').done(function(data){
				parent.find('.price').each(function(){
					var mode = $(this).data('mode');
					if(data.inusd == 1){
						$(this).val(data['price_'+mode+'_otpusk_usd']);
					}else{
						$(this).val(data['price_'+mode+'_otpusk']);
					}
				});
			});
		});
		// Ручное изменение артикула поставщика
		$('.comment').on('keyup, change', function(){
			var parent = $(this).closest('tr'),
					data = {
						id_product: parent.data('id'),
						id_supplier: id_supplier,
						mode: $(this).data('mode'),
						comment: $(this).val()
					};
			ajax('product', 'UpdateAssort', data, 'json').done(function(data){
			});
		});
		// Ручное изменение цены
		$('.price').on('keyup, change', function(){
			var parent = $(this).closest('tr'),
				data = {
					id_product: parent.data('id'),
					id_supplier: id_supplier,
					mode: $(this).data('mode'),
					price: $(this).val(),
				};
			ajax('product', 'UpdateAssort', data, 'json').done(function(data){
			});
		});
		// Клик по "Удалить из ассортимента"
		$('.icon-remove').on('click', function(e){
			if(confirm('Действительно удалить?')){
				e.preventDefault();
				var parent = $(this).closest('tr'),
					id = parent.data('id');
				ajax('product', 'DelFromAssort', {id_product: id, id_supplier: id_supplier}).done(function(){
					parent.fadeOut().remove();
				});
			}
		});
	});
	// Функция переключения "Единой цены"
	function TogglePriceColumns(action){
		if(action == 'On'){
			$('.price_2, .price_opt_title_js').css({
				"display": "none"
			});
			$('.price_mopt_title_js').html('Цена');
			$.each($('td.price_1 input'), function(){
				var id = $(this).attr('id').replace(/\D+/g,"");
				if($('#price_opt_otpusk_'+id).val() !== $('#price_mopt_otpusk_'+id).val()){
					if($('#price_opt_otpusk_'+id).val() == '0,00'){
						$('#price_opt_otpusk_'+id).val($('#price_mopt_otpusk_'+id).val()).change();
					}else{
						$('#price_mopt_otpusk_'+id).val($('#price_opt_otpusk_'+id).val()).change();
					}
				}
			});
		}else{
			$('.price_2, .price_opt_title_js').css({
				"display": "table-cell"
			});
			$('.price_mopt_title_js').html('Цена розн.');
			$.each($('td.price_1 input'), function(){
				var id = $(this).attr('id').replace(/\D+/g,"");
			});
		}
	}
</script>