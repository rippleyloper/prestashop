/**
 *  Please read the terms of the CLUF license attached to this module(cf "licences" folder)
 *
 * @author    Línea Gráfica E.C.E. S.L.
 * @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
 * @license   https://www.lineagrafica.es/licenses/license_en.pdf
 *            https://www.lineagrafica.es/licenses/license_es.pdf
 *            https://www.lineagrafica.es/licenses/license_fr.pdf
 */

var lgsecurity = {
    scan: function () {
        $('.lgsecurity_list tbody').LoadingOverlay('show');
        $.ajax({
            url: './index.php',
            method: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'ajax': 1,
                'controller': 'AdminModules',
                'module_name': lgsecurity_module_name,
                'configure': lgsecurity_module_name,
                'action': 'scan',
                'token': lgsecurity_token,
                'auth_token': lgsecurity_auth_token,
                'rand': new Date().getTime()
            },
            success: function (response) {
                $('.lgsecurity_list tbody').LoadingOverlay('hide');
                $('.lgsecurity_list tbody').html(response.html);
                if (response.result < 0) {
                    $('.lgsecurity_result_success').hide();
                    $('.lgsecurity_result_error').hide();
                } else if (response.result == 0) {
                    $('.lgsecurity_result_success').show();
                    $('.lgsecurity_result_error').hide();
                } else {
                    $('.lgsecurity_result_success').hide();
                    $('.lgsecurity_result_error').show();
                }
            },
            error: function (response) {
                $('.lgsecurity_list tbody').LoadingOverlay('hide');
                if (response != "undefined") {
                    if (response.status != "undefined"
                        && response.errorcode == 401
                        && response.authurl != "undefined"
                    ) {
                        getAliexpressAuth(response.responseJSON.authurl);
                    } else {
                        showErrorMessage(aliexpress_error_unknown_error);
                    }
                } else {
                    showErrorMessage(aliexpress_error_unknown_error);
                }
            }
        });
    },
    deleteDir: function (id_lgsecuriry_stack) {
        $('.lgsecurity_list tbody').LoadingOverlay('show');
        $.ajax({
            url: './index.php',
            method: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'ajax': 1,
                'controller': 'AdminModules',
                'module_name': lgsecurity_module_name,
                'configure': lgsecurity_module_name,
                'action': 'deleteDir',
                'id_lgsecuriry_stack': id_lgsecuriry_stack,
                'token': lgsecurity_token,
                'auth_token': lgsecurity_auth_token,
                'rand': new Date().getTime()
            },
            success: function (response) {
                $('.lgsecurity_list tbody').LoadingOverlay('hide');
                $('.lgsecurity_list tbody').html(response.html)
                if (response.result < 0) {
                    $('.lgsecurity_result_success').hide();
                    $('.lgsecurity_result_error').hide();
                } else if (response.result == 0) {
                    $('.lgsecurity_result_success').show();
                    $('.lgsecurity_result_error').hide();
                } else {
                    $('.lgsecurity_result_success').hide();
                    $('.lgsecurity_result_error').show();
                }
            },
            error: function (response) {
                $('.lgsecurity_list tbody').LoadingOverlay('hide');
                if (response != "undefined") {
                    if (response.status != "undefined"
                        && response.errorcode == 401
                        && response.authurl != "undefined"
                    ) {
                        getAliexpressAuth(response.responseJSON.authurl);
                    } else {
                        showErrorMessage(lgsecurity_error_unknown_error);
                    }
                } else {
                    showErrorMessage(lgsecurity_error_unknown_error);
                }
            }
        });
    }
}

$(document).ready(function(){
    $(document).on('click', '#lgsecurity_scan_button', function() {
        lgsecurity.scan();
    });
    $(document).on('click', '.lgsecurityDelteItemButton', function() {
        if (confirm(lgsecurity_confirmation_message)) {
            lgsecurity.deleteDir($(this).data('id'));
        }
    });
});
