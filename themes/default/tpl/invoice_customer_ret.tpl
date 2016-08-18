<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Возврат по накладной покупателя</title>
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
.blf{border-left:1px solid #FFF;}
.brf{border-right:1px solid #FFF;}
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
.selected{color:#F00;font-weight: bold;}
.adate{font-size: 11px;margin-left: 177px;}
.note_red{color:Red;font-size: 11px; font-weight:normal;}
	</style>
	</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr class="top">
			<td colspan="4">
				<span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span> <span class="invoice">Возврат покупателя по накладной от <?=$date?> <?=str_repeat("&nbsp;", 7)?> № &nbsp; <b><?=$id_order?>-возв</b></span>
				<br><span class="adate">Дата формирования возврата: <?=date("d.m.Y",$order['return_date'])?></span></td>
		</tr>
		<tr>
			<td class="first_col undln">
				<u><strong>отправитель</strong></u></td>
			<td class="second_col">
				<?=$Contragent['name']?></td>
			<td class="first_col undln lb">
				<u><strong>получатель</strong></u></td>
			<td class="second_col">
				<?=$Customer['name']?></td>
		</tr>
		<tr>
			<td class="undln">
				адрес</td>
			<td>
				<?=$Contragent['phones']?></td>
			<td class="undln lb">
				адрес доставки</td>
			<td>
				<?=$addr_deliv?></td>
		</tr>
		<tr>
			<td colspan="2">
				<span class="undln">контактные данные</span><br>
				<?=$Contragent['descr']?></td>
			<td colspan="2" class="lb">
				<span class="undln">контактные данные</span><br>
				<?=$Customer['descr']?></td>
		</tr>
	</tbody>
	</table>
<?
$c1 = 25;
$c2 = 30;
$c3 = 60;
$c4 = 200;
$c5 = 45;
$c6 = 35;
$c7 = 27;
$c8 = 60;
$c9 = 60;
$c10 = 60;
$c11 = 60;
$c12 = 70;
?>
<table border="0" cellpadding="0" cellspacing="0" class="table_main">
<col width="<?=$c1?>">
<col width="<?=$c2?>">
<col width="<?=$c3?>">
<col width="<?=$c4?>">
<col width=<?=$c5?>>
<col width=<?=$c6?>>
<col width=<?=$c7?>>
<col width=<?=$c8?>>
<col width=<?=$c9?>>
<col width=<?=$c10?>>
<col width=<?=$c11?>>
<col width=<?=$c12?>>
	<tbody>
		<tr class="hdr">
			<td rowspan="2" class="bl bt">№</td>
			<td rowspan="2" class="bt">
				Код</td>
			<td rowspan="2" class="bt">
				Фото</td>
			<td rowspan="2" class="bt">
				Название</td>
			<td rowspan="2" class="bt">
				Цена за шт.</td>
			<td rowspan="2" class="bt">
				К-во в ящ.</td>
			<td rowspan="2" class="bt">
				ящ.</td>
			<td rowspan="2" class="bt">
				заказано, шт</td>
			<td rowspan="2" class="bt">
				факт</td>
			<td rowspan="2" class="bt">
				Сумма</td>
			<td colspan="2" class="bt">
				Возврат</td>
		</tr>
		<tr class="hdr">
			<td>
				Кол-во</td>
			<td>
				Сумма</td>
		</tr>
		<?$ii=1;$qty=0;$weight=0;$volume=0;$rqty=0;$rsum=0;?>
		<?foreach ($arr as $i){?>
		<?if ($i['opt_qty']>0 && $i['return_qty']!=0){?>
		</tbody></table>
		<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width="<?=$c1?>">
<col width="<?=$c2?>">
<col width="<?=$c3?>">
<col width="<?=$c4?>">
<col width=<?=$c5?>>
<col width=<?=$c6?>>
<col width=<?=$c7?>>
<col width=<?=$c8?>>
<col width=<?=$c9?>>
<col width=<?=$c10?>>
<col width=<?=$c11?>>
<col width=<?=$c12?>>
		<tbody>
		<tr class="main">
			<td class="bl c1">
				<?=$ii++?></td>
			<td class="c2">
				<?=$i['article']?></td>
			<td class="c3"><img height="48" width="48" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>"></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_opt']!=''){?> <span class="note_red"><?=$i['note_opt']?></span><?}?></td>
			<td class="c5">
				<?=$i['site_price_opt']?></td>
			<td class="c6">
				<?=$i['inbox_qty']?></td>
			<td class="c7">
				<?=$i['box_qty']?></td>
			<td class="c8">
				<?=$i['opt_qty']?></td><?$qty+=$i['opt_qty'];?>
			<td class="c9 selected">
				&nbsp;</td>
			<td class="c10">
				<?=$i['opt_sum']?></td>
			<td class="c11 selected">
				<?=$i['return_qty']?></td>
			<td class="c12 selected">
				<?=round($i['return_sum'],2)?></td><?$rsum+=$i['return_sum'];?>
		</tr>
		<?} if($i['mopt_qty']>0 && $i['return_mqty']!=0){?>
		</tbody></table>
		<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width="<?=$c1?>">
<col width="<?=$c2?>">
<col width="<?=$c3?>">
<col width="<?=$c4?>">
<col width=<?=$c5?>>
<col width=<?=$c6?>>
<col width=<?=$c7?>>
<col width=<?=$c8?>>
<col width=<?=$c9?>>
<col width=<?=$c10?>>
<col width=<?=$c11?>>
<col width=<?=$c12?>>
		<tbody>
		<tr>
			<td class="bl c1">
				<?=$ii++?></td>
			<td class="c2">
				<?=$i['article_mopt']?></td>
			<td class="c3"><img height="48" width="48" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>"></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_mopt']!=''){?> <span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
			<td class="c5">
				<?=$i['site_price_mopt']?></td>
			<td class="c6">
				<?=$i['inbox_qty']?></td>
			<td class="c7">
				&nbsp;</td>
			<td class="c8">
				<?=$i['mopt_qty']?></td><?$qty+=$i['mopt_qty'];?>
			<td class="c9 selected">
				&nbsp;</td>
			<td class="c10">
				<?=$i['mopt_sum']?></td>
			<td class="c11 selected">
				<?=$i['return_mqty']?></td>
			<td class="c12 selected">
				<?=round($i['return_msum'],2)?></td><?$rsum+=$i['return_msum'];?>
		</tr>
		<?}?>
		<?}?>
		</tbody></table>
		<table border="0" cellpadding="0" cellspacing="0" class="table_sum" style="margin-top: 0px;">
		<col width="<?=$c1?>">
<col width="<?=$c2?>">
<col width="<?=$c3?>">
<col width="<?=$c4?>">
<col width=<?=$c5?>>
<col width=<?=$c6?>>
<col width=<?=$c7?>>
<col width=<?=$c8?>>
<col width=<?=$c9?>>
<col width=<?=$c10?>>
<col width=<?=$c11?>>
<col width=<?=$c12?>>
			<tbody>
		<tr>
			<td class="blf brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="brf"></td>
			<td class="brf">&nbsp;</td>
			<td class="brf">&nbsp;</td>
			<td class="br">&nbsp;</td>
			<td class="br bb"><b><?=$rsum?></b></td>
		</tr>
	</tbody>
	</table>
<br>
</body>
</html>