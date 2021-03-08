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

{extends file="helpers/list/list_content.tpl"}
{block name="td_content"}
	{if $key == 'status'}
		<a data-id = {$tr.id_hipopupnotification|escape:'htmlall':'UTF-8'} data-status = {$tr.active|escape:'htmlall':'UTF-8'} class="popup-status btn {if $tr.active == '0'}btn-danger{else}btn-success{/if}" 
		href="#" title="{if $tr.active == '0'}{l s='Disabled' mod='hipopupnotification'}{else}{l s='Enabled' mod='hipopupnotification'}{/if}">
			<i class="{if $tr.active == '0'}icon-remove {else}icon-check{/if}"></i>
		</a>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}




