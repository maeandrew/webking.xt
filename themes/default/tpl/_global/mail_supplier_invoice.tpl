<style>
	* { padding: 0; margin: 0; }
	.logo { font-size: 28px; color: #00F; font-weight: bold; }
	.undln { text-decoration: underline; }
	.lb { border-left: 1px dashed #000; padding-left: 5px; }
	.table_header { margin-left: 3px; width: 827px; }
	.table_header .top td { padding: 10px 0 15px 0; font-size: 14px; }
	.table_header .first_col { width: 150px; }
	.table_header .second_col { width: 300px; }
	.table_header .top span.invoice { margin-left: 20px; font-size: 18px; text-decoration: underline; }
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
	.table_main { margin: 10px 0 0 1px; clear: both; }
	.table_main td { padding: 1px 1px 0; font-size: 12px; text-align: center; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; font-size: 14px; font-weight: 900; }
	.table_main th { text-align: center; vertical-align: middle; font-weight: lighter; font-size: 11px;}
	.table_main td.name { padding: 1px; font-size: 12px; text-align: left; border-right: 1px #000 solid; border-bottom: 1px solid #000; }
	.table_main .hdr td { font-weight: bold; padding: 1px; }.
	.table_main .hdr1 td { text-align: left; }
	.table_main td.postname { text-align: left; }
	.table_main .main td { height: 50px; font-size: 14px; font-weight: 900; }
	.table_main .main td.img { width: 56px; }
	.table_sum { margin: 10px 0 0 1px; }
	.table_sum td { padding: 1px 1px 0; font-size: 12px; text-align: center; vertical-align: middle; }
	.table_sum td.name { padding: 1px; font-size: 12px; text-align: left; }
	.adate { font-size: 11px; margin-left: 177px; }
	.note_red { color: #f00; font-size: 14px; font-weight: 900; }
	.note_grin { color: #f00; font-size: 22px; font-weight: 900; }
	.break { page-break-before: always; }
	.break_after { page-break-after: always; }
	.dash { border-bottom: 1px #f00 dashed; margin-bottom: 10px; }
</style>

<div style="display: block;">
	<p style="margin: 1px 0 0 10px; font-size: 14px; font-weight: bold;">
		<div style="float:left">
			<span class="logo"><?=$_SERVER['SERVER_NAME']?></span>
		</div>
	</p>
	</div>
	<div style="clear: both; float:left; margin: 10px; font-size: 14px; font-weight: bold; width: 383px; padding-left: 10px;">
		<b><?=$supplier['name'].', '.$supplier['phone'].', '.$supplier['place']?></b>
	</div>
	<div style="float:left; margin: 10px; white-space: normal; width: 383px; padding-left: 10px;" class="bl">
		<p><?=$contragent['descr']?></p>
	</div>
	<div style="clear: both;"></div>
	<table border="0" cellpadding="0" cellspacing="0" style="width: 827px; clear: both; float: left; margin-top: 10px" class="table_main">
		<thead>
			<tr class="hdr">
				<th class="br bl bt bb">№ заказа</th>
				<th class="br bt bb">Сумма по отп. ценам</th>
				<th class="br bt bb">Сумма факт</th>
			</tr>
		</thead>
		<tbody>
	<?$otpusk = 0;
	$kotpusk  = 0;
	foreach($sorders[$id_supplier] as $k=>$o){?>
		<tr class="hdr">
			<td class="bl bb"><?=$k?></td>
			<td class="note_red bb"><?=$o['order_otpusk']?></td>
			<td class="bb br">&nbsp;</td>
		</tr>
		<?$otpusk += $o['order_otpusk'];
		$kotpusk += isset($o['site_sum'])?$o['site_sum']:0;
	}?>
	<tr class="hdr">
			<td class="bnb" style="text-align:right">Сумма</td>
			<td class="note_red"><?=$otpusk?></td>
			<td class="bb br">&nbsp;</td>
		</tr>
		<tr class="hdr">
			<td class="bnb note_red" style="text-align: right; font-size: 13pt;">Скидка</td>
			<td class="bb bt br">&nbsp;</td>
			<td class="bb bt br">&nbsp;</td>
		</tr>
		<tr class="hdr">
			<td class="bnb note_red" style="text-align: right; font-size: 13pt;">Сумма к оплате</td>
			<td class="bb br">&nbsp;</td>
			<td class="bb br">&nbsp;</td>
		</tr>
	</tbody>
</table>

<?foreach($supplier['orders'] as $order_key=>$order){?>
	<table class="table_main" border="0" cellpadding="0" cellspacing="0">
		<col style="width: <?=$c1?>;"/>
		<col style="width: <?=$c2?>;"/>
		<col style="width: <?=$c3?>;"/>
		<col style="width: <?=$c4?>;"/>
		<col style="width: <?=$c5?>;"/>
		<col style="width: <?=$c6?>;"/>
		<col style="width: <?=$c7?>;"/>
		<col style="width: <?=$c8?>;"/>
		<thead>
			<tr>
				<th colspan="9" style="border: 0;">
					<p style="font-size: 20px; font-weight: bold; width: 827px; text-align: center">№ &nbsp;<?=$order_key?> - <b style="font-size:16px; color: red"><?=$orders[$order_key]['note2']?></b></p>
				</th>
			</tr>
			<tr class="hdr">
				<th class="bt br bl bb">№</th>
				<th class="bt br bb">Арт</th>
				<th class="bt br bb">Фото</th>
				<th class="bt br bb">Название</th>
				<th class="bt br bb">Цена 1шт.</th>
				<th class="bt br bb">Заказано, шт</th>
				<th class="bt br bb">факт</th>
				<th class="bt br bb">Сумма</th>
			</tr>
		</thead>
		<tbody>
			<?$ii = 1;
			$sum = 0;
			$qty = 0;
			$weight = 0;
			$volume = 0;
			$sum_otpusk = 0;
			foreach($order as &$i){
				if($i['opt_qty'] > 0 && $i['id_supplier'] == $id_supplier){?>
					<tr class="main">
						<td class="bl bb"><?=$ii++?></td>
						<td class="bb"><?=$i['art']?></td>
						<td class="bb">
							<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
						</td>
						<td class="name bb">
							<?=$i['note_opt'] != ''?'<span class="note_red">'.$i['note_opt'].'</span><br>':null;?>
							<?=$i['name']?>
						</td>
						<td class="bb"><?=!$supplier['is_partner']?$i['price_opt_otpusk']:null;?></td>
						<td class="bb"><?=$i['opt_qty']?></td>
						<td class="bb">&nbsp;</td>
						<td class="bb"><?!$supplier['is_partner']?round($i['price_opt_otpusk']*$i['opt_qty'], 2):null;?></td>
					</tr>
					<?$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);
					$qty += $i['opt_qty'];
					$volume += $i['volume']*$i['opt_qty'];
					$weight += $i['weight']*$i['opt_qty'];
					$sum = round($sum+$i['opt_sum'],2);
				}
				if($i['mopt_qty'] > 0 && $i['id_supplier_mopt'] == $id_supplier){?>
					<tr class="main">
						<td class="bl bb"><?=$ii++?></td>
						<td class="bb"><?=$i['art']?></td>
						<td class="bb">
							<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
						</td>
						<td class="name bb">
							<?=$i['note_mopt'] != ''?'<span class="note_red">'.$i['note_mopt'].'</span><br>':null;?>
							<?=$i['name']?>
						</td>
						<td class="bb"><?=!$supplier['is_partner']?$i['price_mopt_otpusk']:null?></td>
						<td class="bb"><?=$i['mopt_qty']?></td>
						<td class="bb">&nbsp;</td>
						<td class="bb"><?=!$supplier['is_partner']?round($i['price_mopt_otpusk']*$i['mopt_qty'], 2):null;?></td>
					</tr>
					<?$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)),2);
					$qty += $i['mopt_qty'];
					$volume += $i['volume']*$i['mopt_qty'];
					$weight += $i['weight']*$i['mopt_qty'];
					$sum = round($sum+$i['mopt_sum'],2);
				}
			}?>
			<tr class="table_sum">
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn" style="text-align: right">Сумма:</td>
				<td class="br bb bl"><?=!$supplier['is_partner']?'<div class="note_red">'.$sum_otpusk.'</div>':null;?></td>
			</tr>
		</tbody>
	</table>
<?}?>
