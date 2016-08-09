<div class="cabinet">
	<ul id="breadcrumbs">
		<li><a href="/">Главная</a>&gt;</li>
		<li><a href="/cabinet">Личный кабинет</a></li>
	</ul>
	<h2>Личный кабинет <a href="/cabinet/info/" title="Редактировать личные данные" class="edit_personal">Редактировать</a></h2>
	<div class="balance" style="display: none;">
		Текущий баланс
		<span><?=$User['name']?></span>
	</div>
	<div class="personal_data"  style="display: none;">
		<h2>Личные данные <a href="/cabinet/info/" title="Редактировать личные данные" class="edit_personal">Редактировать</a>
		</h2>
		<div class="clear"></div>
		<div id="order" class="order">
			<form action="/cart/" method="post">
				<section class="left">
					<fieldset>
						<legend>Основная информация:</legend>
						<div class="line login">
							<label for="login">Пользователь</label>
							<?if($User['name']){?>
								<span class="saved_info"><?=$User['name']?></span>
								<input type="hidden" name="login" id="login" value="<?=$User['name']?>"/>
							<?}else{?>
								<input required type="text" name="login" id="login" value=""/>
								<div id="name_error"></div>
							<?}?>
						</div>
						<div class="line email">
							<label for="email">E-mail</label>
							<?if($User['email']){?>
								<span class="saved_info"><?=$User['email']?></span>
								<input type="hidden" name="email" id="email" value="<?=$User['email']?>"/>
							<?}else{?>
								<div class="clear"></div>
								<input required type="text" name="email" id="email" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value=""/>
								<div id="name_error"></div>
							<?}?>
						</div>
						<div class="clear"></div>
						<div class="line person">
							<label for="name">Контактное лицо</label><?//=isset($errm['cont_person'])?"<span class=\"errmsg\">".$errm['cont_person']."</span>":null?>
							<?if($Customer['cont_person']){?>
								<span class="saved_info"><?=$Customer['cont_person']?></span>
								<input type="hidden" name="cont_person" id="name" value="<?=$Customer['cont_person']?>"/>
							<?}else{?>
								<input required type="text" name="cont_person" id="name" value=""/>
								<div id="name_error"></div>
								<p class="shadowtext">(Сидоров Иван Петрович) - образец!</p>
							<?}?>
						</div>
						<div class="line phone">
							<label for="phone">Контактный телефон</label><?//=isset($errm['phones'])?"<span class=\"errmsg\">".$errm['phones']."</span>":null?>
							<?if($Customer['phones']){?>
								<span class="saved_info"><?=$Customer['phones']?></span>
								<input type="hidden" name="phones" id="phone" value="<?=$Customer['phones']?>"/>
							<?}else{?>
								<input required type="tel" name="phones" id="phone" maxlength="15" value=""/>
								<div id="phone_error"></div>
								<p class="shadowtext">(099 123-45-67) - образец!</p>
							<?}?>
						</div>
						<div id="contragent" class="line">
							<label for="id_manager">Личный менеджер</label>
							<?if($SavedContragent['id_user']){?>
								<span class="saved_info"><?=$SavedContragent['name_c']?></span>
								<input type="hidden" name="id_manager" id="id_manager" value="<?=$SavedContragent['id_user']?>"/>
							<?}else{?>
								<div class="select">
									<select required name="id_manager" id="id_manager">
									<option selected disabled class="cntr_0" value="">--Выберите менеджера--</option>
									<?$ii=1;foreach($manager as $item){
										if($SavedContragent['id_user'] && $item['id_user']==$SavedContragent['id_user']){?>
											<option selected class="cntr_<?=$ii?>" value="<?=$SavedContragent['id_user']?>"><?=$SavedContragent['name_c']?></option>
										<?}else{?>
											<option class="cntr_<?=$ii?>" value="<?=$item['id_user']?>"><?=$item['name_c']?></option>
										<?}?>
									<?$ii++;}?>
									</select>
								</div>
							<?}?>
						</div>
					</fieldset>
				</section>
				<section class="right">
					<fieldset>
						<legend>Настройки доставки:</legend>
						<div class="line region">
							<label for="id_region">Область</label>
							<?if($SavedCity){?>
								<span class="saved_info"><?=$SavedCity['region']?></span>
								<input type="hidden" name="id_region" id="id_region" value="<?=$SavedCity['region']?>"/>
							<?}else{?>
								<div class="select">
									<select required name="id_region" id="id_region" onBlur="regionSelect(id_region.value);" onChange="regionSelect(id_region.value);">
										<option disabled selected>Выберите область</option>
									<?foreach ($regions as $item){?>
										<option value="<?=$item['region']?>"><?=$item['region']?></option>
									<?}?>
									</select>
								</div>
							<?}?>
						</div>
						<div class="line city">
							<label for="id_city">Город</label>
							<?if($SavedCity){?>
								<span class="saved_info"><?=$SavedCity['name']?></span>
								<input type="hidden" name="id_city" id="id_city" value="<?=$SavedCity['names_regions']?>"/>
							<?}else{?>
								<div class="select">
									<select required name="id_city" id="id_city" onBlur="citySelect(id_city.value);" onChange="citySelect(id_city.value);">
									</select>
								</div>
							<?}?>
						</div>
						<div class="line id_delivery">
							<label for="id_delivery">Способ доставки</label>
							<?if($SavedDeliveryMethod){?>
								<span class="saved_info"><?=$SavedDeliveryMethod['name']?></span>
								<input type="hidden" name="id_delivery" id="id_delivery" value="<?=$SavedDeliveryMethod['id_delivery']?>"/>
							<?}else{?>
								<div class="select">
									<select required name="id_delivery" id="id_delivery" onBlur="deliverySelect();" onChange="deliverySelect();">
									</select>
								</div>
							<?}?>
						</div>
						<?if($SavedDeliveryMethod['id_delivery']==3 || !$SavedDeliveryMethod['id_delivery']){?>
							<div class="line delivery_service" id="delivery_service">
								<label for="id_delivery_service">Служба доставки</label>
								<?if($SavedCity['shipping_comp']){?>
									<span class="saved_info"><?=$SavedCity['shipping_comp']?></span>
									<input type="hidden" name="id_delivery_service" id="id_delivery_service" value="<?=$SavedCity['shipping_comp']?>"/>
								<?}else{?>
									<div class="select">
										<select name="id_delivery_service" onBlur="deliveryServiceSelect(id_delivery_service.value);" onChange="deliveryServiceSelect(id_delivery_service.value);" id="id_delivery_service">
										</select>
									</div>
								<?}?>
							</div>
							<div class="line" id="delivery_department">
								<label for="id_delivery_department">Отделение в Вашем городе</label>
								<?if($SavedCity['address']){?>
									<span class="saved_info"><?=$SavedCity['address']?></span>
									<input type="hidden" name="id_delivery_department" id="id_delivery_department" value="<?=$SavedCity['id_city']?>"/>
								<?}else{?>
									<div class="select">
										<select name="id_delivery_department" id="id_delivery_department">
										</select>
									</div>
								<?}?>
							</div>
						<?}?>
					</fieldset>
				</section>
				<div class="clear"></div>
				<?if(!$Customer['id_delivery']){?>
					<input style="width: 250px;" name="apply" type="submit" class="save_order confirm" value="Сохранить изменения"/>
				<?}?>
			</form>
		</div>
	</div>
	<div class="clear"></div>
	<h3>Балансы</h3>
	<div class="balance_details">
		<div class="customer_balance">
			<p>Остаток на счету:</p>
			<span class="value" <?if($Customer['balance'] < 0){?>style="color: #f00;"<?}?>>
				<?=$Customer['balance']!=0?number_format($Customer['balance'],2,",",""):"0,00"?><span class="unit"> грн.</span>
			</span>
				<div class="clear"></div>
			<?if($Customer['discount']!=0){?>
				<p>Персональная скидка:</p>
				<span class="value">
					<?=$Customer['discount']!=0?$Customer['discount']:0?><span class="unit"> %</span>
				</span>
			<?}?>
		</div>
		<?if(!$Customer['bonus_card']){?>
			<div class="bonus_balance">
				<h5>Вы получили бонусную карту? Пришло время ее активировать! <br>
				Для этого заполните, пожалуйста, в <a href="/cabinet/info/">личных данных</a> информацию, которая поможет нам сделать Ваши покупки проще, а работу с нами - приятнее.</h5><a href="/page/Skidki/">Детали бонусной программы</a>
			</div>
		<?}else{?>
			<div class="bonus_balance">
				<p>Бонусный баланс:</p>
				<span class="value">
					<?=$Customer['bonus_balance']!=null?number_format($Customer['bonus_balance'],2,",",""):"20,00"?><span class="unit"> грн.</span>
				</span>
				<div class="clear"></div>
				<p>Бонусный Процент:</p>
				<span class="value">
					<?=$Customer['bonus_discount']!=null?$Customer['bonus_discount']:1?><span class="unit"> %</span>
				</span>
				<div class="clear"></div>
				<a href="/page/Skidki/">Детали бонусной программы.</a>
			</div>
		<?}?>
		<div class="clear"></div>
	</div>
	<br>
	<div class="history">
		<h2>История заказов</h2>
		<div class="clear"></div>
		<table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">
		<?if($orders){?>
			<thead>
				<tr>
					<th><a href="<?=$sort_links['date']?>" class="up_down">Дата</a></th>
					<th><a href="<?=$sort_links['id_order']?>" class="up_down">Заказ №</a></th>
					<th><a href="<?=$sort_links['status']?>" class="up_down">Статус</a></th>
					<th>Сумма</th>
					<th>Менеджер</th>
					<th width="300">Информация по заказу</th>
					<th width="3%">Удалить</th>
				</tr>
			</thead>
			<?foreach ($orders as $i){?>
			<tr>
				<td>
					<p><?=date("d.m.Y",$i['creation_date'])?></p>
				</td>
				<td>
					<p>
						<a href="<?=_base_url?>/customer_order/<?=$i['id_order']?>"/><?=$i['id_order']?></a>
					</p>
				</td>
				<td>
					<p<?=($i['id_order_status']==2)?' class="status_done"':null?>><?=$order_statuses[$i['id_order_status']]['name']?></p>
				</td>
				<td>
					<p><?=round($i['sum_discount'],2)?></p>
				</td>
				<td>
					<p>
					<?php if(!empty($i['contragent_site'])):?>
						<a href="<?=$i['contragent_site']?>"><?=$i['contragent']?></a>
					<?php else:?>
						<?=$i['contragent']?>
					<?php endif?>
					</p>
				</td>
				<td><?php if(isset($i['note_customer'])) echo $i['note_customer']?></td>
				<td>
					<?if($i['id_order_status']==6){?>
						<p>&mdash;</p>
					<?}else{?>
						<p>
							<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
								<input type="submit" name="smb_off" class="run_order_off cancel" value="X">
								<input type="hidden" name="id_order" value="<?=$i['id_order']?>">
							</form>
						</p>
					<?}?>
				</td>
			</tr>
			<?}?>
		</table>
		<?}else{?>
			<p>У Вас нету ни одного заказа</p>
		</table>
		<?}?>
		<style type="text/css">
			.colortext {
				color: #b00; /* Цвет текста */
				font-size: 14pt
			}
		</style>
		<p class="colortext">Отгружаются заказы в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
		<p class="colortext">Пожалуйста, после выполнения предоплаты, сообщите сумму проплаты с номером заказа Вашему менеджеру.</p>
	</div><!--class="history"-->
</div><!--class="cabinet"-->