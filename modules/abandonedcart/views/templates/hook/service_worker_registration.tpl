<script data-keepinline>
    var kb_display_custom_notif = 0;
    var dashboard_worker = '{$dashboard_worker}{*escape not required as contain URL*}';
    var kb_service_worker_front_url = '{$kb_service_worker_front_url nofilter}'; {*escape not required as contain URL*}
    var kb_registed_success = "{l s='Registered Successfully' mod='abandonedcart'}";
    var kb_registed_error = "{l s='Error in registrated as admin' mod='abandonedcart'}";
    var settings_fcm = '{$settings_fcm nofilter}'; {*Variable is JSON encoded, can't escape*}
    var abd_ajax_url = '{$ajax_path nofilter}'; {*Variable contains URL, escape not required*}
</script>
<style>
    .kboverlaygg {
        width: 100%;
        height: 100%;
        position: fixed;
        background: rgba(0,0,0,0.5);
        z-index: 9;
    }
</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="{$kbsrc}/views/js/firebase/firebase-app.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/firebase/firebase-storage.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/firebase/firebase-auth.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/firebase/firebase-database.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/firebase/firebase-messaging.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/firebase/firebase.js"></script>{*escape not required as contain URL*}
<script src="{$kbsrc}/views/js/service_worker_registeration_template.js"></script>{*escape not required as contain URL*}


{*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
* We offer the best and most useful modules PrestaShop and modifications for your online store.
*
* @category  PrestaShop Module
* @author    knowband.com <support@knowband.com>
* @copyright 2018 Knowband
* @license   see file: LICENSE.txt
*}