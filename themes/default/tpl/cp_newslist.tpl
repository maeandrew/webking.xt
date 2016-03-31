<ul class="newslist">
	<?if(!empty($list)){
		foreach($list as $i){?>

			<li>
				<div class="item animate">
					<h3 class="item_title"><?=$i['title']?></h3>
					<div class="item_date">
						<?if(date('d-m-Y') == date("d-m-Y", $i['date'])){?>
							Сегодня
						<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $i['date'])){?>
							Вчера
						<?}else{
							echo date("d.m.Y", $i['date']);
						}?>
					</div>
					<?if(!empty($i['thumbnail']))  var_dump($i['thumbnail'])?>
					<div class="item_description">
						<!-- <div class="item_thumb"><?=$i['thumbnail']?></div> -->
						<div class="item_thumb"><img src="" alt=""></div>
						<div class="item_descr"><?=$i['descr_short']?></div>						
					</div>
					<div class="read_more">
						<a href="<?=Link::Custom('news', $i['translit']);?>">Читать новость</a>
					</div>
				</div>
			</li>
		<?}
	}else{?>
		Новостей нет
	<?}?>
</ul>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas architecto sequi omnis accusamus sapiente velit quis maxime mollitia, natus expedita dignissimos quidem repudiandae hic, distinctio a totam, obcaecati. Veniam, mollitia!