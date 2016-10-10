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
.tal { text-align: left !important; }
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
.abbrs { font-size: 17px !important; line-height: 19px !important; padding: 0 .5% !important; }
thead>tr>th:first-of-type { padding: 0 .5% !important; }
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
    width: 100%;
    display: block;
    clear: left;
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
	$c1 = 65;
	$c2 = 100;
	$c3 = 280;
	$c4 = 280;
	$c5 = 75;
	$c6 = 65;
	$c7 = 65;
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
					</colgroup>
					<thead>
						<tr class="hdr" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?> height: 30px;">
							<th class="bt bl tal" rowspan="2">№,<br>Скл.,<br>Артикул</th>
							<th class="bt" rowspan="2">Фото</th>
							<th class="bt" rowspan="2">Название</th>
							<th class="bt" rowspan="2">Характеристики</th>
							<th class="bt" rowspan="2">Цена за<br>шт.</th>
							<th class="bt">Заказано</th>
							<th class="bt">Факт</th>
						</tr>
						<tr class="hdr" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?> height: 30px;">
							<th>Склад</th>
							<th>Возврат</th>
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
										<td class="c1 bl tal abbrs" rowspan="2"><?=$ii++?><br><?=$i['article']?><br><?=$i['art']?></td>
										<td class="c2" rowspan="2">
											<?if($i['image'] != ''){?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['image'], 'medium')?>">
											<?}else{?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
											<?}?>
										</td>
										<td class="name c3" rowspan="2">
											<?=!empty($i['note_opt'])?'<span class="note_red">'.$i['note_opt'].'</span>':null?><?=$i['name']?><?=!empty($i['instruction'])?'<span class="instruction">'.$i['instruction'].'</span>':null?>
										</td>
										<td class="c4 tal" rowspan="2" style="font-size: 8pt; padding: 0 1%;">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
										<td class="c5" rowspan="2"><?= number_format($i['site_price_opt'], 2, ",", "")?></td>
										<!-- Заказано -->
										<td class="c6"><?=$i['opt_qty']?><?if($i['warehouse_quantity'] > 0){?><span class="subvalue"><?=$i['warehouse_quantity']?></span><?}?> <?=$i['units']?></td>
										<!-- Факт -->
										<td class="c7" style="<?=($i['opt_qty'] != $i['contragent_qty'] && $i['contragent_qty'] >= 0)? 'color: #f00; font-weight: bold;':null;?>">
											<?=$i['contragent_qty'] >= 0?$i['contragent_qty']:null;?>
										</td>
									</tr>
									<tr class="main">
										<!-- Склад -->
										<td><?=$i['warehouse_quantity'] > 0?$i['warehouse_quantity']:null?></td>
										<!-- Возврат -->
										<td></td>
									</tr>
								<?}
								if($i['mopt_qty'] > 0){?>
									<tr>
										<td class="c1 bl tal abbrs" rowspan="2"><?=$ii++?><br><?=$i['article_mopt']?><br><?=$i['art']?></td>
										<td class="c2" rowspan="2">
											<?if($i['image'] != ''){?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['image'], 'medium')?>">
											<?}else{?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
											<?}?>
										</td>
										<td class="name c3" rowspan="2">
											<?=!empty($i['note_mopt'])?'<span class="note_red">'.$i['note_mopt'].'</span>':null?><?=$i['name']?><?=!empty($i['instruction'])?'<span class="instruction">'.$i['instruction'].'</span>':null?>
										</td>
										<td class="c4 tal" rowspan="2" style="font-size: 8pt; padding: 0 1%;">font-size: 8pt; Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
										<td class="c5" rowspan="2"><?= number_format($i['site_price_mopt'], 2, ",", "")?></td>
										<!-- Заказано -->
										<td class="c6">
											<?=$i['mopt_qty']?><?if($i['warehouse_quantity'] > 0){?><span class="subvalue"><?=$i['warehouse_quantity']?></span><?}?> <?=$i['units']?>
										</td>
										<!-- Факт -->
										<td class="c7" style="<?if($i['mopt_qty'] != $i['contragent_mqty'] && $i['contragent_mqty'] >= 0){?>color: #f00; font-weight: bold;<?}?>">
											<?=$i['contragent_mqty'] >= 0?$i['contragent_mqty']:null;?>
										</td>
									</tr>
									<tr class="main">
										<!-- Склад -->
										<td><?=$i['warehouse_quantity'] > 0?$i['warehouse_quantity']:null?></td>
										<!-- Возврат -->
										<td></td>
									</tr>
								<?}
							}?>
							<tr>
								<td colspan="7" class="bl" style="<?=$key == 'closed'? 'background: #c4ffc6;' : 'background: #ffc4c4;';?> height: 5px;"></td>
							</tr>
						</tbody>
					<?}?>
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