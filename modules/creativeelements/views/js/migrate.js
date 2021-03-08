/*!
 * Creative Elements - Elementor based PageBuilder
 * pagebuilder.webshopworks.com
 * Copyright 2019 WebshopWorks
 */

function Class(c) {
	return (c.contructor.prototype = c).contructor;
}

// fix for multiple select val(): when no options are selected, return [] instead of null
$.fn.val = (function (parent) {
	return function val(value) {
		return void 0 === value && this[0] && this[0].multiple && parent.call(this) === null ? [] : parent.apply(this, arguments);
	}
})($.fn.val);

// for advanced content templates
CeView = Class({
	attr: {},

	contructor: function CeView() {},

	addRenderAttribute: function(elem, key, value) {
		elem in this.attr || (this.attr[elem] = {});
		key in this.attr[elem] || (this.attr[elem][key] = []);
		$.isArray(value) || (value = [value]);

		this.attr[elem][key] = this.attr[elem][key].concat(value);
	},

	getRenderAttributeString: function( elem ) {
		if (!this.attr[elem]) return '';
		var key, attr = [];

		for (key in this.attr[elem]) {
			attr.push(key + '="' + this.attr[elem][key].join(' ') + '"');
		}
		return attr.join(' ');
	}
});
