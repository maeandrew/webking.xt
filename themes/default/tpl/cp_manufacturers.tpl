<rh1><?=$h1?></rh1>

<div class="break" id="manufacturers">

	<?$ii=1;foreach ($list as $i){?>

     <div class="plate_m">

	 	<div class="manufacturer<?=($ii==3)?' nm':null?>">

            <div class="wrap break">

                <rh4><b><a title="<?=$i['name']?>" href="<?=_base_url.'/manufacturer/'.$i['translit']?>/">

                	<img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['m_image'])?_base_url.$i['m_image']:'/efiles/_thumb/nofoto.jpg'?>"></a></b></rh4>

            </div>

		</div>

      </div>

	<?$ii++; if($ii>3){$ii=1;} }?>

</div>