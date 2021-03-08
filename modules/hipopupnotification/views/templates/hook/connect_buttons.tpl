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

{if isset($fb_on) && $fb_on}
	{if $fb_button_size == 'big'}
		<a onclick="fb_login();" class="popup-sc-button popup-sc-fb-button popup-sc-onclick-btn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}">
			<span class="popup-sc-button-text">
				<span>{l s='Sign in with Facebook' mod='hipopupnotification'}</span>
			</span>
			<span class="popup-sc-button-icon">
				<span></span>
			</span>
		</a>
	{else}
		<a onclick="fb_login();" class="popup-sc-s-btn popup-sc-fb-s-btn popup-sc-onclick-btn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}" title="{l s='Sign in with Facebook' mod='hipopupnotification'}"><span><span></span></span></a>
	{/if}
{/if}

{if isset($tw_on) && $tw_on}
	{if $tw_button_size == 'big'}
		<a href="#"  onclick="window.open('{$callback_url|escape:'htmlall':'UTF-8'}', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=300, width=700, height=600');" class="popup-sc-button popup-sc-tw-button popup-sc-onclick-btn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}">
			<span class="popup-sc-button-text">
				<span>{l s='Sign in with Twitter' mod='hipopupnotification'}</span>
			</span>
			<span class="popup-sc-button-icon">
				<span></span>
			</span>
		</a>
	{else}
		<a href="#" onclick="window.open('{$callback_url|escape:'htmlall':'UTF-8'}', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=300, width=700, height=600');" class="popup-sc-s-btn popup-sc-tw-s-btn popup-sc-onclick-btn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}" title="{l s='Sign in with Twitter' mod='hipopupnotification'}"><span><span></span></span></a>
	{/if}
{/if}

{if isset($gl_on) && $gl_on}
	{if $gl_button_size == 'big'}
		<span class="g-signin popup-sc-button popup-sc-gl-button popup-sc-onclick-btn googleplusSignIn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}" id='googleplusSignIn-big-{$hook}'>
			<span class="popup-sc-button-text">
				<span>{l s='Sign in with Google' mod='hipopupnotification'}</span>
			</span>
			<span class="popup-sc-button-icon">
				<span></span>
			</span>	
		</span>
	{else}
		<span class="g-signin popup-sc-s-btn popup-sc-gl-s-btn popup-sc-onclick-btn googleplusSignIn {if $psv>= 1.7} popup-sc-btn-17 {else} popup-sc-btn-16 {/if}" title="{l s='Sign in with Google' mod='hipopupnotification'}" id='googleplusSignIn-small-{$hook}'><span><span></span></span></span>
	{/if}
{/if}
