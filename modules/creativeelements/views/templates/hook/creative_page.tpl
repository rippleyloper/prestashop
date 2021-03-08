{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

{$ver=$creative_elements->getVersion()}
<div class="elementor elementor-{$creativepage_id|intval}" data-version="{$ver}">
	<div id="elementor-inner">
		<div id="elementor-section-wrap">
		{foreach from=$creativepage_data item=section_data}
			{include file=$smarty.const._PS_MODULE_DIR_|cat:'creativeelements/views/templates/hook/element_section.tpl' this=CreativeElements::factory('ElementSection', $section_data)}
		{/foreach}
		</div>
	</div>
</div>
