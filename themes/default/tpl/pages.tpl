<div class="paginator">
	<ul>
		<?if(isset($FIRST)){?>
			<li class="first_page"><a href="<?=Link::Category($GLOBALS['Rewrite'], array('page'=> $URL_FIRST));?>" title="На первую страницу" class="animate"><?=$FIRST?></a></li>
		<?}
		if(isset($LP)){?>
			<li class="prev_pages"><a href="<?=Link::Category($GLOBALS['Rewrite'], array('page'=> $URL_LP));?>" class="icon-font animate"><i class="material-icons"><?=$LP?></i></a></li>
		<?}
		foreach($PAGE as $p){
			echo $p;
		}
		if(isset($NP)){?>
			<li class="next_pages"><a href="<?=Link::Category($GLOBALS['Rewrite'], array('page'=> $URL_NP));?>" class="icon-font animate"><i class="material-icons"><?=$NP?></i></a></li>
		<?}
		if(isset($LAST)){?>
			<li class="last_page"><a href="<?=Link::Category($GLOBALS['Rewrite'], array('page'=> $URL_LAST));?>" title="На последнюю страницу" class="animate"><?=$LAST?></a></li>
		<?}?>
		<!-- <li>
			<form action="<?=$GLOBALS['URL_base'].preg_replace("#^(.*?)/(p[0-9]+)(.*?)$#is", "\$1\$3/", preg_replace("#^/(.*?)$#i", "\$1", $_SERVER['REQUEST_URI']))?>" method="post">
				<p>
					<input type="text" class="number_page" name="page_nbr" />
					<input type="submit" class="search_page" value="" />
				</p>
			</form>
		</li> -->
	</ul>
</div>