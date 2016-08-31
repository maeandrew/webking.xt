<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($list) && count($list)){?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1 comment_list">
			<col width="80%">
			<col width="20%">
			<thead class="main_thead">
				<tr>
					<th class="left">Информация об отзывах к товарам</th>
					<th class="left" colspan="3"></th>
				</tr>
			</thead>
			<?foreach ($list as $i){?>
				<?$interval = date_diff(date_create(date("d.m.Y", strtotime($i['date_comment']))), date_create(date("d.m.Y")));?>
					<thead>
						<tr class="coment<?=$i['Id_coment']?> animate <?if(!$i['visible'] && $interval->format('%a') < 3){?>bg-lyellow<?}?>">
							<th class="left">
								<div><a href="/product/<?=$i['translit']?>" class="bold_text">#<?=$i['Id_coment']?></a>
									<?if($i['pid_comment'] != ''){?>
										<span class="resp_to_comment">Ответ на отзыв #<?=$i['pid_comment']?></span>
									<?}?>
								</div>
								<div><span class="bold_text">Автор:</span> <?=$i['username']?></div>
								<div class="date"><?=date("d.m.Y", strtotime($i['date_comment']))?></div>
								<div class="comment_text bold_text"><?=$i['text_coment']?></div>
								<div class="prod_title"><span class="bold_text">Товар:</span> <?=$i['name']?></div><!-- <a href="<?='/adm/productedit/'.$i['url_coment']?>">Товар: <?=$i['name']?></a> -->
								<div class="btn_wrap">
									<?if($i['pid_comment'] == ''){?>
										<a class="btn-m-green btn_answer adm_comment_reply_js" href="#" data-idComment="<?=$i['Id_coment']?>" data-username="<?=$_SESSION['member']['name']?>" data-idproduct="<?=$i['url_coment']?>" data-useremail="<?=$_SESSION['member']['email']?>">Ответить</a>
										<a class="btn-m btn_answer adm_comment_reply_cancel_js hidden" href="#">Скрыть</a>
									<?}?>
									<a class="small mr6 icon-font btn-m-blue" title="Посмотреть товар на сайте" href="/adm/productedit/<?=$i['url_coment']?>" target="_blank">e Перейти к товару</a>
								</div>
							</th>
							<th class="right actions" colspan="3">
								<?=!$i['visible']?'<span class="invisible" style="color: red;">скрытый</span>':null?>
								<?if($i['pid_comment'] == ''){?>
									<div><span class="bold_text">Оценка:</span> <?=$i['rating']?>/5</div>
								<?}?>
								<span class="bold_text">Видимость</span> <input type="checkbox" id="pop_<?=$i['Id_coment']?>" name="pop_<?=$i['Id_coment']?>" <?if(isset($pops1[$i['Id_coment']])){?>checked="checked"<?}?> onchange="SwitchPops1(this, <?=$i['Id_coment']?>)">
								<div class="del_btn_wrap"><a class="icon-delete btn-m" onClick="if(confirm('Комментарий будет удален.\nПродолжить?') == true){dropComent(<?=$i['Id_coment']?>);};">t Удалить</a></div>
							</th>
						</tr>
					</thead>
					<tbody class="subcomment">
						<?if(isset($i['answer']) && is_array($i['answer']) && !empty($i['answer'])){?>
							<?foreach($i['answer'] as $a){?>
								<tr class="coment<?=$a['Id_coment']?>">
									<td class="left">
										<div><span class="bold_text">Автор:</span> <?=$a['username']?></div>
										<div class="date"><?=date("d.m.Y", strtotime($a['date_comment']))?></div>
										<div class="comment_text bold_text"><?=$a['text_coment']?></div>
									</td>
									<td class="right actions" colspan="3">
										<?=!$a['visible']?'<div class="invisible" style="color: red;">скрытый</div>':null?>
										<span class="bold_text">Видимость</span> <input type="checkbox" id="pop_<?=$a['Id_coment']?>" name="pop_<?=$a['Id_coment']?>" <?if(isset($pops1[$a['Id_coment']])){?>checked="checked"<?}?> onchange="SwitchPops1(this, <?=$a['Id_coment']?>)">
										<div class="del_btn_wrap"><a class="icon-delete btn-m" onClick="if(confirm('Комментарий будет удален.\nПродолжить?') == true){dropComent(<?=$a['Id_coment']?>);};">t Удалить</a></div>
									</td>
								</tr>
							<?}?>
						<?}?>
					</tbody>
				<?}?>
			<!-- 	<tr>
					<td>&nbsp;</td>
					<td class="center"><input class="btn-m-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr> -->
		</table>
	</form>
<?}else{?>
	<div class="notification warning"> <span class="strong">Комментариев нет</span></div>
<?}?>
