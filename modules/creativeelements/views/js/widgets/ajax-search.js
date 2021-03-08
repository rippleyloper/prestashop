/**
 * Creative Elements - Elementor based PageBuilder
 * pagebuilder.webshopworks.com
 * Copyright 2019 WebshopWorks
 */

jQuery(function($) {
	var $searchWidget = $('.elementor-ajax-search');
	var $searchBox = $searchWidget.find('input[type=search]');
	var searchURL = $searchWidget.attr('action');

	$.widget('prestashop.ceBlockSearchAutocomplete', $.ui.autocomplete, {
		_renderItem: function (ul, product) {
			return $("<li>")
				.append($("<a>")
					.append($("<span>").html(product.category_name).addClass("category"))
					.append($("<span>").html(product.name).addClass("product"))
				).appendTo(ul)
			;
		}
	});

	$searchBox.ceBlockSearchAutocomplete({
		source: function(query, response) {
			$.post(searchURL, {
				s: query.term,
				resultsPerPage: 10
			}, null, 'json').then(function(resp) {
				response(resp.products);
			}).fail(response);
		},
		select: function(event, ui) {
			var url = ui.item.url;
			window.location.href = url;
		},
	});
});
