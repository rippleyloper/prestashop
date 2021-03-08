{**
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
*}

<script type="text/javascript">
    {literal}
        var psv = {/literal}{$psv|escape:'htmlall':'UTF-8'}{literal};
        var enable_header_login_popup = Boolean({/literal}{$enable_header_login_popup|escape:'htmlall':'UTF-8'}{literal});
        var enable_responsive = Boolean({/literal}{$enable_responsive|escape:'htmlall':'UTF-8'}{literal});
        var resize_start_point = {/literal}{$resize_start_point}{literal};
        var enable_facebook_login = Boolean({/literal}{$enable_facebook_login|escape:'htmlall':'UTF-8'}{literal});
        var facebook_app_id = '{/literal}{$facebook_app_id}{literal}';
        var gp_client_id = '{/literal}{$gp_client_id}{literal}';
        var enable_google_login = '{/literal}{$enable_google_login}{literal}';
        var pn_social_redirect = '{/literal}{$redirect|escape:'htmlall':'UTF-8'}{literal}';
        var my_account_url = '{/literal}{$my_account_url|escape:'htmlall':'UTF-8'}{literal}';
        var controller_name = '{/literal}{$controller_name nofilter}{literal}';
        var hi_popup_module_dir = '{/literal}{$hi_popup_module_dir nofilter}{literal}';
        var popup_secure_key = '{/literal}{$popup_secure_key|escape:'htmlall':'UTF-8'}{literal}';
        var popup_sc_front_controller_dir = '{/literal}{$popup_sc_front_controller_dir nofilter}{literal}';
        var popup_sc_loader = '{/literal}{$popup_sc_loader|escape:'htmlall':'UTF-8'}{literal}';
        var popup_sc_loader = '{/literal}{$popup_sc_loader|escape:'htmlall':'UTF-8'}{literal}';
        var pn_back_url = '{/literal}{$pn_back_url nofilter}{literal}';
        var baseDir = {/literal}{if $psv >= 1.7} {literal} prestashop.urls.base_url {/literal}{else} {literal}baseDir {/literal}{/if} {literal};
        var hiPopup = {};
        var hiPopupExit = {};
    {/literal}
</script>

<style type="text/css">
     @media (max-width: {$hide_start_point}px) {
        .mfp-wrap, .mfp-bg{
            display: none;
        }
     }
</style>

{if $enable_google_login}
    <script src="https://apis.google.com/js/api:client.js"></script>
{/if}

{if $enable_facebook_login}
    <script type="text/javascript">
          window.fbAsyncInit = function() {
            FB.init({
              appId      : facebook_app_id,
              xfbml      : true,
              version    : 'v2.9'
            });
            FB.AppEvents.logPageView();
          };
          {literal}
              (function(d, s, id){
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) {return;}
                 js = d.createElement(s); js.id = id;
                 js.src = "//connect.facebook.net/en_US/sdk.js";
                 fjs.parentNode.insertBefore(js, fjs);
               }(document, 'script', 'facebook-jssdk'));
          {/literal}
    </script>
{/if}