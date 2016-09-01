<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Прайс-лист</title>
    <style type="text/css">
        @media print {
            table { page-break-inside: avoid; }
            h1 { display: none}
        }
        h1 {
            width: 800px;
            margin: 0 auto;
            text-align: center;
            line-height: 50px;
        }
        th { font-size: 25px; }
        table {
            text-align: center;
            border-right: none;
            border-bottom: none;
            border-collapse: collapse;
            margin: auto;
            page-break-inside: avoid;
        }
        .line { border-top: 0; border-right: 0; }
        .main { margin-top: 40px; border: 1px solid #000;}
        .price {
            max-height: 20px;
            height: 20px;
        }
        <?if($_GET['photo'] != 2){?>
		td,th {
			border-top: none;
			border-left: none;
			padding: 0 5px;
		}
        table {
            width: 800px;
        }
        .price_container { padding: 0; }
        .price_container span { display: block; }
        span.best_price {
            width: 30px;
            height: 30px;
            margin-left: 20%;
        }
        <?if(count($_GET['column']) > 1){?>
			.price-0 { background: #afa; }
        .price-1 { background: #aef; }
        .price-2 { background: #ffa; }
        .price-3 { background: #faa; }
        <?}
        }else{?>
		* {
			margin: 0;
			padding: 0;
			font-family: "Arial", Helvetica, sans-serif;}
         table {
             width: 100%;
         }
        body {
            width: 1077px;
            margin: 0 auto;
        }
        <?if(count($_GET['column']) > 1){?>
			.price-0 span { background: #afa; }
        .price-1 span { background: #aef; }
        .price-2 span { background: #ffa; }
        .price-3 span { background: #faa; }
        .price span { margin: 0 auto; display: block; width: 100px;}
        <?}?>
        .description {
            position: relative;
            text-shadow: 1px 1px 0 #fff, -1px 1px 0 #fff, 1px -1px 0 #fff, -1px -1px 0 #fff;
            line-height: 20px;
            color: #000;
            font-size: 15pt;
            height: 50px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            z-index: 50;
            font-weight: bold;
        }
        .line {
            border-left: 1px solid #000;
        }
        .line td.product {
            position: relative;
            width: 50%;
            max-width: 50%;
            border: 0;
        }
        .product table {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            padding: 0;
        }
        .product tr th,
        .product tr td {
            text-align: center;
            font-weight: normal;
            font-size: 18px;
            border: 1px solid #000;
        }
        .product .photo {
            overflow: hidden;
            width: 250px;
            padding-bottom: 10px;
            line-height: 0;
            border: 0;
        }
        .product tr.title td.name {
            padding-left: 5px;
            width: 100%;
            font-size: 15px;
            text-align: left;
            border: 0;
        }
        .product tr.title td.name p {
            font-size: 20px;
        }
        .product tr.art td.art {
            padding-right: 5px;
            width: 100%;
            font-size: 15px;
            text-align: right;
            border: 0;
            height: 20px;
        }
        .product tr.header td {
            line-height: 15px;
            height: 15px;
            font-size: 13px;
        }
        .product tr td.quantity {
            max-width: 70px;
        }
        .product tr.price {
            max-height: 20px;
        }
        .product tr td.quantity p,
        .product tr td.price p {
            color: #e00;
            width: 100%;
            font-size: 12pt;
        }
        .product tr.header td,
        .product tr.quantity td,
        .product tr.price td {
            border-bottom: 0;
        }
        span.best_price {
            position: absolute;
            width: 50px;
            height: 50px;
            top: 0;
            right: 0;
        }
        <?}?>
        table.information {
            page-break-after: always;
            width: 500px;
            text-align: left;
        }
        table.information th {
            text-align: center;
            font-weight: normal;
            font-size: 18px;
        }
        table.information th,
        table.information td {
            padding: 0 5px;
            border: 1px solid #000;
        }
        table.information .price {
            text-align: center;
            width: 100px;
        }
        span.best_price {
            display: block;
            background-image: url('../../images/best_price.png');
            -webkit-background-size: 100%;
            background-size: 100%;
            background-repeat: no-repeat;
        }
        div.article,
        div.photo_inner {
            position: relative;
        }
        div.photo_inner img {
            position: relative;
            max-height: 245px;
            z-index: 0;
        }
        h1.global_cat {
            page-break-before: always;
        }
        h1.global_cat:first-of-type {
            page-break-before: avoid;
        }
    </style>
</head>
<body>
<?$price = array(
	'0'=>"При сумме заказа более ".$GLOBALS['CONFIG']['full_wholesale_order_margin']."грн.",
'1'=>"При сумме заказа от ".$GLOBALS['CONFIG']['wholesale_order_margin']." до ".$GLOBALS['CONFIG']['full_wholesale_order_margin']."грн.",
'2'=>"При сумме заказа от ".$GLOBALS['CONFIG']['retail_order_margin']." до ".$GLOBALS['CONFIG']['wholesale_order_margin']."грн.",
'3'=>"При сумме заказа до ".$GLOBALS['CONFIG']['retail_order_margin']."грн.",
);?>
<?if(count($_GET['column']) > 1){?>
<table class="information">
<tr>
<th colspan="2">Цветовые обозначения</th>
</tr>
<?foreach($_GET['column'] as $column){?>
<tr>
<td><?=$price[$column];?></td>
<td class="price price-<?=$column?>"><span>#,## грн.</span></td>
</tr>
<?}?>
</table>
<?}?>
<?if($_GET['photo'] == 0){
	$headrow = "<td style=\"width: 50px;\">Арт.</td>
<td>Наименование</td>
<td style=\"width: 60px;\">Мин. кол-во</td>
<td style=\"width: 70px;\">Цена за ед. товара</td>";
}elseif($_GET['photo'] == 1){
$headrow = "<td style=\"width: 50px;\">Арт.</td>
<td style=\"width: 90px;\">Фото</td>
<td>Наименование</td>
<td style=\"width: 60px;\">Мин. кол-во</td>
<td style=\"width: 70px;\">Цена за ед. товара</td>";
}
if(isset($_GET['savedprices']) == false){
if($_GET['header']){
echo "<h1>".$_GET['header']."</h1>";
}else{
echo "<h1>Прайс-лист оптового интернет-магазина ".$GLOBALS['CONFIG']['shop_name']."</h1>";
}
}else{
echo "<h1>".$name."</h1>";
}
if($_GET['photo'] == 2){
if(isset($_GET['savedprices']) == true){
$ii = 0;
foreach($list as $l1){
if(isset($l1['subcats'])){
echo "<h1 ";
if($ii > 0){
echo "class=\"global_cat\"";
}
echo ">".$l1['name']."</h1>";
$ii++;
foreach($l1['subcats'] as $l2){
$i2 = 1;
if(empty($l2['products']) == false){
foreach($l2['products'] as $p){?>
<?if($p['price_mopt'] == 0){
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
}
}else{
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
}
}?>
<?if(($i2%2) == 1){?>
<?if($i2 == 1){?>
<table border="0" class="line" style="margin-top: 40px">
<tr class="main" style="background: #eee; height: 50px;">
<th colspan="2"><?=$l2['name'];?></th>
</tr>
<?}else{?>
<table border="0" class="line">
<?}?>
<tr>
<td class="product">
<?}?>
<table>
    <tr class="title">
        <td class="photo" rowspan="<?=count($_GET['column'])+4?>">
            <div class="photo_inner">
                <?if($p['image'] != ''){?>
                <img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
                <!-- <img height="250" src="<?=_base_url.G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>"> -->
                <?}else{?>
                <img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
                <!-- <img height="250" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>" /> -->
                <?}?>
                <!-- <img height="250" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>"/> -->
                <?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
                <span class="best_price" title="Лучшая цена"></span>
                <?}?>
            </div>
        </td>
        <td class="name" colspan="3"><p><?=$p['name']?></p></td>
    </tr>
    <tr class="art">
        <td class="art" colspan="3">Арт. <?=$p['art'];?></td>
    </tr>
    <tr class="header">
        <td class="quantity">Мин. кол-во</td>
        <td class="price">Цена за ед. товара</td>
    </tr>
    <tr class="min_qty">
        <td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
        <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
        echo number_format($p['price_mopt']*$margin,2,",","");
        }else{
        foreach($_GET['column'] as $column){?>
        <td class="price price-<?=$column;?>">
        <span><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
        </td>
        </tr>
        <tr>
        <?}
        }?>
</table>
<?if(($i2%2) == 1){?>
</td>
<td class="product">
<?}else{?>
</td>
</tr>
</table>
<?}
							$i2++;
						}
						if(($i2%2) == 0){?>
</table>
<?}
					}elseif(empty($l2['subcats']) == false){
						foreach($l2['subcats'] as $l3){
							$i3 = 1;
							if(isset($l3['products'])){
								foreach($l3['products'] as $p){
									if($p['price_mopt'] == 0){
										if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
}
}else{
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
}
}?>
<?if(($i3%2) == 1){?>
<?if($i3 == 1){?>
<table border="0" class="line" style="margin-top: 40px">
<tr class="main" style="background: #eee; height: 50px;">
<th colspan="2"><?=$l3['name'];?></th>
</tr>
<?}else{?>
<table border="0" class="line">
<?}?>
<tr>
<td class="product">
<?}?>
<table>
    <tr class="title">
        <td class="photo" rowspan="<?=count($_GET['column'])+4?>">
            <div class="photo_inner">
                <?if($p['image'] != ''){?>
                <img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
                <!-- <img height="250" src="<?=_base_url.G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>"> -->
                <?}else{?>
                <img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
                <!-- <img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" /> -->
                <?}?>
                <!-- <img height="250px" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>"/> -->
                <?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
                <span class="best_price" title="Лучшая цена"></span>
                <?}?>
            </div>
        </td>
        <td class="name" colspan="3"><p><?=$p['name']?></p></td>
    </tr>
    <tr class="art">
        <td class="art" colspan="3">Арт. <?=$p['art'];?></td>
    </tr>
    <tr class="header">
        <td class="quantity">Мин. кол-во</td>
        <td class="price">Цена за ед. товара</td>
    </tr>
    <tr class="min_qty">
        <td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
        <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
        echo number_format($p['price_mopt']*$margin,2,",","");
        }else{
        foreach($_GET['column'] as $column){?>
        <td class="price price-<?=$column;?>">
        <span><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
        </td>
        </tr>
        <tr>
        <?}
        }?>
</table>
<?if(($i3%2) == 1){?>
</td>
<td class="product">
<?}else{?>
</td>
</tr>
</table>
<?}
									$i3++;
								}
								if(($i3%2) == 0){?>
</table>
<?}
							}
						}
					}
				}
			}
		}
	}else{
		foreach($cat as $l){?>
<table border="1" class="main">
<tr style="background: #eee; height: 50px;">
<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>">
<?=$l['name'];?>
</th>
</tr>
</table>
<?$ii=1;
foreach($list as $pi){
foreach($pi as $p){?>
<?if($p['price_mopt'] == 0){
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
}
					}else{
						if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
}
}?>
<?if(($ii%2) == 1){?>
<table border="0" class="line">
<tr>
<td class="product">
<?}?>
<table>
    <tr class="title">
        <td class="photo" rowspan="<?=count($_GET['column'])+4?>">
            <div class="photo_inner">
                <?if($p['image'] != ''){?>
                <img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
                <!-- <img height="250" src="<?=_base_url.G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>"> -->
                <?}else{?>
                <img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
                <!-- <img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" /> -->
                <?}?>
                <!-- <img height="250px" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>"/> -->
                <?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
                <span class="best_price" title="Лучшая цена"></span>
                <?}?>
            </div>
        </td>
        <td class="name" colspan="3"><p><?=$p['name']?></p></td>
    </tr>
    <tr class="art">
        <td class="art" colspan="3">Арт. <?=$p['art'];?></td>
    </tr>
    <tr class="header">
        <td class="quantity">Мин. кол-во</td>
        <td class="price">Цена за ед. товара</td>
    </tr>
    <tr class="min_qty">
        <td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
        <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
        echo number_format($p['price_mopt']*$margin,2,",","");
        }else{
        foreach($_GET['column'] as $column){?>
        <td class="price price-<?=$column;?>">
        <span><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
        </td>
        </tr>
        <tr>
        <?}
        }?>
</table>
<?if(($ii%2) == 0){?>
</td>
</tr>
</table>
<?}else{?>
</td>
<td class="product">
<?}
				$ii++;
				}
			}
			if(($ii%2) == 0){?>
</table>
<?}
		}
	}
}else{
	if(isset($_GET['savedprices']) == true){
		$ii = 0;
		foreach($list as $l1){
			if(isset($l1['subcats'])){
				echo "<h1 ";
				if($ii > 0){
echo "class=\"global_cat\"";
}
echo ">".$l1['name']."</h1>";
$ii++;
foreach($l1['subcats'] as $l2){
$i2 = 1;
if(empty($l2['products']) == false){?>
<table border="1" class="main">
<tr style="background: #eee; height: 50px;">
<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>" >
<?=$l2['name'];?>
</th>
</tr>
<tr><?=$headrow;?></tr>
</table>
<?foreach($l2['products'] as $p){?>
<?if($p['price_mopt'] == 0){
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
}
}else{
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
}
}?>
<table border="0" class="line">
    <tr>
        <td class="product">
            <table border="1" class="line">
                <tr style=" <?=$i2%2 == 0?"background: #eee;":null;?>">
                <?if($p['price_mopt'] == 0){
										if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                $margin = str_replace(",",".",$_GET['margin']);
                }else{
                $margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
                }
                }else{
                if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                $margin = str_replace(",",".",$_GET['margin']);
                }else{
                $margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
                }
                }?>
                <td style="width: 50px;">
                    <div class="article">
                        <?=$p['art']?>
                        <?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
                        <span class="best_price" title="Лучшая цена"></span>
                        <?}?>
                    </div>
                </td>
                <?if($_GET['photo'] == 1){?>
                <td style="width: 90px;">
                <?if($p['image'] != ''){?>
                <img height="90" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
                <!-- <img height="90" src="<?=_base_url.G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>"> -->
                <?}else{?>
                <img height="90" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
                <!-- <img height="90" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" /> -->
                <?}?>
                <!-- <img width="90" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>" alt=""/> -->
                </td>
                <?}?>
                <td style="text-align: left;"><?=$p['name']?></td>
                <td style="width: 60px;"><?=$p['min_mopt_qty'].' '.$p['units']?></td>
                <td style="width: 80px;" class="price_container">
                    <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                    echo number_format($p['price_mopt']*$margin,2,",","");
                    }else{
                    foreach($_GET['column'] as $column){?>
                    <span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
                    <?}
                    }?>
                </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?$i2++;
						}
						if(($i2%2) == 0){?>
</table>
<?}
					}elseif(empty($l2['subcats']) == false){
						foreach($l2['subcats'] as $l3){
							$i3 = 1;
							if(isset($l3['products'])){?>
<table border="1" class="main">
<tr style="background: #eee; height: 50px;">
<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>" >
<?=$l3['name'];?>
</th>
</tr>
<tr><?=$headrow;?></tr>
</table>
<?foreach($l3['products'] as $p){
if($p['price_mopt'] == 0){
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
											$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
										}
									}else{
										if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
}
}?>
<table border="0" class="line">
    <tr>
        <td class="product">
            <table border="1" class="line">
                <tr style=" <?=$i3%2 == 0?"background: #eee;":null;?>">
                <?if($p['price_mopt'] == 0){
												if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                $margin = str_replace(",",".",$_GET['margin']);
                }else{
                $margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
                }
                }else{
                if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                $margin = str_replace(",",".",$_GET['margin']);
                }else{
                $margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
                }
                }?>
                <td style="width: 50px;">
                    <div class="article">
                        <?=$p['art']?>
                        <?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
                        <span class="best_price" title="Лучшая цена"></span>
                        <?}?>
                    </div>
                </td>
                <?if($_GET['photo'] == 1){?>
                <td style="width: 90px;">
                <?if($p['image'] != ''){?>
                <img height="90" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
                <!-- <img height="90" src="<?=_base_url.G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>"> -->
                <?}else{?>
                <img height="90" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
                <!-- <img height="90" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" /> -->
                <?}?>
                <!-- <img width="90" src="<?=_base_url.G::GetImageUrl($p['img_1'], 'medium')?>" alt=""/> -->
                </td>
                <?}?>
                <td style="text-align: left;"><?=$p['name']?></td>
                <td style="width: 60px;"><?=$p['min_mopt_qty'].' '.$p['units']?></td>
                <td style="width: 80px;" class="price_container">
                    <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
                    echo number_format($p['price_mopt']*$margin,2,",","");
                    }else{
                    foreach($_GET['column'] as $column){?>
                    <span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
                    <?}
                    }?>
                </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?$i3++;
								}
								if(($i3%2) == 0){?>
</table>
<?}
							}
						}
					}
				}
			}
		}
	}else{
		if(isset($cat) == true){
			foreach($cat as $l){
				$n = 0;$i = 0;?>
<table border="1" class="main">
    <tr style="background: #eee; height: 50px;">
        <th colspan="<?=$_GET['photo'] == 0?'4':'5';?>" >
            <?=$l['name'];?>
        </th>
    </tr>
    <tr><?=$headrow;?></tr>
</table>
<?foreach($list as $li){
					foreach($li as $l){
						if($l['min_mopt_qty'] > 0){?>
<table border="1" class="line">
<tr style=" <?=$n%2 == 0?"background: #eee;":null;?>">
<?if($l['price_mopt'] == 0){
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$l['opt_correction_set']]);
}
}else{
if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
$margin = str_replace(",",".",$_GET['margin']);
}else{
$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$l['mopt_correction_set']]);
}
}?>

<td style="width: 50px;">
    <div class="article">
        <?=$l['art']?>
        <?if($l['opt_correction_set'] == 3 || $l['mopt_correction_set'] == 3){?>
        <span class="best_price" title="Лучшая цена"></span>
        <?}?>
    </div>
</td>
<?if($_GET['photo'] == 1){?>
<td style="width: 90px;">
<?if($l['image'] != ''){?>
<img height="90" src="<?=G::GetImageUrl($l['image'], 'medium')?>" alt="<?=$l['name']?>">
<!-- <img height="90" src="<?=_base_url.G::GetImageUrl($l['image'], 'medium')?>" alt="<?=$l['name']?>"> -->
<?}else{?>
<img height="90" src="<?=G::GetImageUrl($l['img_1'], 'medium')?>" />
<!-- <img height="90" src="<?=G::GetImageUrl($l['img_1'], 'medium')?>" /> -->
<?}?>
<!-- <img width="90" src="<?=_base_url.G::GetImageUrl($l['img_1'], 'medium')?>" alt=""/> -->
</td>
<?}?>
<td style="text-align: left;"><?=$l['name']?></td>
<td style="width: 60px;"><?=$l['min_mopt_qty'].' '.$l['units']?></td>
<td style="width: 80px;" class="price_container">
    <?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
    echo number_format($l['price_mopt']*$margin,2,",","");
    }else{
    foreach($_GET['column'] as $column){?>
    <span class="price-<?=$column;?>"><?=number_format($l['price_mopt']*$margins[$column],2,",","");?></span>
    <?}
    }?>
</td>
</tr>
</table>
<?$n++;}
					}
				}
			}
		}else{?>
<h1 style='width: 800px; margin: auto; text-align: center;'>Вы не выбрали категорию.</h1><br>
<h2 style='width: 800px; margin: auto; text-align: center;'>Для формирования прайс-листа необходимо выбрать хотя бы одну категорию.</h2>
<?}
	}
}?>
</body>
</html>