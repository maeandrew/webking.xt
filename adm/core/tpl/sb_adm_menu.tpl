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
			<?}?>

			<?if(_acl::isAllow('units')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'units'?' sb-menu__item_active':null;?>">
					<a href="/adm/units/">Единицы измерения</a>
					<a href="/adm/unitadd/" class="sb-menu__item__add animate" title="Добавить единицу измерения"><i class="icon-add">a</i></a>
				</li>
			<?}?>

			<?if (_acl::isAllow('segmentations')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'segmentations'?' sb-menu__item_active':null;?>">
					<a href="/adm/segmentations/">Сегментации</a>
					<a href="/adm/segmentationadd/" class="sb-menu__item__add animate" title="Добавить сегментацию"><i class="icon-add">a</i></a>
				</li>
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
			<?}?>
			<?if(_acl::isAllow('seotextformats')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'seotextformats'?' sb-menu__item_active':null;?>">
					<a href="/adm/seotextformats/">Формат сеотекста</a>
					<a href="/adm/seotextformatsadd/" class="sb-menu__item__add animate" title="Добавить формат сеотекста"><i class="icon-add">a</i></a>
				</li>
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
				</ul>
			<?}?>
			<?if (_acl::isAllow('configs')){?>
				<li class="sb-menu__item<?=$GLOBALS['CurrentController'] == 'configs'?' sb-menu__item_active':null;?>">
					<a href="/adm/configs/">Настройки</a>
					<a href="/adm/configadd/" class="sb-menu__item__add animate" title="Добавить настройку"><i class="icon-add">a</i></a>
				</li>
			<?}?>
		</ul>
		<div class="clear"></div>
	</div>
<?}?>
