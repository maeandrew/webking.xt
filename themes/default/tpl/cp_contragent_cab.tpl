<div class="contragent_cab">
	<?if(isset($errm) && isset($msg)){?><div class="msg-error"><p><?=$msg?></p></div><?}?>
	<?if($contragent['remote'] == 1){?>
		<p class="contragent_balance">Баланс: <b><?=$current_customer['balance']?number_format($current_customer['balance'], 2, ",", "").'грн.':'Н/Д';?></b></p>
	<?}?> 
	<button class="open_modal mdl-button mdl-js-button mdl-button--raised mdl-button--colored btn-m-blue btn_js" data-target="work_days_js" data-name="work_days_js"><i class="material-icons">access_time</i>Рабочие дни</button>
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="margin-form hidden">
		<input type="text" name="discount" id="discount" value="<?=isset($current_customer['discount'])?htmlspecialchars(1-$current_customer['discount']/100):null?>" disabled="disabled">
		<input type="hidden" name="min_koef_manager" id="min_koef_manager" value="<?=$GLOBALS['CONFIG']['min_koef_manager']?>">
		<input type="hidden" name="max_koef_manager" id="max_koef_manager" value="<?=$GLOBALS['CONFIG']['max_koef_manager']?>">
		<input type="hidden" name="id_user" id="id_user" value="<?=$current['id_user']?>">
		<input type="hidden" name="email" id="email" value="<?=$current['email']?>">
		<input type="hidden" name="discount" id="discount" value="<?=isset($current_customer['discount'])?htmlspecialchars(1-$current_customer['discount']/100):null?>"/>
		<button type="submit" name="change_margin" id="change-margin" class="btn-m-green">Сохранить</button>
	</form>
	<div class="history">
		<table border="0" cellpadding="0" cellspacing="0" class="returns_table table" width="100%">
			<thead>
				<tr>
					<th rowspan="2" class="date">
						<a href="<?=$sort_links['creation_date']?>">Дата</a>
					</th>
					<th rowspan="2" class="date">
						<a href="<?=$sort_links['target_date']?>">Дата отгрузки</a>
					</th>
					<th rowspan="2" class="order">
						<a href="<?=$sort_links['id_order']?>" class="up_down">Заказ №</a>
					</th>
					<th rowspan="2" class="status">
						<a href="<?=$sort_links['status']?>" class="up_down">Статус</a>
					</th>
					<th rowspan="2" class="sum">Сумма</th>
					<th rowspan="2" class="client">
						Клиент
						<?if(isset($filtered_client)){?>
						<form action="<?=_base_url."/cabinet/"?>" method="post" id="client-filter">
							<button name="clear_client_filtr" class="btn-s-green">Сбросить фильтр</button>
						</form>
						<?}?>
					</th>
					<th colspan="2" class="note">Примечание</th>
					<th rowspan="2" class="bill">Счет/Накладная</th>
				</tr>
				<tr>
					<th width="175px">Менеджер</th>
					<th width="175px">Склад</th>
				</tr>
			</thead>
			<?if(isset($orders) && !empty($orders)){
				foreach($orders as $i){?>
					<tr class="ord-<?=$i['id_order']?>" <? if($i['id_customer'] == $current['id_user']){?>style="background: #F1FFF1;"<?}?>>
						<td class="date">
							<?=date("d.m.Y",$i['creation_date'])?>
						</td>
						<td class="date">
							<?if($i['target_date'] != 0 ){
								echo date("d.m.Y",$i['target_date']);
							}else{
								echo "-";
							}?>
						</td>
						<td class="order">
							<a href="<?=_base_url?>/customer_order/<?=$i['id_order']?>"/><?=$i['id_order']?></a>
						</td>
						<td class="status">
							<?=$order_statuses[$i['id_order_status']]['name']?>
							<input type="hidden" class="target-date-<?=$i['id_order']?>" value="<?if($i['target_date'] != 0 ){ echo date("d.m.Y",$i['target_date']); }?>" />
							<input type="hidden" class="client-<?=$i['id_order']?>" value="<?=$i['cont_person']?>" />
							<?if(!in_array($i['id_order_status'], array("2", "6", "8")) && $contragent['remote'] == 1){?>
								<a href="#" class="change-status btn_js" title="Нажмите, чтобы изменить статус и дату отгрузки заказа" data-target="select_status_js" data-name="select_status_js" data-idorder="<?=$i['id_order']?>"><i class="material-icons">mode_edit</i></a>
							<?}?>
						</td>
						<td class="sum">
							<p>
								<?=number_format($i['sum_discount'], 2, ",", "")?><br>
								<?if($i['id_customer'] == $current['id_user']){
									if($i['discount'] > 0){?>
										с наценкой <?=$i['discount'];?>
									<?}
								}?>
							</p>
						</td>
						<td class="client">
							<?if($i['id_customer'] == $current['id_user']){?>
								<p class="name-klient">
									<a href="<?=_base_url."/cabinet/".$i['id_klient']?>" title="Нажмите, чтобы отобразить заказы только этого клиента"><?=$i['name_klient']?> </a>
								</p>
								<p class="cont-person-klient">
									<?=$i['cont_person_klient']?>
									<?if(!in_array($i['id_order_status'], array("2", "6", "8"))){?>
										<a href="#" class="change-client btn_js" title="Нажмите, чтобы изменить клиента для заказа" data-target="select_client_js" data-name="select_client_js" data-idorder="<?=$i['id_order']?>"><i class="material-icons">mode_edit</i></a>
									<?}?>
								</p>
								<input type="hidden" class="current-client" value="<?=$i['id_klient']?>"/>
							<?}else{?>
								<p class="name-customer"><a href="<?=_base_url."/cabinet/".$i['id_customer']?>"><?=$i['name_customer'];?> </a></p>
								<p class="cont-person"><?=$i['cont_person'];?></p>
								<input type="hidden" class="current-client" value="<?=$i['id_customer']?>"/>
							<?}?>
						</td>
						<td colspan="2" class="notes">
							<textarea onChange="setOrderNote(<?=$i['id_order']?>)" class="note1" id="order_note_<?=$i['id_order']?>"><?=isset($i['note'])?$i['note']:null?></textarea>
							<textarea onChange="setOrderNote_zamena(<?=$i['id_order']?>)" class="note2" id="order_note2_<?=$i['id_order']?>"><?=isset($i['note2'])?$i['note2']:null?></textarea>
						</td>
						<td class="bill">
							<button id="invoice" class="invoice-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect ord-<?=$i['id_order']?> btn-m-green btn_js" data-name="bill_form_js" data-target="bill_form_js" <?=$i['id_klient'] == 5462?'data-confirm="Покупатель не выбран. Продолжить?"':null?>>Счет</button>
							<button id="bill" class="bill-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect ord-<?=$i['id_order']?> btn-m-orange btn_js" data-name="bill_form_js"  data-target="bill_form_js" <?=$i['id_klient'] == 5462?'data-confirm="Покупатель не выбран. Продолжить?"':null?>>Накл.</button><br>
							<a target="_blank" href="<?=_base_url?>/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>">Накл. сайт<br></a>
							<a target="_blank" href="<?=_base_url?>/invoice_customer_fakt/<?=$i['id_order']?>/<?=$i['skey']?>">Накл. факт</a>
						</td>
					</tr>
				<?}
			}else{?>
				<tr>
					<td colspan="12">Нет заказов за последние 30 дней</td>
				</tr>
			<?}?>
		</table>
	</div>	
<!--
	<form action="<?=$GLOBALS['URL_request']?>" method="post" id="work_days_js" class="modal_hidden">
		<table border="0" cellpadding="0" cellspacing="0" class="kontrag table">
			<thead>
				<tr>
					<th>Дата</th>
					<th>Рабочий</th>
				</tr>
			</thead>
			<tbody>
				<?$ii = 3;
				foreach($dates as $d=>$a){
				$date = new DateTime($d);?>
					<tr>
						<td><?=$date->format("d.m.Y")?></td>
						<?if($ii<=$GLOBALS['CONFIG']['order_day_end']){?>
							<td><?=isset($a['work_day'])&&$a['work_day']?'да':'-'?></td>
						<?}else{?>
							<td>
								<?if(isset($a['work_day'])){?>
									<input id="day<?=$a['d']?>" type="checkbox" <?if($a['work_day'] == 1){?>checked="checked"<?}?> onchange="SwitchContragentDate('<?=$a['d']?>', 'day');" />
								<?}?>
							</td>
						<?}?>
					</tr>
				<?$ii++;}?>
			</tbody>
		</table>
	</form>
-->
</div><!--class="contragent_cab"-->

<!-- CHANGE STATUS MODAL FORM -->
	<div id="select_status_js" data-type="modal" >
		<div class="modal_container">
		<form action="<?=$GLOBALS['URL_request']?>" method="POST" class="select-status">
			<div class="line">
				<label for="order">№ заказа:</label>
				<span class="order_num"></span>
				<input type="hidden" name="order" class="order_num"/>
			</div>
			<div class="line">
				<label for="client">Покупатель:</label><br>
				<span id="client"></span>
			</div>
			<div class="line status_block">
				<label for="status">Статус:</label>
				<select name="status" id="status">
					<?foreach($order_statuses as $s){
						if(in_array($s['id_order_status'], array("4","7","8"))){?>
							<option value="<?=$s['id_order_status']?>"><?=$s['name']?></option>
						<?}
					}?>
				</select>
			</div>
			<div class="line target_date">
				<label for="target_date">Дата сборки:</label>
				<input required="required" disabled="disabled" type="date" name="target_date" id="target_date" min="<?=date("H") > 16?date("Y-m-d", strtotime(date("Y/m/d") . "+2 days")):date("Y-m-d", strtotime(date("Y/m/d") . "+1 days"));?>"/>
			</div>
			<button type="submit" name="change_status" class="btn-m-green	mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Подтвердить</button>
		</form>
		</div>
	</div>
	<!-- CHANGE CLIENT MODAL FORM -->
	<div id="select_client_js" data-type="modal" >
		<div class="modal_container">
			<form action="<?=$GLOBALS['URL_request']?>" method="POST" class="select-client">
				<div class="line">
					<label for="order">№ заказа:&nbsp;&nbsp;</label>
					<span class="order_num"></span>
					<input type="hidden" name="order" class="order_num"/>
				</div>
				<div class="line">
					<label for="client_change">Клиент:</label>
					<select name="client" id="client_change">
						<?foreach($customers as $c){?>
							<option value="<?=$c['id_user']?>"><?=$c['cont_person']?></option>
						<?}?>
					</select>
				</div>
				<button type="submit" name="change_client" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Подтвердить</button>
			</form>
		</div>
	</div>
	<!-- MAKE BILL/INVOICE MODAL FORM -->
	<div id="bill_form_js" data-type="modal" >
		<div class="modal_container">
			<form action="<?=_base_url?>/tcpdf" target="_blank" method="POST" class="bill-form">
				<div class="line">
					<h4 id="doctype"></h4>
					<input type="hidden" name="doctype" id="doctype"/>
				</div>
				<div class="line">
					<label for="order">№ заказа:&nbsp;&nbsp;</label>
					<span class="order_num"></span>
					<input type="hidden" name="order" class="order_num"/>
				</div>
				<div class="line">
					<label for="margin">Индивидуальная наценка:
						<input type="text" name="margin" id="margin" placeholder="Введите наценку..."/>
					</label>
				</div>
				<div class="line">
					<label for="recipient">Отправитель:</label>
					<input type="hidden" name="contragent" value="<?=$current['id_user']?>"/>
					<select name="recipient" required id="recipient">
						<?foreach($remitters as $k=>$remitter){?>
							<option value="<?=$remitter['id']?>"><?=$remitter['name']?></option>
						<?}?>
					</select>
				</div>
				<div class="line">
					<label for="personal_client">Клиент:</label>
					<textarea type="text" name="personal_client" id="personal_client" placeholder="Для замены получателя в накладной или счете, введите все необходимые данные здесь..."></textarea>
					<input type="hidden" name="client" value=""/>
				</div>
				<div class="line clearfix">
					<label for="fact" class="settings">
						<input type="checkbox" name="fact" id="fact"/>
						Факт
					</label>
				</div>
				<div class="line clearfix">
					<label for="NDS" class="settings">
						<input type="checkbox" name="NDS" id="NDS"/>
						НДС
					</label>
				</div>
				<div class="line">
					<button type="submit" name="create-bill" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сформировать</button>
				</div>
			</form>
		</div>	
	</div>
	<!-- CHANGE WORK DAYS MODAL FORM -->	
	<div id="work_days_js" data-type="modal" >
		<div class="modal_container">
			<form action="<?=$GLOBALS['URL_request']?>" method="post">
				<table border="0" cellpadding="0" cellspacing="0" class="kontrag table">
					<thead>
						<tr>
							<th>Дата</th>
							<th>Рабочий</th>
						</tr>
					</thead>
					<tbody>
						<?$ii = 3;
						foreach($dates as $d=>$a){
						$date = new DateTime($d);?>
							<tr>
								<td><?=$date->format("d.m.Y")?></td>
								<?if($ii<=$GLOBALS['CONFIG']['order_day_end']){?>
									<td><?=isset($a['work_day'])&&$a['work_day']?'да':'-'?></td>
								<?}else{?>
									<td>
										<?if(isset($a['work_day'])){?>
											<input id="day<?=$a['d']?>" type="checkbox" <?if($a['work_day'] == 1){?>checked="checked"<?}?> onchange="SwitchContragentDate('<?=$a['d']?>', 'day');" />
										<?}?>
									</td>
								<?}?>
							</tr>
						<?$ii++;}?>
					</tbody>
				</table>
			</form>
		</div>
	</div>

<script type="text/javascript">
	$('#change-margin').on('click', function(e){
		var value = $('#discount').val().replace(",", ".");
		var min = $('#min_koef_manager').val();
		var max = $('#max_koef_manager').val();
		if(value < min || isNaN(value)){
			alert('Минимальное значение = '+min);
			e.preventDefault();
		}else if(value > max){
			alert('Максимальное значение = '+max);
			e.preventDefault();
		}
	});
</script>