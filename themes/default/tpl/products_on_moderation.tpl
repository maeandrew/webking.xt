<?if (isset($errm) && isset($msg)){?><div class="msg-error"><p><?=$msg?></p></div>><?}?><?=isset($errm['products'])?"<div class=\"msg-error\"><p>".$errm['products']."</p></div>":null;?><?if(isset($_SESSION['errm'])){	foreach($_SESSION['errm'] as $msg){		if(!is_array($msg)){?>		<div class="msg-error"><p><?=$msg?></p></div>		<?}	}}unset($_SESSION['errm'])?><div id="supplier_cab">	<div id="second">		<table width="100%" cellspacing="0" border="1" class="supplier_assort_table table">			<colgroup>				<col width="20%">				<col width="50%">				<col width="20%">				<col width="10%">			</colgroup>			<thead>				<tr>					<th class="image">Фото</th>					<th class="name">Название</th>					<th class="status">Статус</th>					<th class="controls">Действия</th>				</tr>			</thead>		</table>		<table width="100%" cellspacing="0" border="0" class="moderation table">			<colgroup>				<col width="20%">				<col width="50%">				<col width="20%">				<col width="10%">			</colgroup>			<tbody>			<?if(isset($list) && !empty($list)){				foreach($list as $i){?>					<tr id="tr_mopt_<?=$i['id']?>">						<td class="photo_cell">							<?if($i['images'] != ''){								$images = explode(';', $i['images']);?>								<a href="<?=file_exists($GLOBALS['PATH_root'].$images[0])?_base_url.htmlspecialchars($images[0]):'/images/nofoto.png'?>">									<img alt="" height="90" src="<?=file_exists($GLOBALS['PATH_root'].$images[0]) && !empty($images[0])?_base_url.htmlspecialchars($images[0]):'/images/nofoto.png'?>">								</a>							<?}else{?>								<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>">									<img alt="" height="90" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1']) && !empty($i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/images/nofoto.png'?>">								</a>							<?}?>						</td>						<td class="name_cell">							<?=G::CropString($i['name'])?>							<?if($i['moderation_status'] == 1){?>								<div class="msg-error">									<p><b>Отклонено!</b> <?=$i['comment'];?></p>								</div>							<?}?>						</td>						<td class="status">							<?=$i['status_name'];?>						</td>						<td class="controls">							<a class="edit" title="Изменить" href="<?=_base_url?>/cabinet/editproduct/?id=<?=$i['id']?>&type=moderation"><i class="material-icons">mode_edit</i></a>							<a title="Удалить" onclick="DeleteProductFromModeration(<?=$i['id'];?>); return false;" href="#"><i class="material-icons">delete</i></a>						</td>					</tr>				<?}			}?>			</tbody>		</table>	</div></div><?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?><script>	function DeleteProductFromModeration(id){		$.ajax({			url: '/cabinet/deletefrommoderation',			type: 'POST',			data: {				id: id			}		}).done(function(){			$('#tr_mopt_'+id).fadeOut();		});	}	$(window).scroll(function(){		if($(this).scrollTop() > 154){			if(!$('.supplier_assort_table').hasClass('fixed_thead')){				var width = $('.moderation').width();				$('.supplier_assort_table').css("width", width).addClass('fixed_thead');				$('#second').css("margin-top", "26px");			}		}else{			if($('.supplier_assort_table').hasClass('fixed_thead')){				$('.supplier_assort_table').removeClass('fixed_thead');				$('#second').css("margin-top", "0");			}		}	});</script>