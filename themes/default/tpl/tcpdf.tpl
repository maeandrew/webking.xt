<?php
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Оптовый интернет-магазин '.$GLOBALS['CONFIG']['shop_name']);
$pdf->SetTitle($order_details['id_order']);
$pdf->SetKeywords('накладная, счет, интернет-магазин, '.$GLOBALS['CONFIG']['shop_name']);
// set default header data
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ---------------------------------------------------------
// set font
$pdf->SetFont('freemono', '', 10);
// add a page
$pdf->AddPage();
//Исходные данные
$counter = 1;
$total_sum = 0;
$total_sum_fact = 0;
$fact_rows = '';
$rows = '';
//starting page
$content = '
<style rel="text/stylesheet">
	h2 {text-align: center;}
	p {line-height: 1.5em;height: 30px;}

	/* HEADER TABLE STYLES */

	table.header {
		max-width: 100%;
		border-collapse: collapse;
		}
	table.header tr th,
	table.header tr td {
		line-height: 2pt;
		border: none;
		}
	.recipient {
		width: 15%;
		}
		.recipient_value {
			width: 85%;
		}


	/* MAIN TABLE STYLES */

	table.main {
		width: 100%;
		border-collapse: collapse;
		}
	table.main tr th,
	table.main tr td {
		height: 20px;
		border: 1px solid #000;
		text-align: center;
		}
	table.main .num {
		width: 5%;
		}
	table.main .art {
		width: 7	%;
		}
	table.main .name {
		width: 47%;
		}
	table.main td.name {
		text-align: left;
		}
	table.main .unit {
		width: 8%;
		}
	table.main .price {
		width: 11%;
		}
	table.main .quantity_fact,
	table.main .quantity {
		width: 11%;
		}
	table.main .sum_fact,
	table.main .sum {
		width: 11%;
		}
	table.main .spacer {
		border: none;
		}
	table.main .total_sum_fact_label,
	table.main .total_sum_label {
		border: none;
		text-align: right;
		}
	table.main .total_sum_fact,
	table.main .total_sum {
		border: 1px solid #000;
		}
	img {
		float: left;
		}
</style>
';
$order_info ='
<h2>'.$settings['doctype'].' № &nbsp;'.$order_details['id_order'].'&nbsp;&nbsp; от &nbsp;&nbsp;'.date("d.m.Y", strtotime($settings['date'])).'г.</h2>
<table class="header" border="0">
	<tbody>
		<tr>
			<td class="recipient"><b>Поставщик:</b></td>
			<td class="recipient_value">'.$settings['data'].'</td>
		</tr>
		';
$content .= $order_info;
if(isset($cstmr)){
	$recipient = '
			<tr>
				<td class="recipient"><b>Покупатель:</b></td>
				<td class="recipient_value">'.$cstmr['cont_person'].', '.$order_details['address']['region'].', г. '.$order_details['address']['name'].', т. '.$cstmr['phones'].'</td>
			</tr>
	';
}elseif(isset($order_details['cont_person'])){
	$recipient = '
			<tr>
				<td class="recipient"><b>Покупатель</b></td>
				<td class="recipient_value">'.$order_details['cont_person'].'</td>
			</tr>
	';
}else{
	$recipient = '';
}
$content .= $recipient;
if(isset($settings['pay_form']) && $settings['pay_form'] !=''){
	$content .= '
			<tr>
				<td class="recipient"><b>Форма оплаты</b></td>
				<td class="recipient_value">'.$settings['pay_form'].'</td>
			</tr>
		</tbody>
	</table>
	<br>
	<br>
	';
}else{
	$content .= '
		</tbody>
	</table>
	<br>
	<br>
	';
}
$table_header = '
<table class="main" border="0">
	<thead>
		<tr>
			<th class="num"><b>№</b></th>
			<td class="art"><b>Арт.</b></td>
			<th class="name"><b>Наименование товара (работ, услуг)</b></th>
			<th class="unit"><b>Ед.</b></th>
			<th class="quantity"><b>Кол-во</b></th>
			<th class="price"><b>Цена</b></th>
			<th class="sum"><b>Сумма</b></th>
		</tr>
	</thead>
	<tbody>
	';
$fact_table_header = '
<table class="main" border="0">
	<thead>
		<tr>
			<th class="num"><b>№</b></th>
			<th class="art"><b>Арт.</b></th>
			<th class="name"><b>Наименование товара (работ, услуг)</b></th>
			<th class="unit"><b>Ед.</b></th>
			<th class="quantity_fact"><b>Кол-во факт.</b></th>
			<th class="price"><b>Цена</b></th>
			<th class="sum_fact"><b>Сумма факт.</b></th>
		</tr>
	</thead>
	<tbody>
	';
foreach($order as $o){
	if(isset($settings['fact'])){
		if ($o['contragent_qty'] > 0 && $o['contragent_mqty'] <= 0){
			$fact_rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity_fact">'.$o['contragent_qty'].'</td>
					<td class="price">'.number_format($o['site_price_opt']*$settings['margin'],2,",","").'</td>
					<td class="sum_fact">'.number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['contragent_qty'],2,",","").'</td>
				</tr>
			';
			$total_sum_fact += number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['contragent_qty'],2,",","");
			$counter++;
		}elseif($o['contragent_qty'] <= 0 && $o['contragent_mqty'] > 0){
			$fact_rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity_fact">'.$o['contragent_mqty'].'</td>
					<td class="price">'.number_format($o['site_price_mopt']*$settings['margin'],2,",","").'</td>
					<td class="sum_fact">'.number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['contragent_mqty'],2,",","").'</td>
				</tr>
			';
			$total_sum_fact += number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['contragent_mqty'],2,",","");
			$counter++;
		}elseif($o['contragent_qty'] > 0 && $o['contragent_mqty'] > 0){
			$fact_rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity_fact">'.$o['contragent_qty'].'</td>
					<td class="price">'.number_format($o['site_price_opt']*$settings['margin'],2,",","").'</td>
					<td class="sum_fact">'.number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['contragent_qty'],2,",","").'</td>
				</tr>
			';
			$counter++;
			$fact_rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity_fact">'.$o['contragent_mqty'].'</td>
					<td class="price">'.number_format($o['site_price_mopt']*$settings['margin'],2,",","").'</td>
					<td class="sum_fact">'.number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['contragent_mqty'],2,",","").'</td>
				</tr>
			';
			$total_sum_fact += number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['contragent_qty'],2,",","");
			$total_sum_fact += number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['contragent_mqty'],2,",","");
			$counter++;
		}
	}else{
		if($o['opt_qty'] > 0 && $o['mopt_qty'] <= 0 ){
			$rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity">'.$o['opt_qty'].'</td>
					<td class="price">'.number_format($o['site_price_opt']*$settings['margin'],2,",","").'</td>
					<td class="sum">'.number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['opt_qty'],2,",","").'</td>
				</tr>
			';
			$total_sum += number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['opt_qty'],2,",","");
			$counter++;
		}elseif($o['opt_qty'] <= 0 && $o['mopt_qty'] > 0){
			$rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity">'.$o['mopt_qty'].'</td>
					<td class="price">'.number_format($o['site_price_mopt']*$settings['margin'],2,",","").'</td>
					<td class="sum">'.number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['mopt_qty'],2,",","").'</td>
				</tr>
			';
			$total_sum += number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['mopt_qty'],2,",","");
			$counter++;
		}elseif($o['opt_qty'] > 0 && $o['mopt_qty'] > 0){
			$rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity">'.$o['opt_qty'].'</td>
					<td class="price">'.number_format($o['site_price_opt']*$settings['margin'],2,",","").'</td>
					<td class="sum">'.number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['opt_qty'],2,",","").'</td>
				</tr>
			';
			$counter++;
			$rows .= '
				<tr>
					<td class="num">'.$counter.'</td>
					<td class="art">'.$o['art'].'</td>
					<td class="name">'.$o['name'].'</td>
					<td class="unit">'.$o['units'].'</td>
					<td class="quantity">'.$o['mopt_qty'].'</td>
					<td class="price">'.number_format($o['site_price_mopt']*$settings['margin'],2,",","").'</td>
					<td class="sum">'.number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['mopt_qty'],2,",","").'</td>
				</tr>
			';
			$total_sum += number_format(round($o['site_price_opt']*$settings['margin'],2)*$o['opt_qty'],2,",","");
			$total_sum += number_format(round($o['site_price_mopt']*$settings['margin'],2)*$o['mopt_qty'],2,",","");
			$counter++;
		}
	}
}
if(isset($settings['NDS'])){
	$fact_summary_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>Всего без НДС:</b></td>
				<td class="total_sum_fact">'.number_format(($total_sum_fact*(1-20/120)),2,",","").'</td>
			</tr>
	';
	$summary_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>Всего без НДС:</b></td>
				<td class="total_sum">'.number_format(($total_sum*(1-20/120)),2,",","").'</td>
			</tr>
	';
	$fact_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>НДС(20%):</b></td>
				<td class="total_sum_fact">'.number_format(($total_sum_fact*(20/120)),2,",","").'</td>
			</tr>
	';
	$NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>НДС(20%):</b></td>
				<td class="total_sum">'.number_format(($total_sum*(20/120)),2,",","").'</td>
			</tr>
	';
	$fact_summary_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>Всего с НДС(20%):</b></td>
				<td class="total_sum_fact">'.number_format($total_sum_fact,2,",","").'</td>
			</tr>
	';
	$summary_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>Всего с НДС(20%):</b></td>
				<td class="total_sum">'.number_format($total_sum,2,",","").'</td>
			</tr>
	';
}else{
	$fact_summary_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>Всего без НДС:</b></td>
				<td class="total_sum_fact">'.number_format($total_sum_fact,2,",","").'</td>
			</tr>
	';
	$summary_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>Всего без НДС:</b></td>
				<td class="total_sum">'.number_format($total_sum,2,",","").'</td>
			</tr>
	';
	$fact_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>НДС(20%):</b></td>
				<td class="total_sum_fact">'.number_format(0,2,",","").'</td>
			</tr>
	';
	$NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>НДС(20%):</b></td>
				<td class="total_sum">'.number_format(0,2,",","").'</td>
			</tr>
	';
	$fact_summary_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_fact_label" colspan="2"><b>Всего с НДС(20%):</b></td>
				<td class="total_sum_fact">'.number_format($total_sum_fact,2,",","").'</td>
			</tr>
	';
	$summary_NDS_row = '
			<tr>
				<td class="spacer" colspan="4"></td>
				<td class="total_sum_label" colspan="2"><b>Всего с НДС(20%):</b></td>
				<td class="total_sum">'.number_format($total_sum,2,",","").'</td>
			</tr>
	';
}
if(isset($settings['fact'])){
	$content .= $fact_table_header;
	$content .= $fact_rows;
	$content .= $fact_summary_row;
	$content .= $fact_NDS_row;
	$content .= $fact_summary_NDS_row;
}else{
	$content .= $table_header;
	$content .= $rows;
	$content .= $summary_row;
	$content .= $NDS_row;
	$content .= $summary_NDS_row;
}
$invoice_footer_1 = '
		</tbody>
	</table>
	<br>
	<table style="width: 100%;">
		<tr>
			<td style="width:40%;line-height: 5px;" colspan="2">Место составления: г. Харьков</td>
		</tr>
		<tr>
			<td style="width:30%;line-height: 25px;"></td>
			';
$bill_footer_1 = '
			</tbody>
		</table>
		<br>
		<table style="width: 100%;">
		<tr>
			<td style="width:40%;line-height: 5px;" colspan="2">Место составления: г. Харьков</td>
		</tr>
		<tr>
		';
$stamp_pasichnik = '
	<td style="width: 40%;"><img alt="stamp" src="'._base_url.'/images/2835916412.png" /></td>
	';
$stamp_chuprina = '
	<td style="width: 40%;"><img alt="stamp" src="'._base_url.'/images/2903815255.png" /></td>
	';
$stamp_universal = '
	<td style="width: 40%;"><img alt="stamp" src="'._base_url.'/images/'.substr($settings['data'], -10).'.png" /></td>
	';
$invoice_footer_1_1 = '
	<td style="width:10%;line-height: 25px;"></td>
	<td style="width:10%;line-height: 5px;">Выписал:</td>
	';
$invoice_footer_1_2 = '
	<td style="width:10%;line-height: 25px;"></td>
	<td style="width:50%;line-height: 5px;">Выписал:</td>
	';
$invoice_footer_2 = '
		</tr>
	</table>
	';
$bill_footer_1_1 = '
	<td style="width:10%;line-height: 25px;"></td>
	<td style="width:10%;line-height: 25px;">Отправил:</td>
	';
$bill_footer_1_2 = '
	<td style="width:10%;line-height: 25px;"></td>
	<td style="width:50%;line-height: 5px;">Отправил:</td>
	';
$bill_footer_2 = '
			<td style="width:40%;line-height: 5px;">Получил:</td>
		</tr>
	</table>
	';
if($settings['doctype'] == 'Счет'){
	$content .= $invoice_footer_1;
	if(isset($settings['stamp'])){
		$content .= $invoice_footer_1_1;
		if($settings['recipient'] == 0){
			$content .= $stamp_universal;
		}elseif($settings['recipient'] == 1){
			$content .= $stamp_pasichnik;
		}elseif($settings['recipient'] == 2){
			$content .= $stamp_chuprina;
		}
	}else{
		$content .= $invoice_footer_1_2;
	}
	$content .= $invoice_footer_2;
}else{
	$content .= $bill_footer_1;
	if(isset($settings['stamp'])){
		$content .= $bill_footer_1_1;
		if($settings['recipient'] == 0){
			$content .= $stamp_universal;
		}elseif($settings['recipient'] == 1){
			$content .= $stamp_pasichnik;
		}elseif($settings['recipient'] == 2){
			$content .= $stamp_chuprina;
		}
	}else{
		$content .= $bill_footer_1_2;
	}
	$content .= $bill_footer_2;
}
// output content
$pdf->writeHTML($content, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>