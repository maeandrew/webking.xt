<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Информация о наличии</title>
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		.wrap{
			width: 960px;
			margin: 0 auto;
		}
		table {
			width: 100%;
		}
		table, th, td {
			border: 1px solid #cccccc;
		}
		h1 {
			margin-top: 200px;
		}
	</style>
</head>
<body>
	<div class="wrap">
	<?if($result[0]['art'] == 0){?>
		<h1>Товара нет в наличии или введен неправильный артикул</h1>
	<?}else{?>
		<table cellspacing="0">
			<thead>
				<h2>Арт. <?=$result[0]['art']?></h2>
				<h3><?=$result[0]['name']?></h3>
			</thead>
			<tbody>
				<tr>
					<th>Арт.</th>
					<th>Контакты поставщика</th>
					<th>Цена<br> поставщика<br> опт</th>
					<th>Цена<br> поставщика<br> мелк. опт</th>
					<th>Наличие<br> на сайте</th>
				</tr>
				<?foreach($result as $r):?>
					<tr align="center">
						<td><?=$r['article']?></td>
						<td align="left"><?=$r['supp_name']?><br><?=$r['place']?><br><?=$r['phones']?></td>
						<td><?=$r['price_opt_otpusk']?></td>
						<td><?=$r['price_mopt_otpusk']?></td>
						<td><?php if($r['active']==1){echo "Да";}else{ echo "--";}?></td>
					</tr>
				<?endforeach?>
			</tbody>
		</table>
	<?}?>
	</div><!--class="wrap"-->
</body>
</html>