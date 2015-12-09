<rh1>Производитель <?=$manname?></rh1>

	<img src="<?=file_exists($GLOBALS['PATH_root'].$man_image)?_base_url.$man_image:'/efiles/_thumb/nofoto.jpg'?>" class="man_logo">

<div class="mancats">

<?foreach ($subcats as $branch){?>

	<?foreach ($branch as $i){?>

		<?if($i['nolink']){?>

			<span <?=$i['selected']?'class="selected"':null?> style="margin:20px <?=$i['cat_level']*1.5?>em;"><?=$i['name']?></span>

		<?}else{?>

			<a style="margin:20px <?=$i['cat_level']*1.5?>em;" href="<?=_base_url.'/manufacturer/'.$mantranslit.'/'.$i['cat_id'].'/'.$i['translit']?>/#products"><?=$i['name']?></a>

		<?}?>

		<br>

	<?}?>

	<br>

<?}?>

</div>

<?if(isset($list) && count($list)){?>

	<a name="products"></a>

		<br><br>

		<div class="break" id="products">

		<?$ii=1;foreach ($list as $i){?>

			<div class="plate">

				<div class="product<?=($ii==3)?' nm':null?>">

                    <div class="wrap break">

                        <rh4><a class="alt" href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/"><img src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['i_image'])):'/efiles/_thumb/nofoto.jpg'?>"><?=$i['name']?></a></rh4>

                        <span class="descr">

                            <?=$i['descr']?>

                        </span>

                        <div class="advan">

							<a href="<?=_base_url.'/item/'.$i['item_id'].'/'.$i['translit']?>/""><?=($ii!=3)?'Подробнее':'В корзину'?></a>

                        </div>

                    </div>

                </div>

			</div>

		<?$ii++; if($ii>3){$ii=1;} }?>

		</div>



<?}?>