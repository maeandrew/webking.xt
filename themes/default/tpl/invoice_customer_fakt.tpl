<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Накладная факт</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td {
margin:0; padding:0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline}
:focus { outline:0}
html,body { height:100%}
body { font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 12px; color: #333;}
.logo { font-size: 28px; color: #00F; font-weight: bold;}
.undln { text-decoration: underline;}
.lb { border-left: 1px dashed #000; padding-left: 5px;}
.table_header { width: 800px;  padding: 10px;  padding-bottom: 0px;}
.table_header .top td { padding: 10px 0 15px 0; font-size: 14px;}
.table_header .first_col { width: 90px;}
.table_header .second_col { width: 325px;}
.table_header .top span.invoice {font-size:18px;font-weight: bold;}
.bl { border-left: 1px solid #000;}
.bln { border-left: 0 !important;}
.br { border-right: 1px solid #000;}
.brn { border-right: 0 !important;}
.bt { border-top: 1px solid #000;}
.btn { border-top: 0 !important;}
.bb { border-bottom: 1px solid #000; }
.bbn { border-bottom: 0 !important;}
.blf { border-left: 1px solid #FFF;}
.brf { border-right: 1px solid #FFF;}
.bn { border: 0 !important; }
.table_main{ width: 800px;  padding: 10px;  padding-bottom: 0px;}
.table_main:last-of-type{page-break-after: avoid;}
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
.note_red{color:Red;font-size: 11px; font-weight:normal;}
h1.filial {
	text-align: center;
	font-size: 27px;
}
@media print {
h1.filial { display: none; }
}
</style>
	</head>
<body>
<h1 class="filial"><?=empty($filial) == false?"Филиал - ".$filial['title']:null;?></h1>
<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr>
	        <td colspan="4"  valign="top" style="padding: 0 18px; font-family: Arial, &quot;Helvetica Neue&quot;, Helvetica, sans-serif; font-size: 24px; font-weight: bold; text-align: center;">
	            <img align="none" height="52" src="https://xt.ua/themes/default/img/xt.png" style="width: 175px; height: 52px; margin: 0px;" width="175">
	        </td>
		</tr>
		<tr class="top">
			<td align="center" colspan="4">
				<span class="invoice">Расходная накладная № <?=$id_order?> от <?=date("d.m.Y",$order['creation_date'])?></span>
				<br><span class="adate">Ориентировочная дата отгрузки: <?=$date?></span></td>
		</tr>
		<tr>
				<td>Получатель:</td>
				<td style="font-weight: bold;">
					<?=$order['cont_person']?>&nbsp;&nbsp;&nbsp; тел. <?=$order['phones']?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<span class="undln"></span>
					<td class="undln lb"></td>
					<td><?=$addr_deliv?></td>
				</td>
				<td colspan="2" class="lb">
				</td>
			</tr>
			<?if(!empty($address)){?>
				<tr>
					<td>Транспортная компания:</td>
					<td style="font-weight: bold;">
						<?=$address['shipping_company_title']?>
					</td>
				</tr>
				<tr>
					<td>Область:</td>
					<td style="font-weight: bold;">
						<?=$address['region_title']?>
					</td>
				</tr>
				<tr>
					<td>Город:</td>
					<td style="font-weight: bold;">
						<?=$address['city_title']?>
					</td>
				</tr>
				<tr>
					<td>Тип доставки:</td>
					<td style="font-weight: bold;">
						<?=$address['delivery_type_title']?>
					</td>
				</tr>
				<?if($address['delivery_department'] !=''){?>
					<tr>
						<td>Отделение:</td>
						<td style="font-weight: bold;">
							<?=$address['delivery_department']?>
						</td>
					</tr>
				<?}?>
				<?if($address['address'] !=''){?>
					<tr>
						<td>Адрес:</td>
						<td style="font-weight: bold;">
							<?=$address['address']?>
						</td>
					</tr>
				<?}?>
			<?}else{?>
				<tr>
					<td>Адрес доставки:</td>
					<td style="font-weight: bold;">
						Не указан
					</td>
				</tr>
			<?}?>
			<tr>
				<td colspan="4" class="spacer"></td>
			</tr>
			<tr>
				<td>Отправитель:</td>
				<td style="font-weight: bold;">
					<?if(isset($remitter)){?>
						<p><?=$remitter['name']?>, <?=$remitter['address'];?>, <?=$remitter['rs']==''?null:'Р/с '.$remitter['rs'].', ';?>МФО <?=$remitter['mfo'];?>, <?=$remitter['bank'];?>, ЕГРПОУ <?=$remitter['egrpou'];?></p>
					<?}else{?>
						Не указан
					<?}?>
				</td>
			</tr>
			<tr>
				<td>Менеджер:</td>
				<td style="font-weight: bold;">
					<?=$Contragent['name']?>
				</td>
			</tr>
	</tbody>
</table>
<?
$c1 = 25;
$c2 = 40;
$c3 = 45;
$c4 = 60;
$c5 = 250;
$c6 = 45;
$c7 = 70;
$c8 = 60;
$c9 = 60;
$c10 = 60;
$c11 = 65;
?>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_main">
	<col width="<?=$c1?>"/>
	<col width="<?=$c2?>"/>
	<col width="<?=$c3?>"/>
	<col width="<?=$c4?>"/>
	<col width="<?=$c5?>"/>
	<col width="<?=$c6?>"/>
	<col width="<?=$c7?>"/>
	<col width="<?=$c8?>"/>
	<col width="<?=$c9?>"/>
	<col width="<?=$c10?>"/>
	<col width="<?=$c11?>"/>
	<tbody>
		<tr class="hdr">
			<td rowspan="2" class="bl bt">№</td>
			<td rowspan="2" class="bt">Скл.</td>
			<td rowspan="2" class="bt">Арт.</td>
			<td rowspan="2" class="bt">Фото</td>
			<td rowspan="2" class="bt">Название</td>
			<td rowspan="2" class="bt">Отпущено, шт</td>
			<td colspan="2" class="bt">Поля клиента</td>
			<td rowspan="2" class="bt">Цена за шт.</td>
			<td rowspan="2" class="bt">Сумма факт</td>
			<td rowspan="2" class="bt">Вес,<br/>Объем</td>
		</tr>
		<tr class="hdr">
			<td>Цена розница</td>
			<td>Сумма розница</td>
		</tr>
		<?$ii=1;$qty=0;$weight=0;$volume=0;$sum=0;
		if(empty($arr) === false){
			foreach($arr as &$a){
				foreach($a as &$i){
					if($i['opt_qty'] > 0){?>
						<tr class="main">
							<td class="bl c1"><?=$ii++?></td>
							<td class="c2"><?=$i['article']?></td>
							<td class="c3"><?=$i['art']?></td>
							<td class="c4">
								<?if($i['image'] != ''){?>
									<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=htmlspecialchars($i['name'])?>">
								<?}else{?>
									<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
								<?}?>
							</td>
							<td class="name c5">
								<?=$i['name']?>
								<?if($i['note_opt']!=''){?>
									<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_opt'])?></span>
								<?}?>
							</td>
							<td class="c7"><?=$i['contragent_qty'] < 0?0:$i['contragent_qty'];?></td>
							<td class="c9">&nbsp;</td>
							<td class="c10">&nbsp;</td>
							<td class="c6"><?=number_format($i['site_price_opt'], 2, ",", "");?></td>
							<?$qty += $i['contragent_qty'];?>
							<td class="c8"><?=number_format($i['contragent_sum'], 2, ",", "");?></td>
							<?$sum += $i['contragent_sum'];?>
							<td class="c11">
								<?=number_format($i['volume']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2, ",", "")?><br/>
								<?=number_format($i['weight']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2, ",", "")?>
							</td>
							<?$weight += round($i['weight']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2);
							$volume += round($i['volume']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2);?>
						</tr>
					<?}
					if($i['mopt_qty'] > 0){?>
						<tr>
							<td class="bl c1"><?=$ii++?></td>
							<td class="c2"><?=$i['article_mopt']?></td>
							<td class="c3"><?=$i['art']?></td>
							<td class="c4">
								<?if($i['image'] != ''){?>
									<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=htmlspecialchars($i['name'])?>">
								<?}else{?>
									<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
								<?}?>
							</td>
							<td class="name c5">
								<?=$i['name']?>
								<?if($i['note_mopt']!=''){?>
									<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_mopt'])?></span>
								<?}?>
							</td>
							<td class="c7"><?=$i['contragent_mqty'] < 0?0:$i['contragent_mqty'];?></td>
							<td class="c9">&nbsp;</td>
							<td class="c10">&nbsp;</td>
							<td class="c6"><?=number_format($i['site_price_mopt'], 2, ",", "");?></td>
							<?$qty+=$i['contragent_mqty'];?>
							<td class="c8"><?=number_format($i['contragent_msum'], 2, ",", "");?></td>
							<?$sum+=$i['contragent_msum'];?>
							<td class="c11">
								<?=number_format($i['volume']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2, ",", "");?><br/>
								<?=number_format($i['weight']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2, ",", "");?>
							</td>
							<?$weight += round($i['weight']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2);
							$volume += round($i['volume']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2);?>
						</tr>
					<?}
				}
			}
		}?>
		<?if($order['freight'] != 0){?>
			<tr>
				<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Итого:</td>
				<td class="br bb"><?=number_format($sum, 2, ",", "");?></td>
				<td class="bn">&nbsp;</td>
		</tr>
			<tr style="margin-top: 0px;">
				<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Услуги:</td>
				<td class="br bb"><?=number_format($order['freight'], 2, ",", "");?></td>
				<?$sum += $order['freight'];?>
				<td class="bn">&nbsp;</td>
			</tr>
		<?}
		if($order['order_discount'] != 0){?>
			<tr>
				<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Скидка:</td>
				<td class="br bb"><?="-".number_format($order['order_discount'], 2, ",", "");?></td>
				<?$sum -= $order['order_discount'];?>
				<td class="bn">&nbsp;</td>
			</tr>
		<?}?>
		<tr>
			<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;"><b>Всего к оплате:</b></td>
			<td class="br bb"><b><?=number_format($sum, 2, ",", "");?></b></td>
			<td class="bn">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8" class="bn" style="text-align: right;"></td>
            <td colspan="3" class="bn">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="11" class="bn" style="text-align: left; font-size: 14px;"><?=$GLOBALS['CONFIG']['invoice_customer_phrase']?></td>
		</tr>

		<tr><td colspan="11" class="bn">&nbsp;<br/>&nbsp;</td></tr>
		<tr>
			<td colspan="5" class="bn">отпустил___________________</td>
			<td colspan="5" class="bn">принял___________________</td>
			<td class="bn">&nbsp;</td>
		</tr>
	</tbody>
</table>
<?if(isset($Sertificates)){?>
	<br/>
	<?foreach($Sertificates as $s){?>
		<br/><br/>
		<img src="<?=file_exists($GLOBALS['PATH_root'].'/phpthumb/phpThumb.php?src='.$s.'&w=800')?_base_url.'/phpthumb/phpThumb.php?src='.$s.'&w=800':'/images/nofoto.png'?>" />
	<?}?>
<?}?>
</body>
</html>