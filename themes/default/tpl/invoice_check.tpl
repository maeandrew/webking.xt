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
			.table_main th { text-align: center; font-size: 12px; height: 30px; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; }
			.table_main td.name { padding: 0 1%; text-align: left; border-right: 1px #000 solid; border-bottom: 1px #000 solid; font-size: 17px;}
			.table_main .name div { position: absolute; bottom: 0; right: 0; padding: 5px; font-weight: bold; background: rgba(255, 255, 255, .8); }
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
			.abbrs span { width: 100%; display: block; text-align: right; }
			thead>tr>th:first-of-type { padding: 0 .5% !important; }
			@media print {
				h1.filial { display: none; }
			}
			.subvalue {
				/*position: absolute;*/
				width: 100%;
				bottom: 0;
				right: 0;
				font-size: 14px;
				padding: 0 3px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.ordered:before{
				content: 'З.';
				position: absolute;
				/*top: auto;*/
				bottom: 0;
				left: 5px;
				font-size: 10px;
				line-height: 20px;
			}
			.delivered{
				padding-left: 30px;
			}
			.delivered:before{
				content: 'П.';
				position: absolute;
				/*top: auto;*/
				bottom: 0;
				left: 5px;
				font-size: 10px;
				line-height: 20px;
			}
			.warehouse:before{
				content: 'С.';
				position: absolute;
				/*top: auto;*/
				bottom: 0;
				left: 5px;
				font-size: 10px;
				line-height: 20px;
			}
			.instruction {
				color: #0018FF;
				width: 100%;
				display: block;
				clear: left;
			}

			.rose { background: #ffc4c4 !important; }
			.green { background: #c4ffc6 !important; }
			.red_bold { color: #f00 !important; font-weight: bold !important; }

			.table_header td span b{ font-size: 14px; }
			.table_header td span.invoice b { font-size: 30px; padding: 0 50px; }
			.table_header td.right_block { max-width: 320px; }
			.table_header td.right_block span:first-of-type b { font-size: 18px; }
			.table_header td.right_block span:last-of-type b { font-size: 15px; }
			.table_main td.charcs { font-size: 8pt; padding: 0 1%; }
			.table_main tr:last-of-type { height: 5px !important; }
			.table_main.closed_order { width: 100%; }
			.table_main.closed_order thead tr td { border: 0; }

			h1.checked { padding: 20px 0; float: left; }
			h1.data_time { padding: 20px 270px 0; float: right; }

		</style>
</head>
<body>
<?if($document == 'invoice'){?>
	<h1 class="filial"><?=empty($filial) == false?"Филиал - ".$filial['title']:null;?></h1>
	<table border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tbody>
			<tr class="top">
				<td colspan="10">
					<span class="invoice">Проверочная накладная № <b><?=$id_order?></b> от <?=date("d.m.Y", $order['creation_date'])?></span>
				</td>
			</tr>
			<tr>
				<td>
					<span><b><?=$addr_deliv?></b></span>
				</td>
				<td class="right_block">
					<span>Сумма заказа - <b><?=$sum_discount?></b></span>
					<br/>
					<span><b><?=$order['note2']?></b></span>
				</td>
			</tr>
		</tbody>
	</table>
	<?
	$c1 = 65;
	$c2 = 100;
	$c3 = 245;
	$c4 = 200;
	$c5 = 70;
	$c6 = 60;
	$c7 = 60;
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
						<tr class="hdr <?=$key == 'closed'? 'green' : 'rose';?>">
							<th class="bt bl tal" rowspan="3">№,<br>Скл.,<br>Артикул</th>
							<th class="bt" rowspan="3">Фото</th>
							<th class="bt" rowspan="3">Название</th>
							<th class="bt" rowspan="3">Характеристики</th>
							<th class="bt hght">Заказано</th>
							<th class="bt" rowspan="3">Возврат</th>
							<th class="bt" rowspan="3">Недостача</th>
						</tr>
						<tr class="hdr <?=$key == 'closed'? 'green' : 'rose';?>">
							<th class="hght">Проведено</th>
						</tr>
						<tr class="hdr <?=$key == 'closed'? 'green' : 'rose';?>">
							<th class="hght">Склад</th>
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
									<tr  >
										<td class="c1 bl tal abbrs" rowspan="3">
											<?=$i['art']?><br><span><?=$ii++?><br><?=$i['article']?></span>
										</td>
										<td class="c2" rowspan="3">
											<?if($i['image'] != ''){?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['image'], 'medium')?>">
											<?}else{?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
											<?}?>
										</td>
										<td class="name c3" rowspan="3">
											<?=!empty($i['note_opt'])?'<span class="note_red">'.$i['note_opt'].'</span>':null?><?=$i['name']?><?=!empty($i['instruction'])?'<span class="instruction">'.$i['instruction'].'</span>':null?>
											<div><?=number_format($i['site_price_opt'], 2, ",", "")?> грн.</div>
										</td>
										<td class="c4 tal charcs" rowspan="3">
											<?if(!empty($i['specifications'])){
												foreach($i['specifications'] as $spec){?>
													<b><?=$spec['caption']?></b> - <?=$spec['value']?> <?=$spec['units']?><br>
												<?}
											}else{?>
												-
											<?}?>
										</td>
										<!-- Заказано -->
										<td class="c5 ordered">
											<span class="subvalue"><?=$i['opt_qty']?> <!--<?if($i['warehouse_quantity'] > 0){?>  <?=$i['units']?> <?}?> --> </span>
										</td>
										<!-- Возврат(Факт) -->
										<td class="c6
									 	  <?=$i['opt_qty'] != $i['contragent_qty'] && $i['contragent_qty'] >= 0? 'red_bold':null;?>"
										  rowspan="3">
											<?=$i['contragent_qty'] >= 0?$i['contragent_qty']:null;?>
										</td>
										<!-- Недостача(Возврат) -->
										<td rowspan="3"></td>
									</tr>
									<tr >
										<!-- Проведено -->
										<td class="delivered"><?=$i['contragent_qty'] < 0?0:$i['contragent_qty'];?></td>
									</tr>
									<tr >
										<!-- Склад -->
										<td class="warehouse"><span class="subvalue"><?=$i['warehouse_quantity'] > 0?$i['warehouse_quantity']:null?></span></td>
									</tr>
								<?}
								if($i['mopt_qty'] > 0){?>
									<tr>
										<td class="c1 bl tal abbrs" rowspan="3">
											<?=$i['art']?><br><span><?=$ii++?><br><?=$i['article_mopt']?></span>
										</td>
										<td class="c2" rowspan="3">
											<?if($i['image'] != ''){?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['image'], 'medium')?>">
											<?}else{?>
												<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
											<?}?>
										</td>
										<td class="name c3" rowspan="3">
											<?=!empty($i['note_mopt'])?'<span class="note_red">'.$i['note_mopt'].'</span>':null?><?=$i['name']?><?=!empty($i['instruction'])?'<span class="instruction">'.$i['instruction'].'</span>':null?>
											<div><?=number_format($i['site_price_mopt'], 2, ",", "")?> грн.</div>
										</td>
										<td class="c4 tal charcs" rowspan="3">
											<?if(!empty($i['specifications'])){
												foreach($i['specifications'] as $spec){?>
													<b><?=$spec['caption']?></b> - <?=$spec['value']?> <?=$spec['units']?><br>
												<?}
											}else{?>
												-
											<?}?>
										</td>
										<!-- Заказано -->
										<td class="c5 ordered">
											<span class="subvalue"><?=$i['mopt_qty']?><?if($i['warehouse_quantity'] > 0){?> <!-- <?=$i['units']?>--> <?}?></span>

										</td>
										<!-- Возврат(Факт) -->
										<td class="c6 <?=$i['mopt_qty'] != $i['contragent_mqty'] && $i['contragent_mqty'] >= 0?'red_bold':null;?>" rowspan="3">
											<?=$i['contragent_mqty'] >= 0?$i['contragent_mqty']:null;?>
										</td>
										<!-- Недостача(Возврат) -->
										<td rowspan="3"></td>
									</tr>
									<tr >
										<!-- Проведено -->
										<!-- <td class="delivered"> <?=$i['contragent_mqty'] < 0?0:$i['contragent_mqty'];?>  </td> -->
										<td class="delivered"> <?=$i['contragent_mqty'] > 0?$i['contragent_mqty']:0;?>  </td>
									</tr>
									<tr >
										<!-- Склад -->
										<td class="warehouse"><span class="subvalue"><?=$i['warehouse_quantity'] > 0?$i['warehouse_quantity']:null?></span></td>
									</tr>
								<?}
							}?>
							<tr>
								<td colspan="7" class="bl <?=$key == 'closed'? 'green' : 'rose';?>"></td>
							</tr>
						</tbody>
					<?}?>
				</table>
			<?}
		}
	}else{?>
		<table class="table_main closed_order">
			<thead>
				<tr class="hdr green">
					<td><h1>Заказ закрыт</h1></td>
				</tr>
			</thead>
		</table>
	<?}?>
	<h1 class="checked">Проверил:</h1><h1 class="data_time">Дата, время:</h1>
	<?}?>
</body>
</html>