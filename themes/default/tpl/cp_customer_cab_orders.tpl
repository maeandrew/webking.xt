<? require "cp_customer_cab_leftside.tpl";?>
<div class="customer_cab">
	<div class="msg-info">
		<p>Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
	</div>
	<div id="orders_history">

		<?!isset($_GET['t'])?$_GET['t']='all':null;?>
		<div class="<?switch ($_GET['t']){
			case 'working':
				$s[] = 1;
				$s[] = 6;
				?>working<?
			break;
			case 'completed':
				$s[] = 2;
				?>completed<?
			break;
			case 'canceled':
				$s[] = 4;
				$s[] = 5;
				?>canceled<?
			break;
			case 'drafts':
				$s[] = 3;
				?>drafts<?
			break;
			default:
				$s = array();
			break;
		}?> editing">
			<?if($orders){?>
				<ul class="orders_list">
					<?foreach ($orders as $i){
						if(in_array($i['id_order_status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){
							//print_r($i['city_info']);
							?>
						<!-- <li>
							<div class="one_order">
								<div class="order_head">
									<p>Совместная корзина № <?=$i['id_order']?></p>
									<div>Выполнен | icon icon icon icon icon_1</div>
									<span>Детали</span><span>Участники</span>
								</div>
								<div>
									<div>
										<img src="">
										<span>Дата заказа</span>
										<p>12/06/15</p>
									</div>
									<div>
										<img src="">
										<span>Товаров</span>
										<p>329 шт.</p>
									</div>
									<div>
										<img src="">
										<span>Сумма к оплате</span>
										<p>2516,12 грн</p>
									</div>
									<div>
										<img src="">
										<span>Скидка</span>
										<p>16%</p>
									</div>
									<div>
										<h6>Ваш менеджер</h6>
										<img src="">
										<span>Вишневская Оксана</span>
										<span>099 435 4672</span>
										<img src=""><img src=""><span>2234</span>
									</div>
									<div>
										<h6>Способ доставки</h6>
										<p><span>ТТН:</span>45245687989</p>
										<p><span>Город:<span>Харьков</p>
										<p><span>Отделение</span>№62 ул.Кирова</p>
									</div>
								</div>
							</div>
						</li> -->

						<li>
							<section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
								<div class="title">
									<div class="container">
										<span class="number">Совместная корзина № <?=$i['id_order']?></span>
										<div class="print">
											<div class="icon"><img src="<?=_base_url?>/themes/default/img/print1.png"></div>
											<ul class="expanded">
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_XLS_black_24px.svg"></a></li>
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_txt_black_24px.svg"></a></li>
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_img_black_24px.svg"></a></li>
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_black_24px.svg"></a></li>
											</ul>
										</div>
										<div class="status">Выполнен</div>
									</div>
									<div class="tabs mdl-tabs__tab-bar">
										<a href="#starks-panel-<?=$i['id_order']?>" class="mdl-tabs__tab is-active">Детали</a>
										<a href="#lannisters-panel-<?=$i['id_order']?>" class="mdl-tabs__tab">Учасники</a>
										<a href="#targaryens-panel-<?=$i['id_order']?>" class="mdl-tabs__tab">Список товаров</a>
									</div>
								</div>
								<div class="content">
									<div class="mdl-tabs__panel is-active" id="starks-panel-<?=$i['id_order']?>">
										<div class="info">
											<div class="date">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_date_range_black_24px.svg"></span>
												<span class="label">Дата заказа</span>
												<span class="value"><?=date("d.m.Y",$i['creation_date'])?></span>
											</div>
											<div class="count">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_local_shipping_black_24px.svg"></span>
												<span class="label">Товаров</span>
												<span class="value">353 шт.</span>
											</div>
											<div class="sum">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_attach_money_black_24px.svg"></span>
												<span class="label">Сумма к оплате</span>
												<span class="value"><?=number_format($i['sum_discount'],2,',','')?> грн.</span>
											</div>
											<div class="discount">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_shuffle_black_24px.svg"></span>
												<span class="label">Скидка</span>
												<span class="value">%</span>
											</div>
										</div>
										<div class="additional">
											<div class="manager">
												<div class="label">Ваш менеджер</div>
												<div class="avatar"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /></div>
												<div class="details">
													<div class="line_1"><?=$i['contragent']?> / Гвоздик Алёна</div>
													<div class="line_2"><?=$i['contragent_info']['phones']?></div>
													<div class="line_3">like dislike <span class="votes_cnt">15686</span></div>
												</div>
											</div>
											<div class="delivery">
												<div class="label">Способ доставки</div>
												<div class="avatar"><img src="http://lorempixel.com/abstract/70/70/" alt="avatar" /></div>
												<div class="details">
													<div class="line_1">
														<span class="label">ТТН:</span>
														<span class="value">4524524456456</span>
													</div>
													<div class="line_2">
														<span class="label">Город:</span>
														<span class="value"><?=$i['city_info']['name']?></span>
													</div>
													<div class="line_3">
														<span class="label">Отделение:</span>
														<span class="value"><?=$i['city_info']['address']?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="mdl-tabs__panel" id="lannisters-panel-<?=$i['id_order']?>">
										<div class="info">
											<div class="date">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_date_range_black_24px.svg"></span>
												<span class="label">Дата заказа</span>
												<span class="value"><?=date("d.m.Y",$i['creation_date'])?></span>
											</div>

										</div>
										<div class="additional">
											<div class="manager">
												<div class="label">Ваш менеджер</div>
												<div class="avatar"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /></div>
												<div class="details">
													<div class="line_1"><?=$i['contragent']?> / Гвоздик Алёна</div>
													<div class="line_2"><?=$i['contragent_info']['phones']?></div>
													<div class="line_3">like dislike <span class="votes_cnt">15686</span></div>
												</div>
											</div>
											<div class="delivery">
												<div class="label">Способ доставки</div>
												<div class="avatar"><img src="http://lorempixel.com/abstract/70/70/" alt="avatar" /></div>
												<div class="details">
													<div class="line_1">
														<span class="label">ТТН:</span>
														<span class="value">4524524456456</span>
													</div>
													<div class="line_2">
														<span class="label">Город:</span>
														<span class="value"><?=$i['city_info']['name']?></span>
													</div>
													<div class="line_3">
														<span class="label">Отделение:</span>
														<span class="value"><?=$i['city_info']['address']?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="mdl-tabs__panel" id="targaryens-panel-<?=$i['id_order']?>">
										<div class="info">
											<div class="date">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_date_range_black_24px.svg"></span>
												<span class="label">Дата заказа</span>
												<span class="value"><?=date("d.m.Y",$i['creation_date'])?></span>
											</div>
											<div class="count">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_local_shipping_black_24px.svg"></span>
												<span class="label">Товаров</span>
												<span class="value">353 шт.</span>
											</div>
											<div class="discount">
												<span class="icon"><img src="<?=_base_url?>/themes/default/img/ic_shuffle_black_24px.svg"></span>
												<span class="label">Скидка</span>
												<span class="value">%</span>
											</div>
										</div>
									</div>
								</div>
							</section>
						</li>




							<!-- <li class="order clearfix col-lg-8 col-md-9 col-sm-12">
								<div class="order_header">
									<p>Заказ <b>№ <?=$i['id_order']?></b> от <?=date("d.m.Y",$i['creation_date'])?></p>
									<p class="details">
										<a href="<?=_base_url?>/customer_order/<?=$i['id_order']?>">Подробности заказа</a>
									</p>
								</div>
								<div class="order_content">
									<p><b>Сумма к оплате:</b> <?=number_format($i['sum_discount'],2,',','')?>грн.</p>
									<p><b>Менеджер заказа:</b> <?=$i['contragent']?></p>
									<p><b>Информация по заказу:</b> <?=(isset($i['note_customer']) && $i['note_customer'] != '')?$i['note_customer']:'отсутствует';?></p>
									<div class="status
									<?if(in_array($i['id_order_status'], array(1,6))){?>
										working
									<?}elseif($i['id_order_status'] == 2){?>
										completed
									<?}elseif($i['id_order_status'] == 3){?>
										drafts
									<?}elseif(in_array($i['id_order_status'], array(4,5))){?>
										canceled
									<?}?>
									">
										<p><?=$order_statuses[$i['id_order_status']]['name']?></p>
									</div>
									<div class="controls fright">
										<form action="<?=_base_url?>/cart/<?=$i['id_order']?>" method="post" class="fleft">
											<button type="submit" class="remake_order btn-m-green open_modal" data-target="order_remake_js">Повторить заказ</button>
										</form>
										<?if($i['id_order_status'] == 1){?>
											<form action="<?=$GLOBALS['URL_request']?>" method="post">
												<input type="hidden" name="id_order" value="<?=$i['id_order']?>"/>
												<input type="submit" name="smb_cancel" class="cancel_order btn-m btn-red-inv" value="Отменить">
											</form>
										<?}elseif($i['id_order_status'] != 6 && $i['id_order_status'] != 1){?>
											<form action="<?=$GLOBALS['URL_request']?>" method="post" class="fright">
												<button type="submit" name="smb_off" class="btn-m-red-inv">Удалить</button>
												<input type="hidden" name="id_order" value="<?=$i['id_order']?>">
											</form>
										<?}?>
									</div>
								</div>
							</li> -->
						<?}?>
					<?}?>
				</ul>
			<?}else{?>
				<p class="no_orders">У Вас нету ни одного заказа</p>
			<?}?>
		</div>
		<!-- ORDER REMAKE MODAL FORM -->
		<!-- <div id="order_remake_js" class="modal_hidden">
			<form action="<?=_base_url?>/cart/" method="post" class="order_remake">
				<p><b>Добавить</b> товары из данного заказа к товарам из текущей корзины или <b>заменить</b> содержимое корзины содержимым данного заказа?</p>
				<button type="submit" name="add_order" class="btn-m-green fleft">Добавить к корзине</button>
				<button type="submit" name="remake_order" class="btn-m-green fright">Заменить корзину</button>
			</form>
		</div> -->

	</div><!--class="history"-->
</div><!--class="cabinet"-->