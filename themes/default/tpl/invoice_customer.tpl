<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Накладная покупателя</title>
	<style>
		body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6,
		pre, form, label, fieldset, img, input, textarea, p,
		blockquote, th, td {
			margin: 0;
			padding: 0;
			border: 0;
			outline: 0;
			font-size: 100%;
			vertical-align: baseline;
			position: relative;
		}
		body.invoice {
			font-family: "Roboto", Helvetica, sans-serif;
			font-size: 12px;
			color: #333;
		}
		.invoice .table {
			margin: 0 auto;
		}
		.invoice .header * {
			line-height: 30px;
		}
		.invoice .header .logo {
			display: inline-block;
			height: 30px;
			width: auto;
			vertical-align: top;
			margin-right: 15px;
		}
		.invoice .header .title {
			font-size: 18px;
			font-weight: bold;
		}
		.invoice .header .site {
			font-size: 36px;
			text-align: right;
			float: right;
			font-weight: bold;
		}
		.invoice .undln {
			text-decoration: underline;
		}
		.invoice .table_header {
			width: 800px;
			padding: 10px;
			padding-bottom: 0px;
		}
		.invoice .table_header .top td {
			padding-top: 15px;
			font-size: 14px;
		}
		.invoice .table_header .first_col {
			width: 90px;
		}
		.invoice .table_header .second_col {
			width: 325px;
			font-weight: bold;
		}
		/*.table_header .top span.invoice {margin-left:20px;font-size:18px;text-decoration:underline;}*/

		.invoice .table_header .top .title {
			font-size: 18px;
			font-weight: bold;
		}
		.invoice .bl {
			border-left: 1px solid #000;
		}
		.invoice .br {
			border-right: 1px solid #000;
		}
		.invoice .bt {
			border-top: 1px solid #000;
		}
		.invoice .bb {
			border-bottom: 1px solid #000 !important;
		}
		.invoice .blf {
			border-left: 1px solid #FFF !important;
		}
		.invoice .brf {
			border-right: 1px solid #FFF !important;
		}
		.invoice .bbf {
			border-bottom: 1px solid #FFF !important;
		}
		/*.table_main{margin:10px 0 0 1px;}*/

		.invoice .table_main {
			padding: 10px;
		}
		.invoice .table_main td {
			padding: 1px 1px 0;
			font-size: 12px;
			text-align: center;
			border-right: 1px #000 solid;
			border-bottom: 1px #000 solid;
			vertical-align: middle;
		}
		.invoice .table_main td.name {
			padding: 1px;
			padding-left: 5px;
			padding-right: 5px;
			font-size: 12px;
			text-align: left;
			border-right: 1px #000 solid;
			border-bottom: 1px #000 solid;
		}
		.invoice .table_main .hdr td {
			font-weight: bold;
			padding: 1px;
		}
		.invoice .table_main .main td {
			height: 50px;
		}
		.invoice .table_main .main td.img {
			width: 56px;
		}
		.invoice .table_sum {
			margin: 10px 0 0 1px;
		}
		.invoice .table_sum td {
			padding: 1px 1px 0;
			font-size: 12px;
			text-align: center;
			vertical-align: middle;
		}
		.invoice .table_sum td.name {
			padding: 1px;
			font-size: 12px;
			text-align: left;
		}
		.invoice tr.min td {
			height: 1px;
			font-size: 1px;
			line-height: 1px;
			margin: 0px;
			padding: 0px;
		}
		.invoice .adate {
			font-size: 11px;
			margin-left: 177px;
		}
		.invoice .note_red {
			color: Red;
			font-size: 11px;
			font-weight: normal;
		}
		.invoice .stamp {
			position: absolute;
			width: 40%;
			top: -50px;
			right: 40%;
			-webkit-transform: rotate(-20deg);
			-ms-transform: rotate(-20deg);
			-o-transform: rotate(-20deg);
			transform: rotate(-20deg);
		}
		.invoice .spacer {
			height: 1em;
		}
		.invoice .hidden {
			display: none;
		}
	</style>
</head>
<body class="invoice">
	<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" class="table_header">
		<colgroup>
			<col width="50%" />
			<col width="50%" />
		</colgroup>
		<tbody>
			<tr>
				<td colspan="2" class="header">
					<img src="https://xt.ua/themes/default/img/xt.png" class="logo">
					<span class="title">Расходная накладная № <?=$id_order?> от <?=date("d.m.Y",$order['creation_date'])?></span>
					<span class="site">xt.ua</span>
				</td>
			</tr>
			<tr class="top">
				<td>
					<span class="subtitle"><b>Отправитель:</b></span>
					<p><?=!isset($remitter)?'Не указан':$remitter['name'].'<br>, '.$remitter['address'].', '.($remitter['rs']==''?null:'Р/с '.$remitter['rs'].', ').'МФО '.$remitter['mfo'].', '.$remitter['bank'].', ЕГРПОУ '.$remitter['egrpou'];?></p>
					<br>
					<span class="subtitle"><b>Менеджер:</b></span>
					<p><?=$contragent['name'].', '.$contragent['phone']?></p>
				</td>
				<td>
					<span class="subtitle"><b>Получатель:</b></span>
					<p><?=$customer['last_name'].' '.$customer['first_name'].' '.$customer['middle_name'].', '.@$user['phone'];?>
						<br>
						<?=empty($address)?'Адрес доставки не указан':$address['region_title'].', '.$address['city_title'].', '.$address['delivery_type_title'].', '.$address['shipping_company_title'].', '.($address['id_delivery'] == 1?$address['delivery_department']:$address['address']);?>
					</p>
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
