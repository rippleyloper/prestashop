{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_miniature_item'}
	<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
		{* {if $product.price_without_reduction != $product.price_tax_exc  }

             {if $product.id_category_default == 100}
                 <img src="/img/black.png" class="img-responsive" style="
       position: absolute;
       z-index: 1;
       width: 40%;
   ">
                 {else}
                 <img src="img/bolsa.png" class="img-responsive" style="
       position: absolute;
       z-index: 1;
       width: 40%;
   ">
             {/if}



         {/if}*}
		{if $product.price_without_reduction != $product.price_tax_exc}
			{*$dcto=(($product.price*100)*$product.price_tax_exc)-100*}
		{if $product.id_category_default == 194}
			<img src="img/bolsaVyber.png" class="img-responsive" style="
       position: absolute;
       z-index: 1;
       width: 15%;
       margin-top: 45px;
   ">
		{/if}
			<span class="bg-danger btn btn-danger" style="position: absolute;z-index: 1"> {round(((($product.price_tax_exc*100)/$product.price_without_reduction)-100)*-1 ,0)}% DCTO </span>


		{/if}

		<div class="thumbnail-container">
			{block name='product_thumbnail'}
				{if $product.cover}
					<a href="{$product.url}" class="thumbnail product-thumbnail">
						{if count($product.images) > 1 }
							<img
									class="img_main"
									src = "{$product.cover.bySize.home_default.url}"
									alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name}{/if}"
									data-full-size-image-url = "{$product.cover.large.url}"
							>

							{hook h="displayTmHoverImage" id_product=$product.id_product home='home_default' large='large_default'}
						{else}
							<img class="second_main"
								 src = "{$product.cover.bySize.home_default.url}"
								 alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name}{/if}"
								 data-full-size-image-url = "{$product.cover.large.url}"

							>
						{/if}
					</a>
				{else}
					<a href="{$product.url}" class="thumbnail product-thumbnail">
						<img
								src = "{$urls.no_picture_image.bySize.home_default.url}"
						>
					</a>
				{/if}
			{/block}
			{block name='product_flags'}
				<ul class="product-flags">
					{foreach from=$product.flags item=flag}
						<!--  <li class="{$flag.type}">{$flag.label}</li>-->
					{/foreach}
				</ul>
			{/block}
			<a href="#" class="quick-view" data-link-action="quickview">
				<i class="material-icons search">&#xE417;</i> {l s='' d='Shop.Theme.Actions'}
			</a>
			{block name='product_buy'}
				{if !$configuration.is_catalog}
					<div class="product-actions-main">
						<form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
							<input type="hidden" name="token" value="{$static_token}">
							<input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id">
							<input type="hidden" name="id_customization" value="0" class="product_customization_id">
							<button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if $product.availability == 'unavailable'}disabled{/if}data-toggle="tooltip" title="Add to cart">
								{l s='' d='Shop.Theme.Actions'}
								<i class="material-icons">&#xE8CC;</i>
							</button>
						</form>
					</div>
				{/if}
			{/block}
		</div>
		<div class="product-description">
			{block name='product_name'}
				<span class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></span>
			{/block}

			{block name='product_price_and_shipping'}
				{if $product.show_price}
					<div class="product-price-and-shipping">
						<span itemprop="price" class="price">{$product.price}</span>
						{if $product.has_discount}
							{hook h='displayProductPriceBlock' product=$product type="old_price"}
							{if $product.discount_type === 'percentage'}
								<span class="discount-percentage">{$product.discount_percentage}</span>
							{/if}
							<span class="regular-price">{$product.regular_price}</span>
						{/if}

						{hook h='displayProductPriceBlock' product=$product type="before_price"}
						{hook h='displayProductPriceBlock' product=$product type='unit_price'}

						{hook h='displayProductPriceBlock' product=$product type='weight'}
					</div>
				{/if}
			{/block}
			{block name='product_reviews'}
				{hook h='displayProductListReviews' product=$product}
			{/block}

			<div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">

				{block name='product_variants'}
					{if $product.main_variants}
						{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
					{/if}
				{/block}
			</div>

	</article>
{/block}