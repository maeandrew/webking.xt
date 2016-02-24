<style>
   .colortext {
	color: #006400; /* Цвет текста - зеленый */
	font-size: 14pt
   }
   .colortext_red {
	color: #FF0000; /* Цвет текста-красный */
	font-size: 14pt
   }
</style>
<div id="terminal_cabinet" class="cabinet">
	<h1><?=$h1;?></h1>
	<div class="clear"></div>
	<div class="table-row header-row">
		<div class="table-column order-row color-white">№ заказа</div>
		<div class="table-column date-row color-white">Дата</div>
		<div class="table-column phone-row color-white">Телефон клиента</div>
		<div class="table-column sum-row color-white">Сумма</div>
		<div class="table-column invoice-row color-white">Накладная</div>
		<div class="table-column contragent-row color-white">Менеджер</div>
	</div>
	<?$ii = 1;
	foreach($orders as $o){?>
		<div class="table-row body-row <?=$ii%2 == 0?'zebra':null;?>">
			<div class="table-column order-row color-black"><?=$o['id_order'];?></div>
			<div class="table-column date-row color-black">
				<?if(date("d.m.Y", $o['creation_date']) == date("d.m.Y")){
					echo "Сегодня в ".date("H:i", $o['creation_date']);
				}elseif(date("d.m.Y", strtotime('-1 day', time())) == date("d.m.Y", $o['creation_date'])) {
					echo "Вчера в ".date("H:i", $o['creation_date']);
				}else{
					echo date("d.m.Y H:i", $o['creation_date']);
				}?>
			</div>
			<div class="table-column phone-row color-black"><?=isset($o['phones']) && $o['phones']!=''?substr_replace($o['phones'], '****', -6 , 4):null;?></div>
			<div class="table-column sum-row color-black"><?=number_format($o['sum'], 2, ",", "")?> грн.</div>
			<div class="table-column invoice-row color-black"><a target="_blank" href="<?=_base_url?>/invoice_anonim/<?=$o['id_order']?>/">Открыть накладную</a></div>
			<div class="table-column contragent-row color-black"><?=$o['contragent']?></div>
		</div>
		<?$ii++;
	}?>
</div>