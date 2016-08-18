<?if(isset($_SESSION['errm'])){
	foreach($_SESSION['errm'] as $msg){
if(!is_array($msg)){?>
<div class="msg-error">
<p><?=$msg?></p>
</div>
<?}?>
<script type="text/javascript">
	$('html, body').animate({
	scrollTop: 0
	}, 500, "easeInOutCubic");
</script>
<?}
}?>
<div id="supplier_cab" class="cabinet_content row">
	<h1><?=$cabinet_page == 'settings'?'Настройки':'Ассортимент'?></h1>
	<?if($cabinet_page == 'settings'){?>
		<div id="kalendar_content" data-type="modal">
			<div class="modal-container">
				<table border="0" cellpadding="0" width="100%">
					<colgroup>
						<col width="50%">
						<col width="50%">
					</colgroup>
					<tr>
						<th>Дата</th>
						<th>Рабочий день</th>
					</tr>
				</table>
				<div class="table_wrapp">
					<table border="0" cellpadding="0" width="100%">
						<colgroup>
							<col width="50%">
							<col width="50%">
						</colgroup>
						<?foreach($cal as $c){?>
							<tr>
								<td>
									<p><?=$c['date_dot']?>, <span<?if(isset($c['red'])){?> class="color-red"<?}?>><?=$c['d_word']?></span></p>
								</td>
								<td>
									<p>
										<input id="day<?=$c['date_']?>" type="checkbox" <?if($c['active'] == 0){?>disabled="disabled"<?}?> <?if($c['day']){?>checked="checked"<?}?> onchange="SwitchSupplierDate('<?=$c['date_dot']?>')">
									</p>
								</td>
							</tr>
						<?}?>
					</table>
				</div>
			</div>
		</div>
		<div class="sett_cabinet col-md-12">
			<div id="popup_msg" class="history">
				<div class="msg-warning">
					<p>Пожалуйста подождите, осуществляется пересчет цен ассортимента.</p>
				</div>
			</div>
			<div class="cabinet_block fleft">
				<div class="dollar">
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" onsubmit="RecalcSupplierCurrency();return false;">
						<label for="currency_rate">Личный курс доллара</label>
						<input type="text" name="currency_rate" id="currency_rate" value="<?=$supplier['currency_rate']?>">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="RecalcSupplierCurrency();">Пересчитать</button>
						<input type="hidden" id="currency_rate_old" value="<?=$supplier['currency_rate']?>">
					</form>
					<p class="checksum">Контрольная сумма - <b><?=$check_sum['checksum']?> грн</b></p>
				</div>
				<div class="calendar clearfix">
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
					<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored btn_js" data-name="kalendar_content">Календарь</button>
				</div>
				<form class="work_days_add" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
					<label for="start_date" class="fleft">С даты:
						<input type="date" name="start_date" id="start_date" value="<?=date("Y-m-d", time());?>"/>
					</label>
					<label for="num_days" class="fleft">Количество дней (от 10 до 90):
						<input type="number" name="num_days" id="num_days" min="10" max="90" value="90" pattern="[0-9]{2}"/>
					</label>
					<button type="submit" name="update_calendar1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Отправить</button>
				</form>
			</div>
			<div class="form_block fright hidden">
				<form action="<?=Link::Custom('cabinet', 'price');?>" method="post">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Форма сверки цен</button>
				</form>
				<form action="<?=Link::Custom('cabinet', 'price1');?>" method="post">
					<button name="price" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Новая с ценами</button>
					<button name="no-price" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Новая без цен</button>
					<button name="wide" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сверх-новая с ценами</button>
					<button name="multiple" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Многоразовая без цен</button>
				</form>
			</div>
		</div>
	<?}
	if($cabinet_page == 'assortment'){?>
		<?if(isset($cnt) && $cnt >= 30){?>
			<div class="sort_page_top col-md-12">
				<a href="<?=Link::Custom('cabinet', 'assortment');?>limitall/"<?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
			</div>
		<?}?>
		<div class="switch_price_container">
			<span>Единая цена</span>
			<label class="mdl-switch mdl-js-switch" for="switch_price">
				<input type="checkbox" id="switch_price" class="mdl-switch__input price_switcher_js" <?=(isset($supplier['single_price']) && $supplier['single_price'] == 1)?'checked':null?> >
				<span class="mdl-switch__label"></span>
			</label>
		</div>
		<div class="col-md-12 assortiment_table_block">
			<input type="hidden" name="currency_rate" id="currency_rate" value="<?=$supplier['currency_rate'];?>">
			<!-- НОВЫЙ СПИСОК БЛОКАМИ -->
			<div class="assortiment_table">
				<?if(count($list)){
					foreach($list as $i){?>
						<div class="products_list_item <?=isset($_SESSION['Assort']['products'][$i['id_product']]['active']) && $_SESSION['Assort']['products'][$i['id_product']]['active']?'available':'notavailable'?>" data-id-product="<?=$i['id_product']?>">
							<div class="removeFromAssort">
								<a href="#" onclick="AddDelProductAssortiment($(this), <?=$i['id_product']?>);return false;" class="icon-font removeFromAssort_js" id="remove<?=$i['id_product']?>" title="Удалить"><i class="material-icons">close</i></a>
								<div class="mdl-tooltip" for="remove<?=$i['id_product']?>">Удалить</div>
							</div>
							<div class="photo_cell">
								<div class="btn_js" data-name="big_photo">
									<?if($i['image'] != ''){?>
										<img class="toBigPhoto" id="big_photo_<?=$i['id_product']?>" alt="" height="90" src="<?=_base_url?><?=G::GetImageUrl($i['image'], 'thumb')?>" data-original-photo="<?=_base_url?><?=G::GetImageUrl($i['image'])?>">
									<?}else{?>
										<img class="toBigPhoto" id="big_photo_<?=$i['id_product']?>" alt="" height="90" src="<?=_base_url?><?=G::GetImageUrl($i['img_1'], 'thumb')?>" data-original-photo="<?=_base_url?><?=G::GetImageUrl($i['img_1'])?>">
									<?}?>
									<div class="mdl-tooltip" for="big_photo_<?=$i['id_product']?>">Нажмите<br>для увеличения</div>
								</div>							
							</div>
							<div class="name_cell" data-idproduct="<?=$i['id_product']?>">
								<a href="<?=Link::Product($i['translit']);?>">
									<?=G::CropString($i['name'])?>
								</a>
								<!-- <a href="#" class="err_mark btn_js" data-name="err_mark"><i class="material-icons" id="edit<?=$i['id_product']?>">edit</i></a> -->
								<p class="sub">арт. <?=$i['art']?>
									<?if(is_array($price_products) && in_array($i['id_product'], $price_products)){?>
										<span class="pricelist_item">Товар в прайс-листе</span>
									<?}?>
								</p>
								<?if((isset($i['min_opt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']) || (isset($i['min_mopt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price'])){?>
									<p style="color:#f00;">Ваш товар заблокирован для продажи.<br>Рекомендованная цена:
									<?if($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price']){
										echo "от миним. к-ва <".($i['min_mopt_price']-0.01)." грн.";
									}
									if(($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']) && ($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price'])){
										echo ", ";
									}
									if($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']){
										echo "от ящика <".($i['min_opt_price']-0.01)." грн.";
									}?>
									</p>
								<?}?>
							</div>
							<div class="product_balance">
								<span class="prod_detail_info">Остаток товара:</span>
								<label id="balance_info-<?=$i['id_product']?>" class="mdl-checkbox mdl-js-checkbox">
									<input type="checkbox" name="product_limit_checkbox" class="mdl-checkbox__input" data-id-product="<?=$i['id_product']?>" data-koef="<?=$supplier['koef_nazen_mopt']?>" data-supp="<?=$i['sup_comment']?>" <?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit']) && $_SESSION['Assort']['products'][$i['id_product']]['product_limit'] > 0?'checked':null;?>>
								</label>
								<div class="mdl-tooltip" for="balance_info-<?=$i['id_product']?>">Остаток товара</div>
								<!-- <a href="#" onclick="$('#product_limit_mopt_<?=$i['id_product']?>').val(parseInt($('#product_limit_mopt_<?=$i['id_product']?>').val())+1000000000); toAssort(<?=$i['id_product']?>, 0, <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>'); return false;">Вкл</a><br> -->
								<input type="hidden" id="product_limit_mopt_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit'])?$_SESSION['Assort']['products'][$i['id_product']]['product_limit']:"0"?>" class="input_table">
								<!-- <a href="#" onclick="$('#product_limit_mopt_<?=$i['id_product']?>').val(0); toAssort(<?=$i['id_product']?>, 0, <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>'); return false;">Выкл</a> -->
							</div>
							<div class="min_prod_qty">
								<span class="prod_detail_info">Минимальное количество:</span>
								<p id="min_mopt_qty_<?=$i['id_product']?>"><?=$i['min_mopt_qty']?> <?=$i['units']?><?=$i['qty_control']?" *":null?></p>
								<div class="mdl-tooltip" for="min_mopt_qty_<?=$i['id_product']?>">Минимальное количество</div>
							</div>
							<div class="price_1">
								<span class="prod_detail_info">Цена отпускная мин. к-ва:</span>
								<?if($i['inusd'] == 1){?>
									<input type="text" id="price_mopt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk_usd'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk_usd'], 3):"0"?>" class="usd_price price_mopt_otpusk_js input_table" onchange="toAssort(<?=$i['id_product']?>, 0,  <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>')">
								<?}else{?>
									<input type="text" id="price_mopt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'], 2):"0"?>" class="uah_price price_mopt_otpusk_js input_table" onchange="toAssort(<?=$i['id_product']?>, 0,  <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>')">
								<?}?>
								<div class="mdl-tooltip" for="price_mopt_otpusk_<?=$i['id_product']?>">Цена отпускная мин. к-ва</div>
							</div>
							<div class="price_2">
								<span class="prod_detail_info">Цена отпускная ящиком:</span>
								<?if($i['inusd'] == 1){?>
									<input type="text" id="price_opt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk_usd'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk_usd'], 3):"0"?>" class="usd_price price_opt_otpusk_js input_table" onchange="toAssort(<?=$i['id_product']?>, 1, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>')">
								<?}else{?>
									<input type="text" id="price_opt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'], 2):"0"?>" class="uah_price price_opt_otpusk_js input_table" onchange="toAssort(<?=$i['id_product']?>, 1, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>')">
								<?}?>
								<div class="mdl-tooltip" for="price_opt_otpusk_<?=$i['id_product']?>">Цена отпускная ящиком</div>
							</div>
							<div class="to_dollar">
								<span class="prod_detail_info">Перевести в $:</span>
								<!-- <form> -->
									<label id="dollar_info_<?=$i['id_product']?>" class="mdl-checkbox mdl-js-checkbox" for="inusd-<?=$i['id_product']?>">
										<input type="checkbox" name="product_limit" id="inusd-<?=$i['id_product']?>" class="mdl-checkbox__input currency inusd<?=$i['id_product']?>" <?=$i['inusd'] == 1?'checked':null;?> value="1">
									</label>
									<!-- <input type="checkbox" <?=$i['inusd'] == 1?'checked="checked"':'';?> class="inusd<?=$i['id_product']?>" style="float: none !important; margin: 0 auto;"  onclick="SetInUSD(<?=$i['id_product']?>, <?=$supplier['koef_nazen_mopt']?>, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>'); return false;" value="1"> -->
								<!-- </form> -->
								<div class="mdl-tooltip" for="dollar_info_<?=$i['id_product']?>">Перевести в $</div>
							</div>
						</div>
					<?}
				}?>
			</div>

			<!-- СТАРЫЙ СПИСОК ТАБЛИЦЕЙ -->
			<!-- <table width="100%" cellspacing="0" border="1" class="supplier_assort_table thead table">
				<colgroup>
					<col width="57%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="3%">
				</colgroup>
				<thead>
					<tr>
						<th>Название</th>
						<th>Остаток товара</th>
						<th>Минимальное<br>количество</th>
						<th class="price_1">
							<p>Цена отпускная мин. к-ва</p>
							<div class="switcher_container">
								<div id="switcher" class="only_price <?=(isset($supplier['single_price']) && $supplier['single_price'] == 1)?'On':'Off'?> fright">
									<div class="switch animate"></div>
								</div>
								<span>Единая цена</span>
								<label class="mdl-switch mdl-js-switch" for="switch_price">
									<input type="checkbox" id="switch_price" class="mdl-switch__input price_switcher_js" <?=(isset($supplier['single_price']) && $supplier['single_price'] == 1)?'checked':null?> >
									<span class="mdl-switch__label"></span>
								</label>
							</div>
						</th>
						<th class="price_2">Цена отпускная ящиком</th>
						<th>$</th>
					</tr>
				</thead>
			</table>
			<table width="100%" cellspacing="0" border="1" class="table table_tbody">
				<colgroup>
					<col width="3%">
					<col width="10%">
					<col width="44%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="3%">
				</colgroup>
				<tbody>
					<?if(count($list)){
						foreach($list as $i){?>
							<tr id="tr_mopt_<?=$i['id_product']?>" class="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['active']) && $_SESSION['Assort']['products'][$i['id_product']]['active']?'available':'notavailable'?>">
								<td class="removeFromAssort">
									<a href="#" onclick="DelFromAssort(<?=$i['id_product']?>);return false;" class="icon-font" id="remove<?=$i['id_product']?>" title="Удалить"><i class="material-icons">close</i></a>
									<div class="mdl-tooltip" for="remove<?=$i['id_product']?>">Удалить</div>
								</td>
								<td class="photo_cell">
									<div class="btn_js" data-name="big_photo">
										<?if($i['image'] != ''){?>
											<img class="toBigPhoto" id="big_photo_<?=$i['id_product']?>" alt="" height="90" src="<?=_base_url?><?=G::GetImageUrl($i['image'], 'thumb')?>" data-original-photo="<?=_base_url?><?=G::GetImageUrl($i['image'])?>">
										<?}else{?>
											<img class="toBigPhoto" id="big_photo_<?=$i['id_product']?>" alt="" height="90" src="<?=_base_url?><?=G::GetImageUrl($i['img_1'], 'thumb')?>" data-original-photo="<?=_base_url?><?=G::GetImageUrl($i['img_1'])?>">
										<?}?>
										<div class="mdl-tooltip" for="big_photo_<?=$i['id_product']?>">Нажмите<br>для увеличения</div>
									</div>									
								</td>
								<td class="name_cell" data-idproduct="<?=$i['id_product']?>">
									<a href="<?=Link::Product($i['translit']);?>">
										<?=G::CropString($i['name'])?>
									</a>
									<a href="#" class="err_mark btn_js" data-name="err_mark"><i class="material-icons" id="edit<?=$i['id_product']?>">edit</i></a>
									<p class="sub">арт. <?=$i['art']?>
										<?if(is_array($price_products) && in_array($i['id_product'], $price_products)){?>
											<span class="pricelist_item">Товар в прайс-листе</span>
										<?}?>
									</p>
									<?if((isset($i['min_opt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']) || (isset($i['min_mopt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price'])){?>
										<p style="color:#f00;">Ваш товар заблокирован для продажи.<br>Рекомендованная цена:
										<?if($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price']){
											echo "от миним. к-ва <".($i['min_mopt_price']-0.01)." грн.";
										}
										if(($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']) && ($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price'])){
											echo ", ";
										}
										if($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']){
											echo "от ящика <".($i['min_opt_price']-0.01)." грн.";
										}?>
										</p>
									<?}?>
								</td>
								<td>
									<label class="mdl-checkbox mdl-js-checkbox" for="checkbox-<?=$i['id_product']?>">
										<input type="checkbox" name="product_limit_checkbox" id="checkbox-<?=$i['id_product']?>" class="mdl-checkbox__input" data-id-product="<?=$i['id_product']?>" data-koef="<?=$supplier['koef_nazen_mopt']?>" data-supp="<?=$i['sup_comment']?>" <?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit']) && $_SESSION['Assort']['products'][$i['id_product']]['product_limit'] > 0?'checked':null;?>>
									</label>
									<a href="#" onclick="$('#product_limit_mopt_<?=$i['id_product']?>').val(parseInt($('#product_limit_mopt_<?=$i['id_product']?>').val())+1000000000); toAssort(<?=$i['id_product']?>, 0, <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>'); return false;">Вкл</a><br>
									<input type="hidden" id="product_limit_mopt_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit'])?$_SESSION['Assort']['products'][$i['id_product']]['product_limit']:"0"?>" class="input_table">
									<a href="#" onclick="$('#product_limit_mopt_<?=$i['id_product']?>').val(0); toAssort(<?=$i['id_product']?>, 0, <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>'); return false;">Выкл</a>
								</td>
								<td>
									<p id="min_mopt_qty_<?=$i['id_product']?>"><?=$i['min_mopt_qty']?> <?=$i['units']?><?=$i['qty_control']?" *":null?></p>
								</td>
								<td class="price_1">
									<?if($i['inusd'] == 1){?>
										<input type="text" id="price_mopt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk_usd'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk_usd'], 3):"0"?>" class="usd_price input_table" onchange="toAssort(<?=$i['id_product']?>, 0,  <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>')">
									<?}else{?>
										<input type="text" id="price_mopt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'], 2):"0"?>" class="uah_price input_table" onchange="toAssort(<?=$i['id_product']?>, 0,  <?=$supplier['koef_nazen_mopt']?>, '<?=$i['sup_comment']?>')">
									<?}?>
								</td>
								<td class="price_2">
									<?if($i['inusd'] == 1){?>
										<input type="text" id="price_opt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk_usd'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk_usd'], 3):"0"?>" class="usd_price input_table" onchange="toAssort(<?=$i['id_product']?>, 1, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>')">
									<?}else{?>
										<input type="text" id="price_opt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'], 2):"0"?>" class="uah_price input_table" onchange="toAssort(<?=$i['id_product']?>, 1, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>')">
									<?}?>
								</td>
								<td>
									<form>
										<label class="mdl-checkbox mdl-js-checkbox" for="inusd-<?=$i['id_product']?>">
											<input type="checkbox" name="product_limit" id="inusd-<?=$i['id_product']?>" class="mdl-checkbox__input inusd<?=$i['id_product']?>" <?=$i['inusd'] == 1?'checked':null;?> value="1">
										</label>
										<input type="checkbox" <?=$i['inusd'] == 1?'checked="checked"':'';?> class="inusd<?=$i['id_product']?>" style="float: none !important; margin: 0 auto;"  onclick="SetInUSD(<?=$i['id_product']?>, <?=$supplier['koef_nazen_mopt']?>, <?=$supplier['koef_nazen_opt']?>, '<?=$i['sup_comment']?>'); return false;" value="1">
									</form>
								</td>
							</tr>
						<?}
					}?>
				</tbody>
			</table> -->

			<!-- <style>
				@import url("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
			</style>
			<div class="dialog_duplicate hidden" title="Отметка дубля">
				<input type="hidden" name="id">
				<p>Отметить товар <span></span> как дубль.</p>
				<br>
				<input type="text" name="duplicate_comment" placeholder="Артикул основного товара">
				<button class="btn-m-green" onclick="">Отправить</button>
			</div> -->

			<div id="err_mark" data-type="modal">
				<div class="modal_container">
					<h4>Отметка об ошибке</h4>
					<hr>
					<p>Увидели ошибку или дубль товара,<br>напишите, пожалуйста.</p>
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<input type="hidden" name="id_product">
						<textarea name="feedback_text" id="feedback_text" cols="30" rows="8" required></textarea>
						<button type="submit" name="sub_com" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Отправить</button>
					</form>
				</div>
			</div>
			<?if(isset($cnt) && $cnt >= 30){?>
				<div class="sort_page">
					<a href="<?=Link::Custom('cabinet', 'assortment');?>?limit=all"<?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
				</div>
			<?}?>
			<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
			<div class="add_functions fleft">
				<div class="add_items1">
					<p>Цены в гривнах, &#8372;</p>
					<hr>
					<form action="<?=$GLOBALS['URL_request']?>export" method="post">
						<button type="submit" class="export_excel btn-m-blue">Экспортировать в Excel</button>
					</form>
					<hr>
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<button type="submit" name="smb_import" class="import_excel btn-m-blue">Импортировать</button>
						<input type="file" name="import_file" required="required" class="file_select">
					</form>
				</div>
			</div>
			<div class="add_functions fright">
				<div class="add_items1">
					<p>Цены в долларах, $</p>
					<hr>
					<form action="<?=$GLOBALS['URL_request']?>export_usd" method="post">
						<button type="submit" class="export_excel btn-m-green">Экспортировать в Excel</button>
					</form>
					<hr>
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<button type="submit" name="smb_import_usd" class="import_excel btn-m-green">Импортировать</button>
						<input type="file" name="import_file" required="required" class="file_select">
					</form>
				</div>
			</div>
			<?if(isset($total_updated)){?><br>Обновлено: <?=$total_updated?><?}?>
			<?if(isset($total_added)){?><br>Добавленио: <?=$total_added?><?}?>
		</div>
	<?}?>
</div>
<script>
	<?if($supplier['single_price'] == 0){?>
		TogglePriceColumns("Off");
	<?}else{?>
		TogglePriceColumns("On");
	<?}?>
	$(function(){
		$('[class^="duplicate_check_"]').on('click', function(e){
			e.preventDefault();
			$('.dialog_duplicate').dialog('open');
			var id = $(this).prop('class').replace(/[^0-9\.]+/g, '');
			var art = $(this).next().val();
			$('.dialog_duplicate input[name="id"]').val(id);
			$('.dialog_duplicate p span').text(art);
			var onclick='ToggleDuplicate('+id+',<?=$_SESSION["member"]["id_user"]?>, $(\'.dialog_duplicate input[name="duplicate_comment"]\').val());$(\'.dialog_duplicate\').dialog(\'close\');$(\'.duplicate_check_'+id+'\').prop(\'checked\', true);$(\'.duplicate_check_'+id+'\').prop(\'disabled\', true);';
			$('.dialog_duplicate button').attr('onclick', onclick);
		});
		/*$('.switch').click(function(){
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
		});*/
		
		$('.removeFromAssort_js').on('click', function(){
			$(this).closest('.products_list_item').remove();
		});

		/* Новый переключатель обьедения цены */
		$('.price_switcher_js').on('change', function(){			
			var single_price;

			if ($(".price_switcher_js").prop("checked")){
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

			$.ajax({
				url: '/ajaxsuppliers',
				type: "POST",
				dataType : "json",
				data:({
					action: 'toggle_single_price',
					id_supplier: '<?=$supplier['id_user'];?>',
					single_price: single_price
				}),
			});
		});

		// Переключение валюты
		$('.currency').on('change', function(){
			var id_product = $(this).closest('.products_list_item').find('.name_cell').data('idproduct');
			var	inusd;
			var this_item = $(this).closest('.products_list_item');

			if($(this).prop("checked")){
				inusd = 1;
			}else{
				inusd = 0;
			}
			var data = {
				id_product: id_product,
				id_supplier: '<?=$supplier['id_user'];?>',
				inusd: inusd
			};
			ajax('product', 'UpdateAssort', data, 'json').done(function(data){
				if(data.inusd == 1){
					this_item.find('.price_mopt_otpusk_js').val(data['price_mopt_otpusk_usd']);
					this_item.find('.price_opt_otpusk_js').val(data['price_opt_otpusk_usd']);
				}else{
					this_item.find('.price_mopt_otpusk_js').val(data['price_mopt_otpusk']);
					this_item.find('.price_opt_otpusk_js').val(data['price_opt_otpusk']);
				}				
			});
		});

		$('td.price_1 input').keyup(function(){
			var id = $(this).attr('id').replace(/\D+/g,"");
			if($('#switcher').hasClass('On')){
				$('#price_opt_otpusk_'+id).val($(this).val());
				$(this).blur(function(){
					$('#price_opt_otpusk_'+id).change();
				});
			}
		});
		$('.err_mark').on('click', function() {
			var id = $(this).closest('.name_cell').attr('data-idproduct');
			$('#err_mark [name="id_product"]').val(id);
		});
	});
	function TogglePriceColumns(action){
		if(action == 'On'){			
			$('.price_1 .prod_detail_info, .price_1 .mdl-tooltip').text('Цена отпускная');
			$('.price_2').css({
				"display": "none"
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
			$('.price_1 .prod_detail_info, .price_1 .mdl-tooltip').text('Цена отпускная мин. к-ва');
			$('.price_2').css({
				"display": "block"
			});			
			$.each($('td.price_1 input'), function(){
				var id = $(this).attr('id').replace(/\D+/g,"");
			});
		}
	}	
</script>