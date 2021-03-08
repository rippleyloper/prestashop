<!--/**
 * This file is added by Anshul for adding Popup reminder changes.
 * It will allow to show the popup (with coupon & products in the cart) to those customers who left their carts abandoned.
 * Feature: Popup Reminder (Jan 2020)
 */
-->
<script>
    var diff_in_sec = "{$diff_in_sec}";
    var kb_pop_time = "{$cart_added_time}";
    var popup_front_again = "{$popup_data['frequuency_popup_again']}";
    var current_time = "{$current_time}";
    var kb_id_cart = "{$kb_id_cart}";
    var kb_id_reminder = "{$kb_id_reminder}";
</script>
<div style="display: none;">
<div id="popup_front_velsof" >{$popup_template['body'] nofilter}</div> {*Variable contains URL, escape not required*}
</div>

{*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer tohttp://www.prestashop.com for more information.
* We offer the best and most useful modules PrestaShop and modifications for your online store.
*
* @category  PrestaShop Module
* @author    knowband.com <support@knowband.com>
* @copyright 2020 Knowband
* @license   see file: LICENSE.txt
*
* Description
*
* Abandoned Cart Front TPL
*}