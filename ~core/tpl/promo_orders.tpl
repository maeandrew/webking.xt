<div class="cabinet row" id="supplier_cab">
	<div class="col-md-12">
		<div class="msg-info">
			<p>Раздел сайта на реконструкции. Попробуйте зайти позже.</p>
		</div>
	</div>
	<!-- <div class="promo_orders_table hidden">
		<div class="header">
			<div class="row">
				<div>№</div>
				<div class="creation_date">Дата создания</div>
				<div class="name">Контактное лицо</div>
				<div class="phones">Конт. телефон</div>
				<div class="sum">Сумма заказа</div>
				<div class="comment">Дополнительная информация</div>
				<div class="invoice"></div>
			</div>
		</div>
		<div class="body">
			<?$i = 0;
			if(!empty($orders)){
				foreach($orders as $o){
					$i++;?>
					<div class="row" <?=$i%2==0?'style="background:#eee"':null;?>>
						<div><?=$i?></div>
						<div class="creation_date">
						<?if(date("d.m.Y", $o['creation_date']) == date("d.m.Y")){
							echo "Сегодня в ".date("H:i", $o['creation_date']);
						}elseif(date("d.m.Y", strtotime('-1 day', time())) == date("d.m.Y", $o['creation_date'])) {
							echo "Вчера в ".date("H:i", $o['creation_date']);
						}else{
							echo date("d.m.Y H:i", $o['creation_date']);
						}?>
						</div>
						<div class="name"><?=$o['cont_person']?></div>
						<div class="phones"><?=$o['phones']?></div>
						<div class="sum"><?=number_format($o['sum_discount'], 2, ",", "")?> грн.</div>
						<div class="comment"><?=$o['descr']?></div>
						<div class="invoice"><a href="<?=$GLOBALS['URL_base']?>invoice_supplier/<?=$o['id_order']?>/<?=$_SESSION['member']['id_user']?>/<?=$o['skey']?>" target="_blank">Накладная</a></div>
					</div>
					<?
				}
			}else{?>
				<div class="row">
					<div class="promo_code" style="max-width: 100%;">Нету ни одного заказа</div>
				</div>
			<?}?>
		</div>
	</div> -->
</div>