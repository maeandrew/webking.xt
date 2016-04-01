<ul class="newslist">
	<?if(!empty($list)){
		foreach($list as $i){?>
			<li>
				<div class="item animate mdl-grid">
					<h3 class="item_title mdl-cell mdl-cell--12-col mdl-cell--12-col-phone"><?=$i['title']?></h3>
					<div class="item_date mdl-cell mdl-cell--12-col mdl-cell--12-col-phone">
						<?if(date('d-m-Y') == date("d-m-Y", $i['date'])){?>
							Сегодня
						<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $i['date'])){?>
							Вчера
						<?}else{
							echo date("d.m.Y", $i['date']);
						}?>
					</div>
					<!-- <div class="item_description mdl-grid">
						<div class="item_thumb mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--12-col-phone"><img class="image" src="<?=$i['thumbnail']?>" alt=""></div>
						<div class="item_descr mdl-cell mdl-cell--10-col mdl-cell--10-col-tablet"><?=$i['descr_short']?></div>
					</div> -->
					<div class="item_description">
						<div class="item_thumb"><img class="image" src="<?=$i['thumbnail']?>" alt=""></div>
						<div class="item_descr"><?=$i['descr_short']?></div>
					</div>
					<div class="read_more mdl-cell--12-col mdl-cell--12-col-phone">
						<a href="<?=Link::Custom('news', $i['translit']);?>">Читать новость</a>
					</div>
				</div>
			</li>
		<?}
	}else{?>
		Новостей нет
	<?}?>
</ul>
