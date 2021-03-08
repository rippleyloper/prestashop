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

{if $popup_login_enable_facebook || $popup_login_enable_twitter || $popup_login_enable_google}
	<div class="popup_social_connect_content clearfix">
		{if $popup_login_enable_facebook}
			{**
			<!-- <a onclick="fb_login();" class="sc-button sc-fb-button popup-sc-onclick-btn">
				<span>{l s='FACEBOOK' mod='hipopupnotification'}</span>
			</a> -->
			**}
			<button type="submit" onclick="fb_login();" class="sc-button sc-fb-button popup-sc-onclick-btn">
				<span>{l s='FACEBOOK' mod='hipopupnotification'}</span>
			</button>
		{/if}
		{if $popup_login_enable_twitter}
			{***
				<!-- <a href="#"  onclick="window.open('{$callback_url|escape:'htmlall':'UTF-8'}', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=300, width=700, height=600');" class="sc-button sc-tw-button popup-sc-onclick-btn">
					<span>{l s='TWITTER' mod='hipopupnotification'}</span>
				</a> -->
			**}
			<button type="submit" onclick="window.open('{$callback_url|escape:'htmlall':'UTF-8'}', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=300, width=700, height=600');" class="sc-button sc-tw-button popup-sc-onclick-btn">
				<span>{l s='TWITTER' mod='hipopupnotification'}</span>
			</button>
		{/if}
		{if $popup_login_enable_google}
			{**
			<!-- <span class="g-signin sc-button sc-gl-button popup-sc-onclick-btn googleplusSignIn" id='googleplusSignIn-{$id_popup}'>
				<span>{l s='GOOGLE' mod='hipopupnotification'}</span>
			</span> -->
			**}
			<button type="submit" class="g-signin sc-button sc-gl-button popup-sc-onclick-btn googleplusSignIn" id='googleplusSignIn-{$id_popup}'>
				<span>{l s='GOOGLE' mod='hipopupnotification'}</span>
			</button>
		{/if}
	</div>
{/if}