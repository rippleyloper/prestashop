<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 * We offer the best and most useful modules PrestaShop and modifications for your online store.
 *
 * @author    knowband.com <support@knowband.com>
 * @copyright 2020 knowband
 * @license   see file: LICENSE.txt
 * @category  PrestaShop Module
 */

class CartRule extends CartRuleCore
{
    public function checkValidity(Context $context, $already_in_cart = false, $display_error = true, $check_carrier = true)
    {
        if (!CartRule::isFeatureActive()) {
            return false;
        }
        if (!$this->active) {
            return (!$display_error) ? false : $this->trans('This voucher is disabled', array(), 'Shop.Notifications.Error');
        }
        if (!$this->quantity) {
            return (!$display_error) ? false : $this->trans('This voucher has already been used', array(), 'Shop.Notifications.Error');
        }
        if (strtotime($this->date_from) > time()) {
            return (!$display_error) ? false : $this->trans('This voucher is not valid yet', array(), 'Shop.Notifications.Error');
        }
        if (strtotime($this->date_to) < time()) {
            return (!$display_error) ? false : $this->trans('This voucher has expired', array(), 'Shop.Notifications.Error');
        }

        /*
         * Start: code added by Anshul to allow only single coupon from Abandoned cart module on one cart at a time (Jan 2020)
         */
        $pageName = $context->controller->php_self;
        if ($pageName == 'cart' || $pageName == 'order' || $pageName == 'order-opc' || $pageName == 'checkout' || Tools::getValue('controller') == 'supercheckout') {
            if (Module::isInstalled('abandonedcart') && Module::isEnabled('abandonedcart')) {
                $count_oth = false;
                //changes by tarun
                if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                    $get_cart_rule = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL, false);
                } else {
                    $get_cart_rule = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL);
                }
                //changes over
                if ($get_cart_rule) {
                    foreach ($get_cart_rule as $cart_rule) {
                        if (strpos($cart_rule['description'], 'ABD[') !== false) {
                            $count_oth = true;
                            break;
                        }
                    }
                    $ab_coupon = false;
                    if (strpos($this->description, 'ABD[') !== false) {
                        $ab_coupon = true;
                    }
                    if (Tools::getValue('controller') == 'supercheckout') {
                        if (($ab_coupon && count($get_cart_rule) >= 2) || ($count_oth && count($get_cart_rule) >= 2)) {
                            return (!$display_error) ? false : $this->trans('Please remove the existing coupon first in order to use Abandoned Cart coupon.', array(), 'Shop.Notifications.Error');
                        }
                    } else {
                        if (($ab_coupon && count($get_cart_rule) >= 1) || ($count_oth && count($get_cart_rule) >= 1)) {
                            return (!$display_error) ? false : $this->trans('Please remove the existing coupon first in order to use Abandoned Cart coupon.', array(), 'Shop.Notifications.Error');
                        }
                    }
                }
            }
        }
        /*
         * End: code added by Anshul to allow only single coupon from Abandoned cart module on one cart at a time (Jan 2020)
         */

        if ($context->cart->id_customer) {
            $quantityused = Db::getInstance()->getValue('
			SELECT count(*)
			FROM ' . _DB_PREFIX_ . 'orders o
			LEFT JOIN ' . _DB_PREFIX_ . 'order_cart_rule od ON o.id_order = od.id_order
			WHERE o.id_customer = ' . $context->cart->id_customer . '
			AND od.id_cart_rule = ' . (int) $this->id . '
			AND ' . (int) Configuration::get('PS_OS_ERROR') . ' != o.current_state
			');
            if ($quantityused + 1 > $this->quantity_per_user) {
                return (!$display_error) ? false : $this->trans('You cannot use this voucher anymore (usage limit reached)', array(), 'Shop.Notifications.Error');
            }
        }

        if ($this->group_restriction) {
            $id_cart_rule = (int) Db::getInstance()->getValue('
			SELECT crg.id_cart_rule
			FROM ' . _DB_PREFIX_ . 'cart_rule_group crg
			WHERE crg.id_cart_rule = ' . (int) $this->id . '
			AND crg.id_group ' . ($context->cart->id_customer ? 'IN (SELECT cg.id_group FROM '
                                    . _DB_PREFIX_ . 'customer_group cg WHERE cg.id_customer = ' . (int) $context->cart->id_customer . ')' : '= 1'));
            if (!$id_cart_rule) {
                return (!$display_error) ? false : $this->trans('You cannot use this voucher', array(), 'Shop.Notifications.Error');
            }
        }
        if ($this->country_restriction) {
            if (!$context->cart->id_address_delivery) {
                return (!$display_error) ? false : $this->trans('You must choose a delivery address before applying this voucher to your order', array(), 'Shop.Notifications.Error');
            }
            $id_cart_rule = (int) Db::getInstance()->getValue('
			SELECT crc.id_cart_rule
			FROM ' . _DB_PREFIX_ . 'cart_rule_country crc
			WHERE crc.id_cart_rule = ' . (int) $this->id . '
			AND crc.id_country = (SELECT a.id_country FROM ' . _DB_PREFIX_ . 'address a WHERE a.id_address = '
                            . (int) $context->cart->id_address_delivery . ' LIMIT 1)');
            if (!$id_cart_rule) {
                return (!$display_error) ? false : $this->trans('You cannot use this voucher in your country of delivery', array(), 'Shop.Notifications.Error');
            }
        }
        if ($this->carrier_restriction) {
            if (!$context->cart->id_carrier) {
                return (!$display_error) ? false : $this->trans('You must choose a carrier before applying this voucher to your order', array(), 'Shop.Notifications.Error');
            }
            $id_cart_rule = (int) Db::getInstance()->getValue('
			SELECT crc.id_cart_rule
			FROM ' . _DB_PREFIX_ . 'cart_rule_carrier crc
			INNER JOIN ' . _DB_PREFIX_ . 'carrier c ON (c.id_reference = crc.id_carrier AND c.deleted = 0)
			WHERE crc.id_cart_rule = ' . (int) $this->id . '
			AND c.id_carrier = ' . (int) $context->cart->id_carrier);
            if (!$id_cart_rule) {
                return (!$display_error) ? false : $this->trans('You cannot use this voucher with this carrier', array(), 'Shop.Notifications.Error');
            }
        }
        if ($this->shop_restriction && $context->shop->id && Shop::isFeatureActive()) {
            $id_cart_rule = (int) Db::getInstance()->getValue('
			SELECT crs.id_cart_rule
			FROM ' . _DB_PREFIX_ . 'cart_rule_shop crs
			WHERE crs.id_cart_rule = ' . (int) $this->id . '
			AND crs.id_shop = ' . (int) $context->shop->id);
            if (!$id_cart_rule) {
                return (!$display_error) ? false : $this->trans('You cannot use this voucher', array(), 'Shop.Notifications.Error');
            }
        }
        if ($this->product_restriction) {
            $r = $this->checkProductRestrictions($context, false, $display_error, $already_in_cart);
            if ($r !== false && $display_error) {
                return $r;
            } elseif (!$r && !$display_error) {
                return false;
            }
        }
        if ($this->id_customer && $context->cart->id_customer != $this->id_customer) {
            if (!Context::getContext()->customer->isLogged()) {
                return (!$display_error) ? false : ($this->trans('You cannot use this voucher', array(), 'Shop.Notifications.Error') . ' - ' . $this->trans('Please log in', array(), 'Shop.Notifications.Error'));
            }
            return (!$display_error) ? false : $this->trans('You cannot use this voucher', array(), 'Shop.Notifications.Error');
        }
        if ($this->minimum_amount) {
            $minimum_amount = $this->minimum_amount;
            if ($this->minimum_amount_currency != Context::getContext()->currency->id) {
                $minimum_amount = Tools::convertPriceFull($minimum_amount, new Currency($this->minimum_amount_currency), Context::getContext()->currency);
            }
            $cart_total = $context->cart->getOrderTotal($this->minimum_amount_tax, Cart::ONLY_PRODUCTS);
            if ($this->minimum_amount_shipping) {
                $cart_total += $context->cart->getOrderTotal($this->minimum_amount_tax, Cart::ONLY_SHIPPING);
            }
            $products = $context->cart->getProducts();
            //changes by tarun
            if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                $cart_rules = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL, false);
            } else {
                $cart_rules = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL);
            }
            //changes over
            foreach ($cart_rules as &$cart_rule) {
                if ($cart_rule['gift_product']) {
                    foreach ($products as $key => &$product) {
                        $temp = $key;
                        if (empty($product['gift']) && $product['id_product'] == $cart_rule['gift_product'] && $product['id_product_attribute'] == $cart_rule['gift_product_attribute']) {
                            $cart_total = Tools::ps_round($cart_total - $product[$this->minimum_amount_tax ? 'price_wt' : 'price'], (int) $context->currency->decimals * _PS_PRICE_DISPLAY_PRECISION_);
                        }
                        unset($temp);
                    }
                }
            }
            if ($cart_total < $minimum_amount) {
                return (!$display_error) ? false : $this->trans('You have not reached the minimum amount required to use this voucher', array(), 'Shop.Notifications.Error');
            }
        }
        /* This loop checks:
          - if the voucher is already in the cart
          - if a non compatible voucher is in the cart
          - if there are products in the cart (gifts excluded)
          Important note: this MUST be the last check, because if the tested cart rule has priority over a non combinable one in the cart, we will switch them
         */
        $nb_products = Cart::getNbProducts($context->cart->id);
        //changes by tarun
        if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
            $other_cart_rules = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL, false);
        } else {
            $other_cart_rules = $context->cart->getCartRules(CartRule::FILTER_ACTION_ALL);
        }
        //changes over
        if (count($other_cart_rules)) {
            foreach ($other_cart_rules as $other_cart_rule) {
                if ($other_cart_rule['id_cart_rule'] == $this->id && !$already_in_cart) {
                    return (!$display_error) ? false : $this->trans('This voucher is already in your cart', array(), 'Shop.Notifications.Error');
                }
                if ($other_cart_rule['gift_product']) {
                    --$nb_products;
                }
                if ($this->cart_rule_restriction && $other_cart_rule['cart_rule_restriction'] && $other_cart_rule['id_cart_rule'] != $this->id) {
                    $combinable = Db::getInstance()->getValue('
                                        SELECT id_cart_rule_1
                                        FROM ' . _DB_PREFIX_ . 'cart_rule_combination
                                        WHERE (id_cart_rule_1 = ' . (int) $this->id . ' AND id_cart_rule_2 = ' . (int) $other_cart_rule['id_cart_rule'] . ')
                                        OR (id_cart_rule_2 = ' . (int) $this->id . ' AND id_cart_rule_1 = ' . (int) $other_cart_rule['id_cart_rule'] . ')');
                    if (!$combinable) {
                        $cart_rule = new CartRule((int) $other_cart_rule['id_cart_rule'], $context->cart->id_lang);
                        if ($cart_rule->priority <= $this->priority) {
                            return (!$display_error) ? false : $this->trans('This voucher is not combinable with an other voucher already in your cart:', array(), 'Shop.Notifications.Error') .
                                    ' ' . $cart_rule->name;
                        } else {
                            $context->cart->removeCartRule($cart_rule->id);
                        }
                    }
                }
            }
        }
        if (!$nb_products) {
            return (!$display_error) ? false : $this->trans('Cart is empty', array(), 'Shop.Notifications.Error');
        }
        if (!$display_error) {
            return true;
        }
    }
}
