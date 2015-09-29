/* A polyfill for browsers that don't support ligatures. */
/* The script tag referring to this file must be placed before the ending body tag. */

/* To provide support for elements dynamically added, this script adds
   method 'icomoonLiga' to the window object. You can pass element references to this method.
*/
(function () {
	'use strict';
	function supportsProperty(p) {
		var prefixes = ['Webkit', 'Moz', 'O', 'ms'],
			i,
			div = document.createElement('div'),
			ret = p in div.style;
		if (!ret) {
			p = p.charAt(0).toUpperCase() + p.substr(1);
			for (i = 0; i < prefixes.length; i += 1) {
				ret = prefixes[i] + p in div.style;
				if (ret) {
					break;
				}
			}
		}
		return ret;
	}
	var icons;
	if (!supportsProperty('fontFeatureSettings')) {
		icons = {
			'account_add': '&#xe60a;',
			'favorites': '&#xe60b;',
			'favorites-o': '&#xe612;',
			'odnoklassniki': '&#xe611;',
			'Line': '&#xe610;',
			'account': '&#xe60e;',
			'shopping_cart': '&#xe60f;',
			'sort_alpha_desc': '&#xe600;',
			'sort_alpha_asc': '&#xe601;',
			'clock': '&#xe615;',
			'undo2': '&#xe613;',
			'left': '&#xe613;',
			'loading1': '&#xe602;',
			'loading2': '&#xe603;',
			'loading3': '&#xe604;',
			'exit': '&#xe614;',
			'reload': '&#xe60c;',
			'profile_card': '&#xe605;',
			'sort_by_alpha': '&#xe036;',
			'phone': '&#xe03f;',
			'location': '&#xe052;',
			'add': '&#xe069;',
			'remove': '&#xe07f;',
			'arrow_up_right': '&#xe082;',
			'sort': '&#xe088;',
			'insert_comment': '&#xe0e6;',
			'headset': '&#xe10d;',
			'arrow_down': '&#xe10f;',
			'arrow_left': '&#xe110;',
			'arrow_right': '&#xe111;',
			'arrow_up': '&#xe112;',
			'eye': '&#xe1a8;',
			'error': '&#xe205;',
			'check': '&#xe206;',
			'close': '&#xe209;',
			'menu': '&#xe20e;',
			'dots': '&#xe20f;',
			'share': '&#xe25a;',
			'star': '&#xe260;',
			'star_half': '&#xe261;',
			'star_outline': '&#xe262;',
			'add_shopping_cart': '&#xe269;',
			'delete': '&#xe287;',
			'like': '&#xe291;',
			'like_outline': '&#xe292;',
			'download': '&#xe298;',
			'history': '&#xe29d;',
			'home': '&#xe29e;',
			'lock': '&#xe2ab;',
			'search': '&#xe2ca;',
			'settings': '&#xe2cb;',
			'view_list': '&#xe301;',
			'view_module': '&#xe302;',
			'image': '&#xf03e;',
			'folder': '&#xf07b;',
			'folder-open': '&#xf07c;',
			'twitter': '&#xf099;',
			'facebook': '&#xf09a;',
			'rss': '&#xf09e;',
			'filter': '&#xf0b0;',
			'g+': '&#xf0d5;',
			'sort_handle': '&#xf0dc;',
			'comments-o': '&#xf0e6;',
			'sort-amount-asc': '&#xf160;',
			'sort-amount-desc': '&#xf161;',
			'youtube': '&#xf167;',
			'vk': '&#xf189;',
			'warning': '&#xe606;',
			'edit': '&#xe607;',
			'bonus': '&#xe608;',
			'mail': '&#xe60d;',
			'info': '&#xe609;',
			'0': 0
		};
		delete icons['0'];
		window.icomoonLiga = function (els) {
			var classes,
				el,
				i,
				innerHTML,
				key;
			els = els || document.getElementsByTagName('*');
			if (!els.length) {
				els = [els];
			}
			for (i = 0; ; i += 1) {
				el = els[i];
				if (!el) {
					break;
				}
				classes = el.className;
				if (/icon-/.test(classes)) {
					innerHTML = el.innerHTML;
					if (innerHTML && innerHTML.length > 1) {
						for (key in icons) {
							if (icons.hasOwnProperty(key)) {
								innerHTML = innerHTML.replace(new RegExp(key, 'g'), icons[key]);
							}
						}
						el.innerHTML = innerHTML;
					}
				}
			}
		};
		window.icomoonLiga();
	}
}());