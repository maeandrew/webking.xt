<p style="display: none;">Расшифровка основных поставщиков и контроль загрузки</p>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Сборочная накладная</title>
<style>
body,div,dl,dt,dd,ul,ol,li,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td { margin: 0; padding: 0; border: 0; outline: 0; font-size: 100%; vertical-align: baseline; position: relative;}
:focus {
	outline: 0;
}
html {
	background: #868686;
}
body {
	width: 877px;
	margin: 0 auto;
	padding: 0 15px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #444;
	background: #fff;
	-webkit-box-shadow: 0 0 6px rgba(0,0,0,.5);
	box-shadow: 0 0 6px rgba(0,0,0,.5);
}
.logo {
	font-size: 28px;
	color: #00F;
	font-weight: bold;
}
.undln {
	text-decoration: underline;
}
.lb {
	border-left: 1px dashed #000;
	padding-left: 5px;
}
.table_header {
	clear: both;
	margin: 0 auto;
	width: 877px;
}
.table_header .top td {
	padding: 10px 0 15px 0;
	font-size: 14px;
}
.table_header .first_col { width: 150px; }
.table_header .second_col { width: 300px; }
.table_header .top span.invoice {
	margin-left: 20px;
	font-size: 18px;
	text-decoration: underline;
}
.bl { border-left: 1px solid #000; }
.br { border-right: 1px solid #000; }
.bt { border-top: 1px solid #000; }
.bb { border-bottom: 1px solid #000 !important; }
.bn { border: none !important; }
.bla { text-align: left; }
.bnb { border-bottom: none !important; }
.blf { border-left: 1px solid #FFF; }
.brf { border-right: 1px solid #FFF; }
.bbf { border-bottom: 1px solid #FFF; }
.table_main {
	margin: 10px 0;
	clear: both;
	border-collapse: collapse;
}
.table_main td {
	text-align: center;
	border-right: 1px #000 solid;
	border-bottom: 1px #000 solid;
	vertical-align: middle;
	font-size: 14px;
	font-weight: normal;
	line-height: 25px;
	padding: 0 5px;
}
.table_main th {
	text-align: center;
	border-right: 1px #000 solid;
	border-bottom: 1px #000 solid;
	vertical-align: middle;
	font-weight: lighter;
}
.table_main td.name {
	text-align: left;
	border-right: 1px #000 solid;
	border-bottom: 1px solid #000;
}
.table_main .hdr th,
.table_main .hdr td {
	font-weight: normal;
	font-size: 13px;
	line-height: 20px;
	height: 20px;
}
.table_main .hdr1 td {
	text-align: left;
}
.table_main td.postname {
	text-align: left;
}
.table_main .main td {
	height: 50px;
	font-size: 17px;
	font-weight: normal;
}
.table_main .main td.img {
	width: 56px;
}
.table_sum {
	margin: 10px 0 0 1px;
}
.table_sum td {
	font-size: 13px;
	text-align: center;
	vertical-align: middle;
}
.table_sum td.name {
	font-size: 13px;
	text-align: left;
}
tr.min td {
	height: 1px;
	font-size: 1px;
	line-height: 1px;
	margin: 0;
	padding: 0;
}
.adate {
	font-size: 11px;
	margin-left: 177px;
}
.note_red {
	color: #f00;
	font-size: 16px;
	font-weight: normal;
}
.note_grin {
	color: #f00;
	font-size: 22px;
	font-weight: normal;
}
.break {
	page-break-before: always;
}
.break_after {
	page-break-after: always;
}
.dash {
	border-bottom: 2px #f00 dashed;
	margin-bottom: 10px;
}
@media print {
	html {
		background: transparent;
	}
	body {
		padding: 0;
		-webkit-box-shadow: none;
		box-shadow: none;
	}
	form#send_mail {
		display: none;
	}
}
.filial_icon {
	z-index: 1;
	position: absolute;
	right: 5px;
	bottom: 5px;
	background-repeat: no-repeat;
	height: 30px;
	width: 65px;
}
.filial2 {
	background: url("../../images/odessa_filial.png");
	background-size: 65px 30px;
	background-repeat: no-repeat;
}
.balance { font-size: 17px; }
.balance span { font-weight: bold; }
.balance.plus span { color: #080; }
.balance.minus span { color: #f00; }
.clear { clear: both; }
.orders_block {
	float: left;
	padding: 5px;
	color: #aaa;
	font-size: 12px;
	font-weight: normal;
	border-right: 1px solid #eee;
	width: auto;
	box-sizing: border-box;
}
.pickers {
	display: block;
	margin: 10px 0;
	width: 100%;
	list-style: none;
}
.pickers li {
	position: relative;
	display: block;
	float: left;
	margin: 0 8px;
	border: 1px solid #888;
	border-radius: 4px;
	overflow: hidden;
}
.pickers li:after {
	content: '';
	display: block;
	position: absolute;
	top: 0;
	right: 0;
	width: 15px;
	height: 15px;
	background: #fff;
	border-radius: 0 0 0 100%;
}
.pickers li img {
	max-height: 60px;
}
</style>
</head>
<body>
	<?$colors = array('FFFFFF', 'E50000', 'FF0000', 'FF3232', 'FF4C4C', 'FF7F7F', 'FF9999', 'E59400', 'FFA500', 'FFB732', 'FFC966', 'FFDB99', 'F3F300', 'FEFE32', 'FFFF66', 'FFFF99', '00CC00', '00E500', '00EF00', '33FF33', '66FF66', '99FF99', '00CCCC', '00E5E5', '32EFFF', '00FFFF', '7FFEFE', '1F1FFF', '3232FF', '6666FF', '9999FF', 'C400AB');?>
	<form action="" method="POST" id="send_mail" style="float: right; position: fixed; z-index: 1000; right: 10px; top: 10px;">
		<button name="send_mail">Отправить письма поставщикам</button>
	</form>
	<div style="padding-bottom: 15px; margin: 15px 0; border-bottom: 2px dashed #f00;">
		<table class="table_header">
			<tr class="top">
				<td>
					<span class="invoice">Сборочная накладная от <?=date("d.m.Y",time())?></span>
				</td>
			</tr>
		</table>
		<table class="table_main" cellspacing="0" style="display: none; float: left; width: 627px;" >
			<thead>
				<tr class="hdr">
					<th class="bl bt">№</th>
					<th class="bt">Арт</th>
					<th class="bt">поставщик, телефон, площадка, контейнер</th>
					<th class="bt">Заказов</th>
					<th class="bt">Сумма,<br>грн</th>
					<th class="bt">Оплачено,<br>грн</th>
					<th class="bt">Объём</th>
					<th class="bt">Вес</th>
				</tr>
			</thead>
			<tbody>
				<?$sum_order = 0;
				$sweight = 0;
				$svolume = 0;
				$ii = 1;
				foreach($suppliers as $s){?>
					<tr>
						<td class="bl" style="height: 30px;"><?=$ii++?></td>
						<td><?=$s['art']?></td>
						<td class="postname"><?=$s['name']?>, <?=$s['phone']?>, <?=$s['place']?></td>
						<td><?=$s['num_orders']?></td>
						<td class="note_red"><?=(isset($_GET['no_prices']) == false)?number_format($s['sum_otpusk'],2,",",""):null;?></td>
						<?$sum_order+=$s['sum_otpusk']?>
						<td>&nbsp;</td>
						<td><p style="color: #f00;"><?=$s['sweight']?></p></td>
						<td><p style="color: #444;"><?=$s['svolume']?></p></td>
						<?$svolume += $s['sweight'];$sweight += $s['svolume']?>
					</tr>
				<?}?>
				<tr>
					<td class="bnb" style="height: 30px;" colspan="4">&nbsp;</td>
					<td class="br bb "><?=number_format($sum_order, 2 , ",", "");?></td>
					<td class="bnb" style="width: 80px"></td>
					<td class="br bb"><p style="color: #f00;"><?=$svolume?></p></td>
					<td><p style="color: #444;"><?=$sweight?></p></td>
				</tr>
			</tbody>
		</table>
		<table class="table_main" cellspacing="0" style="clear: none; float: left;">
			<thead>
				<tr class="hdr" style="height: 25px;">
					<th class="bl bt">№</th>
					<th class="bt">Менеджер</th>
					<th class="bt">Заказов</th>
					<th class="bt">Список</th>
					<th class="bt">Сумма</th>
				</tr>
			</thead>
			<tbody>
				<?$i = 1;
				$sum_orders = 0;
				$ordercnt = 0;
				foreach($contragents as $manager){
					if(count($manager['orders']) > 0){
						$sum_order = 0;?>
						<tr>
							<td style="padding: 0 5px; width: 21px;" class="bl"><?=$i?></td>
							<td style="width: 70px;">
								<p style="padding: 0 5px; text-align: left; min-width: 150px; line-height: 30px;"><?=$manager['name'];?></p>
							</td>
							<td style="width: 60px;">
								<?=count($manager['orders']);
								$ordercnt += count($manager['orders']);?>
							</td>
							<td style="max-width: 540px;">
								<?foreach($manager['orders'] as $order){?>
									<div class="orders_block"><?=$order?></div>
									<?foreach($orders[$order]['invoice_data'] as $d){
										if($d['opt_qty'] > 0 && (isset($type) || $d['contragent_qty'] <= 0) && substr_count($d['note_opt'], 'Отмена#') == 0){
											$sum_order += round((round($d['price_opt_otpusk']*$d['opt_qty'], 2)),2);
										}
										if($d['mopt_qty']>0 && (isset($type) || $d['contragent_mqty'] <= 0) && substr_count($d['note_mopt'], 'Отмена#') == 0){
											$sum_order += round((round($d['price_mopt_otpusk']*$d['mopt_qty'], 2)),2);
										}
									}
									?>
								<?}?>
							</td>
							<td style="width: 80px;"><?=(isset($_GET['no_prices']) == false)?number_format($sum_order, 2, ",", ""):null;?></td>
							<?$sum_orders += $sum_order;?>
						</tr>
						<?$i++;
					}
				}
				if(isset($_GET['no_prices']) == false){?>
					<tr>
						<td class="bn"></td>
						<td class="bnb" style="text-align: right; padding: 0 5px;">Всего:</td>
						<td><?=$ordercnt;?></td>
						<td class="bnb" style="text-align: right; padding: 0 5px;">Итого:</td>
						<td><?=(isset($_GET['no_prices']) == false)?number_format($sum_orders, 2, ",", ""):null;?></td>
					</tr>
				<?}?>
			</tbody>
		</table>
	<div style="clear: both;"></div>
	</div>
	<?
	$c1 = 30;
	$c2 = 40;
	$c3 = '*';
	$c4 = 80;
	$c5 = 80;
	$c6 = 80;
	$c7 = 27;
	$c8 = 60;
	$c9 = 60;
	$c10 = 80;
	$supii =1;
	$aaaaaaa = '';
	foreach($suppliers as $id_supplier=>$supplier){
		$pickers = explode(';', $supplier['pickers']);
		if(!empty($supplier['orders'])){?>
			<div style="width: 877px; padding: 15px 0; margin: 15px 0; border-bottom: 2px dashed #f00; page-break-before: always;">
				<div class="logo" style="font-size: 30px; font-weight: bold; position: absolute; top: 0; left: 0; padding: 10px;"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></div>
				<div style="font-size: 30px; font-weight: bold; position: absolute; top: 0; right: 0; padding: 10px; line-height: 24px;">
					<span style="float: right; clear: both;"><?=$supplier['art']?></span>
					<span style="font-size: 25px; float: right; clear: both;"><?=$supplier['area']?></span>
					<?if($supplier['inusd'] > 0 && isset($supplier['currency_rate']) && is_numeric($supplier['currency_rate'])){?>
						<!-- <span style="font-size: 23px; float: right; clear: both;">$1 = <?=number_format($supplier['currency_rate'], 2, ",", "");?>грн.</span> -->
					<?}?>
				</div>
				<h1 style="text-align: center; margin: 0 auto 15px; width: 60%;">Чек от <?=isset($_GET['date']) && $_GET['date'] != ''?date("d.m.Y", strtotime($_GET['date'])):date("d.m.Y",time());?></h1>
				<p class="note_red" style="text-align: center; line-height: 15px; width: 60%; margin: 0 auto;">Чек остается у партнера до момента получения денег.</p>
				<div style="clear: both; float:left; margin: 10px; font-size: 14px; width: 380px; padding-left: 10px;"><?=$supplier['name']?>, <?=$supplier['place']?></div>
				<div style="float:left; margin: 10px; white-space: normal; width: 433px; padding-left: 10px; font-size: 19px;" class="bl">
					<p><?=$supplier['phone']?><br><?=$contragent['descr']?></p>
				</div>
				<table style="width: 50%; clear: both; float: left; margin: 0;" class="table_main">
					<thead>
						<tr class="hdr">
							<th class="bl bt">№ заказов</th>
							<th class="bt">Сумма, грн.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="bl" style="width: 55%; font-size: 11px; line-height: 13px; height: 66px;">
								<?$otpusk = 0;
								$kotpusk = 0;
								foreach($sorders[$id_supplier] as $order){
									if(isset($order['order_num'])){?>
										<?=mb_substr($order['order_num'], 0, strlen($order['order_num']-strrpos($order['order_num'], '-')))?>
										<?$otpusk += $order['order_otpusk'];?>
									<?}
								}?>
							</td>
							<td class="note_red" style="width: 20%;"><?=number_format($otpusk, 2, ",", "");?></td>
						</tr>
					</tbody>
				</table>
				<div class="balance <?=$supplier['example_sum'] < 0?'minus':'plus';?>" style="float: right; font-size: 13px; margin-left: 2%; width: 48%;">Сумма возврата: <span><?if(isset($supplier['example_sum']) && is_numeric($supplier['example_sum'])){?><?=number_format($supplier['example_sum'], 2, ",", "");?><?}else{?>0,00<?}?> грн.</span></div>
				<div class="balance <?=$supplier['balance'] < 0?'minus':'plus';?>" style="float: right; font-size: 13px; margin-left: 2%; width: 48%;">Текущий баланс: <span><?if(isset($supplier['balance']) && is_numeric($supplier['balance'])){?><?=number_format($supplier['balance'], 2, ",", "");?><?}else{?>0,00<?}?> грн.</span></div>
				<?if($supplier['pickers'] != ''){?>
					<h3 style="float: right; margin: 5px 0; margin-left: 2%; width: 48%;">Доверенность на получение товара.</h3>
					<ul class="pickers" style="float: right; margin-left: 2%; width: 48%;">
						<?foreach($pickers as $key=>$value){
							if(trim($value) != ''){?>
								<li>
									<img heaight="60" width="auto" src="<?=_base_url.'/efiles/pickers/'.trim($value).'.jpg'?>" alt="Закупщик <?=trim($value)?>"/>
								</li>
							<?}
						}?>
					</ul>
				<?}?>
				<div class="clear">
					<div style="margin-left: 10%; margin-top: 10px; float: left;">Товар принял: _____________________</div>
					<div style="margin-right: 10%;  margin-top: 10px; float: right;">Оплатил: ____________________</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>

			<div style="width: 877px; display: block; padding: 15px 0 ;">
				<div class="logo" style="font-size: 30px; font-weight: bold; position: absolute; top: 0; left: 0; padding: 10px;"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></div>
				<div style="font-size: 30px; font-weight: bold; position: absolute; top: 0; right: 0; padding: 10px; line-height: 24px;">
					<span style="float: right; clear: both;"><?=$supplier['art']?></span>
					<span style="font-size: 25px; float: right; clear: both;"><?=$supplier['area']?></span>
					<?if($supplier['inusd'] > 0 && isset($supplier['currency_rate']) && is_numeric($supplier['currency_rate'])){?>
						<!-- <span style="font-size: 23px; float: right; clear: both;">$1 = <?=number_format($supplier['currency_rate'], 2, ",", "");?>грн.</span> -->
					<?}?>
				</div>
				<h1 style="text-align: center; margin: 0 auto 15px; width: 60%">Сборочная накладная от <?=isset($_GET['date']) && $_GET['date'] != ''?date("d.m.Y", strtotime($_GET['date'])):date("d.m.Y",time());?></h1>
			</div>
			<div style="clear: both; float:left; margin: 10px; font-size: 14px; width: 380px; padding-left: 10px;"><?=$supplier['name']?>, <?=$supplier['place']?></div>
			<div style="float:left; margin: 10px; white-space: normal; width: 433px; padding-left: 10px; font-size: 19px;" class="bl">
				<p><?=$supplier['phone']?><br><?=$contragent['descr']?></p>
			</div>
			<div class="clear"></div>
			<?if(isset($_GET['no_prices']) == false){?>
				<table style="width: 380px; clear: both; float: left; margin: 0 10px 0 0;" class="table_main">
					<thead>
						<tr class="hdr">
							<th class="bl bt">№ заказа</th>
							<th class="bt">Сумма по отп. ценам, грн.</th>
						</tr>
					</thead>
					<tbody>
						<?$otpusk=0;$kotpusk=0;
						foreach($sorders[$id_supplier] as $order){
							if(isset($order['order_num'])){?>
								<tr>
									<td class="bl"><?=$order['order_num']?></td>
									<td class="note_red"><?=number_format($order['order_otpusk'], 2, ",", "");?></td>
									<?$otpusk += $order['order_otpusk'];?>
								</tr>
							<?}
						}?>
						<tr>
							<td class="bnb" style="text-align: right;">Сумма</td>
							<td class="note_red"><?=number_format($otpusk, 2, ",", "");?></td>
						</tr>
					</tbody>
				</table>
				<div class="balance <?=$supplier['example_sum'] < 0?'minus':'plus';?>" style="float: right; font-size: 13px; margin-left: 20px; width: 50%;">Сумма возврата: <span><?if(isset($supplier['example_sum']) && is_numeric($supplier['example_sum'])){?><?=number_format($supplier['example_sum'], 2, ",", "");?><?}else{?>0,00<?}?> грн.</span></div>
				<div class="balance <?=$supplier['balance'] < 0?'minus':'plus';?>" style="float: right; font-size: 13px; margin-left: 20px; width: 50%;">Текущий баланс: <span><?if(isset($supplier['balance']) && is_numeric($supplier['balance'])){?><?=number_format($supplier['balance'], 2, ",", "");?><?}else{?>0,00<?}?> грн.</span></div>
				<?if($supplier['pickers'] != ''){?>
					<h3 style="float: right; margin: 5px 0; margin-left: 20px; width: 50%;">Доверенность на получение товара.</h3>
					<ul class="pickers" style="float: right; width: 50%;">
						<?foreach($pickers as $key=>$value){
							if(trim($value) != ''){?>
								<li>
									<img heaight="60" width="auto" src="<?=_base_url.'/efiles/pickers/'.trim($value).'.jpg'?>" alt="Закупщик <?=trim($value)?>"/>
								</li>
							<?}
						}?>
					</ul>
				<?}?>
				<h1 style="clear: both;float: left; color: #000000; font-size: 25px; text-align: center; width: 877px; margin-top: 10px; border: 3px solid #<?=$colors[date('j')];?>;"><?=$supplier['personal_message']?></h1>
			<?}
			$c1 = 20;
			$c2 = 60;
			$c3 = 96;
			$c4 = 350;
			$c5 = 70;
			$c6 = 70;
			$c7 = 60;
			$c8 = 90;
			$c9 = 60;
			$c10 = 40;
			$c11 = 40;
			?>
			<?foreach($supplier['orders'] as $order_key=>$order){?>
				<br>
				<table class="table_main" cellspacing="0">
					<col width="<?=$c1?>;"/>
					<col width="<?=$c2?>;"/>
					<col width="<?=$c3?>;"/>
					<col width="<?=$c4?>;"/>
					<col width="<?=$c5?>;"/>
					<col width="<?=$c6?>;"/>
					<col width="<?=$c7?>;"/>
					<col width="<?=$c8?>;"/>
					<col width="<?=$c9?>;"/>
					<thead>
						<tr>
							<th colspan="9" style="border: 0;">
								<p style="font-size: 20px; font-weight: bold; width: 100%; text-align: center">
									№ &nbsp;<?=$sorders[$id_supplier][$order_key]['order_num']?> - <b style="font-size:16px; color:Red"><?=$orders[$order_key]['note2']?></b>
								</p>
							</th>
						</tr>
						<tr class="hdr">
							<th class="bl bt">№</th>
							<th class="bt">Арт</th>
							<th class="bt">Фото</th>
							<th class="bt">Название</th>
							<th class="bt">Цена ед.,<br/>грн.</th>
							<th class="bt">Заказано, ед.</th>
							<th class="bt">Факт</th>
							<th class="bt">Сумма,<br/>грн.</th>
							<th class="bt">Альт.</th>
						</tr>
					</thead>
					<tbody>
						<?$ii=1;
						$sum=0;
						$qty=0;
						$weight=0;
						$volume=0;
						$sum_otpusk=0;
						foreach($order as $i){
							if($i['opt_qty'] > 0 && $i['id_supplier'] == $id_supplier && (isset($type) || $i['contragent_qty'] <= 0) && substr_count($i['note_opt'], 'Отмена#') == 0){?>
								<tr class="main">
									<td class="bl c1"><?=$ii++?></td>
									<td class="c2"><?=$i['art']?></td>
									<td class="c3" style="padding: 0;">
										<?if($i['image'] != ''){?>
											<img height="96" width="96" src="<?=file_exists($GLOBALS['PATH_root'].str_replace("/original/", "/medium/", $i['image']))?_base_url.htmlspecialchars(str_replace("/original/", "/medium/", $i['image'])):'/efiles/_thumb/nofoto.jpg'?>">
										<?}else{?>
											<img height="96" width="96" src="<?=_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1']))?>" />
										<?}?>
									</td>
									<td class="name c4">
										<?if($i['note_opt']!=''){?>
											<span class="note_red" style="font-size: 16px;"><?=$i['note_opt']?></span><br>
										<?}
										echo $i['name'];?>
									</td>
									<td class="c5">
										<?if(!$suppliers[$id_supplier]['is_partner'] && isset($_GET['no_prices']) == false){
											echo number_format($i['price_opt_otpusk'], 2, ",", "");
										}?>
									</td>
									<td class="c6"><?=$i['opt_qty']?></td>
									<?$qty += $i['opt_qty']?>
									<td class="c7"></td>
									<td class="c8">
										<?if(!$suppliers[$id_supplier]['is_partner'] && isset($_GET['no_prices']) == false){?>
											<?=number_format($i['price_opt_otpusk']*$i['opt_qty'], 2, ",", "");?>
											<?$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);?>
										<?}?>
									</td>
									<td class="c9"><?=$i['article_altern']?></td>
									<?$volume += $i['volume']*$i['opt_qty'];?>
									<?$weight += $i['weight']*$i['opt_qty'];?>
								</tr>
							<?}?>
							<?if($i['mopt_qty'] > 0 && $i['id_supplier_mopt'] == $id_supplier && (isset($type) || $i['contragent_mqty'] <= 0) && substr_count($i['note_mopt'], 'Отмена#') == 0){?>
								<tr class="main">
									<td class="bl c1"><?=$ii++?></td>
									<td class="c2"><?=$i['art']?></td>
									<td class="c3" style="padding: 0;">
										<?if($i['image'] != ''){?>
											<img height="96" width="96" src="<?=file_exists($GLOBALS['PATH_root'].str_replace("/original/", "/medium/", $i['image']))?_base_url.htmlspecialchars(str_replace("/original/", "/medium/", $i['image'])):'/efiles/_thumb/nofoto.jpg'?>">
										<?}else{?>
											<img height="96" width="96" src="<?=_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1']))?>" />
										<?}?>
									</td>
									<td class="name c4">
										<?if($i['note_mopt']!=''){?>
											<span class="note_red" style="font-size: 16pt;"><?=$i['note_mopt']?></span><br>
										<?}
										echo $i['name'];?>
									</td>
									<td class="c5">
										<?if(!$suppliers[$id_supplier]['is_partner'] && isset($_GET['no_prices']) == false){
											echo number_format($i['price_mopt_otpusk'], 2, ",", "");
										}?>
									</td>
									<td class="c6"><?=$i['mopt_qty']?></td>
									<?$qty += $i['mopt_qty']?>
									<td class="c7"></td>
									<td class="c8">
										<?if(!$suppliers[$id_supplier]['is_partner'] && isset($_GET['no_prices']) == false){?>
											<?=number_format($i['price_mopt_otpusk']*$i['mopt_qty'], 2, ",", "");?>
											<?$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)), 2);?>
										<?}?>
									</td>
									<?$sum = round($sum+$i['mopt_sum'],2)?>
									<td class="c9"><?=$i['article_mopt_altern']?></td>
									<?$volume += $i['volume']*$i['mopt_qty'];?>
									<?$weight += $i['weight']*$i['mopt_qty'];?>
								</tr>
							<?}
						}
						if(isset($_GET['no_prices']) == false){?>
							<tr class="table_sum">
								<td class="bn" colspan="6"></td>
								<td class="br bnb" style="text-align:right">Сумма:</td>
								<td class="br bb">
									<?if(!$suppliers[$id_supplier]['is_partner'] && isset($_GET['no_prices']) == false){?>
										<div class="note_red"><?=number_format($sum_otpusk, 2, ",", "");?></div>
									<?}?>
								</td>
								<td colspan="3" class="bn"></td>
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>
		<?}
	}?>
</body>
</html>
