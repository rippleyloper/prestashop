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
    <h2 class="popup-title">{l s='Register' mod='hipopupnotification'}</h2>
    <div class="popup_register_form_content">
        <!-- Register Form -->
        <form name="popup_register_form" class="popup_register_form" action="#" method="POST" accept-charset="utf-8">
            <div class="form-group">
                <input type="text" placeholder="{l s='First Name' mod='hipopupnotification'}" name="popup_register_fname" class="{if $popup_template == 'default'}form-control{/if} popup_register_fname popup_user_icon" title="{l s='First Name' mod='hipopupnotification'}">
            </div>
            <div class="form-group">
                <input type="text" placeholder="{l s='Last Name' mod='hipopupnotification'}" name="popup_register_lname" class="{if $popup_template == 'default'}form-control{/if} popup_register_lname popup_user_icon" title="{l s='Last Name' mod='hipopupnotification'}">
            </div>
            <div class="form-group">
                <input type="email" placeholder="{l s='Email' mod='hipopupnotification'}" name='popup_register_email' class="{if $popup_template == 'default'}form-control{/if} popup_register_email popup_email_icon " title="{l s='Email' mod='hipopupnotification'}">
            </div>
            <div class="form-group">
                <input type="password" name="popup_register_password" placeholder="{l s='Password' mod='hipopupnotification'}" class="{if $popup_template == 'default'}form-control{/if} popup_register_password popup_password_icon" title="{l s='Password' mod='hipopupnotification'}">
            </div>
            <div class="popup_register_bottom_text">
                {if $psv >= 1.7}
                    <div class="row">
                        <div class="col-md-12">
                            <span class="custom-checkbox">
                                <input type="checkbox" name="pn_newsletter" value="1" />
                                <span><i class="material-icons checkbox-checked"></i></span>
                                <label>{l s='Sign up for our newsletter!' mod='hipopupnotification'}</label>
                            </span>
                        </div>
                    </div>
                    {if $popup_login_terms_url}
                        <div class="row">
                            <div class="col-md-12">
                                <span class="custom-checkbox">
                                    <input type="checkbox" name="register_terms" value="1" />
                                    <span><i class="material-icons checkbox-checked"></i></span>
                                    <label>{l s='I agree the' mod='hipopupnotification'}</label>
                                    <a href="{$popup_login_terms_url}" target="_blank">{l s='Terms of Use' mod='hipopupnotification'}</a>
                                </span>
                            </div>
                        </div>
                    {/if}
                {else}
                    <div class="checkbox pn-checkbox">
                        <label>
                            <input type="checkbox" name="pn_newsletter" value="1" />
                            {l s='Sign up for our newsletter!' mod='hipopupnotification'}
                        </label>
                    </div>
                    {if $popup_login_terms_url}
                        <div class="checkbox pn-checkbox">
                            <label>
                                <input type="checkbox" name="register_terms" value="1" />
                                {l s='I agree the' mod='hipopupnotification'}
                            </label>
                            <a href="{$popup_login_terms_url}" target="_blank">{l s='Terms of Use' mod='hipopupnotification'}</a>
                        </div>
                    {/if}
                {/if}
                {hook h='higdpr'}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default popup_register_btn {if $popup_template == 'default'}btn-primary{/if}">
                    <img src="{$module_image_dir}/ajax-loader.gif" class="popup-ajax-loader">
                    {l s='Register' mod='hipopupnotification'}
                </button>
            </div>
            {if $popup_login_enable_facebook || $popup_login_enable_twitter || $popup_login_enable_google}
                <h3 class="social-connect-title">{l s='or connect with' mod='hipopupnotification'}</h3>
                {include file="./socialconnect_button_block.tpl"}
            {/if}
        </form>
        
    </div>
</div>