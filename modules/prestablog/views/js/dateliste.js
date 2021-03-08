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
	$('.prestablog_mois').hide();

	if ( $('ul.prestablog_mois').hasClass('prestablog_show') )
		$('.prestablog_show').show();
	else
		$('.prestablog_annee:first').next().show();

	$('.prestablog_annee').click(function(){
		if( $(this).next().is(':hidden') ) {
			$('.prestablog_annee').next().slideUp();
			$(this).next().slideDown();
		}
		return false;
	});
});
