{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

{$settings = $this->getSettings()}
{$classes = array()}
{foreach from=$this->getClassControls() item=control}
	{if empty($settings[$control['name']]) || !$this->isControlVisible($control)}{continue}{/if}
	{$classes[] = $control['prefix_class']|cat:$settings[$control['name']]}
{/foreach}

<div class="elementor-section elementor-element elementor-element-{$this->getId()} elementor-{if $this->getData('isInner')}inner{else}top{/if}-section {implode(' ', $classes)}" data-element_type="{$this->getName()}" {if !empty($settings['animation'])}data-animation="{$settings['animation']}"{/if}>
	{if 'video' === $settings['background_background'] && $settings['background_video_link']}
		{$video_id = CreativeUtils::getYoutubeIdFromUrl($settings['background_video_link'])}
		<div class="elementor-background-video-container elementor-hidden-phone">
		{if $video_id}
			<div class="elementor-background-video" data-video-id="{$video_id}"></div>
		{else}
			<video class="elementor-background-video elementor-html5-video" src="{$settings['background_video_link']}" autoplay loop muted></video>
		{/if}
		</div>
	{/if}

	{if in_array($settings['background_overlay_background'], array('classic', 'gradient'))}
		<div class="elementor-background-overlay"></div>
	{/if}
	<div class="elementor-container elementor-column-gap-{$settings['gap']|escape:'html':'UTF-8'}">
		<div class="elementor-row">
			{foreach from=$this->getChildren() item=child}{$child->printElement()}{/foreach}
		</div>
	</div>
</div>
