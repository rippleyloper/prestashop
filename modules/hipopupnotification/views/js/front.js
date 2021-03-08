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

function loaderOpening (){
    $('body').append('<div class="hi_spinner"><img src="'+popup_sc_loader+'"></div>');
    var top = $('body').scrollTop();
    $('.hi_spinner').css('top', top+'px');
    $('body').addClass('hi_overflow');
}
function loaderClose (){
    $('.hi_spinner').remove();
    $('body').removeClass('hi_overflow');
}

$(document).ready(function(){

    // General data protection regulation 
    var checkbox = $('.hi_psgdpr_consent_checkbox');
    var element = checkbox.closest('form');
    if (checkbox.is(':checked')) {
        element.find('[type="submit"]').removeAttr('disabled');
    } else {
        element.find('[type="submit"]').attr('disabled', 'disabled');;
    }
    $(document).on('change', '.hi_psgdpr_consent_checkbox', function(){
        var element_form = $(this).closest('form');
        if ($(this).is(':checked')) {
            if (element_form.find('[type="submit"]').length > 0) {
                element_form.find('[type="submit"]').removeAttr('disabled');
            } else {
                element_form.nextAll('[type="submit"]').removeAttr('disabled');
            }
        } else {
            if (element_form.find('[type="submit"]').length > 0) {
                element_form.find('[type="submit"]').attr('disabled', 'disabled');
            } else {
                element_form.nextAll('[type="submit"]').attr('disabled', 'disabled');
            }
        }
    });
    /*End*/


    $(".popup-sc-onclick-btn").click(function(){
        return false;
    });
    var hiFirstPopup = hiPopup[Object.keys(hiPopup)[0]];
    if (typeof hiFirstPopup !== "undefined") {
        displayPopup(hiFirstPopup.id, hiPopup);
    }

    var hiFirstExitPopup = hiPopupExit[Object.keys(hiPopupExit)[0]];
    if (typeof hiFirstExitPopup !== "undefined") {
        displayPopup(hiFirstExitPopup.id, hiPopupExit, false);
    }
    if (gp_client_id && enable_google_login) {
        startGoogleAccountSignIn();
    }
});


function displayPopup(id_popup, popup_obj, force = true){
    if (popup_obj[id_popup].animation) {
        var removalDelay = 500;
    } else {
        var removalDelay = 0;
    }
    if (popup_obj[id_popup].cookie_time == '0'){
        $.cookie('hi_popup_cookie_' + id_popup, '0');
    }
    if (popup_obj[id_popup].type == 'html' || popup_obj[id_popup].type == 'facebook' || popup_obj[id_popup].type == 'newsletter' || popup_obj[id_popup].type == 'login' || popup_obj[id_popup].type == 'register' || popup_obj[id_popup].type == 'login_and_register') {
        $('.open-popup-notification-' + id_popup).magnificPopup({
            type:'inline',
            midClick: true,
            removalDelay: removalDelay,
            callbacks: {
                beforeOpen: function() {
                   this.st.mainClass = popup_obj[id_popup].animation + ' ' + popup_obj[id_popup].remove_padding + ' hi-popup-width-auto';
                },
                open: function(){
                    if (popup_obj[id_popup].type == 'html' || popup_obj[id_popup].type == 'facebook') {
                        PopupResponsive(resize_start_point, enable_responsive);
                    }
                },
                close: function(){
                    var nextPopupId = getNextPopupId(popup_obj, popup_obj[id_popup].id);
                    if (typeof nextPopupId !== "undefined") {
                        displayPopup(nextPopupId, popup_obj);
                    }
                },
            }
        });
    } else if (popup_obj[id_popup].type == 'youtube' || popup_obj[id_popup].type == 'vimeo' || popup_obj[id_popup].type == 'gmaps') {
         $('.open-popup-notification-' + id_popup).magnificPopup({
             type:'iframe',
             midClick: true,
             removalDelay: removalDelay,
             callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = popup_obj[id_popup].animation + ' hi-popup-width-auto';
                },
                open: function(){
                     PopupResponsive(resize_start_point, enable_responsive);
                },
                close: function(){
                    var nextPopupId = getNextPopupId(popup_obj, popup_obj[id_popup].id);
                    if (typeof nextPopupId !== "undefined") {
                        displayPopup(nextPopupId, popup_obj);
                    }
                },
             },
             iframe: {
                markup: '<div class="mfp-with-anim" style="height:100%;">'+
                         '<div class="mfp-iframe-scaler">'+
                         '<div class="mfp-close"></div>'+
                         '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                       '</div></div>',
                patterns: {
                    youtube: {
                        index: 'youtube.com/',
                        id: 'v=',
                        src: '%id%?autoplay=1',
                    }
                }
             }
         });
    } else if (popup_obj[id_popup].type == 'image') {
        var image_link = popup_obj[id_popup].image_link;
        if (image_link != '') {
            var html = '<a href="' + image_link + '"><div class="mfp-img"></div></a>';
        } else {
            var html = '<div class="mfp-img"></div>';
        }
         $('.open-popup-notification-' + id_popup).magnificPopup({
             type:'image',
             midClick: true,
             removalDelay: removalDelay,
             callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = popup_obj[id_popup].animation + ' hi-popup-width-auto';
                },
                open: function(){
                     PopupResponsive(resize_start_point, enable_responsive);
                },
                close: function(){
                    var nextPopupId = getNextPopupId(popup_obj, popup_obj[id_popup].id);
                    if (typeof nextPopupId !== "undefined") {
                        displayPopup(nextPopupId, popup_obj);
                    }
                }
             },
             image: {
                 markup: '<div class="mfp-figure">'+
                            '<div class="mfp-close"></div>'+
                             html+
                         '</div>'
             }
         });
    }
    if (popup_obj[id_popup].page == 'exit' && !force) {
        if ($.cookie('hi_popup_cookie_' + id_popup) != '1'){
            var mouseY = 0;
            var topValue = 0;
            var exit_popup_opened = false;
            window.addEventListener("mouseout",function(e){
                mouseY = e.clientY;
                if (mouseY < topValue) {
                    if (!exit_popup_opened){
                        setTimeout(function(){
                             $('.open-popup-notification-'+id_popup).click();
                            if (popup_obj[id_popup].cookie_time != 0){
                                $.cookie('hi_popup_cookie_' + id_popup, '1', { expires: parseInt(popup_obj[id_popup].cookie_time) });
                            }
                        }, popup_obj[id_popup].delay * 1000);
                        if (popup_obj[id_popup].auto_close != 0){
                            var hide_time = (parseInt(popup_obj[id_popup].delay) + parseInt(popup_obj[id_popup].auto_close)) * 1000;
                            setTimeout(function(){
                                $.magnificPopup.close();
                            }, hide_time);
                        }
                        exit_popup_opened = true;
                    }
                }
            }, false);
        }
    } else {
        if ($.cookie('hi_popup_cookie_' + id_popup) != '1') {
            setTimeout(function(){
                $('.open-popup-notification-'+id_popup).click();
                if (popup_obj[id_popup].cookie_time != 0){
                    $.cookie('hi_popup_cookie_' + id_popup, '1', { expires: parseInt(popup_obj[id_popup].cookie_time) });
                }
            }, popup_obj[id_popup].delay*1000);
            if (popup_obj[id_popup].auto_close != 0){
                var hide_time = (parseInt(popup_obj[id_popup].delay) + parseInt(popup_obj[id_popup].auto_close)) * 1000;
                setTimeout(function(){
                    $.magnificPopup.close();
                }, hide_time);
            }
        }
    }
}

function getNextPopupId (o, id){
    var keys = Object.keys( o ),
        idIndex = keys.indexOf( id ),
        nextIndex = idIndex += 1;
    if (nextIndex >= keys.length){
        return;
    }
    var nextKey = keys[ nextIndex ]
    return nextKey;
}

function PopupResponsive(resize_start_point, enable_responsive){
    if (enable_responsive){
        PopupAddRels();
        if ($( window ).width() <= parseInt(resize_start_point)) {
            PopupResize(resize_start_point);
            PopupResizeFontSize(resize_start_point);
        }

        $( window ).resize(function() {
            if ($( window ).width() <= parseInt(resize_start_point)) {
                PopupResize(resize_start_point);
                PopupResizeFontSize(resize_start_point);
            }else{
                PopupResetStyles();
            }
        });
    }
}

function PopupResize(resize_start_point) {
    $('.white-popup, .mfp-content').each(function() {
        var ratio = $(window).width()/parseInt(resize_start_point);
        ratio = ratio > 1 ? 1:ratio; 
        var width = Math.ceil(500 * ratio);
        $(this).attr('style', 'width: '+width+'px !important; height:auto;');
    });
}

function PopupAddRels(){
    var $elem = $('.mfp-content').find('*');
    $elem.each(function() {
        var font_size = $(this).css('font-size');
        $(this).attr('rel', parseInt(font_size));
    });
}

function PopupResizeFontSize(resize_start_point) {
    $('.mfp-content *').each(function() {

        var defaultFS = $(this).attr('rel');

        var ratio = $(window).width()/parseInt(resize_start_point);
        ratio = ratio > 1 ? 1:ratio; 
        var font_size = Math.ceil(defaultFS * ratio);

        $(this).css('font-size', font_size+'px');
        $(this).css('line-height', font_size+'px');
    });
}

function PopupResetStyles(){
    $('.white-popup, .mfp-content').each(function() {
        $(this).removeAttr('style');
    }); 

    var $elem = $('.mfp-content').find('*');
    $elem.each(function() {
        var font_size = $(this).attr('rel');
        $(this).css('font-size', font_size+'px');
        $(this).css('line-height', font_size+'px');
    });
}

$.fn.shake = function(intShakes, intDistance, intDuration) {
    this.each(function() {
        $(this).css("position","relative"); 
        for (var x=1; x<=intShakes; x++) {
            $(this).animate({left:(intDistance*-1)}, (((intDuration/intShakes)/4)))
                .animate({left:intDistance}, ((intDuration/intShakes)/2))
                .animate({left:0}, (((intDuration/intShakes)/4)));
            }
        });
        return this;
};

if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
    $(window).load(function(){
        $('#pf_popup_login_box input:-webkit-autofill').each(function(){
            var text = $(this).val();
            var name = $(this).attr('name');
            $(this).after(this.outerHTML).remove();
            $('input[name=' + name + ']').val(text);
        });
    });
}

// Facebook Connect
function hipopupFbLogin() {
    FB.api('/me?fields=email,birthday,first_name,last_name,gender', function(response) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: hi_popup_module_dir + '/ajax/fb_login.php',
            data: {
                secure_key: popup_secure_key,
                fb_full_info: response,
                user_fname: response.first_name,
                user_lname: response.last_name,
                email: response.email,
                user_data_id: response.id,
                gender: response.gender,
            },
            beforeSend: function(){
                loaderOpening();
            },
            success: function(response){
                if(response.activate_die_url != ''){
                     window.location.href = response.activate_die_url;
                } else {
                    if(pn_back_url) {
                        window.location.href = pn_back_url;
                    } else if (pn_social_redirect == 'my_account') {
                            window.location.href = my_account_url;
                    } else {
                            window.location.reload();
                    }
                }
            }
        });
    });
}

function fb_login(e){
    FB.login(function(response) {
        if (response.authResponse) {
            access_token = response.authResponse.accessToken;
            user_id = response.authResponse.userID;
            hipopupFbLogin();
        }
    },
    {
        scope: 'public_profile,email'
    });
}

/*Google connect*/
function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            var profile = googleUser.getBasicProfile();
            var id_token = googleUser.getAuthResponse().id_token;
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.disconnect();
            if(typeof id_token !== "undefined" && id_token != ''){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: hi_popup_module_dir + '/ajax/gp_login.php',
                    data: {
                        secure_key: popup_secure_key,
                        id_token: id_token
                    },
                    beforeSend: function(){
                        loaderOpening();
                    },
                    success: function(response){
                        if (response.hasOwnProperty('error') && response.error) {
                            loaderClose();
                            alert(response.error + ': ' + response.error_description);
                            return;
                        }
                        if(response.activate_die_url != ''){
                             window.location.href = response.activate_die_url;
                        } else {
                            if(pn_back_url) {
                                window.location.href = pn_back_url;
                            } else if (pn_social_redirect == 'my_account') {
                                window.location.href = my_account_url;
                            } else {
                                window.location.reload();
                            }
                        }
                    }
                });
            }
    });
}

function startGoogleAccountSignIn () {
    gapi.load('auth2', function(){
        auth2 = gapi.auth2.init({
            client_id: gp_client_id,
            cookiepolicy: 'single_host_origin',
        });

        var google_buttons = document.querySelectorAll('.googleplusSignIn');
        for (var i = 0; i < google_buttons.length; i++) {
          attachSignin(google_buttons[i].id);
        }
    });
};