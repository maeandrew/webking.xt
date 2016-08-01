<div class="customer_cab">	
	<h1>Мои заказы<?switch ($_GET['t']){
			case 'working':
				$s[] = 1;
				$s[] = 6;
				?>. Выполняются<?
			break;
			case 'completed':
				$s[] = 2;
				?>. Выполненные<?
			break;
			case 'canceled':
				$s[] = 4;
				$s[] = 5;
				?>. Отмененные<?
			break;
			case 'drafts':
				$s[] = 3;
				?>. Черновики<?
			break;
			default:
				$s = array();
			break;
		}?></h1>	
	<div id="orders_history">
		<div class="msg-info">
			<p>Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
		</div>
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
					<?foreach($orders as $i){
						if(in_array($i['id_order_status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){?>
							<li>
								<section class="order mdl-tabs mdl-js-tabs">
									<div class="title">
										<div class="container">
											<span class="number">
												<span class="numb">Заказ № <?=$i['id_order']?></span>
												<span class="date">Дата: <?=date("d.m.Y",$i['creation_date'])?></span>
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
												<span class="my_item"><?=$str?> на <?=number_format($i['sum_discount'],2,',','')?> грн.</span>
												<div class="status"><?=$order_statuses[$i['id_order_status']]['name']?></div>
												<!-- <div class="mobileBtns">
													<i class="material-icons">add_circle_outline</i>
													<span> заказ</span>
												</div> -->
											</span>
											<div class="print">
												<div class="icon mdl-button mdl-js-button mdl-button--icon" id="menu-lower_<?=$i['id_order']?>">
													<img src="<?=_base_url?>/themes/default/img/print1.png">
												</div>
												<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu print_menu" for="menu-lower_<?=$i['id_order']?>">
													<li class="mdl-menu__item">
														<a href="/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>/?nophoto=true" target="_blank">
															<svg class="icon" id="tt1"><use xlink:href="#XLS"></use></svg><span>Распечатать в XSL</span>
														</a>
													</li>
													<li class="mdl-menu__item">
														<a href="/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>/?nophoto=true" target="_blank"><svg class="icon" id="tt2"><use xlink:href="#txt"></use></svg>Для реализатора</a>
													</li>
													<li class="mdl-menu__item">
														<a href="/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>" target="_blank"><svg class="icon" id="tt3"><use xlink:href="#img"></use></svg>С картинками</a>
													</li>
													<li class="mdl-menu__item">
														<a href="/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>/?nophoto=true" target="_blank"><svg class="icon" id="tt4"><use xlink:href="#paper"></use></svg>Документом</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="tabs mdl-tabs__tab-bar">
										<div class="orderBntsMob">
												<h5>Заказ:</h5>
												<a class="newOrderLink" href="http://xt/"><button class="mdl-button mdl-js-button mdl-button--raised">Новый</button></a>
												<button class="mdl-button mdl-js-button mdl-button--raised btn_js replaceOrderBtn" data-name="cloneOrder">Создать</button>

												<div class="odrerIdAct hidden" data-id-order='<?=$i['id_order']?>'></div>

												<?if($i['id_order_status'] == 2 || $i['id_order_status'] == 3 || $i['id_order_status'] == 4 || $i['id_order_status'] == 5){?>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js delOrderBtn" data-name="confirmDelOrder">Удалить</button>
												<?}else if ($i['id_order_status'] == 6){?>
													<button class="hidden"></button>
												<?}else{?>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js cnslOrderBtn" data-name="confirmCnclOrder">Отменить</button>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js delOrderBtn hidden" data-name="confirmDelOrder">Удалить</button>
													<!-- ВОТ ЭТО ПОТОМ ЗАМЕНИТЬ -->

												<?}?>
											</div>

											<a href="#starks-panel-<?=$i['id_order']?>" class="mdl-tabs__tab is-active tabLink">Детали</a>
											<a href="#targaryens-panel-<?=$i['id_order']?>" class="mdl-tabs__tab tabLink prod_load_js" data-cartid="<?=$i['id_order']?>" data-rewrite="<?=isset($GLOBALS['Rewrite'])?$GLOBALS['Rewrite']:'';?>">Список товаров</a>

											<div class="orderBnts">

												<h5>Заказ:</h5>
												<a href="http://xt/"><button class="mdl-button mdl-js-button mdl-button--raised">Новый</button></a>
												<button class="mdl-button mdl-js-button mdl-button--raised btn_js replaceOrderBtn" data-name="cloneOrder">Создать</button>

												<div class="odrerIdAct hidden" data-id-order='<?=$i['id_order']?>'></div>

												<?if($i['id_order_status'] == 2 || $i['id_order_status'] == 3 || $i['id_order_status'] == 4 || $i['id_order_status'] == 5){?>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js delOrderBtn" data-name="confirmDelOrder">Удалить</button>
												<?}else if ($i['id_order_status'] == 6){?>
													<button class="hidden"></button>
												<?}else{?>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js cnslOrderBtn" data-name="confirmCnclOrder">Отменить</button>
													<button class="mdl-button mdl-js-button mdl-button--raised btn_js delOrderBtn hidden" data-name="confirmDelOrder">Удалить</button>
													<!-- ВОТ ЭТО ПОТОМ ЗАМЕНИТЬ -->

												<?}?>
											</div>
										</div>
									</div>
									<div class="content">
										<div class="mdl-tabs__panel is-active" id="starks-panel-<?=$i['id_order']?>">
											<div class="info">
												<div class="date">
													<span class="icon">
														<svg class="icon">
														  <use xlink:href="#date"></use>
														</svg>
													</span>
													<span class="label">Дата заказа</span>
													<span class="value"><?=date("d.m.Y",$i['creation_date'])?></span>
												</div>
												<div class="count">
													<span class="icon">
														<svg class="icon">
														  <use xlink:href="#shipping"></use>
														</svg>
													</span>
													<span class="label">Товаров</span>
													<span class="value"><?=count($i['products'])?> шт.</span>
												</div>
												<div class="sum">
													<span class="icon">
														<svg class="icon">
														  <use xlink:href="#money"></use>
														</svg>
													</span>
													<span class="label">Сумма к оплате</span>
													<span class="value"><?=number_format($i['sum_discount'],2,',','')?> грн.</span>
												</div>
												<div class="discount">
													<span class="icon">
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
															<a href="#" class="like" onclick="UserRating($(this));return false;">
																<svg class="icon"><use xlink:href="#like"></use></svg>
															</a>
															<a href="#" class="dislike" onclick="UserRating($(this));return false;">
																<svg class="icon"><use xlink:href="#dislike"></use></svg>
															</a>
															<span class="votes_cnt"><?=$i['contragent_info']['like_cnt']?><?//=count($rating)?></span>
														</div>
														<div id="modal_message" data-type="modal">
															<div class="modal_container">
																<div class="mesage_text">Вы уже отдали голос за этого менеджера</div>
															</div>
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
														<th class="mdl-data-table__cell--non-numeric"></th>
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
												</tbody>
											</table>
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
											<!-- <div class="over_sum">Итого: <?=number_format($i['sum_discount'],2,',','')?> грн.</div> -->
										</div>
										<div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
									</div>
								</section>
							</li>
						<?}?>
					<?}?>
				</ul>
			<?}else{?>
				<p class="no_orders">У Вас нет ни одного заказа</p>
			<?}?>
		</div>
		<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
	</div><!--class="history"-->
</div><!--class="cabinet"-->

<script>

/*ПОТОМ ВСЕ ВЫНЕСТИ В МЭЙН Ж ЭС (НАВЕРНО)*/
var statuses = {
	<?for($status = 1; isset($order_statuses[$status]); $status++){
		echo $status.": '".$order_statuses[$status]['name']."',";
	}?>
}

//Удаление заказа в кабинете
$(function(){
	var id_order = <?=$i['id_order']?>;
	/*Определение текущего ID заказа и Отмена*/
	$('.cnslOrderBtn').on('click', function(e){
		id_order = $(this).closest('.mdl-tabs__tab-bar').find('.odrerIdAct').data('id-order');
		$('.editing').find('li').removeClass('canceledOrder');
		$(this).closest('li').addClass('canceledOrder');
	});

	/* "Черная метка" - удаление заказа*/
	$('.delOrderBtn').on('click', function(e){
		id_order = $(this).closest('.mdl-tabs__tab-bar').find('.odrerIdAct').data('id-order');
		$('.editing').find('li').removeClass('deletedOrder');
		$(this).closest('li').addClass('deletedOrder');
	});

	$('.replaceOrderBtn').on('click', function(e){
		id_order = $(this).closest('.mdl-tabs__tab-bar').find('.odrerIdAct').data('id-order');
	});

	// Новый заказ на основе
	$('#replaceCartMod').on('click', function(e){
		ajax('cart', 'duplicate', {id_order: id_order}).done(function(data){
			ajax('cart', 'GetCart').done(function(data){
				$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.products));
			});
		});
	});

	$('#addtoCartMod').on('click', function(e){
		ajax('cart', 'duplicate', {id_order: id_order, add: 1}).done(function(data){
			ajax('cart', 'GetCart').done(function(data){
				$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.products));
			});
		});
	});

	$('.checkout').on('click', function(e){
		$('#cart').find('no_items').addClass('hidden');
	});

	/*Отмена заказа*/
	$('#cnclOrderBtnMod').on('click', function(e){
		ajax('order', 'CancelOrder', {id_order: id_order}).done(function(data){
			if(data === true){
				closeObject('confirmCnclOrder');
				$('.canceledOrder').find('.status').html(statuses[5]);
				$('.editing').find('li.canceledOrder').find('.cnslOrderBtn').addClass('hidden');
				$('.editing').find('li.canceledOrder').find('.delOrderBtn').removeClass('hidden');
			}
		});
	});

	$('#delOrderBtnMod').on('click', function(e){
		ajax('order', 'DeleteOrder', {id_order: id_order}).done(function(data){
			if(data === true){
				closeObject('confirmDelOrder');
				$('.orders_list').find('.deletedOrder').remove();
			};
		});
	});
	$('.prod_load_js').click(function(event) {
		var cart_id = $(this).data('cartid'),
			rewrite = $(this).data('rewrite');
		GetCabProdAjax(cart_id, rewrite);
	});
});
</script>