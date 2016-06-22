<script>
	//$(function() {
	 //   var order_cookie = $.cookie('id_order');
	 //   var order =  '{id_order: order_cookie }';
	  //  ajax('cart', 'add_status_cart').done(function (arr) {
	  //      console.log(arr);
	   // });
  //  });
</script>
<div class="cabinet_content customer_cab customer_cab_cooperative">
	<!-- <div class="msg-info">
		<p>Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или
			частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
	</div> -->
	<div id="orders_history">
		<!-- <?!isset($_GET['t'])?$_GET['t']='joactive':null;?> -->
		<div class="<?switch ($_GET['t']){
			case 'joactive':
				$s[] = 10;
				$s[] = 20;
				?>joactive<?
			break;
			case 'jocompleted':
				$s[] = 11;
				$s[] = 21;
				?>jocompleted<?
			break;
		}?> editing">

		<?if(isset($infoJO)){ ?>
			<ul class="orders_list">
				<?if(in_array($infoJO['status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'joactive') || !isset($_GET['t'])) {?>
					<li>
						<section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect ">
							<div class="title">
								<div class="container">
									<span class="number num_mar">Совместная корзина № <?=$infoJO['id_cart']?></span>
									<?if (isset($_GET['t']) && $_GET['t'] == 'joactive') {?>
										<span class="number">Актуальность информации в корзине на <?=date("Y-m-d H:i:s")?></span>
										<i class="material-icons refresh refresh_js">refresh</i>
									<?}?>
									<div class="print">
										<div class="icon mdl-button mdl-js-button mdl-button--icon" id="menu-lower_<?=$infoJO['id_cart']?>">
											<img src="<?=_base_url?>/themes/default/img/print1.png">
										</div>
										<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-lower_<?=$infoJO['id_cart']?>" style="min-width:160px; !important">
											<li class="mdl-menu__item">
												<a href="/invoice_customer/<?=$infoJO['id_order']?>/<?=$infoJO['skey']?>/?nophoto=true" style="color: #9E9E9E;">
													<svg class="icon" id="tt1" style="margin-right:5px;margin-top:-5px;"><use xlink:href="#XLS"></use></svg><span>Распечатать в XSL</span>
												</a>
											</li>
											<li class="mdl-menu__item">
												<a href="/invoice_customer/<?=$infoJO['id_order']?>/<?=$infoJO['skey']?>/?nophoto=true" style="color: #9E9E9E;"><svg class="icon" id="tt2" style="margin-right:5px;margin-top:-5px;"><use xlink:href="#txt"></use></svg>Для реализатора</a>
											</li>
											<li class="mdl-menu__item">
												<a href="/invoice_customer/<?=$infoJO['id_order']?>/<?=$infoJO['skey']?>" style="color: #9E9E9E;"><svg class="icon" id="tt3" style="margin-right:5px;margin-top:-5px;"><use xlink:href="#img"></use></svg>С картинками</a>
											</li>
											<li class="mdl-menu__item">
												<a href="/invoice_customer/<?=$infoJO['id_order']?>/<?=$infoJO['skey']?>/?nophoto=true" style="color: #9E9E9E;"><svg class="icon" id="tt4" style="margin-right:5px;margin-top:-5px;"><use xlink:href="#paper"></use></svg>Документом</a>
											</li>
										</ul>
									</div>
									<div class="status number">Активный</div> <!--  <?=$order_statuses[$infoJO['id_order_status']]['name']?> -->
								</div>
								<div class="tabs mdl-tabs__tab-bar">
									<a href="#details_panel_<?=$infoJO['id_cart']?>" class="mdl-tabs__tab is-active">Детали</a>
									<?=isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 1? '<a href="#participants_panel" class="mdl-tabs__tab">Участники</a>': null;?>
								<!-- 	<a href="#items_panel_<?=$infoJO['id_cart']?>" class="mdl-tabs__tab <?=isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 0?'getCabCoopProdAjax_js':null;?>" data-idcart="<?=$_SESSION['cart']['id']?>">Список товаров</a> -->

								<a href="#items_panel_<?=$infoJO['id_cart']?>" class="mdl-tabs__tab <?=isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 0?'getCabCoopProdAjax_js':null;?>" data-idcart="<?=$_SESSION['cart']['id']?>" data-rewrite="<?=isset($GLOBALS['Rewrite'])?$GLOBALS['Rewrite']:'';?>">Список товаров</a>
								</div>
							</div>
							<div class="content">
								<div class="mdl-tabs__panel is-active" id="details_panel_<?=$infoJO['id_cart']?>">
									<div class="info">
										<div class="date">
											<span class="icon"><svg class="icon">
												<use xlink:href="#date"></use>
											</svg></span>
											<span class="label">Дата создания корзины</span>
											<span class="value"><?=date("d.m.Y", strtotime($infoJO['creation_date']))?></span>
										</div>
										<div class="count">
											<span class="icon">
												<i class="material-icons">people</i>
											</span>
											<span class="label">Участников</span>
											<span class="value"><?=$infoJO['count_carts']?> чел. </span>
										</div>
										<div class="sum">
											<span class="icon">
												<svg class="icon">
													<use xlink:href="#money"></use>
												</svg>
											</span>
											<span class="label">Сумма к оплате</span>
											<span class="value"><?=$infoJO['total_sum']?> грн.</span>
										</div>
										<div class="discount">
											<span class="icon">
												<svg class="icon">
													<use xlink:href="#shuffle"></use>
												</svg>
											</span>
											<span class="label">Скидка</span>
											<span class="value"><?=$infoJO['discount']?>%</span>
										</div>
									</div>
									<div class="additional">
										<div class="manager">
											<div class="label">Организатор заказа</div>
											<div class="avatar">
												<img src="http://lorempixel.com/fashion/70/70/" alt="avatar"/>
											</div>
											<div class="details">
												<div class="line_1"><? print_r($infoJO['adm_name'])?></div>
												<div class="line_2">телефон: <? print_r($infoJO['adm_phones'])?></div>
												<div class="line_2">email: <? print_r($infoJO['adm_email'])?></div>
												<!--<div class="line_3">
													<a href="#">
														<svg class="icon">
															<use xlink:href="#like"></use>
														</svg>
													</a>
													<a href="#">
														<svg class="icon">
															<use xlink:href="#dislike"></use>
														</svg>
													</a>
													<span class="votes_cnt">15686</span>
												</div>-->
											</div>
										</div>
										<div class="delivery">
											<div class="label">Способ доставки</div>
											<div class="details">
												<div class="line_1">
													<span class="label">ТТН:</span>
													<span class="value"> - </span>
												</div>
												<div class="line_2">
													<span class="label">Город:</span>
													<span class="value"><?//=$infoJO['city_info']['name']?></span>
												</div>
												<div class="line_3">
													<span class="label">Отделение:</span>
													<span class="value"><?//=$infoJO['city_info']['address']?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="mdl-tabs__panel" id="participants_panel">
									<div class="list_coop" id="list_coop">
										<div class="tableFlex tableTitle">
											<div class="tableAvatar">Фото</div>
											<div class="tableName">Имя</div>
											<div class="tablePhone">Номер телефона</div>
											<div class="tableEmail">Email</div>
											<div class="stat_user_cab for_tooltip">Статус</div>
											<div class="tableSum">Сумма</div>
											<div class="del_x"></div>
										</div>
										<?if (isset($infoJO['infoCarts']) && is_array($infoJO['infoCarts'])) : foreach($infoJO['infoCarts'] as $infoCart) :?>
											<div class="tableFlex tableRow">
												<input class="member_id_cart_js" type="hidden" data-cartid="<?=$_SESSION['cart']['id']?>" value="<?=$infoCart['id_cart']?>">

												<div class="tableAvatar img"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar"/></div>
												<div class="tableName"><?=$infoCart['name']?></div>
												<div class="tablePhone"><i class="material-icons">phone</i><?=$infoCart['phone']?></div>
												<div class="tableEmail"><i class="material-icons">email</i><?=$infoCart['email']?></div>
												<div class="stat_user_cab for_tooltip">
													<?if ($infoCart['adm'] == 1) {?>
														<i id="adm" class="material-icons cart_adm">star</i>
														<div class="mdl-tooltip" for="adm">Администратор<br>совместной покупки</div>
													<?}else{
														if($infoCart['ready']==0 && $infoCart['adm'] != 1){?>
															<i id="user_ntm_<?=$infoCart['id_cart']?>" class="material-icons user_intime">update</i>
															<div class="mdl-tooltip" for="user_ntm_<?=$infoCart['id_cart']?>">Не готов</div>
														<?}else if($infoCart['ready']==1 && $infoCart['adm'] != 1){?>
															<i id="user_rd_<?=$infoCart['id_cart']?>" class="material-icons user_ready">check_circle</i>
															<div class="mdl-tooltip" for="user_rd_<?=$infoCart['id_cart']?>">Готов</div>
														<?}
													}?>
												</div>
												<div class="tableSum"><img src="<?=_base_url.'/themes/default/img/hryvnia_sign.png'?>"><?=$infoCart['sum_cart']?></div>
												<div class="del_x">
													<?if ($infoCart['adm'] != 1) {?>
														<i id="del_<?=$infoCart['id_cart']?>" class="del_x_js material-icons">close</i><div class="mdl-tooltip" for="del_<?=$infoCart['id_cart']?>">Удалить участинка корзины</div>
													<?}?></div>
											</div>
										<?endforeach; endif;?>
										<?//print_r($i)?>
									</div>

									<div class="label">Промо-код для совместной корзины: <?=$infoCart['promo']?></div>

									<!-- <div id="block_promo">
										<div class="label">Промо-код для совместной корзины: <?=$infoCart['promo']?></div>
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
												<div>
												<tr>
													<td>
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
															<input class="mdl-textfield__input" type="text" id="sample1">
															<label class="mdl-textfield__label" for="sample1">Отправить на
																Email</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
															<input class="mdl-textfield__input" type="text" id="sample2">
															<label class="mdl-textfield__label" for="sample2">Отправить SMS
																на номер</label>
														</div>
													</td>
												</tr>
												</tbody>
											</form>
										</table>
									</div> -->
								</div>

								<div class="mdl-tabs__panel" id="items_panel_<?=$infoJO['id_cart']?>" >
									<div class="btnWrapFlex"><?if((isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 1) && (isset($_GET['t']) && $_GET['t'] == 'joactive')) {?>
											<input type="button" data-promo="<?=$infoCart['promo']?>" class="checkout_js mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" value="Оформить заказ" data-upgraded=",MaterialButton,MaterialRipple"/>
										<?}else if((isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 0) && (isset($_SESSION['cart']['ready']) && $_SESSION['cart']['ready'] == 0) && (isset($_GET['t']) && $_GET['t'] == 'joactive')){?>
											<input type="hidden" value="<?=$_SESSION['cart']['id']?>">
											<input type="button" class="readyToOrder_js mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" value="Готов" data-upgraded=",MaterialButton,MaterialRipple"/>
										<?}?>
									</div>
									<?if (isset($_SESSION['cart']['adm']) && $_SESSION['cart']['adm'] == 0) {?>
										<div class="products_cart_js"></div>
									<?}else{?>
										<div>
											<?=$prod_list[$infoJO['id_cart']];?>
											<ul class="sorders_list">
												<?//foreach ($infoCarts as $i){ if(in_array($i['status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){ ?>
												<?foreach ($infoJO['infoCarts'] as $i){ ?>
													<li class="id_cart_<?=$i['id_cart']?>">
														<section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
															<div class="title">
																<div class="container for_tooltip">
																	<a href="#" class="mdl-tabs__tab list_in_cart_js" data-cartid="<?=$i['id_cart']?>" data-rewrite="<?=isset($GLOBALS['Rewrite'])?$GLOBALS['Rewrite']:'';?>">
																		<span class="username"><?=$i['name']?></span></a>
																	<?if ($i['adm'] == 1) {?>
																		<i id="cart_adm" class="material-icons cart_adm">star</i>
																		<div class="mdl-tooltip" for="cart_adm">Администратор<br>совместной покупки</div>
																	<?}else{
																		if($i['ready']==0 && $i['adm'] != 1){?>
																			<i id="user_intime_<?=$i['id_cart']?>" class="material-icons user_intime">update</i>
																			<div class="mdl-tooltip" for="user_intime_<?=$i['id_cart']?>">Не готов</div>
																		<?}else if($i['ready']==1 && $i['adm'] != 1){?>
																			<i id="user_ready_<?=$i['id_cart']?>" class="material-icons user_ready">check_circle</i>
																			<div class="mdl-tooltip" for="user_ready_<?=$i['id_cart']?>">Готов</div>
																		<?}
																	}?>
																</div>
															</div>
															<div class="products_cart_js"></div>
														</section>
													</li>
												<?}?>
											</ul>
											<?//endif?>
											<!--<div class="over_sum">Итого: <?=$details['sum_prods']?> грн.</div>-->
										</div>
									<?}?>
								</div>
							</div>
						</section>
					</li>
				<?}?>
			</ul>
			<?}else{ ?>
				<p class="no_orders">У Вас нет ни одного заказа</p>
			<?}?>
		</div>
	</div><!--class="history"-->
</div><!--class="cabinet"-->

<div id="graph" data-type="modal">
	<div class="modal">
		<div class="modal_container">
			<h1 >Start</h1>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.refresh_js').click(function(event) {
			event.preventDefault();
			location.reload();
		});
		$('.del_x_js').click(function(event) {
			var obj = $(this);
			// console.log($(this).closest('tr').find('.member_id_cart_js').val() +' : '+ $(this).closest('tr').find('.member_id_cart_js').data('cartid'));
			// console.log($(this).closest('.tableRow').find('.member_id_cart_js').val());
			ajax('cabinet', 'DelCartFromJO', {id_cart: $(this).closest('.tableRow').find('.member_id_cart_js').val()}).done(function(event) {
				obj.closest('.tableRow').remove();
			}).fail(function(event) {
				console.log('Fail');
			});
		});
		$('.list_in_cart_js').click(function(event) {
			if ($(this).closest('li').find('.products_cart_js').html() == '') {
				$(this).addClass('active_link_to_cart_js');
				// console.log($(this).data('cartid'));
				GetCabCoopProdAjax($(this).data('cartid'), $(this).data('rewrite'));
			}else{
				$(this).removeClass('active_link_to_cart_js');
				if ($(this).closest('li').find('.products_cart_js').hasClass('hidden')) {
					$(this).closest('li').find('.products_cart_js').removeClass('hidden');
				}else{
					$(this).closest('li').find('.products_cart_js').addClass('hidden');
				}
			}
		});
		$('[href^="#items_panel_"').click(function(event) {
			if ($(this).hasClass('getCabCoopProdAjax_js')) {
				console.log($(this).data('idcart'));
				GetCabCoopProdAjax($(this).data('idcart'), $(this).data('rewrite'));
			}
		});

		$('body').on('click', '.checkout_js', function(event) {
			event.preventDefault();
			ajax('cabinet', 'MakeOrderJO', {promo: $(this).data('promo')}).done(function(data) {
				if (data.success == true) {
					console.log(data.msg);
				}else{
					console.log(data.msg);
				}

				console.log('success');
			}).fail(function(data) {
				console.log('Fail');
			});
		});

		$('[id^=items_panel_]').on('click', '.readyToOrder_js', function(event) {
			ajax('cart', 'ReadyUserJO', {id_cart: $(this).closest('div').find('[type="hidden"]').val()}).done(function(data){
				// console.log("success readyToOrder_js");
			}).fail(function(data) {
				console.log("fail ");
			});
		});
	});
</script>