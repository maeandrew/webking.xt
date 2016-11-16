<?if(G::IsLogged()){?>
	<div class="block paper_shadow_1">
		<h2>Меню</h2>
		<ul class="sb-menu">
			<?if(_acl::isAllow('pages')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'coment'?' sb-menu__item_active':null;?>">
					<a href="/adm/coment/" <?=$commentCount>0?'class="color-red"':null;?>>Вопросы по товару (<?=$commentCount;?>)</a>
				</li>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'guestbook'?' sb-menu__item_active':null;?>">
					<a href="/adm/guestbook/" <?=$commGuestBookCount>0?'class="color-red"':null;?>>Комментарии из гостевой книги (<?=$commGuestBookCount;?>)</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('catalog')){?>
				<!--class="sb-menu__item <li <?=$GLOBALS['CurrentController'] == 'duplicates'?' sb-menu__item_active':null;?>">
					<a href="/adm/duplicates/">Дубли товаров (<?=$duplicateCount;?>)</a>
				</li> -->
			<?}?>
			<?if(_acl::isAllow('product_moderation')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'product_moderation'?' sb-menu__item_active':null;?>">
					<a href="/adm/product_moderation/" <?=$moderationCount>0?'class="color-red"':null;?>>Товары на модерации (<?=$moderationCount;?>)</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('graphics')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'graphics'?' sb-menu__item_active':null;?>">
					<a href="/adm/graphics/" <?=$GraphCount>0?'class="color-red"':null;?>>Графики на модерации (<?=$GraphCount;?>)</a>
				</li>
			<?}?>
			<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'photo_products'?' sb-menu__item_active':null;?>">
					<a href="/adm/photo_products/">Товары фотографа</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('catalog')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'cat'?' sb-menu__item_active':null;?>">
					<?=($_SESSION['member']['gid'] == _ACL_REMOTE_CONTENT_)?'Каталог':'<a href="/adm/cat/">Каталог</a>'?>
				</li>
				<ul class="sb-menu__sub-menu">
					<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
						<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'catadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/catadd/" >Добавить категорию</a>
						</li>
					<?}?>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'productadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/productadd/">Добавить товар</a>
					</li>
					<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
						<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'unload_products'?' sb-menu__item_active':null;?>">
							<a href="/adm/unload_products/">Выгрузка товаров</a>
						</li>
					<?}?>
				</ul>
			<?}?>

			<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'site_parsers'?' sb-menu__item_active':null;?>">
					<a href="/adm/site_parsers/">Парсер сайтов</a>
				</li>
			<?}?>

			<?if (_acl::isAllow('specifications')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'specifications'?' sb-menu__item_active':null;?>">
					<a href="/adm/specifications/">Характеристики</a>
					<a href="/adm/specificationadd/" class="sb-menu__item__add animate" title="Добавить характеристику"><i class="icon-add">a</i></a>
				</li>
				<!-- <li class="hidden">
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'specificationadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/specificationadd/">Добавить характеристику</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if(_acl::isAllow('units')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'units'?' sb-menu__item_active':null;?>">
					<a href="/adm/units/">Единицы измерения</a>
					<a href="/adm/unitadd/" class="sb-menu__item__add animate" title="Добавить единицу измерения"><i class="icon-add">a</i></a>
				</li>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'unitadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/unitadd/">Добавить единицу измерения</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if (_acl::isAllow('segmentations')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'segmentations'?' sb-menu__item_active':null;?>">
					<a href="/adm/segmentations/">Сегментации</a>
					<a href="/adm/segmentationadd/" class="sb-menu__item__add animate" title="Добавить сегментацию"><i class="icon-add">a</i></a>
				</li>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'segmentationadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/segmentationadd/">Добавить сегментацию</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if(_acl::isAllow('orders')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'orders'?' sb-menu__item_active':null;?>">
					<a href="/adm/orders/">Заказы</a>
				</li>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'orders_sup'?' sb-menu__item_active':null;?> sb-menu__item_disabled">
					<a href="/adm/orders_sup/">Заказы по поставщикам</a>
				</li>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'stat'?' sb-menu__item_active':null;?> sb-menu__item_disabled">
					<a href="/adm/stat/">Статистика продаж</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('supplier_prov')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'supplier_prov'?' sb-menu__item_active':null;?>">
					<a href="/adm/supplier_prov/">Позиции поставщиков</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('pricelist')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'pricelist'?' sb-menu__item_active':null;?>">
					<a href="/adm/pricelist/">Прайс-листы</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('locations')){?>
				<!--class="sb-menu__item <li <?=$GLOBALS['CurrentController'] == 'citys'?' sb-menu__item_active':null;?>">
					<a href="/adm/citys/">Города</a>
				</li>
				<ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'cityadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/cityadd/">Добавить город</a>
					</li>
				</ul>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'regions'?' sb-menu__item_active':null;?>">
					<a href="/adm/regions/">Регионы</a>
				</li>
				<ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'regionadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/regionadd/">Добавить регион</a>
					</li>
				</ul>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'parkings'?' sb-menu__item_active':null;?>">
					<a href="/adm/parkings/">Стоянки</a>
				</li>
				<ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'parkingadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/parkingadd/">Добавить стоянку</a>
					</li>
				</ul>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'delivservs'?' sb-menu__item_active':null;?>">
					<a href="/adm/delivservs/">Службы доставки</a>
				</li>
				 <ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'delivservadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/delivservadd/">Добавить службу доставки</a>
					</li>
				</ul>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'deliverys'?' sb-menu__item_active':null;?>">
					<a href="/adm/deliverys/">Виды доставки</a>
					<a href="/adm/deliveryadd/" class="add <?=$GLOBALS['CurrentController'] == 'deliveryadd'?'sel':null;?>" title="Добавить вид доставки">Добавить вид доставки</a>
				</li>
				<ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'deliveryadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/deliveryadd/">Добавить вид доставки</a>
					</li>
				</ul>-->
			<?}?>

			<?if(_acl::isAllow('manufacturers')){?>
				<!--class="sb-menu__item <li <?=$GLOBALS['CurrentController'] == 'manufacturers'?' sb-menu__item_active':null;?>">
					<a href="/adm/manufacturers/">Производители</a>
					<a href="/adm/manufactureradd/" class="add <?=$GLOBALS['CurrentController'] == 'manufactureradd'?'sel':null;?>" title="Добавить производителя">Добавить производителя</a>
				</li>

				<ul class="sb_menusub">
					<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'manufactureradd'?' sb-menu__item_active':null;?>">
						<a href="/adm/manufactureradd/">Добавить производителя</a>
					</li>
				</ul> -->
			<?}?>

			<?if(_acl::isAllow('users')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'users'?' sb-menu__item_active':null;?>">
					<a href="/adm/users/">Пользователи</a>
					<a href="/adm/usersadd/" class="sb-menu__item__add animate" title="Добавить пользователя"><i class="icon-add">a</i></a>
				</li>
				<ul class="sb-menu__sub-menu">
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_ADMIN_?>">Администраторы</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_MODERATOR_?>">Администраторы наполнения</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_SEO_?>">СЕО-оптимизаторы</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_CUSTOMER_?>">Покупатели</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_CONTRAGENT_?>">Контрагенты</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/users/<?=_ACL_SUPPLIER_?>">Поставщики</a>
					</li>
					<li class="sb-menu__sub-menu__item">
						<a href="/adm/warehouses/">Поставщики склада</a>
					</li>
				</ul>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'usersadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/usersadd/">Добавить нового пользователя</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'adminadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/adminadd/">Добавить администратора</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seoadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/SEO_optimizatoradd/">Добавить СЕО-оптимизатора</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'customeradd'?' sb-menu__item_active':null;?>">
							<a href="/adm/customeradd/">Добавить покупателя</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'contragentadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/contragentadd/">Добавить контрагента</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'supplieradd'?' sb-menu__item_active':null;?>">
							<a href="/adm/supplieradd/">Добавить поставщика</a>
						</li>
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'warehouseadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/warehouseadd/">Добавить поставщика склада</a>
						</li>
					</ul>
				</li> -->
			<?}?>
			<?if(_acl::isAllow('profiles')){?>
				<li class="sb-menu__item">
					<a href="/adm/profiles/" <?=$GLOBALS['CurrentController'] == 'profiles'?'sel':null;?>>Профили пользователей</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('pages')){?>
				<li class="sb-menu__item hidden">
					<a href="/adm/users/<?=_ACL_SUPPLIER_?>" <?=$GLOBALS['CurrentController'] == 'users'?'sel':null;?>>Поставщики</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('remitters')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'remitters'?' sb-menu__item_active':null;?>">
					<a href="/adm/remitters/">Отправители</a>
					<a href="/adm/remitteradd/" class="sb-menu__item__add animate" title="Добавить отправителя"><i class="icon-add">a</i></a>
				</li>
				<!-- <?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] != _ACL_SEO_)){?>
					<li>
						<ul class="sb_menusub">
							<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'remitteradd'?' sb-menu__item_active':null;?>">
								<a href="/adm/remitteradd/">Добавить отправителя</a>
							</li>
						</ul>
					</li>
				<?}?> -->
			<?}?>

			<?if(_acl::isAllow('monitoring')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && !isset($GLOBALS['REQAR'][1])?' sb-menu__item_active':null;?>">
					<a href="/adm/monitoring/">Мониторинг</a>
				</li>
				<ul class="sb-menu__sub-menu">
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'specifications'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/specifications/">Характеристики</a>
					</li>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'uncategorised_products' && $GLOBALS['REQAR'][1] == 'uncategorised_products'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/uncategorised_products/">Товары без категорий</a>
					</li>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'doubles_translit_products'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/doubles_translit_products/">Дубли товаров</a>
					</li>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'ip_connections'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/ip_connections/">IP соединения</a>
					</li>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'err_feedback'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/err_feedback/">Ошибки от пользователей</a>
					</li>
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'noprice_products'?' sb-menu__item_active':null;?>">
						<a href="/adm/monitoring/noprice_products/">Товары с нулевой ценой</a>
					</li>
				</ul>
			<?}?>

			<?if(_acl::isAllow('news')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'news'?' sb-menu__item_active':null;?>">
					<a href="/adm/news/">Новости</a>
					<a href="/adm/newsadd/" class="sb-menu__item__add animate" title="Добавить новость"><i class="icon-add">a</i></a>
				</li>
				<ul class="sb-menu__sub-menu">
					<!-- <li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'newsadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/newsadd/">Добавить новость</a>
					</li> -->
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'slides'?' sb-menu__item_active':null;?>">
						<a href="/adm/slides/">Слайдер</a>
					</li>
				</ul>
			<?}?>

			<?if(_acl::isAllow('seotext')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seotext'?' sb-menu__item_active':null;?>">
					<a href="/adm/seotext/">SEO-тексты</a>
					<a href="/adm/seotextadd/" class="sb-menu__item__add animate" title="Добавить SEO-текст"><i class="icon-add">a</i></a>
				</li>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seotextsadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/seotextadd/">Добавить SEO-текст</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if(_acl::isAllow('seotextformats')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seotextformats'?' sb-menu__item_active':null;?>">
					<a href="/adm/seotextformats/">Формат сеотекста</a>
					<a href="/adm/seotextformatsadd/" class="sb-menu__item__add animate" title="Добавить формат сеотекста"><i class="icon-add">a</i></a>
				</li>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seotextformatsadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/seotextformatsadd/">Добавить формат сеотекста</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if(_acl::isAllow('posts')){?>
				<!-- <li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'posts'?' sb-menu__item_active':null;?>">
					<a href="/adm/posts/">Статьи</a>
					<a href="/adm/postadd/" class="add <?=$GLOBALS['CurrentController'] == 'postadd'?'sel':null;?>" title="Добавить статью">Добавить статью</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'postadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/postadd/">Добавить статью</a>
						</li>
					</ul>
				</li> -->
			<?}?>

			<?if(_acl::isAllow('pages')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'pages'?' sb-menu__item_active':null;?>">
					<a href="/adm/pages/">Страницы</a>
					<a href="/adm/pageadd/" class="sb-menu__item__add animate" title="Добавить страницу"><i class="icon-add">a</i></a>
				</li>
				<ul class="sb-menu__sub-menu">
					<li class="sb-menu__sub-menu__item<?=$GLOBALS['CurrentController'] == 'configedit'?' sb-menu__item_active':null;?>">
						<a href="/adm/configedit/0">Инструкция для поставщика</a>
					</li>
					<!-- <li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'pageadd'?' sb-menu__item_active':null;?>">
						<a href="/adm/pageadd/">Добавить страницу</a>
					</li> -->
				</ul>
			<?}?>

			<?if (_acl::isAllow('configs')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'configs'?' sb-menu__item_active':null;?>">
					<a href="/adm/configs/">Настройки</a>
					<a href="/adm/configadd/" class="sb-menu__item__add animate" title="Добавить настройку"><i class="icon-add">a</i></a>
				</li>
				<!-- <li>
					<ul class="sb_menusub">
						<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'configadd'?' sb-menu__item_active':null;?>">
							<a href="/adm/configadd/">Добавить настройку</a>
						</li>
					</ul>
				</li> -->
			<?}?>
		</ul>
		<div class="clear"></div>
	</div>
<?}?>
