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

{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'file_lang'}
			<div class="col-lg-9">
				{foreach from=$languages item=language}
					{if $languages|count > 1}
						<div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
					{/if}
					<div class="{if $psv >= 1.6} form-group {else} margin-form{/if}">
						<div class="col-lg-6">
							<input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="file" name="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="hide {$input.class|escape:'htmlall':'UTF-8'}" />
							<div class="dummyfile input-group">
								<span class="input-group-addon"><i class="icon-file"></i></span>
								<input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-name" type="text" class="{$input.class|escape:'htmlall':'UTF-8'} disabled" name="filename" readonly />
								<span class="input-group-btn">
									<button id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
										<i class="icon-folder-open"></i> {l s='Choose a file' mod='hipopupnotification'}
									</button>
								</span>
							</div>
						</div>
						{if $languages|count > 1}
							<div class="col-lg-2">
								<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
									{$language.iso_code|escape:'htmlall':'UTF-8'}
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									{foreach from=$languages item=lang}
									<li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
									{/foreach}
								</ul>
							</div>
						{/if}
					
						{if isset($popup_image) && !empty($popup_image) && $popup_image[$language.id_lang] != ''}
							<p class="{if $psv >= 1.6} help-block col-lg-12 {else} preference_description {/if}">
								<img src='{$upload_icon_path|escape:'htmlall':'UTF-8'}{$popup_image[$language.id_lang|escape:'htmlall':'UTF-8']}' class='hide_{$language.id_lang|escape:'htmlall':'UTF-8'}' width='40'>
							</p>
						{/if}
					</div>
					{if $languages|count > 1}
						</div>
					{/if}
					<script>
					$(document).ready(function(){
						$('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-selectbutton').click(function(e){
							$('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}').trigger('click');
						});
						$('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}').change(function(e){
							var val = $(this).val();
							var file = val.split(/[\\/]/);
							$('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-name').val(file[file.length-1]);
						});
					});
				</script>
				{/foreach}
			</div>
	{else if $input.type == 'search_product'}
		<div id="popup_block_products" class="search_product">
			<div>
				<input type="hidden" name="inputBlockProducts" id="inputBlockProducts" value="{$products_id}" />
				<div id="ajax_choose_upsell_block_product" class="col-lg-6">
						<input type="text" id="product_search" name="product_search" value="" autocomplete="off" class="ac-input">
				</div>
				<div class="col-lg-2">
					<button type="button" id="add-popup-product" class="btn btn-default" name="add-popup-products">
						<i class="icon-plus-sign-alt"></i> {l s='Add' mod='hipopupnotification'}
					</button>
				</div>
				<div id="popup_products" class="col-lg-12 col-lg-offset-3">
					{foreach from=$product_content item=product}
						<div class="form-control-static">
							<button type="button" class="btn btn-default delete_popup_product" data-id-product="{$product['id_product']}">
								<i class="icon-remove text-danger"></i>
							</button>
							{$product['id_product']|intval} - {$product['name']|escape:'html':'UTF-8'}
						</div>
					{/foreach}
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#product_search').autocomplete(pnt_admin_controller_dir+"&ajax=1", 
				    {
				        minChars: 2,
				        max: 50,
				        width: 500,
				        formatItem: function (data) {
				            return data[0]+ '. '+data[2] + '-' + data[1];
				        },
				        scroll: false,
				        multiple: false,
				        extraParams: {
				            action : 'product_search',
				            id_lang : id_lang,
				            secure_key : pnt_secure_key,
				        }
				    });
				});
			</script>
		</div>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
