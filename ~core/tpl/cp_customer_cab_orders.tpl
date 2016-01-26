<div class="customer_cab">
	<div class="msg-info">
		<p>Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
	</div>
	<div id="orders_history">
		<form action=""method="GET">
			<ul id="nav">
				<li>
					<button name="t" value="all" class="all <?=(!isset($_GET['t']) || $_GET['t']=='all')?'active':null;?>">
						Все
					</button>
				</li>
				<li>
					<button name="t" value="working" class="working <?=(isset($_GET['t']) && $_GET['t']=='working')?'active':null;?>">
						Выполняются
					</button>
				</li>
				<li>
					<button name="t" value="completed" class="completed <?=(isset($_GET['t']) && $_GET['t']=='completed')?'active':null;?>">
						Выполенные
					</button>
				</li>
				<li>
					<button name="t" value="canceled" class="canceled <?=(isset($_GET['t']) && $_GET['t']=='canceled')?'active':null;?>">
						Отмененные
					</button>
				</li>
				<li>
					<button name="t" value="drafts" class="drafts <?=(isset($_GET['t']) && $_GET['t']=='drafts')?'active':null;?>">
						Черновики
					</button>
				</li>
			</ul>
		</form>
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
					<?foreach ($orders as $i){
						if(in_array($i['id_order_status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){ ?>
							<li class="order clearfix col-lg-8 col-md-9 col-sm-12">
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
									<?if(in_array($i['id_order_status'], array(1,6))){ ?>
										working
									<?}elseif($i['id_order_status'] == 2){ ?>
										completed
									<?}elseif($i['id_order_status'] == 3){ ?>
										drafts
									<?}elseif(in_array($i['id_order_status'], array(4,5))){ ?>
										canceled
									<?}?>
									">
										<p><?=$order_statuses[$i['id_order_status']]['name']?></p>
									</div>
									<div class="controls fright">
										<form action="<?=_base_url?>/cart/<?=$i['id_order']?>" method="post" class="fleft">
											<button type="submit" class="remake_order btn-m-green open_modal" data-target="order_remake_js">Повторить заказ</button>
										</form>
										<?if($i['id_order_status'] == 1){ ?>
											<!-- <form action="<?=$GLOBALS['URL_request']?>" method="post">
												<input type="hidden" name="id_order" value="<?=$i['id_order']?>"/>
												<input type="submit" name="smb_cancel" class="cancel_order btn-m btn-red-inv" value="Отменить">
											</form> -->
										<?}elseif($i['id_order_status'] != 6 && $i['id_order_status'] != 1){ ?>
											<form action="<?=$GLOBALS['URL_request']?>" method="post" class="fright">
												<button type="submit" name="smb_off" class="btn-m-red-inv">Удалить</button>
												<input type="hidden" name="id_order" value="<?=$i['id_order']?>">
											</form>
										<?}?>
									</div>
								</div>
							</li>
						<?}?>
					<?}?>
				</ul>
			<?}else{ ?>
				<p class="no_orders">У Вас нету ни одного заказа</p>
			<?}?>
		</div>
		<!-- ORDER REMAKE MODAL FORM -->
		<div id="order_remake_js" class="modal_hidden">
			<form action="<?=_base_url?>/cart/" method="post" class="order_remake">
				<p><b>Добавить</b> товары из данного заказа к товарам из текущей корзины или <b>заменить</b> содержимое корзины содержимым данного заказа?</p>
				<button type="submit" name="add_order" class="btn-m-green fleft">Добавить к корзине</button>
				<button type="submit" name="remake_order" class="btn-m-green fright">Заменить корзину</button>
			</form>
		</div>

	</div><!--class="history"-->
</div><!--class="cabinet"-->