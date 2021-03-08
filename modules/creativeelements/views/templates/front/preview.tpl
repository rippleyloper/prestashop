{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

{extends file='page.tpl'}

{block name='page_content_container'}
	{if !empty($creativepage_data)}
		{include file=$smarty.const._PS_MODULE_DIR_|cat:'creativeelements/views/templates/hook/creative_page.tpl'}
	{else}
		{include file=$smarty.const._PS_MODULE_DIR_|cat:'creativeelements/views/templates/hook/empty_page.tpl'}
	{/if}
{/block}
