<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Накладная покупателя</title>
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
.table_header .first_col{width: 90px;}
.table_header .second_col{width: 325px;}
.table_header .top span.invoice{margin-left:20px;font-size:18px;text-decoration:underline;}
.bl{border-left:1px solid #000;}
.br{border-right:1px solid #000;}
.bt{border-top:1px solid #000;}
.bb{border-bottom:1px solid #000 !important;}
.blf{border-left:1px solid #FFF;}
.brf{border-right:1px solid #FFF;}
.table_main{margin:10px 0 0 0px;}
.table_main td{padding:1px 1px 0;font-size:12px; text-align:center; border-right:1px #000 solid;border-bottom:1px #000 solid;vertical-align: middle; border-left:1px #000 solid;}
.table_main td.name{padding:1px;font-size:12px; text-align:left; border-right:1px #000 solid;border-bottom:1px #000 solid; border-left:1px #000 solid}
.table_main .hdr td{font-weight: bold;padding: 1px;}
.table_main .main td{height:50px;}
.table_main .main td.img{width:56px;}
.table_sum{margin:10px 0 0 1px;}
.table_sum td{padding:1px 1px 0;font-size:12px; text-align:center; vertical-align: middle;}
.table_sum td.name{padding:1px;font-size:12px; text-align:left;}
tr.min td{height: 1px; font-size: 1px;line-height: 1px;margin: 0px;padding: 0px;}
.adate{font-size: 11px;margin-left: 177px;}
.note_red{color:Red;font-size: 11px; font-weight:normal;}
	</style>
	</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="table_header">
	<tbody>
		<tr class="top">
			<td colspan="4">
				 <span class="invoice">Прайс <?=str_repeat("&nbsp;", 5)?></span>
				<br><span >Телефон для заказа товара: <?=$Customer['address_ur']?></span></td>
		</tr>
	</tbody>
	</table>
<?
$c3 = 60;
$c4 = 230;
$c5 = 45;
$c6 = 60;
$c8 = 30;
$c9 = 36;
$c11 = 60;
$c12 = 230;
$c13 = 45;
$c14 = 60;
$c16 = 30;
?>
<table border="0" cellpadding="0" cellspacing="0" class="table_main">
<col width=<?=$c6?> />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c8?> />
<col width=<?=$c9?> />
<col width=<?=$c14?> />
<col width="<?=$c11?>" />
<col width="<?=$c12?>" />
<col width=<?=$c13?> />
<col width=<?=$c16?> />
	<tbody>
		<tr class="hdr">
			<td rowspan="2" class="bt">
				Артикул</td>
			<td rowspan="2" class="bt">
				Фото</td>
			<td rowspan="2" class="bt">
				Название</td>
			<td rowspan="2" class="bt">
				Цена за шт.</td>
			<td rowspan="2" class="bt">
				Мин. к-во</td>
                        <td >
                        </td>
			<td rowspan="2" class="bt">
				Артикул</td>
			<td rowspan="2" class="bt">
				Фото</td>
			<td rowspan="2" class="bt">
				Название</td>
			<td rowspan="2" class="bt">
				Цена за шт.</td>
			<td rowspan="2" class="bt">
				Мин. к-во</td>
		</tr>
		<?$ii=1;$qty=0;$weight=0;$volume=0;?>
		</tbody></table>
		<table  >
		<?foreach ($arr as $i){?>
		<?if ($ii & 1){?>
			<?if ($i['price_mopt'] != 0){?>
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;">
		<col width=<?=$c6?> />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c8?> />
		<tbody>
            		<tr >
			<td class="c6">
				<?=$i['art']?></td>
			<td class="c3"><img height="48" width="48" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1'])):'/images/nofoto.png'?>" /></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_mopt']!=''){?> <span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
			<td class="c5">
				<?=round($i['price_mopt']*(1-$Customer['discount']/100), 2)?></td>
			<td class="c8">
				<?=$i['mopt_qty']?></td>
            		</tr >
		</tbody> </table>
		</td>
<td style="width:30px;">
</td>
<td>
<? } ?>
<? } else  {?>
	<?if ($i['price_mopt'] != 0){?>
		<table border="0" cellpadding="0" cellspacing="0"  class="table_main" style="margin-top: 0px;" >
		<col width=<?=$c6?> />
<col width="<?=$c3?>" />
<col width="<?=$c4?>" />
<col width=<?=$c5?> />
<col width=<?=$c8?> />
		<tbody>
              		<tr >
			<td class="c6">
				<?=$i['art']?></td>
			<td class="c3"><img height="48" width="48" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $i['img_1'])):'/images/nofoto.png'?>" /></td>
			<td class="name c4">
				<?=$i['name']?><?if ($i['note_mopt']!=''){?> <span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
			<td class="c5">
				<?=round($i['price_mopt']*(1-$Customer['discount']/100), 2)?></td>
			<td class="c8">
				<?=$i['mopt_qty']?></td>
            		</tr >
		</tbody> </table>
		<?}?>
		<? } ?>
    <?$ii++;?>
		<?}?>
		</td></tr></table>
</body>
</html>