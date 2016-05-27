<div class="ordersProdList">	
	<div class="ordersProdListTitle">
		<div class="prodListPhoto">Фото</div>
		<div class="orderProdName">Наименование товара</div>
		<div class="prodListPrice">Цена</div>
		<div class="prodListPrice">Кол-во</div>
		<div class="prodListPrice">Cумма</div>
	</div>
	
	<?foreach ($list as $item) {
	if($item['opt_qty'] > 0){
		$mode = 'opt';
	}else{
		$mode = 'mopt';
	}?>
		<div class="ordersProdListContent">
			<div class="avatar">
            	<?if(!empty($item['images'])){?>
					<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
				<?}else{?>
					<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
				<?}?>
            	<!-- <img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /> -->
            </div>
            <div class="orderProdName"><?=$item['name'];?></div>
            <div class="cent">
            	<span class="priceTitle">Цена:</span>
            	<span class="priceItem"><?=$item['site_price_'.$mode]?> грн.</span>
            </div>
            <div class="cent">
            	<span class="priceTitle">Кол-во:</span>
            	<span class="priceItem"><?=$item[$mode.'_qty'];?> шт.</span>
            </div>
            <div class="cent">
            	<span class="priceTitle">Сумма:</span>
            	<span class="priceItem"><?=$item[$mode.'_sum'];?> грн.</span>
            </div>
		</div>
	<?}?>
</div>	









<!-- <div class="ordersProdList">	
	<div class="mdl-grid ordersProdListTitle">
		<div class="mdl-cell mdl-cell--2-col prodPhoto">Фото</div>
		<div class="mdl-cell mdl-cell--7-col">Наименование товара</div>
		<div class="mdl-cell mdl-cell--1-col">Цена</div>
		<div class="mdl-cell mdl-cell--1-col">Кол-во</div>
		<div class="mdl-cell mdl-cell--1-col">Cумма</div>
	</div>
	
	<?foreach ($list as $item) {
	if($item['opt_qty'] > 0){
		$mode = 'opt';
	}else{
		$mode = 'mopt';
	}?>
		<div class="mdl-grid ordersProdListContent">
			<div class="avatar">
            	<?if(!empty($item['images'])){?>
					<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
				<?}else{?>
					<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
				<?}?>
            	<img src="http://lorempixel.com/fashion/70/70/" alt="avatar" />
            </div>
            <div class="orderProdName mdl-cell mdl-cell--7-col"><?=$item['name'];?></div>
            <div class="cent mdl-cell mdl-cell--1-col"><?=$item['site_price_'.$mode]?></div>
            <div class="cent mdl-cell mdl-cell--1-col"><?=$item[$mode.'_qty'];?></div>
            <div class="cent mdl-cell mdl-cell--1-col"><?=$item[$mode.'_sum'];?></div>
		</div>
	<?}?>
</div>	 -->



	<!-- <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp">
		<thead>
		    <tr>
		        <th class="mdl-data-table__cell--non-numeric"><div class="">
		            <div class="avatar">
		            	<img alt="<?=G::CropString($product['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $product['img_1']);?>"/>
	
		            </div>
		        </th>
		        <th class="mdl-data-table__cell--non-numeric">Наименование товара</th>
		        <th>Цена</th>
		        <th>Количество</th>
		        <th>Cумма</th>
		    </tr>
		</thead>		
		<?foreach ($list as $item) {
			if($item['opt_qty'] > 0){
				$mode = 'opt';
			}else{
				$mode = 'mopt';
			}?>
				<tbody>
				    <tr>
				        <td class="mdl-data-table__cell--non-numeric">
				            <div class="avatar">
				            	<?if(!empty($item['images'])){?>
									<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
								<?}else{?>
									<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
								<?}?>
				            	<img src="http://lorempixel.com/fashion/70/70/" alt="avatar" />
				            </div>
	
				        </td>
				        <td class="mdl-data-table__cell--non-numeric"><div class="orderProdName"><?=$item['name'];?></div></td>
				        <td><div class="cent"><?=$item['site_price_'.$mode]?></div></td>
				        <td><div class="cent"><?=$item[$mode.'_qty'];?></div></td>
				        <td><div class="cent"><?=$item[$mode.'_sum'];?></div></td>
				    </tr>
				</tbody>
		<?}?>
	</table> -->