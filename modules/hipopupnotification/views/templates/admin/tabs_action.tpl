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

<div class="tabs {if $psv < 1.6 } tabs_left {/if}">
	{if $prefix == 'news_letter' || $prefix == 'social_connect'}
		<a class="list-group-item {if $action == '' || $action == 'settings'} active{/if}"
		href="{$module_url|escape:'htmlall':'UTF-8'}&{$url_key|escape:'htmlall':'UTF-8'}={$tab_parent}&action=settings">
			{l s='Settings' mod='hipopupnotification'}
		</a>
		<a class="list-group-item {if $action == 'stats'} active{/if}"
		href="{$module_url|escape:'htmlall':'UTF-8'}&{$url_key|escape:'htmlall':'UTF-8'}={$tab_parent}&action=stats">
			{l s='Stats' mod='hipopupnotification'}
		</a>
	{/if}
</div>