<ul class="newslist">
	<?foreach($list as $i){?>
		<li class="col-sm-6 col-md-4 col-lg-3">
			<div class="item animate">
				<div class="item_title"><?=$i['title']?></div>
				<div class="item_date">
					<?if(date('d-m-Y') == date("d-m-Y", $i['date'])){?>
						Сегодня
					<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $i['date'])){?>
						Вчера
					<?}else{
						echo date("d.m.Y", $i['date']);
					}?>
				</div>
				<div class="item_description"><?=$i['descr_short']?></div>
				<div class="read_more">
					<a href="<?=_base_url?>/news/<?=$i['id_news']?>/<?=$i['translit']?>/">Читать новость</a>
				</div>
			</div>
		</li>
	<?}?>
</ul>