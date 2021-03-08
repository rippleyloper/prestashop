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
    /*Socila connect button click*/
    $(".connect").click(function(){
        return false;
    });

    if (enable_header_login_popup){
        if (psv >= 1.7) {
            if (!prestashop.customer.is_logged) {
                $('.user-info a').attr('href','#login-and-register-popup-sign');
                $('.user-info a').addClass('login');
            }
        } else {
            $('.login').attr('href','#login-and-register-popup-sign');
        }
        $('.login').magnificPopup({
          type:'inline',
          midClick: true,
          removalDelay: 0,
          callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = 'popup_signin_popup hi-popup-width-auto popup_remove_padding';
                }
          }
        });
    }

    $('.popup_register_form').on('submit', function(){
        var $this = $(this);
        $.ajax({
            type: 'POST',
            dataType : 'JSON',
            data:{
                login_request: true,
                ajax: true,
                submitAccount:'',
                secure_key: popup_secure_key,
                customer_firstname: $this.find('.popup_register_fname').val(),
                customer_lastname: $this.find('.popup_register_lname').val(),
                email: $this.find('.popup_register_email').val(),
                passwd: $this.find('input[name="popup_register_password"]').val(),
                newsletter: $this.find('input[name="pn_newsletter"]:checked').val(),
                register_terms: $this.find('input[name="register_terms"]:checked').val(),
            },
            beforeSend: function(){
                $this.find('.popup-ajax-loader').show();
            },
            url: popup_sc_front_controller_dir,
            success: function(response){
                $this.find('.popup-ajax-loader').hide();
                if (response.hasError) {
                    response.errors.forEach(function(error) {
                        $.growl.error({ title: '', message: error});
                    });
                } else {
                    window.location.href = my_account_url;
                }
            }
        });
        return false;
    });

    $('.popup_login_form').on('submit', function(){
        var $this = $(this);
        if (psv >= 1.7) {
            var url = popup_sc_front_controller_dir;
        } else {
            var url = baseUri + '?controller=authentication';
        }
        $.ajax({
            type: 'POST',
            dataType : 'JSON',
            url: url,
            data:{
                email: $this.find('input[name="popup_login_email"]').val(),
                passwd: $this.find('input[name="popup_login_password"]').val(),
                SubmitLogin: '',
                ajax: true,
                login_request: true,
                secure_key: popup_secure_key,
            },
            beforeSend: function(){
                $this.find('.popup-ajax-loader').show();
            },
            success: function(response){
                $this.find('.popup-ajax-loader').hide();
                if (response.hasError){
                    $.growl.error({ title: "", message:response.errors});
                }else{
                    window.location.href = my_account_url;
                }
            }
        });
        return false;
    });
});