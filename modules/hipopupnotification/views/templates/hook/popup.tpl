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

{if $content && $content != ''}
	<div id="popup-notification-{$id_popup}" class="popup_type_{$content_type|escape:'htmlall':'UTF-8'} white-popup mfp-with-anim mfp-hide " data-id-popup = {$id_popup}>
		<div class="popup-container popup-nmb-{$id_popup|intval}">
			<div class="notification-content">
				{if $content_type == 'html' || $content_type == 'newsletter' || $content_type == 'login' || $content_type == 'register' || $content_type == 'login_and_register'}
					{$content nofilter}
				{else if $content_type == 'facebook'}
					<script>
		                (function(d, s, id) {
		                  var js, fjs = d.getElementsByTagName(s)[0];
		                  if (d.getElementById(id)) return;
		                  js = d.createElement(s); js.id = id;
		                  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId={$sc_facebook_app_id}";
		                  fjs.parentNode.insertBefore(js, fjs);
		                }(document, 'script', 'facebook-jssdk'));
		            </script>
					<div class="fb-like-box" data-href="{$content}" data-width="{$width-30}" data-height="{$height-30}" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
				{/if}
			</div>
		</div>
	</div>
	{if $content_type == 'html' || $content_type == 'facebook' || $content_type == 'newsletter' || $content_type == 'login' || $content_type == 'register' || $content_type == 'login_and_register'}
		<a href="#popup-notification-{$id_popup}" class="open-popup-notification-{$id_popup}"></a>
	{else if $content_type == 'youtube'}
		<a href="://www.youtube.com/embed/{$content|escape:'html':'UTF-8'}" class="open-popup-notification-{$id_popup}"></a>
	{else if $content_type == 'vimeo'}
		<a href="https://vimeo.com/{$content|escape:'html':'UTF-8'}" class="open-popup-notification-{$id_popup}"></a>
	{else if $content_type == 'gmaps'}
		<a href="{$content nofilter}" class="open-popup-notification-{$id_popup}"></a>
	{else if $content_type == 'image'}
		<a href="{if $content != ''}{$image_dir}/{$content nofilter}{/if}" class="open-popup-notification-{$id_popup}"></a>
	{/if}

	<style type="text/css">
		{if $responsive}
			#popup-notification-{$id_popup}{
				width: {$width|intval}px;
				height: {$height|intval}px;
			}
		{/if}
		{if $background_image != ''}
			#popup-notification-{$id_popup} .popup_authentication_box{
				background: transparent;
			}
			#popup-notification-{$id_popup}{
				background: #fff url('{$image_dir|escape:'html':'UTF-8'}/{$background_image|escape:'html':'UTF-8'}');
				background-repeat: {$background_repeat|escape:'html':'UTF-8'};
			}
		{/if}
	</style>
	<script type="text/javascript">
		var hiPopupItem = {};
		hiPopupItem['id'] = '{$id_popup|intval}';
		hiPopupItem['width'] = '{$width|intval}';
		hiPopupItem['height'] = '{$height|intval}';
		hiPopupItem['cookie_time'] = '{$cookie_time|intval}';
		hiPopupItem['delay'] = '{$delay_time|intval}';
		hiPopupItem['auto_close'] = '{$auto_close_time|intval}';
		hiPopupItem['page'] = '{$popup_type|escape:"htmlall":"UTF-8"}';
		hiPopupItem['type'] = '{$content_type|escape:"htmlall":"UTF-8"}';
		hiPopupItem['animation'] = '{$animation|escape:"htmlall":"UTF-8"}';
		hiPopupItem['remove_padding'] = '{$remove_padding|escape:"htmlall":"UTF-8"}';
		hiPopupItem['image_link'] = '{$image_link|escape:"htmlall":"UTF-8"}';

		{if $popup_type == 'all_pages'}
			hiPopup['{$id_popup|intval}'] = hiPopupItem;
		{/if}

		{if $popup_type == 'exit'}
			hiPopupExit['{$id_popup|intval}'] = hiPopupItem;
		{/if}

		{if $popup_type == 'home' && $controller_name == 'index'}
			hiPopup['{$id_popup|intval}'] = hiPopupItem;
		{/if}
		
		{if $popup_type == 'category' && $controller_name == 'category'}
			hiPopup['{$id_popup|intval}'] = hiPopupItem;
		{/if}

		{if $popup_type == 'product' && $controller_name == 'product'}
			hiPopup['{$id_popup|intval}'] = hiPopupItem;
		{/if}

		{if $popup_type == 'custom'}
			hiPopup['{$id_popup|intval}'] = hiPopupItem;
		{/if}
	</script>
{/if}