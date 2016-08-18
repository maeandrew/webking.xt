<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Накладная контрагента</title>
	<style>
	body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td {
	margin:0; padding:0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline}
:focus {outline:0}
html,body {height:100%}
body {font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 12px; color: #333;}
.logo{font-size: 28px; color: #00F; font-weight: bold;}
.undln{text-decoration:underline;}
.lb{border-left:1px dashed #000;padding-left:5px;}
.table_header{margin-left:3px;width:800px;}
.table_header .top td{padding:10px 0 15px 0;font-size:14px;}
.table_header .first_col{width: 150px;}
.table_header .second_col{width: 300px;}
.table_header .top span.invoice{margin-left:20px;font-size:18px;text-decoration:underline;}
.bl{border-left:1px solid #000;}
.br{border-right:1px solid #000;}
.bt{border-top:1px solid #000;}
.bb{border-bottom:1px solid #000 !important;}
.bn{border:none !important;}
.bnb{border-bottom:none !important;}
.blf{border-left:1px solid #FFF;}
.brf{border-right:1px solid #FFF;}
.bbf{border-bottom:1px solid #FFF;}
.table_main{margin:10px 0 0 1px;}
.table_main td{padding:1px 1px 0;font-size:12px; text-align:center; border-right:1px #000 solid;border-bottom:1px #000 solid;vertical-align: middle;}
.table_main td.name{padding:1px;font-size:12px; text-align:left; border-right:1px #000 solid;border-bottom:1px #000 solid;}
.table_main .hdr td{font-weight: bold;padding: 1px;}
.table_main .main td{height:50px;}
.table_main .main td.img{width:56px;}
.table_sum{margin:10px 0 0 1px;}
.table_sum td{padding:1px 1px 0;font-size:12px; text-align:center; vertical-align: middle;}
.table_sum td.name{padding:1px;font-size:12px; text-align:left;}
tr.min td{height: 1px; font-size: 1px;line-height: 1px;margin: 0px;padding: 0px;}
.adate{font-size: 11px;margin-left: 177px;}
.note_red{color:Red;font-size: 14px; font-weight:900;}
.note_grin{color:#00FF00;font-size: 18px; font-weight:900;}
	</style>
	</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr class="top">
			<td colspan="4">
				<span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span>
				<span class="invoice">Накладная контрагента от <?=date("d.m.Y",$order['creation_date'])?> <?=str_repeat("&nbsp;", 3)?> № &nbsp; <b><?=$id_order?></b></span>
			</td>
		</tr>
		<tr>
			<td class="first_col undln">
				<u><strong>Отправитель</strong></u></td>
			<td class="second_col">
				<?=$Contragent['name']?></td>
			<td class="first_col undln lb">
				<u><strong>Получатель</strong></u></td>
			<td class="second_col">
				<?=$Customer['name']?></td>
		</tr>
		<tr>
			<td class="undln">
				Контакты</td>
			<td>
				<?=$Contragent['phones']?></td>
			<td class="undln lb">
				Доставка</td>
			<td>
				<?=$addr_deliv?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2" class="lb">
				<span class="undln">Контактные данные</span><br>
				<?=$Customer['descr']?></td>
		</tr>
		<tr>
			<td colspan="2">
				<span class="undln"></td>
			<td class="undln lb">
				Конт. лицо:</td>
			<td><?=$order['cont_person']?> <?=$order['phones']?></td>
		</tr>
	</tbody>
	</table>
<?
$c1 = 25;
$c2 = 10;
$c3 = 70;
$c4 = "*";
$c5 = 80;
$c6 = 80;
$c7 = 27;
$c8 = 60;
$c9 = 60;
$c10 = 60;
?>
<p style="margin:20px 0 0 10px;font-size:14px;font-weight:bold">Расшифровка основных поставщиков и контроль загрузки</p>
<table border="0" cellpadding="0" cellspacing="0" style="width: 802px;" class="table_main">
	<col width="<?=$c1?>" />
	<col width="<?=$c2?>" />
	<col width="<?=$c3?>" />
	<col width="<?=$c4?>" />

	<col width=<?=$c5?> />
	<col width=<?=$c6?> />
	<col width=<?=$c7?> />
	<col width=<?=$c8?> />
	<col width=<?=$c9?> />
	<col width=<?=$c10?> />
	<tbody>
		<tr class="hdr">
			<td class="bl bt">
				№</td>
			<td class="bt">
				группа</td>
			<td class="bt">
				Код части заказа</td>
			<td class="bt">
				поставщик, телефон, площадка, контейнер</td>
			<td class="bt">
				Сумма по заказу, грн</td>
			<td class="bt">
				К оплате поставщику, грн</td>
			<td class="bt">
				Комиссия<br>контр.</td>
			<td class="bt">
				Комиссия<br>сайта</td>
			<td class="bt">
				Загружено</td>
			<td class="bt">
				Вес,<br>Объем</td>
		</tr>
		<?$sum_order=0;$sweight=0;$svolume=0;?>
		<?$ii=1;foreach($suppliers as $s){?>
		<tr>
			<td class="bl" style="height: 30px;"><?=$ii++?></td>
			<td ><?=$s['is_partner']?'пар':null?></td>
			<td><?=$order['id_order']?>-<?=$s['article']?></td>
			<td><?=$s['name']?>, <?=$s['phones']?>, <?=$s['place']?></td>

			<td><?=$s['sum']?></td>
			<?$sum_order+=$s['sum']?>

			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?=round($s['svolume'],2)?><br><?=round($s['sweight'],2)?></td>
				<?$svolume+=round($s['svolume'],2);?><?$sweight+=round($s['sweight'],2);?>
		</tr>
		<?}?>
		<tr>
			<td class="bnb" style="height: 30px;" colspan="4">&nbsp;</td>

			<td class="br bb"><?=$sum_order?></td>
			<td class="bn">&nbsp;</td>
			<td class="bn">&nbsp;</td>
			<td class="bn">&nbsp;</td>
			<td class="bnb">&nbsp;</td>
			<td class="br bb"><?=round($svolume,2)?><br><?=round($sweight,2)?></td>
		</tr>
	</tbody>
	</table>
<?
$c1 = 25;
$c2 = 10;
$c3 = 100;
$c4 = "*";
$c5 = 80;
$c6 = 80;
$c7 = 27;
$c8 = 60;
$c9 = 60;
?>
<?if(isset($suppliers_altern)){?>
<?php if (false): ?>
	<p style="margin:20px 0 0 10px;font-size:14px;font-weight:bold">Расшифровка альтернативных поставщиков</p>
<table border="0" cellpadding="0" cellspacing="0" style="width: 802px;" class="table_main">
	<col width="<?=$c1?>" />
	<col width="<?=$c2?>" />
	<col width="<?=$c3?>" />
	<col width="<?=$c4?>" />

	<col width=<?=$c5?> />
	<col width=<?=$c6?> />
	<col width=<?=$c7?> />
	<col width=<?=$c8?> />
	<col width=<?=$c9?> />
	<tbody>
		<tr class="hdr">
			<td class="bl bt">
				№</td>
			<td class="bt">
				группа</td>
			<td class="bt">
				Код части заказа</td>
			<td class="bt">
				поставщик, телефон, площадка, контейнер</td>
			<td class="bt">
				Сумма по заказу, грн</td>
			<td class="bt">
				К оплате поставщику, грн</td>
			<td class="bt">
				Комиссия<br>контр.</td>
			<td class="bt">
				Комиссия<br>сайта</td>
			<td class="bt">
				Загружено</td>
		</tr>
		<?$sum_order=$sum_supplier=$sum_kom=$sum_kom_site="&nbsp;"?>
		<?$ii=1;foreach($suppliers_altern as $s){?>
		<tr>
			<td class="bl" style="height: 30px;"><?=$ii++?></td>
			<td ><?=$s['is_partner']?'пар':null?></td>
			<td><?=$order['id_order']?>-<?=$s['article']?></td>
			<td><?=$s['name']?>, <?=$s['phones']?>, <?=$s['place']?></td>

			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?}?>
		<tr>
			<td class="bnb" style="height: 30px;" colspan="4">&nbsp;</td>

			<td><?=$sum_order?></td>
			<td><?=$sum_supplier?></td>
			<td><?=$sum_kom?></td>
			<td><?=$sum_kom_site?></td>
			<td class="nb">&nbsp;</td>
		</tr>
	</tbody>
	<div> some text</div>
  <?php echo "some text"; ?>
<?php endif; ?>
</table>
<?}?>
<?$supii=1;?>
<?foreach($products as $id_supplier=>$parr){?>
<table border="0" cellpadding="0" cellspacing="0" style="width: 800px;margin-top: 1px;"><tbody><tr><td style="border-bottom:1px #000 dashed;">&nbsp;</td></tr></tbody></table>
<p style="margin:1px 0 0 10px;font-size:14px;font-weight:bold"><span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span> <?=str_repeat("&nbsp;", 10)?> Заказ от <?=$date?> <?=str_repeat("&nbsp;", 10)?> № &nbsp; <b><?=$id_order?>-<?=$suppliers[$id_supplier]['article']?></b></p><b>
<table border="0" cellpadding="0" cellspacing="0" style="width: 802px;">
	<col width="25" />
	<col width="50" />
	<col width="350" />
	<col width="*" />
	<tr>
		<td style="font-size:14px;font-weight:bold;background-color: #ccc;padding:5px;text-align: center;"><?=$supii++?></td>
		<td style="font-size:14px;"><?=$suppliers[$id_supplier]['is_partner']?'пар':'&nbsp;'?><br><?=$suppliers[$id_supplier]['dn']?></td>
		<td style="font-size:11px;">
			<span style="text-decoration: underline;font-weight: bold;margin-right: 10px;">Отправитель:</span> <?=$suppliers[$id_supplier]['name']?><br>
			<span style="text-decoration: underline;margin-right: 53px;">Адрес:</span><?=$suppliers[$id_supplier]['phones']?><br>
			<span style="text-decoration: underline;margin-right: 34px;">Контакты:</span><?=$suppliers[$id_supplier]['place']?></td>
		<td style="font-size:11px;">
			<span style="text-decoration: underline;font-weight: bold;margin-right: 10px;">Получатель:</span> <?=$Contragent['name']?><br>
			<span style="text-decoration: underline;margin-right: 20px;">Адрес:</span><?=$Contragent['phones']?><br>
			<span style="text-decoration: underline;margin-right: 34px;">
		</td>
	</tr>
	</table>
<?
$c1 = 25;
$c2 = 40;
$c3 = 60;
$c4 = 250;
$c5 = 45;
$c6 = 35;
$c7 = 27;
$c8 = 60;
$c9 = 60;
$c10 = 60;
$c11 = 75;
$c12 = 70;
?>
<table border="0" cellpadding="0" cellspacing="0" class="table_main">

<col width="<?=$c1?>" />
<col width="<?=$c2?>" />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c6?> />
<col width=<?=$c7?> />
<col width=<?=$c8?> />
<col width=<?=$c9?> />
<col width=<?=$c10?> />
<col width=<?=$c11?> />
<col width=<?=$c12?> />
	<tbody>
		<tr class="hdr">
			<td class="bl bt">№</td>
			<td class="bt">
				Код</td>
			<td class="bt">
				Фото</td>
			<td class="bt">
				Название</td>
			<td class="bt">
				Цена за шт.</td>
			<td class="bt">
				К-во в ящ.</td>
			<td class="bt">
				ящ.</td>
			<td class="bt">
				заказано, шт</td>
			<td class="bt">
				факт</td>
			<td class="bt">
				Сумма</td>
			<td class="bt">
				Альтерн. поставщик</td>
			<td class="bt">
				Вес,<br>Объем</td>
		</tr>
		<?$ii=1;$sum=0;$qty=0;$weight=0;$volume=0;$sum_otpusk=0;?>
		<?foreach ($parr as $i){?>
		<?if ($i['opt_qty']>0 && $i['id_supplier']==$id_supplier){?>
		</tbody>
		</table>
<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
<col width="<?=$c1?>" />
<col width="<?=$c2?>" />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c6?> />
<col width=<?=$c7?> />
<col width=<?=$c8?> />
<col width=<?=$c9?> />
<col width=<?=$c10?> />
<col width=<?=$c11?> />
<col width=<?=$c12?> />
		<tbody>
		<tr class="main">
			<td class="bl c1">
				<?=$ii++?></td>
			<td class="c2">
				<?=$i['art']?></td>
			<td class="c3"><img height="48" width="48" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>" /></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_opt']!=''){?> <span class="note_red"><?=$i['note_opt']?></span><?}?></td>
			<td class="c5">
				<?if (!$suppliers[$id_supplier]['is_partner']){?><div class="note_red"><?=$i['price_opt_otpusk']?></div><?}?>
				<?=$i['site_price_opt']?></td>
			<td class="c6">
				<?=$i['inbox_qty']?></td>
			<td class="c7">
				<?=$i['box_qty']?></td>
			<td class="c8"><div class="note_grin">
				<?=$i['opt_qty']?></td><?$qty+=$i['opt_qty'];?>
			<td class="c9">&nbsp;
				</td>
			<td class="c10">
				<?if (!$suppliers[$id_supplier]['is_partner']){?><div class="note_red"><?=round($i['price_opt_otpusk']*$i['opt_qty'], 2)?></div><?$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);}?>
				<?=$i['opt_sum']?></td><?$sum=round($sum+$i['opt_sum'],2)?>
			<td class="c11">
				<?=$i['article_altern']?></td>
			<td class="c12">
				<?=round($i['volume']*$i['opt_qty'],2)?><br><?=round($i['weight']*$i['opt_qty'],2)?></td>
				<?$volume+=round($i['volume']*$i['opt_qty'],2);?><?$weight+=round($i['weight']*$i['opt_qty'],2);?>
		</tr>
		<?} if($i['mopt_qty']>0 && $i['id_supplier_mopt']==$id_supplier){?>
		</tbody></table>
		<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width="<?=$c1?>" />
<col width="<?=$c2?>" />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c6?> />
<col width=<?=$c7?> />
<col width=<?=$c8?> />
<col width=<?=$c9?> />
<col width=<?=$c10?> />
<col width=<?=$c11?> />
<col width=<?=$c12?> />
		<tbody>
		<tr>
			<td class="bl c1">
				<?=$ii++?></td>
			<td class="c2">
				<?=$i['art']?></td>
			<td class="c3"><img height="48" width="48" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>" /></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_mopt']!=''){?> <span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
			<td class="c5">
				<?if (!$suppliers[$id_supplier]['is_partner']){?><div class="note_red"><?=$i['price_mopt_otpusk']?></div><?}?>
				<?=$i['site_price_mopt']?></td>
			<td class="c6">
				<?=$i['inbox_qty']?></td>
			<td class="c7">&nbsp;
				</td>
			<td class="c8"><div class="note_grin">
				<?=$i['mopt_qty']?></div></td><?$qty+=$i['mopt_qty'];?>
			<td class="c9">&nbsp;
				</td>
			<td class="c10">
				<?if (!$suppliers[$id_supplier]['is_partner']){?><div class="note_red"><?=round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)?></div><?$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)),2);}?>
				<?=$i['mopt_sum']?></td><?$sum=round($sum+$i['mopt_sum'],2)?>
			<td class="c11">
				<?=$i['article_mopt_altern']?></td>
			<td class="c12">
				<?=round($i['volume']*$i['mopt_qty'],2)?><br><?=round($i['weight']*$i['mopt_qty'],2)?></td>
				<?$volume+=round($i['volume']*$i['mopt_qty'],2);?><?$weight+=round($i['weight']*$i['mopt_qty'],2);?>
		</tr>
		<?}?>
		<?}?>
		</tbody></table>
		<table border="0" cellpadding="0" cellspacing="0" class="table_sum" style="margin-top:0px;">
		<col width="<?=$c1?>" />
<col width="<?=$c2?>" />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c6?> />
<col width=<?=$c7?> />
<col width=<?=$c8?> />
<col width=<?=$c9?> />
<col width=<?=$c10?> />
<col width=<?=$c11?> />
<col width=<?=$c12?> />
			<tbody>
		<tr>
			<td class="blf brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>

			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>

			<td class="br" style="text-align:right">Сумма:</td>
			<td class="br bb"><?if (!$suppliers[$id_supplier]['is_partner']){?><div class="note_red"><?=$sum_otpusk?></div><?}?><?=round($sum,2)?></td>
			<td class="br">&nbsp;</td>
			<td class="br bb"><?=round($volume,2)?><br><?=round($weight,2)?></td>
		</tr>

		<tr><td colspan=4 class="nb">отпустил___________________</td>
			<td colspan=4 class="nb">принял___________________</td>
			<td colspan=5 class="nb">&nbsp;</td>
		</tr>
	</tbody>
	</table>

<?}?>
<br>
</b></body>
</html>