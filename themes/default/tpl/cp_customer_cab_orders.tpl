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
			<?if($orders){ ?>
				<ul class="orders_list">
							<? //print_r($orders); ?>
					<?foreach ($orders as $i){
						if(in_array($i['id_order_status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){ ?>


						<li>
							<section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
								<div class="title">
									<div class="container">
										<span class="number" style="min-width:92%;">
											<span class="numb">Заказ № <?=$i['id_order']?></span>
											<span class="date"  style="padding-left:20px">Дата: <?=date("d.m.Y",$i['creation_date'])?></span>

											<?php
												$str = count($i['products']). ' товар';
												$count = count($i['products']);
												if(substr($count,-1) == 1 && substr($count,-2) != 11)
													$str .= '';
												else if(substr($count,-1) >= 2 && substr($count,-2,1) != 1 && substr($count,-1) <= 4)
													$str .= 'а';
												else
													$str .= 'ов';
											?>
											<span class="my_item" style="padding-left:20px"><?=$str?> на <?=number_format($i['sum_discount'],2,',','')?> грн.</span>
											<div class="status"><?=$order_statuses[$i['id_order_status']]['name']?></div>
										</span>
										<div class="print">

											<div class="icon mdl-button mdl-js-button mdl-button--icon" id="menu-lower_<?=$i['id_order']?>">
												<img src="<?=_base_url?>/themes/default/img/print1.png">
											</div>

											<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-lower_<?=$i['id_order']?>" style="width:180px; height:120px; !important">
												<!-- <img src="<?=_base_url?>/themes/default/img/ic_paper_XLS_black_24px.svg">
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_txt_black_24px.svg"></a></li>
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_img_black_24px.svg"></a></li>
												<li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_black_24px.svg"></a></li> -->
												<li>
													<a href="#"><svg class="icon" id="tt1"><use xlink:href="#XLS"></use></svg>Распечатать в XML</a>
													<div class="mdl-tooltip" for="tt1">Распечатать в XML</div>

												</li>
												<li>
													<a href="#"><svg class="icon" id="tt2"><use xlink:href="#txt"></use></svg>Для реализатора</a>
													<div class="mdl-tooltip" for="tt2">Распечатать для реализатора</div>
												</li>
												<li>
													<a href="#"><svg class="icon" id="tt3"><use xlink:href="#img"></use></svg>С картинками</a>
													<div class="mdl-tooltip" for="tt3">Распечатать с картинками</div>
												</li>

												<li><a href="#"><svg class="icon" id="tt4"><use xlink:href="#paper"></use></svg>Документом</a>
													<div class="mdl-tooltip" for="tt4">Распечатать документом</div>
												</li>

											</ul>

										</div>

									</div>
									<div class="tabs mdl-tabs__tab-bar">
										<a href="#starks-panel-<?=$i['id_order']?>" class="mdl-tabs__tab is-active">Детали</a>
										<!-- <a href="#lannisters-panel-<?=$i['id_order']?>" class="mdl-tabs__tab">Учасники</a> -->
										<a href="#targaryens-panel-<?=$i['id_order']?>" class="mdl-tabs__tab" onClick="GetCabProdAjax(<?=$i['id_order']?>);">Список товаров</a>
									</div>
								</div>
								<div class="content">
									<div class="mdl-tabs__panel is-active" id="starks-panel-<?=$i['id_order']?>">
										<div class="info">
											<div class="date">
												<span class="icon">
													<!-- <img src="<?=_base_url?>/themes/default/img/ic_date_range_black_24px.svg"> -->

													<svg class="icon">
													  <use xlink:href="#date"></use>
													</svg>

												</span>
												<span class="label">Дата заказа</span>
												<span class="value"><?=date("d.m.Y",$i['creation_date'])?></span>
											</div>
											<div class="count">
												<span class="icon">
 													<!--<img src="<?=_base_url?>/themes/default/img/ic_local_shipping_black_24px.svg"> -->
 													<svg class="icon">
													  <use xlink:href="#shipping"></use>
													</svg>
												</span>
												<span class="label">Товаров</span>
												<span class="value"><?=count($i['products'])?> шт.</span>
											</div>
											<div class="sum">
												<span class="icon">
													<!-- <img src="<?=_base_url?>/themes/default/img/ic_attach_money_black_24px.svg"> -->
													<svg class="icon">
													  <use xlink:href="#money"></use>
													</svg>
												</span>
												<span class="label">Сумма к оплате</span>
												<span class="value"><?=number_format($i['sum_discount'],2,',','')?> грн.</span>
											</div>
											<div class="discount">
												<span class="icon">
													<!-- <img src="<?=_base_url?>/themes/default/img/ic_shuffle_black_24px.svg"> -->
													<svg class="icon">
													  <use xlink:href="#shuffle"></use>
													</svg>
												</span>
												<span class="label">Скидка</span>
												<span class="value"><?=(1 - $i['discount']) * 100?>%</span>
											</div>
										</div>
										<div class="additional">
											<div class="manager" data-id="<?=$i['contragent_info']['id_user']?>">
												<div class="label">Ваш менеджер</div>
												<div class="avatar">
													<img src="http://lorempixel.com/fashion/70/70/" alt="avatar" />
												</div>
												<div class="details">
													<div class="line_1"><?=$i['contragent']?></div>
													<div class="line_2"><?=$i['contragent_info']['phones']?></div>
													<div class="line_3">
														<a href="#" class="like" onclick="UserRating()">
															<svg class="icon"><use xlink:href="#like"></use></svg>
														</a>
														<a href="#" class="dislike" onclick="UserRating()">
															<svg class="icon"><use xlink:href="#dislike"></use></svg>
														</a>
														<span class="votes_cnt"><?=$i['contragent_info']['like_cnt']?><?//=count($rating)?></span>
													</div>
												</div>
											</div>
											<div class="delivery">
												<div class="label">Способ доставки</div>
												<div class="avatar">
													<img src="http://lorempixel.com/abstract/70/70/" alt="avatar" />
												</div>
												<div class="details">
													<div class="line_1">
														<span class="label">ТТН:</span>
														<span class="value"> - </span>
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
                                        <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp" id="list_coop">
                                            <thead>
                                                <tr>
                                                    <th class="mdl-data-table__cell--non-numeric">
                                                    </th>
                                                    <th class="mdl-data-table__cell--non-numeric">Статус</th>
                                                    <th>Сумма</th>
                                                    <th></th>
                                                </tr>

                                            </thead>
                                            <tbody>
												<?if (isset($infoCarts) && is_array($infoCarts)) : foreach($infoCarts as $infoCart) :?>
													<tr>
														<td class="mdl-data-table__cell--non-numeric">
															<div class="avatar img"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /></div>
														</td>
														<td class="mdl-data-table__cell--non-numeric stat_user_cab"><?=$infoCart['title_status']?></td>
														<td><?=$infoCart['sum_cart']?></td>
														<td class="del_x"><i class="material-icons">close</i></td>
													</tr>
												<?endforeach; endif;?>
           								 <?//print_r($i)?>
                                            </tbody>
                                        </table>
										<!--<div class="additional info">
											<div class="manager">
												<div class="label">Ваш менеджер</div>
												<div class="avatar"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /></div>
												<div class="details">
													<div class="line_1"><?=$i['contragent']?> / Гвоздик Алёна</div>
													<div class="line_2"><?=$i['contragent_info']['phones']?></div>
													<div class="line_3">like dislike <span class="votes_cnt">15686</span></div>
												</div>
											</div>

										</div>-->
                                        <?//print_r($prodsCarts)?>
                                        <div id="block_promo">
                                            <div class="label">Промо-кода для совместной корзины: 5577321</div>
                                            <div class="label">Вы можете передать его любым удобным для Вас способом:</div>
                                            <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                                                <thead>
                                                    <tr>
                                                        <th class="mdl-data-table__cell--non-numeric">Пригласить участника
                                                            <label class="mdl-button mdl-js-button mdl-button--primary">Отправить</label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <form action="#">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                                <input class="mdl-textfield__input" type="text" id="sample1">
                                                                <label class="mdl-textfield__label" for="sample1">Отправить на Email</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                                <input class="mdl-textfield__input" type="text" id="sample2">
                                                                <label class="mdl-textfield__label" for="sample2">Отправить SMS на номер</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </form>
                                            </table>
                                        </div>
									</div>
									<div class="mdl-tabs__panel" id="targaryens-panel-<?=$i['id_order']?>">
										<div id="products"></div>
										<div class="over_sum">Итого: <?=number_format($i['sum_discount'],2,',','')?> грн.</div>
									</div>
									<div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
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
			<?}else{ ?>
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

