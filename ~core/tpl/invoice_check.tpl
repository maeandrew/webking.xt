<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Проверочная накладная</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,
label,fieldset,img,input,textarea,p,blockquote,th,td {
margin: 0; padding: 0; border: 0; outline: 0; font-size: 100%; vertical-align: baseline; }
:focus { outline: 0 }
html,body { height: 100%; width: 800px; margin: 0 auto; }
body { font-family: "Helvetica", sans-serif; font-size: 12px; color: #333; }
h1 { font-size: 19px; }
.logo { font-size: 28px; color: #00F; font-weight: bold; }
.undln { text-decoration: underline; }
.lb { border-left: 1px dashed #000; padding-left: 5px; }
.table_header { width: 800px; page-break-before: always; }
.table_header:first-of-type { page-break-before: avoid; }
.table_header .top td { padding: 10px 0 15px 0; font-size: 14px; }
.table_header .first_col { width: 90px; }
.table_header .second_col { width: 325px; }
.table_header .top span.invoice { font-size:18px; font-weight: bold; display: block; text-align: center; }
.bl { border-left: 1px solid #000; }
.br { border-right: 1px solid #000; }
.bt { border-top: 1px solid #000; }
.bb { border-bottom: 1px solid #000 !important; }
.blf { border-left: 1px solid #FFF; }
.brf { border-right: 1px solid #FFF; }
.nb { border: 0 !important; }
.table_main { margin: 10px 0 0 1px; }
.table_main tr { page-break-inside: avoid; font-size: 17px;}
.table_main td { position: relative; text-align: center; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; }
.table_main th { text-align: center; font-size: 12px; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; }
.table_main td.name { padding: 0 1%; text-align: left; border-right: 1px #000 solid; border-bottom: 1px #000 solid; }
.table_main .hdr td { font-weight: bold; padding: 1px; }
.table_main .main td { height: 50px; font-size: 17px; }
.table_main .main td img { width: 96px; }
.table_sum { margin: 10px 0 0 1px; }
.table_sum td { padding: 1px 1px 0; font-size: 12px; text-align: center; vertical-align: top; }
.table_sum td.name { padding: 1px; font-size: 12px; text-align: left; }
tr.min td { height: 1px; font-size: 1px; line-height: 1px; margin: 0px; padding: 0px;}
.adate { font-size: 11px; margin-left: 177px; }
.note_red { width: 100%; display: block; clear: left; color: red; font-weight: bold; }
h1.filial { text-align: center; font-size: 27px; }
@media print {
	h1.filial { display: none; }
}
.subvalue {
	position: absolute;
	width: 100%;
	bottom: 0;
	right: 0;
	font-size: 15px;
	padding: 0 3px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
.subvalue:before {
	content: 'скл. ';
	/*position: absolute;*/
	width: 100%;
	top: -10px;
	left: 0;
	font-size: 11px;
	line-height: 11px;
	/*text-align: center;*/
	text-align: left;
	/*border-top: 1px solid #000;*/
}
.instruction {
	color: #0018FF;
}
</style>
</head>
<body>
<?if($document == 'invoice'){?>
	<h1 class="filial"><?=empty($filial) == false?"Филиал - ".$filial['title']:null;?></h1>
	<table border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tbody>
			<tr class="top">
				<td colspan="10">
					<span class="invoice">Проверочная накладная № <b style="font-size: 30px; padding: 0 50px;"><?=$id_order?></b> от <?=date("d.m.Y", $order['creation_date'])?></span>
				</td>
			</tr>
			<tr>
				<td>
					<span><b style="font-size: 14px;"><?=$addr_deliv?></b></span>
				</td>
				<td style="max-width: 320px;">
					<span>Сумма заказа - <b style="font-size: 18px;"><?=$sum_discount?></b></span>
					<br/>
					<span><b style="font-size: 15px;"><?=$order['note2']?></b></span>
				</td>
			</tr>
		</tbody>
	</table>
	<?
	$c1 = 25;
	$c2 = 45;
	$c3 = 65;
	$c4 = 100;
	$c5 = 360;
	$c6 = 75;
	$c7 = 65;
	$c8 = 65;
	$c9 = 60;
	$c10 = 70;
	if(!empty($arr['opened'])){
		foreach($arr as $key=>&$array){
			if(count($array) > 0){?>
				<table border="0" cellpadding="0" cellspacing="0" class="table_main">
					<colgroup>
						<col width="<?=$c1?>">
						<col width="<?=$c2?>">
						<col width="<?=$c3?>">
						<col width="<?=$c4?>">
						<col width="<?=$c5?>">
						<col width="<?=$c6?>">
						<col width="<?=$c7?>">
						<col width="<?=$c8?>">
						<col width="<?=$c9?>">
						<col width="<?=$c10?>">
					</colgroup>
					<thead>
						<tr class="hdr" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?>">
							<th class="bl bt">№</th>
							<th class="bt">Скл.</th>
							<th class="bt">Артикул</th>
							<th class="bt">Фото</th>
							<th class="bt">Название</th>
							<th class="bt">Цена за шт.</th>
							<th class="bt">Заказано, шт</th>
							<th class="bt">Факт</th>
							<th class="bt">Возврат</th>
							<th class="bt">Резмеры<br>Вес</th>
						</tr>
					</thead>
					<?$ii = 1;
					$qty = 0;
					$weight = 0;
					$volume = 0;
					foreach($array as &$a){?>
						<tbody>
							<?foreach($a as &$i){
								if($i['opt_qty'] > 0){?>
									<tr class="main">
										<td class="bl c1"><?=$ii++?></td>
										<td class="c2"><?=$i['article']?></td>
										<td class="c3"><?=$i['art']?></td>
										<td class="c4"><img height="96" width="96" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"></td>
										<td class="name c5"><?=$i['name']?><br><?=$i['instruction'] != ''?"<span class='instruction'>".$i['instruction']."</span>":null ?><?if($i['note_opt']!=''){?> <span class="note_red"><?=$i['note_opt']?></span><?}?></td>
										<td class="c6"><?=$i['site_price_opt']?></td>
										<td class="c7"><?=$i['opt_qty']?><?if($i['warehouse_quantity'] > 0){?><span class="subvalue"><?=$i['warehouse_quantity']?></span><?}?></td>
										<td class="c8" style="<?=($i['opt_qty'] != $i['contragent_qty'] && $i['contragent_qty'] >= 0)? 'color: #f00; font-weight: bold;':null;?>">
											<?=$i['contragent_qty'] >= 0 ? $i['contragent_qty'] : null;?>
										</td>
										<td class="c9"></td>
										<td class="c10" style="text-align: right;">
											<?if(!in_array($i['id_product'], $products) || $i['out'] == 1){?>
												<?=$i['volume'] > 0?$i['volume']:'   ';?><small> кг&nbsp;</small>
												<hr>
												<?=$i['weight'] > 0?$i['weight'].'<small> м<sup>3</sup></small>&nbsp;':'<small style="float: left; clear: both; width: 100%; text-align: left !important;">&nbsp;д<hr>&nbsp;ш<hr>&nbsp;в</small>';?>
											<?}else{?>
												<small><small>Не заполнять</small></small>
											<?}?>
										</td>
										<?$volume += $i['volume']*$i['opt_qty'];?>
										<?$weight += $i['weight']*$i['opt_qty'];?>
									</tr>
								<?}
								if($i['mopt_qty'] > 0){?>
									<tr>
										<td class="bl c1"><?=$ii++?></td>
										<td class="c2"><?=$i['article_mopt']?></td>
										<td class="c3"><?=$i['art']?></td>
										<td class="c4"><img height="96" width="96" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"></td>
										<td class="name c5"><?=$i['name']?><br><?=$i['instruction'] != ''?"<span class='instruction'>".$i['instruction']."</span>":null ?><?if($i['note_mopt']!=''){?> <span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
										<td class="c6"><?=$i['site_price_mopt']?></td>
										<td class="c7"><?=$i['mopt_qty']?><?if($i['warehouse_quantity'] > 0){?><span class="subvalue"><?=$i['warehouse_quantity']?></span><?}?></td>
										<td class="c8" style="<?if($i['mopt_qty'] != $i['contragent_mqty'] && $i['contragent_mqty'] >= 0){?>color: #f00; font-weight: bold;<?}?>">
											<?=$i['contragent_mqty'] >= 0 ? $i['contragent_mqty'] : null;?>
										</td>
										<td class="c9"></td>
										<td class="c10" style="text-align: right;">
											<?if(!in_array($i['id_product'], $products) || $i['out'] == 1){?>
												<?=$i['volume'] > 0?$i['volume']:'   ';?><small> кг&nbsp;</small>
												<hr>
												<?=$i['weight'] > 0?$i['weight'].'<small> м<sup>3</sup></small>&nbsp;':'<small style="float: left; clear: both; width: 100%; text-align: left !important;">&nbsp;д<hr>&nbsp;ш<hr>&nbsp;в</small>';?>
											<?}else{?>
												<small><small>Не заполнять</small></small>
											<?}?>
										</td>
										<?$volume += $i['volume']*$i['mopt_qty'];?>
										<?$weight += $i['weight']*$i['mopt_qty'];?>
									</tr>
								<?}
							}?>
							<tr>
								<td colspan="10" class="bl" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?> height: 5px;"></td>
							</tr>
						</tbody>
					<?}?>
					<tr>
						<th colspan="6" class="nb"></th>
						<th colspan="3" class="nb" style="text-align: right; padding-right: .5em;">Суммарный объем:<br>Суммарный вес:</th>
						<th class="bl" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?> height: 5px;"><?=$weight;?> м<sup>3</sup><br><?=$volume;?> кг</th>
					</tr>
				</table>
			<?}
		}
	}else{?>
		<table class="table_main" style="width: 100%;">
			<thead>
				<tr class="hdr" style="background: #c4ffc6;">
					<td style="border: 0;"><h1>Заказ закрыт</h1></td>
				</tr>
			</thead>
		</table>
	<?}?>
	<h1 style="padding: 20px 0; float: left;">Проверил:</h1><h1 style="padding: 20px 270px 0; float: right;">Дата, время:</h1>
<?}?>
</body>
</html>