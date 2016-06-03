<!-- <h1><?=$h1?></h1> -->
<div id="assortment" class="grid">
	<div class="row">
		<div class="col-md-12">
			<h2>Информация о поставщике</h2>
			<p>Имя: <?=$supplier['name']?></p>
			<p>Телефоны: <?=$supplier['phones']?></p>
			<p>Контактный телефон: <?=$supplier['real_phone']?></p>
			<p>Контактный email: <?=$supplier['real_mail']?></p>
			<p>Адрес: <?=$supplier['place']?></p>
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
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Новая с ценами</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=true" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Новая без цен</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=false" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Сверх-новая с ценами</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=wide" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
				<tr class="animate">
					<td>Многоразовая без цен</td>
					<td>
						<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=multiple" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-lg-2 col-md-3 col-sm-8 col-xs-12 infoBlock sb_block">
				
				<!-- <table class="list">
					<thead>
						<tr>
							<td colspan="2">Информация</td>
						</tr>
					</thead>
					<tr class="animate">
						<td colspan="2"><?=$supplier['name'];?> Name</td>
					</tr>
					<tr class="animate">
						<td>Артикул:</td>
						<td><?=$supplier['article'];?></td>
					</tr>
					<tr class="animate">
						<td>Рабочие дни до:</td>
						<td><?=date("d.m.Y", strtotime($supplier['next_update_date']));?></td>
					</tr>
					<?if(is_numeric($supplier['balance'])){?>
						<tr class="animate">
							<td>Текущий баланс:</td>
							<td><?=number_format($supplier['balance'], 2, ",", "")?> грн.</td>
						</tr>
					<?}?>
					<tr class="animate">
						<td>Курс доллара:</td>
						<td><?=number_format($supplier['currency_rate'], 2, ",", "");?> грн.</td>
					</tr>
					<tr class="animate">
						<td>Всего товаров:</td>
						<td><?=$supplier['all_products_cnt'];?> шт.</td>
					</tr>
					<tr class="animate">
						<td>В наличии:</td>
						<td><?=$supplier['active_products_cnt'];?> шт.</td>
					</tr>
					<tr class="animate">
						<td>На модерации:</td>
						<td><?=$supplier['moderation_products_cnt'];?> шт.</td>
					</tr>
				</table> -->
				<div class="sb_container supplier_info animate">
					<div class="infoTitle tac textBold">Информация</div>
					<div class="line clearfix supplier_name">
						<!-- <div class="parameter fleft">Поставщик:</div> -->
						<div class="value tac textBold"><?=$supplier['name'];?>Name</div>
					</div>
					<div class="line clearfix animate">
						<div class="fleft">Артикул:</div>
						<div class="value fright textBold"><?=$supplier['article'];?></div>
					</div>
					<div class="line clearfix animate <?=strtotime($supplier['next_update_date'])-time() <= 60*60*24*7*8?'color-red':null;?>">
						<div class="fleft">Рабочие дни до:</div>
						<div class="value fright textBold"><?=date("d.m.Y", strtotime($supplier['next_update_date']));?></div>
					</div>
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
						<form action="" method="post" onsubmit="RecalcSupplierCurrency();return false;">
							<label for="currency_rate">Личный курс доллара</label><br>
							<div class="flexWrap">
								<input type="text" name="currency_rate" id="currency_rate" value="<?=$supplier['currency_rate']?>">
								<button class="btn-m-lblue" onclick="RecalcSupplierCurrency();">Пересчитать</button>
							</div>
							<input type="hidden" id="currency_rate_old" value="<?=$supplier['currency_rate']?>">
						</form>
						<p class="checksum">Контрольная сумма - <b><?=$check_sum['checksum']?> грн</b></p>
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
						<button type="button" id="kalendar" name="update_calendar1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Отправить</button>
						<button type="button" class="btn-m-lblue fr btn_js" data-name="kalendar_content">Календарь</button> 
					</div>-->
				</div>
				<!-- <form class="work_days_add" action="<?=$GLOBALS['URL_request']?>" method="post">
					<label for="start_date" class="fleft">С даты:
						<input type="date" name="start_date" id="start_date" value="<?=date("Y-m-d", time());?>"/>
					</label>
					<label for="num_days" class="fleft">Количество дней (от 10 до 90):
						<input type="number" name="num_days" id="num_days" min="10" max="90" value="90" pattern="[0-9]{2}"/>
					</label>
					<button type="submit" name="update_calendar1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Отправить</button>
				</form> -->
			</div>
			<div class="excelBlock">
				<div class="row">
					<div class="add_functions col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="add_items1">
							<p>Цены в гривнах, &#8372;</p>
							
							<form action="<?=$GLOBALS['URL_request']?>export" method="post">
								<button type="submit" class="export_excel btn-m-blue">Экспортировать в Excel</button>
							</form>
							
							<form action="<?=$GLOBALS['URL_request']?>" method="post" enctype="multipart/form-data">
								<button type="submit" name="smb_import" class="import_excel btn-m-blue">Импортировать</button><br>
								<input type="file" name="import_file" required="required" class="file_select">
							</form>
						</div>
					</div>
					<div class="add_functions col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="add_items1">
							<p>Цены в долларах, $</p>
							
							<form action="<?=$GLOBALS['URL_request']?>export_usd" method="post">
								<button type="submit" class="export_excel btn-m-green">Экспортировать в Excel</button>
							</form>
							
							<form action="<?=$GLOBALS['URL_request']?>" method="post" enctype="multipart/form-data">
								<button type="submit" name="smb_import_usd" class="import_excel btn-m-green">Импортировать</button><br>
								<input type="file" name="import_file" required="required" class="file_select">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<!--=============================================================================================================-->




	<div class="product_list row">
		<div class="col-md-12">
			<h2>Ассортимент</h2>
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
						<td>Цена розн.</td>
						<td>Цена опт</td>
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
									<img <?=$wh?> class="lazy" data-original="<?=_base_url?><?=str_replace('original', 'small', $item['images'][0]['src'])?>" alt="<?=$item['name']?>">
									<noscript>
										<img <?=$wh?> src="<?=_base_url?><?=str_replace('original', 'small', $item['images'][0]['src'])?>" alt="<?=$item['name']?>">
									</noscript>
								<?}else{?>
									<img <?=$wh?> class="lazy" data-original="<?=_base_url?><?=str_replace("image/", "image/250/", $item['img_1'])?>"/>
									<noscript>
										<img <?=$wh?> src="<?=_base_url?><?=str_replace("image/", "image/250/", $item['img_1'])?>"/>
									</noscript>
								<?}?>
							</td>
							<td>
								<p><?=$item['name'];?></p>
								<p>Арт. <?=$item['art'];?></p>
							</td>
							<td class="center"><input type="checkbox" class="active" <?=$item['active']>0?'checked':null;?>></td>
							<td class="center"><?=$item['min_mopt_qty'];?><?=$item['units'];?></td>
							<td class="center">
								<input type="number" step="0.01" min="0" class="input-m price" data-mode="mopt" value="<?=$item['inusd'] == 1?$item['price_mopt_otpusk_usd']:$item['price_mopt_otpusk'];?>">
							</td>
							<td class="center">
								<input type="number" step="0.01" min="0" class="input-m price" data-mode="opt" value="<?=$item['inusd'] == 1?$item['price_opt_otpusk_usd']:$item['price_opt_otpusk'];?>">
							</td>
							<td class="center"><input type="checkbox" <?=$item['inusd'] == 1?'checked':null;?> class="currency"></td>
							<td class="center"></td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	var id_supplier = <?=$id_supplier;?>;
	<?=$supplier['single_price']==0?'TogglePriceColumns("Off");':'TogglePriceColumns("On");';?>
	$(function(){
		// Клик по переключателю "Единая цена"
		$('.switch').click(function(){
			var single_price;
			if($(this).closest('#switcher').hasClass('Off')){
				if(window.confirm('Для каждого товара, вместо двух цен, будет установлена единая цена.\nПроверьте, пожалуйста, цены после выполнения.')){
					$(this).closest('#switcher').toggleClass('On').toggleClass('Off');
					if($(this).closest('#switcher').hasClass('On')){
						// document.cookie = "onlyprice=On;";
						TogglePriceColumns('On');
						single_price = 1;
					}else{
						// document.cookie = "onlyprice=Off;";
						TogglePriceColumns('Off');
						single_price = 0;
					}

				}
			}else{
				$(this).closest('#switcher').toggleClass('On').toggleClass('Off');
				if($(this).closest('#switcher').hasClass('On')){
					// document.cookie = "onlyprice=On;";
					TogglePriceColumns('On');
					single_price = 1;
				}else{
					// document.cookie = "onlyprice=Off;";
					TogglePriceColumns('Off');
					single_price = 0;
				}
			}
			$.ajax({
				url: '/ajaxsuppliers',
				type: "POST",
				dataType : "json",
				data:({
					"action": 'toggle_single_price',
					"id_supplier": '<?=$supplier['id_user'];?>',
					"single_price": single_price
				}),
			});
		});
		// Переключение активности записи ассортимента
		$('.active').on('change', function(){
			var parent = $(this).closest('tr'),
				active = 0;
			if(this.checked){
				active = 1;
			}
			var data = {
				id_product: parent.data('id'),
				id_supplier: id_supplier,
				active: active
			}
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
			}
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
		// Ручное изменение цены
		$('.price').on('keyup, change', function(){
			var parent = $(this).closest('tr'),
				data = {
					id_product: parent.data('id'),
					id_supplier: id_supplier,
					mode: $(this).data('mode'),
					price: $(this).val(),
					comment: 'comment example'
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
				ajax('product', 'DelFromAssort', {id: id, id_supplier: id_supplier}).done(function(){
					parent.fadeOut().remove();
				});
			}
		});
	});
	// Функция переключения "Единой цены"
	function TogglePriceColumns(action){
		if(action == 'On'){
			$('.price_1').css({
				"width": "20%"
			});
			$('th.price_1 p').text('Цена отпускная');
			$('.price_2').css({
				"display": "none"
			});
			$('.switcher_container').css({
				"width": "100%"
			});
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
			$('.price_1').css({
				"width": "10%"
			});
			$('th.price_1 p').text('Цена отпускная мин. к-ва');
			$('.price_2').css({
				"display": "table-cell"
			});
			$('.switcher_container').css({
				"width": "200%"
			});
			$.each($('td.price_1 input'), function(){
				var id = $(this).attr('id').replace(/\D+/g,"");
			});
		}
	}

	// Фиксация Заголовка таблицы
	// $(window).scroll(function(){
	// 		console.log($('.supplier_assort_table').offset().top - $('header').outerHeight());
	// 	if($(this).scrollTop() >= 86){
	// 		if(!$('.supplier_assort_table.thead').hasClass('fixed_thead')){
	// 			var width = $('.table_tbody').width();
	// 			$('.supplier_assort_table.thead').css("width", width).addClass('fixed_thead');
	// 			$('.table_tbody').css("margin-top", "65px");
	// 		}
	// 	}else{
	// 		if($('.supplier_assort_table.thead').hasClass('fixed_thead')){
	// 			$('.supplier_assort_table.thead').removeClass('fixed_thead');
	// 			$('.table_tbody').css("margin-top", "0");
	// 		}
	// 	}
	// });
</script>