<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Накладная покупателя</title>
<style>
	body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td {
	margin:0; padding:0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline;position: relative;}
	:focus {outline:0}
	html,body {height:100%}
	body {font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 12px; color: #333;}
	.logo{font-size: 28px; color: #00F; font-weight: bold;}
	/*.undln{text-decoration:underline;}*/
	/*.lb{border-left:1px dashed #000;padding-left:5px;}*/
	.table_header {width:800px;padding: 10px;padding-bottom: 0px;}
	.table_header .top td {padding-top: 10px;font-size:14px;}
	.table_header .first_col {width: 90px;}
	.table_header .second_col {width: 325px;font-weight: bold;}
	/*.table_header .top span.invoice {margin-left:20px;font-size:18px;text-decoration:underline;}*/
	.table_header .top span.invoice {font-size:18px;font-weight: bold;}
	.bl{border-left:1px solid #000;}
	.br{border-right:1px solid #000;}
	.bt{border-top:1px solid #000;}
	.bb{border-bottom:1px solid #000 !important;}
	.blf{border-left:1px solid #FFF !important;}
	.brf{border-right:1px solid #FFF !important;}
	.bbf{border-bottom:1px solid #FFF !important;}
	/*.table_main{margin:10px 0 0 1px;}*/
	.table_main{padding: 10px;}
	.table_main td{padding:1px 1px 0;font-size:12px; text-align:center; border-right:1px #000 solid;border-bottom:1px #000 solid;vertical-align: middle;}
	.table_main td.name{padding:1px;padding-left: 5px;padding-right: 5px;font-size:12px; text-align:left; border-right:1px #000 solid;border-bottom:1px #000 solid;}
	.table_main .hdr td{font-weight: bold;padding: 1px;}
	.table_main .main td{height:50px;}
	.table_main .main td.img{width:56px;}
	.table_sum{margin:10px 0 0 1px;}
	.table_sum td{padding:1px 1px 0;font-size:12px; text-align:center; vertical-align: middle;}
	.table_sum td.name{padding:1px;font-size:12px; text-align:left;}
	tr.min td{height: 1px; font-size: 1px;line-height: 1px;margin: 0px;padding: 0px;}
	.adate{font-size: 11px;margin-left: 177px;}
	.note_red{color:Red;font-size: 11px; font-weight:normal;}
	.stamp {
		position: absolute;
		width: 40%;
		top: -50px;
		right: 40%;
		-webkit-transform: rotate(-20deg);
		-ms-transform: rotate(-20deg);
		-o-transform: rotate(-20deg);
		transform: rotate(-20deg);
	}
	.spacer {
		height: 1em;
	}
	.hidden {
		display: none;
	}
</style>
</head>
<body>
	<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tbody>
			<tr>
	            <td colspan="4"  valign="top" style="padding: 0 18px; font-family: Arial, &quot;Helvetica Neue&quot;, Helvetica, sans-serif; font-size: 24px; font-weight: bold; text-align: center;">
	                <img align="none" height="52" src="https://xt.ua/themes/default/img/xt.png" style="width: 175px; height: 52px; margin: 0px;" width="175">
	            </td>
			</tr>
			<tr class="top">
				<td align="center" colspan="4">
					<!-- <span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span> -->
					<span class="invoice">Счет № <?=$id_order?> от <?=date("d.m.Y",$order['creation_date'])?></span>
				</td>
			</tr>
		</tbody>
	</table>
	<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" style="padding: 10px; ">
		<tbody>
			<tr>
				<td>Получатель:</td>
				<td style="font-weight: bold;">
					<?=trim($Customer['last_name'].$Customer['first_name'].$Customer['middle_name']) == ''?$Customer['cont_person']:trim($Customer['last_name']).' '.trim($Customer['first_name']).' '.trim($Customer['middle_name'])?>, тел. <?=$Customer['phone']?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<span class="undln"></span>
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
	$c3 = 60;
	$c4 = 48;
	$c5 = 384;
	$c6 = 60;
	$c8 = 60;
	$c10 = 60;
	$c13 = 60;
	?>
	<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" class="table_main">
		<col width="<?=$c1?>" />
		<col width="<?=$c2?>" />
		<col width="<?=$c3?>" class="<?=isset($_GET['nophoto']) && $_GET['nophoto'] == true?'hidden':null;?>" />
		<col width="<?=$c4?>" />
		<col width="<?=$c5?>" />
		<col width="<?=$c6?>" />
		<col width="<?=$c8?>" />
		<col width="<?=$c10?>" />
		<col width="<?=$c13?>" />
		<tbody>
			<tr class="hdr">
				<td class="bl bt">№</td>
				<td class="bt">Скл.</td>
				<td class="bt">Артикул</td>
				<td class="bt <?=isset($_GET['nophoto']) && $_GET['nophoto'] == true?'hidden':null;?>">Фото</td>
				<td class="bt">Название</td>
				<td class="bt">Цена за шт.</td>
				<td class="bt">заказано, шт</td>
				<td class="bt">Сумма</td>
				<td class="bt">Вес,<br>Объем</td>
			</tr>
			<?$ii=1;$qty=0;$weight=0;$volume=0;?>
			<?if(isset($arr)){
			foreach ($arr as &$a){
				foreach($a as &$i){?>
				<?if($i['opt_qty']>0){?>
				<tr class="main">
					<td class="bl c1"><?=$ii++?></td>
					<td class="c2"><?=$i['article']?></td>
					<td class="c6"><?=$i['art']?></td>
					<td class="c3 <?=isset($_GET['nophoto']) && $_GET['nophoto'] == true?'hidden':null;?>">
						<?if(isset($i['image']) && !empty($i['image'])){?>
							<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=$i['name']?>">
						<?}else if(!empty($i['img_1'])){?>
							<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
						<?}else {?>
							<img height="48" src="<?=_base_url?>/images/nofoto.png" />
						<?}?>
					</td>
					<td class="name c4">
						<?=$i['name']?>
						<?if ($i['note_opt']!=''){?>
							<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_opt'])?></span>
						<?}?>
					</td>
					<td class="c5"><?=$i['site_price_opt']?></td>
					<td class="c8"><?=$i['opt_qty']?></td><?$qty+=$i['opt_qty'];?>
					<td class="c10"><?=$i['opt_sum']?></td>
					<td class="c13"><?=round($i['volume']*$i['opt_qty'],2)?><br><?=round($i['weight']*$i['opt_qty'],2)?></td>
					<?$weight+=round($i['weight']*$i['opt_qty'],2);?><?$volume+=round($i['volume']*$i['opt_qty'],2);?>
				</tr>
				<?}
				if($i['mopt_qty']>0){?>
					<tr>
						<td class="bl c1"><?=$ii++?></td>
						<td class="c2"><?=$i['article_mopt']?></td>
						<td class="c6"><?=$i['art']?></td>
						<td class="c3 <?=isset($_GET['nophoto']) && $_GET['nophoto'] == true?'hidden':null;?>">
							<?if(isset($i['image']) && !empty($i['image'])){?>
								<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=$i['name']?>">
							<?}else if(!empty($i['img_1'])){?>
								<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
							<?}else {?>
								<img height="48" src="<?=_base_url?>/images/nofoto.png" />
							<?}?>
						</td>
						<td class="name c4">
							<?=$i['name']?>
							<?if ($i['note_mopt']!=''){?>
								<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_mopt'])?></span>
							<?}?>
						</td>
						<td class="c5"><?=$i['site_price_mopt']?></td>
						<td class="c8"><?=$i['mopt_qty']?></td><?$qty+=$i['mopt_qty'];?>
						<td class="c10"><?=$i['mopt_sum']?></td>
						<td class="c13"><?=round($i['volume']*$i['mopt_qty'],2)?><br><?=round($i['weight']*$i['mopt_qty'],2)?></td>
						<?$weight+=round($i['weight']*$i['mopt_qty'],2);?><?$volume+=round($i['volume']*$i['mopt_qty'],2);?>
					</tr>
				<?}?>
				<?}?>
			<?}
			}?>
			<tr>
				<td class="bbf blf" <?=isset($_GET['nophoto']) && $_GET['nophoto'] == true?'colspan="6"':'colspan="7"';?> colspan="7" style="text-align:right;padding: 5px;">Сумма:</td>
				<td class="br bb" style="font-weight:bold;"><?=round($order['sum_discount'],2)?></td>
				<td class="br bb" style="font-weight:bold;"><?=round($volume,2)?><br><?=round($weight,2)?></td>
			</tr>
		</tbody>
	</table>
	<table align="center" width="800" style="padding: 10px;">
		<tbody>
			<tr>
				<td colspan=11 class="nb" style="text-align: left;">Действует в течении 3 дней</td>
			</tr>
			<tr>
				<td colspan=11 class="nb">&nbsp;<br>&nbsp;</td>
			</tr>
			<tr>
				<td colspan=4 class="nb">Выписал___________________<!-- <img class="stamp" src="<?=$GLOBALS['URL_base'];?>/images/2754500962.png" alt=""> --></td>
				<td colspan=4 class="nb">Принял___________________</td>
				<td colspan=3 class="nb">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<?if(isset($Sertificates)){?>
		<br>
		<?foreach ($Sertificates as $s){?>
			<br><br>
			<img src="<?=file_exists($GLOBALS['PATH_root'].'/phpthumb/phpThumb.php?src='.$s.'&w=800')?_base_url.'/phpthumb/phpThumb.php?src='.$s.'&w=800':'/images/nofoto.png'?>" />
		<?}?>
	<?}?>
	</body>
</html>
