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

<div class="{if $button_position == 'inline'}position_inline{else}position_block{/if}">
	{if $button_size == 'small'}
		<a onclick="fb_login();" class="popup-sc-s-btn popup-sc-fb-s-btn popup-sc-onclick-btn" title="{l s='Sign in with Facebook' mod='hipopupnotification'}"><span><span></span></span></a>
	{else}
		<a onclick="fb_login();" class="popup-sc-button popup-sc-fb-button popup-sc-onclick-btn">
			<span class="popup-sc-button-text">
				<span>{l s='Sign in with Facebook' mod='hipopupnotification'}</span>
			</span>
			<span class="popup-sc-button-icon">
				<span></span>
			</span>
		</a>
	{/if}
</div>
