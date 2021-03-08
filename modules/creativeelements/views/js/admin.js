/*!
 * Creative Elements - Elementor based PageBuilder
 * pagebuilder.webshopworks.com
 * Copyright 2019 WebshopWorks
 */

document.addEventListener('DOMContentLoaded', function() {
	if (!('creativePageType' in window)) return;

	// Cancel button fix
	$('.btn[id$=_form_cancel_btn]')
		.removeAttr('onclick')
		.attr('href', location.href.replace(/&id\w*=\d+|&(add|update)[a-z]+(=1)?/g, ''))
	;

	// fix for after ajax save new ybc_blog post update links
	history.pushState = (function(parent) {
		return function(data, title, url) {
			var id = url.match(/&id_post=(\d+)/);
			id && $('.btn-edit-with-ce').each(function() {
				this.href = this.href.replace('&id_page=0', '&id_page=' + id[1]);
			});

			return parent.apply(this, arguments);
		};
	})(history.pushState);

	function onClickBtn(e) {
		if (~this.href.indexOf('&id=0') || ~this.href.indexOf('&id_page=0')) {
			e.preventDefault();
			return alert(creativePageSave);
		}
		if (!creativePageType) {
			var $type = $('#type');
			if ($type.val() != $type.next().val()) {
				e.preventDefault();
				return alert(creativePageSave);
			}

			this.href = this.href.replace('&type=', '$&' + $('#type').next().val());
		}
	}

	var btnTmpl = $('#tmpl-btn-edit-with-ce').html();

	if (~creativePageHook.indexOf('Product')) {
		var $tf = $('<div class="translationsFields tab-content">').wrap('<div class="translations tabbable">');
		$tf.parent()
			.insertAfter('#related-product')
			.before('<h2 class="ce-product-hook">' + creativePageHook + '</h2>')
		;

		$('textarea[id*=description_short_]').each(function(i, el) {
			var id = el.id.split('_').pop(),
				lang = el.parentNode.className.match(/translation-label-(\w+)/),
				$btn = $(btnTmpl).click(onClickBtn),
				href = $btn.attr('href');

			$btn.attr('href', href.replace('&token=', '&id_lang=' + id + '$&').replace('&type=product', '&type=' + creativePageHook));
			$('<div class="translation-field tab-pane">')
				.addClass(lang ? 'translation-label-'+lang[1] : '')
				.addClass(el.parentNode.classList.contains('active') ? 'active' : '')
				.addClass(el.parentNode.classList.contains('visible') ? 'visible' : '')
				.append($btn)
				.appendTo($tf)
			;
		});
	}

	$([
		'textarea[name^=content_]',
		'textarea[name^=description_]:not([name*=short])',
		'textarea[name*="[content]"]',
		'textarea[name*="[description]"]'
	].join()).each(function(i, el) {
		var id = el[el.id ? 'id' : 'name'].split('_').pop(),
			$btn = $(btnTmpl).insertBefore(el).click(onClickBtn),
			href = $btn.attr('href');

		$btn.attr('href', href.replace('&token=', '&id_lang=' + id + '$&'));

		if (!creativePageType || $.inArray(id, hideEditor) >= 0) {
			$(el).hide().next('.maxLength').hide();
		} else {
			$btn.after('<br>');
		}
	});
});
