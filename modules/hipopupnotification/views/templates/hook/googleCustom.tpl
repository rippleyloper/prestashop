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
		<span class="g-signin popup-sc-s-btn popup-sc-gl-s-btn popup-sc-onclick-btn googleplusSignIn" title="{l s='Sign in with Google' mod='hipopupnotification'}" id='googleplusSignIn-top'><span><span></span></span></span>
	{else}
		<span class="g-signin popup-sc-button popup-sc-gl-button popup-sc-onclick-btn googleplusSignIn" id='googleplusSignIn-{$id_popup}'>
			<span class="popup-sc-button-text">
				<span>{l s='Sign in with Google' mod='hipopupnotification'}</span>
			</span>
			<span class="popup-sc-button-icon">
				<span></span>
			</span>	
		</span>
	{/if}
</div>


