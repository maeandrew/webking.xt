<rh1>Карта сайта</rh1>



<rh3>Страницы</rh3>

<ul>

	<?foreach ($pages_list as $i){?>

		<li style="padding: 5px 15px;">

			<a href="<?=_base_url.'/page/'.$i['translit']?>/"><?=$i['title']?></a>

			<?$GLOBALS['SITEMAP_URLS'][] = _base_url.'/page/'.$i['translit'].'/'?>

		</li>

	<?}?>

</ul>



<rh3>Производители</rh3>

<ul>

	<?foreach ($mans_list as $i){?>

		<li style="padding: 5px 15px;">

			<a href="<?=_base_url.'/manufacturer/'.$i['translit']?>/"><?=$i['name']?></a>

			<?$GLOBALS['SITEMAP_URLS'][] = _base_url.'/manufacturer/'.$i['translit'].'/'?>

		</li>

	<?}?>

</ul>





<rh3>Каталог</rh3>



	<?$prev_level=0;foreach ($cat_list as $i){?>



		<?if($i['cat_level'] != 0){?>

		<?if($i['cat_level']>$prev_level){?>

			<ul>

				<li style="padding: 5px 15px;">

		<?}elseif($i['cat_level']==$prev_level){?>

				</li>

			<li style="padding: 5px 15px;">

		<?}elseif($i['cat_level']<$prev_level){$amount = $prev_level-$i['cat_level'];?>

			</li>

        <?for($jj=0;$jj<$amount;$jj++){?>

			</ul>

		<?}?>

        </li>

        <li style="padding: 5px 15px;">

		<?}?>

			<a href="<?=_base_url.'/items/'.$i['cat_id'].'/'.$i['translit']?>/"><?=$i['name']?></a>

			<?$GLOBALS['SITEMAP_URLS'][] = _base_url.'/items/'.$i['cat_id'].'/'.$i['translit'].'/'?>

		<?$prev_level = $i['cat_level']?>

	<?}}?>



	</ul>

