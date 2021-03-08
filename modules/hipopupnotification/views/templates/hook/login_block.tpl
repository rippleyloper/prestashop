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

<div class="popup_authentication_box">
    <h2 class="popup-title">{l s='Login' mod='hipopupnotification'}</h2>
    <div class="popup_login_form_content">
        <!-- Login Form -->
        <form name="popup_login_form" class="popup_login_form" action="#" method="POST">
            <div class="form-group">
                <input type="text" placeholder="{l s='Email' mod='hipopupnotification'}" name="popup_login_email" class="{if $popup_template == 'default'}form-control{/if} popup_login_email popup_email_icon" title="{l s='Email' mod='hipopupnotification'}">
            </div>
            <div class="form-group password-group">
                <input type="password" name="popup_login_password" placeholder="{l s='Password' mod='hipopupnotification'}" class="{if $popup_template == 'default'}form-control{/if} popup_login_password popup_password_icon" title="{l s='Password' mod='hipopupnotification'}">
                <a class='forgot-password' href="{$forgot_password_url}">
                    {l s='Forgot Password?' mod='hipopupnotification'}
                </a>
            </div>
            {hook h='higdpr'}
            <div class="form-group">
                <button type="submit" class="btn btn-default popup_login_btn {if $popup_template == 'default'}btn-primary{/if}">
                    <img src="{$module_image_dir}/ajax-loader.gif" class="popup-ajax-loader">
                    {l s='Login' mod='hipopupnotification'}
                </button>
            </div>

            {if $popup_login_enable_facebook || $popup_login_enable_twitter || $popup_login_enable_google}
                <h3 class="social-connect-title">{l s='or connect with' mod='hipopupnotification'}</h3>
                {include file="./socialconnect_button_block.tpl"}
            {/if}
        </form>
    </div>
</div>
