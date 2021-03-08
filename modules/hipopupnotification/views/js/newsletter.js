/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

$(document).ready(function(){
	$('.popup_newsletter_form').on('submit', function(e){
		var $this = $(this);
		$.ajax({
			type: 'POST',
  			dataType : 'JSON',
			data:{
				login_request: true,
				ajax: true,
				action: 'newsletter_subscribtion',
				secure_key: popup_secure_key,
				firstname: $this.find('.popup_first_name').val(),
				lastname: $this.find('.popup_last_name').val(),
				email: $this.find('.popup_email').val(),
				popup_terms: $('input[type="checkbox"]:checked').val(),
				newsletter: 1
			},
			url: popup_sc_front_controller_dir,
			beforeSend: function(){
				$this.find('.popup-ajax-loader').show();
			},
			success: function(response){
				$this.find('.popup-ajax-loader').hide();
				if(response.hasError){
					response.errors.forEach(function(error) {
                        $.growl.error({ title: '', message: error});
                    });
				} else {
					$this.hide();
            		if (!response.isVoucher) {
            			$this.parent().find('.hi-popup-success').removeClass('hide');
            		} else {
            			$this.parent().find('.hi-popup-voucher-desc').removeClass('hide');
            		}
            		setTimeout(function(){
        				$.magnificPopup.close();
        			}, 2000);
				}
			}
		});
		return false;
	});
});