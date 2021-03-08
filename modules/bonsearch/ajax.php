<?php
/**
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
 */

require_once('../../config/config.inc.php');
require_once('../../init.php');
require_once(dirname(__FILE__).'/bonsearch.php');

$bonsearch = new Bonsearch();
$result_products = array();
$products = array();
$bonsearch_key = Tools::getValue('search_key');
$context = Context::getContext();
$count = 0;
$product_link = $context->link;



if (Tools::strlen($bonsearch_key) >= 3) {
    $products = Product::searchByName($context->language->id, $bonsearch_key);
    $total_products = count($products);
    if ($total_products) {
        for ($i = 0; $i < $total_products; $i++) {
            if (($products[$i]['name']) && ($products[$i]['active'])) {
                $images = Image::getImages($context->language->id, $products[$i]['id_product']);
                $product = new Product($products[$i]['id_product']);
                $products[$i]['link'] = $product_link->getProductLink($products[$i]['id_product'], $product->link_rewrite[1], $product->id_category_default, $product->ean13);
                $products[$i]['link_rewrite'] = $product->link_rewrite[1];
                $products[$i]['id_image'] = $images[0]['id_image'];
                $products[$i]['price'] = Tools::displayPrice(Tools::convertPrice($products[$i]['price_tax_incl'], $context->currency), $context->currency);
                if ($count < Configuration::get('BON_SEARCH_COUNT')) {
                    $result_products[] = $products[$i];
                    $count ++;
                } else {
                    break;
                }
            }
        }
    }

    $context->smarty->assign(array(
        'enable_image' => Configuration::get('BON_SEARCH_IMAGE'),
        'enable_price' => Configuration::get('BON_SEARCH_PRICE'),
        'enable_name' => Configuration::get('BON_SEARCH_NAME'),
        'search_alert'   => $bonsearch->no_product,
        'link' => $context->link,
        'products' => $result_products,
        'query' => $bonsearch_key,
    ));

    $context->smarty->display(dirname(__FILE__).'/views/templates/hook/popupsearch.tpl');
} else {
    echo '<div class="wrap_item">'.$bonsearch->three_character.'</div>';
}
