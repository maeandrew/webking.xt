<?php
$GLOBALS['__page_title'] = 'Страница не найдена';
$GLOBALS['__page_description'] = 'Запрашиваемая страница не найдена';
$tpl->Assign('h1', 'Запрашиваемая страница не найдена');
unset($parsed_res);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_404.tpl');