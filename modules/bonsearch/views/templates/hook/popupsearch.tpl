{*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Advanced Ajax Live Search Product
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}


    {if isset($products) && $products}
        <div class="wrap_item">
        {foreach from=$products item=product name=product}
            <div class="product clearfix">
                {if isset($enable_image) && $enable_image}
                    <div class="search_img">
                        <a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" class="product_image">
                            <img src="{$link->getImageLink($product.id_image, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" alt="{$product.name|escape:'html':'UTF-8'}" />
                        </a>
                    </div>
                {/if}
                <div class="search_info">
                    {if isset($enable_name) && $enable_name}
                        <a class="product_name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                            {$product.name|truncate:35:'...'|escape:'html':'UTF-8'}
                        </a>
                    {/if}
                    {if isset($enable_price) && $enable_price}
                        <span class="price">{$product.price|escape:'html':'UTF-8'}</span>
                    {/if}
                </div>
            </div>
        {/foreach}
        <a href="/busqueda?controller=search&search_query={$query|escape:'html':'UTF-8'}" class="btn btn-sm btn-dark">Ver Mas</a>

</div>
    {/if}
