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

<div class="newsletter-container">
	<form action="" method="post" class="popup_newsletter_form">
		<h2 class="popup-title">
			{if $nl_voucher_code}
				{l s='Subscribe to our newsletter and get discount coupon!' mod='hipopupnotification'}
			{else}
				{l s='Subscribe to our newsletter' mod='hipopupnotification'}
			{/if}
		</h2>
		<div class="form-group">
			<input class="{if $popup_template == 'default'}form-control{/if} popup_first_name popup_user_icon" type="text" name="popup_first_name"  placeholder="{l s='First Name' mod='hipopupnotification'}">
		</div>
		<div class="form-group">
			<input class="{if $popup_template == 'default'}form-control{/if} popup_last_name popup_user_icon" type="text" name="popup_last_name"  placeholder="{l s='Last Name' mod='hipopupnotification'}">
		</div>
		<div class="form-group">
			<input class="{if $popup_template == 'default'}form-control{/if} popup_email popup_email_icon" type="text" name="popup_email"  placeholder="{l s='Email' mod='hipopupnotification'}">
		</div>
		{if $nl_terms_url}
			{if $psv >= 1.7}
                <div class="row">
                    <div class="col-md-12">
                        <span class="custom-checkbox">
                            <input type="hidden" name="popup_terms" value="0">
							<input type="checkbox" class="popup_terms" name="popup_terms" value="1">
                            <span><i class="material-icons checkbox-checked"></i></span>
                            <label title="{l s='Terms of Use' mod='hipopupnotification'}">{l s='I agree the' mod='hipopupnotification'}
								<a href="{$nl_terms_url}" target="_blank">{l s='Terms of Use' mod='hipopupnotification'}</a>
							</label>
                        </span>
                    </div>
                </div>
	        {else}
                <div class="form-group">
					<input type="hidden" name="popup_terms" value="0">
					<input type="checkbox" class="popup_terms" name="popup_terms" value="1">
					<label title="{l s='Terms of Use' mod='hipopupnotification'}">{l s='I agree the' mod='hipopupnotification'}
						<a href="{$nl_terms_url}" target="_blank">{l s='Terms of Use' mod='hipopupnotification'}</a>
					</label>
				</div>
	        {/if}
        {/if}
        {hook h='higdpr'}
		<div class="form-group">
			<button type="submit" name="submitPopupNewsletter" class="{if $popup_template == 'default'}btn btn-primary{/if}">
				<img src="{$module_image_dir}/ajax-loader.gif" class="popup-ajax-loader">
				{l s='Subscribe' mod='hipopupnotification'}
			</button>
		</div>
	</form>

	<div class="{if $psv >= 1.6} alert alert-success {else} success {/if} hi-popup-success hide">
		{l s='You have successfully subscribed to newsletter' mod='hipopupnotification'}
	</div>
	<div class="hi-popup-voucher-desc hide">
		<p>{$nl_popup_description}</p>
	</div>
</div>
