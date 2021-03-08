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

<div id="search_widget" class="col-lg-4 col-md-5 col-sm-12 search-widget" data-search-controller-url="{$link->getPageLink('search')|escape:'html':'UTF-8'}">
    <div class="wrap_search_widget">
        <form method="get" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" id="searchbox">
            <input type="hidden" name="controller" value="search" />
            <input type="text" id="input_search" name="search_query" placeholder="{l s='Search our catalog' mod='bonsearch'}" class="ui-autocomplete-input" autocomplete="off" />
            <button type="submit">
                <i class="material-icons search"></i>
                <span class="hidden-xl-down">{l s='Search' mod='bonsearch'}</span>
            </button>
        </form>
        <div id="search_popup"></div>
    </div>
</div>
