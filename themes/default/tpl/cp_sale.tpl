<div class="border">
	<div id="tabs"><span><a href="<?=_base_url?>/">Рекомендуем</a></span><span><a href="<?=_base_url.'/special/'?>">Специальное предложение</a></span><span class="nm selected">Распродажа</span></div>
	<?if(count($list)){?>
		<div class="break" id="products">
			<?$ii=1;foreach ($list as $i){?>
			<div class="plate">
				<div class="product<?=($ii==3)?" nm":null;?>">
					<div class="wrap break">
						<h4><a class="alt" href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/"><img src="<?=_base_url.G::GetImageUrl($i['i_image'], 'thumb')?>"><?=$i['name']?></a></h4>
						<span class="descr"><?=$i['descr']?></span>
						<?if($i['price']){?>
							<div class="advan_price"><?=$i['price']?> $</div>
							<div class="advan_act"><a href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/">Подробнее</a></div>
						<?}else{?>
							<div class="advan"><a href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/">Подробнее</a></div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
		<?$ii++; if($ii>3){$ii=1;} }?>
	<?}?>
</div>
