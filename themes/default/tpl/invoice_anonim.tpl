<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Накладная покупателя</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,
form,label,fieldset,img,input,textarea,p,blockquote,th,td {
margin: 0; padding: 0; border: 0; outline: 0; font-size: 100%; vertical-align: baseline; }
:focus { outline: 0; }
html,body { height: 100%; }
body { font-family: Arial, sans-serif; font-size: 14px; color: #000; margin: 0 auto; width: 800px; margin: 0 auto; }
.logo { font-size: 28px; color: #00F; font-weight: bold; }
.undln { text-decoration: underline; }
.lb { border-left: 1px dashed #000; padding-left: 5px; }
.table_header { margin-left: 3px; width: 800px; }
.table_header .top td { padding: 10px 0 15px 0; font-size: 16px; }
.table_header .first_col { width: 90px; }
.table_header .second_col { width: 325px; }
.table_header .top span.invoice { margin-left: 90px; font-size: 23px; }
.bl { border-left: 1px solid #000; }
.br { border-right: 1px solid #000; }
.bt { border-top: 1px solid #000; }
.bb { border-bottom: 1px solid #000 !important; }
.blf { border-left: 1px solid #FFF; }
.brf { border-right: 1px solid #FFF; }
.table_main { margin: 10px 0 0 1px; }
.table_main th, .table_main td { font-size: 14px; text-align: center; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; }
.table_main td.name { padding: 5px; font-size: 14px; text-align: left; border-right: 1px #000 solid; border-bottom: 1px #000 solid; }
.table_main .hdr th { font-weight: bold; font-size: 12px; }
.table_main .main th, .table_main .main td { height: 50px; }
.table_main .main td.img { width: 56px; }
.table_sum { margin: 10px 0 0 1px; }
.table_sum td { padding: 5px; font-size: 14px; text-align: center; vertical-align: middle; }
.table_sum td.name { font-size: 14px; text-align: left; }
tr.min td { height: 1px; font-size: 1px; line-height: 1px; margin: 0px; padding: 0px; }
.note_red { color: #f00; font-size: 11px; font-weight: normal; }
</style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr class="top">
			<td colspan="4">
				<span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span>
				<span class="invoice"><b>Заказ № <?=$id_order?> от <?=$date?></b></span>
			</td>
		</tr>
		<tr>
			<td>
				<span class="adate">Из соображений конфиденциальности данные о покупателе скрыты</span>
			</td>
		</tr>
	</tbody>
</table>
<?
$c1 = 30;
$c2 = 45;
$c3 = 60;
$c4 = 90;
$c5 = 345;
$c6 = 80;
$c7 = 70;
$c8 = 80;
?>
<table border="0" cellpadding="0" cellspacing="0" class="table_main">
	<col width="<?=$c1?>">
	<col width="<?=$c2?>">
	<col width="<?=$c3?>">
	<col width="<?=$c4?>">
	<col width="<?=$c5?>">
	<col width="<?=$c6?>">
	<col width="<?=$c7?>">
	<col width="<?=$c8?>">
	<tbody>
		<tr class="hdr">
			<th rowspan="2" class="bl bt">№</th>
			<th rowspan="2" class="bt">Склад</th>
			<th rowspan="2" class="bt">Артикул</th>
			<th rowspan="2" class="bt">Фото</th>
			<th rowspan="2" class="bt">Наименование товара</th>
			<th rowspan="2" class="bt">Цена за ед.</th>
			<th rowspan="2" class="bt">Заказано ед.</th>
			<th rowspan="2" class="bt">Сумма</th>
		</tr>
	</tbody>
</table>
<?$ii=1;$qty=0;$weight=0;$volume=0;?>
<?foreach($arr as $i){?>
	<?if($i['opt_qty']>0){?>
	<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width="<?=$c1?>">
		<col width="<?=$c2?>">
		<col width="<?=$c3?>">
		<col width="<?=$c4?>">
		<col width="<?=$c5?>">
		<col width="<?=$c6?>">
		<col width="<?=$c7?>">
		<col width="<?=$c8?>">
		<tbody>
			<tr class="main">
				<td class="bl c1"><?=$ii++?></td>
				<td class="c2"><?=$i['article']?></td>
				<td class="c3"><?=$i['art']?></td>
				<td class="c4">
					<img height="80" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>">
				</td>
				<td class="name c5">
					<?=$i['name']?>
					<?if($i['note_opt']!=''){?>
						<span class="note_red"><?=$i['note_opt']?></span>
					<?}?>
				</td>
				<td class="c6"><?=number_format($i['site_price_opt'], 2, ",", "");?></td>
				<td class="c7"><?=$i['opt_qty']?> <?=$i['units']?></td><?$qty+=$i['opt_qty'];?>
				<td class="c8"><?=number_format($i['opt_sum'], 2, ",", "");?></td>
				<?$weight+=round($i['weight']*$i['opt_qty'],2);?><?$volume+=round($i['volume']*$i['opt_qty'],2);?>
			</tr>
		</tbody>
	</table>
	<?}
	if($i['mopt_qty']>0){?>
	<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width="<?=$c1?>">
		<col width="<?=$c2?>">
		<col width="<?=$c3?>">
		<col width="<?=$c4?>">
		<col width="<?=$c5?>">
		<col width="<?=$c6?>">
		<col width="<?=$c7?>">
		<col width="<?=$c8?>">
		<tbody>
			<tr>
				<td class="bl c1"><?=$ii++?></td>
				<td class="c2"><?=$i['article_mopt']?></td>
				<td class="c3"><?=$i['art']?></td>
				<td class="c4">
					<img height="80" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>">
				</td>
				<td class="name c5">
					<?=$i['name']?>
					<?if($i['note_mopt']!=''){?>
						<span class="note_red"><?=$i['note_mopt']?></span>
					<?}?>
				</td>
				<td class="c6"><?=number_format($i['site_price_mopt'], 2, ",", "");?></td>
				<td class="c7"><?=$i['mopt_qty']?></td><?$qty+=$i['mopt_qty'];?>
				<td class="c8"><?=number_format($i['mopt_sum'], 2, ",", "");?></td>
				<?$weight+=round($i['weight']*$i['mopt_qty'],2);?>
				<?$volume+=round($i['volume']*$i['mopt_qty'],2);?>
			</tr>
		</tbody>
	</table>
	<?}?>
<?}?>
<table border="0" cellpadding="0" cellspacing="0" class="table_sum" style="margin-top: 0px;">
	<col width="<?=$c1?>">
	<col width="<?=$c2?>">
	<col width="<?=$c3?>">
	<col width="<?=$c4?>">
	<col width="<?=$c5?>">
	<col width="<?=$c6?>">
	<col width="<?=$c7?>">
	<col width="<?=$c8?>">
	<tbody>
		<tr>
			<td class="blf brf"></td>
			<td class="brf"></td>
			<td class="brf"></td>
			<td class="brf"></td>
			<td class="brf"></td>
			<td class="brf"></td>
			<td class="br" style="text-align:right"><b>Сумма:</b></td>
			<td class="br bb"><b><?=number_format($order['sum_discount'], 2, ",", "");?></b></td>
		</tr>
	</tbody>
</table>
<?if(count($Sertificates) > 0){?>
	<?foreach($Sertificates as $s){?>
		<br><br><br>
		<img src="<?=file_exists($GLOBALS['PATH_root'].'/phpthumb/phpThumb.php?src='.$s.'&w=800')?_base_url.'/phpthumb/phpThumb.php?src='.$s.'&w=800':'/images/nofoto.png'?>">
	<?}?>
<?}?>
</body>
</html>