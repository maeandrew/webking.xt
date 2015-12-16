<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Сводная накладная</title>
	<style>
	body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td { 
	margin:0; padding:0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline}
:focus {outline:0}
html,body {height:100%}
body {font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 12px; color: #333;}


.logo{font-size: 28px; color: #00F; font-weight: bold;}

.undln{text-decoration:underline;}
.lb{border-left:1px dashed #000;padding-left:5px;}

.table_header{margin-left:3px;width:827px;}
.table_header .top td{padding:10px 0 15px 0;font-size:14px;}
.table_header .first_col{width: 150px;}
.table_header .second_col{width: 300px;}
.table_header .top span.invoice{margin-left:20px;font-size:18px;text-decoration:underline;}

.bl{border-left:1px solid #000;}
.br{border-right:1px solid #000;}
.bt{border-top:1px solid #000;}
.bb{border-bottom:1px solid #000 !important;}
.bn{border:none !important;}
.bla{ text-align:left;}

.bnb{border-bottom:none !important;}

.blf{border-left:1px solid #FFF;}
.brf{border-right:1px solid #FFF;}
.bbf{border-bottom:1px solid #FFF;}

.table_main{margin:10px 0 0 1px; clear:both; page-break-inside: avoid}
.table_main td{padding:1px 1px 0;font-size:12px; text-align:center; border-right:1px #000 solid;border-bottom:1px #000 solid;vertical-align: middle;}

.table_main td.name{padding:1px;font-size:12px; text-align:left; border-right:1px #000 solid;border-bottom:1px #000 solid;}
.table_main .hdr td{font-weight: bold;padding: 1px;}.
.table_main .hdr1 td{text-align:left}

.table_main .main td{height:50px;}
.table_main .main td.img{width:56px;}

.table_sum{margin:10px 0 0 1px;}
.table_sum td{padding:1px 1px 0;font-size:12px; text-align:center; vertical-align: middle;}
.table_sum td.name{padding:1px;font-size:12px; text-align:left;}


tr.min td{height: 1px; font-size: 1px;line-height: 1px;margin: 0px;padding: 0px;}

.adate{font-size: 11px;margin-left: 177px;}
.note_red{color:Red;font-size: 14px; font-weight:900;}
.note_grin{color:Red;font-size: 22px; font-weight:900;}

.break{page-break-before: always}
.break_after{page-break-after: always;}
.dash {border-bottom:1px #000 dashed; margin-bottom: 10px;}

        

	</style>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr class="top">
			<td colspan="4">
				<span class="invoice">Машрут от <?=date("d.m.Y",time())?></span></td>
		</tr>
		
</table>

     <table class="table_main" border="0" cellpadding="0" cellspacing="0"> 

        <tr class="hdr" height="40">
    <td class="bl bt">№</td>
    <td class="bt">Заказ</td>
   <td class="bt">Сумма</td>
   <td class="bt">Наценка</td>
   <td class="bt">Данные покупателя</td>
    <td class="bt">Примечание 1</td>
    <td class="bt">Примечание 2</td>


        </tr>


    <?php $i = 1; ?>
    <?$sum_order=0 ?>
    <?$sum_nacen=0 ?>
    <?php foreach($orders as $order): ?>
    <tr >
        <td width=25 class="bl"><?php echo $i?></td>
        <td width=25 ><p style="font-size:16px;font-weight:bold"><?php echo $order['id_order']?></p></td>
       <td width=100 ><p style="font-size:16px;font-weight:bold"><?php echo $order['sum_discount'] ?></p><p  style="font-size:16px;font-weight:bold"></span></p></td>
        <?$sum_order+=$order['sum_discount']?>
       <td width=100 ><p style="font-size:16px;font-weight:bold"><?php echo round((1-$order['discount'])/0.95, 4) ?></p><p  style="font-size:16px;font-weight:bold"></span></p></td>
        <?$sum_nacen+=$order['sum_discount']-$order['sum_discount']*(0.95/(1-$order['discount'])) ?>

       <td width=* ><p style="font-size:16px;font-weight:bold"><?php echo $order['cont_person'].' '.$order['phones'].' '.$order['addr_descr'] ?></p></td>

        <td width=140 ><p style="font-size:16px;font-weight:bold"><?php echo $order['note'] ?></p></td>

       <td width=100 style="font-size:10px;font-weight:bold"><?php echo $order['note2'] ?></td>

    </tr>
    <?php $i++; ?>
    <?php endforeach ?>


<tr class="hdr">
    <!-- <td class="bnb" style="text-align:right" height="30"></td>-->
   <!--  <td class="note_red"><?=$otpusk?></td>-->

    <td ></td>
    <td class="bnb" style="text-align:right">Сумма</td>
    <td ><?=$sum_order?></td>
    <td ><?=round($sum_nacen, 2)?></td>
    </tr>

</table>


  

</body>
</html>