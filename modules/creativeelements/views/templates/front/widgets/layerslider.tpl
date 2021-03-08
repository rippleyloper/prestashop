{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

{$slider}

{if $previewId}
<style>
.elementor-editor-active #elementor .elementor-widget-ps-widget-LayerSlider .elementor-editor-widget-settings { z-index: 50; }
</style>
<script>
	var js = $('#layerslider_{$previewId}').prev().html() || '';
	{literal}
	if (js = js.match(/{([^]*)}/)) eval(js[1]);
	{/literal}
</script>
{/if}
