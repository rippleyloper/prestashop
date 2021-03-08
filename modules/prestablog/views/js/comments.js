/**
 * 2008 - 2020 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial

 */

$(document).ready(function() {
	if ( $("#submitOk").length ) {
		$('html, body').animate({scrollTop: $("#submitOk").offset().top}, 750);

	}

	if ( $("#errors").length ) {
		$('html, body').animate({scrollTop: $("#errors").offset().top}, 750);
	}

 	$('#comments').show();

	$("#with-http").hide();

	$("#url").focus(function() { $("#with-http").fadeIn(); });

	$("#url").focusout(function() { $("#with-http").fadeOut(); });
});
