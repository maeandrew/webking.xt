<div id="content">
	<div class="content_page">
		<ul class="pages_list">
			<?$cnt = count($data);?>
			<?foreach($data as $key => $value){?>
				<?$title = explode(' | ', $value['title']);?>
				<li>
					<div class="fleft identifier color-sgrey"><?=$cnt;?>.</div>
					<div class="fleft"><a href="/page/<?=$value['translit'];?>/"><?=$title[0];?></a></div>
				</li>
				<?$cnt--;
			}?>
		</ul>
	</div>
</div>