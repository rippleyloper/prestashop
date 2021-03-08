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

{if $enable_header_login_popup}
    <div id="login-and-register-popup-sign" class="white-popup mfp-with-anim mfp-hide popup_type_login_and_register {if !$header_both_popups}header_single_popup{/if}">
        {$content nofilter}
    </div>
{/if}