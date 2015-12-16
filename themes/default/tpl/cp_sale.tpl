				<div class="border">



					<div id="tabs"><span><a href="<?=_base_url?>/">Рекомендуем</a></span><span><a href="<?=_base_url.'/special/'?>">Специальное предложение</a></span><span class="nm selected">Распродажа</span></div>



<?if(count($list)){?>



		<br><br>

		<div class="break" id="products">

		<?$ii=1;foreach ($list as $i){?>

			<div class="plate">

				<div class="product<?=($ii==3)?' nm':null?>">

                    <div class="wrap break">

                        <rh4><a class="alt" href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/"><img src="<?=file_exists($GLOBALS['PATH_root'].$i['i_image'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['i_image'])):'/efiles/_thumb/nofoto.jpg'?>"><?=$i['name']?></a></rh4>

                        <span class="descr">

                            <?=$i['descr']?>

                        </span>

					<?if($i['price']){?>

						<div class="advan_price"><?=$i['price']?> $</div>

						<div class="advan_act">

							<a href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/">Подробнее</a>

                        </div>

					<?}else{?>

						<div class="advan">

							<a href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/">Подробнее</a>

                        </div>

					<?}?>

                    </div>

                </div>

			</div>

		<?$ii++; if($ii>3){$ii=1;} }?>

		</div>





<?}else{?>

	<br>

<?}?>



			</div>

