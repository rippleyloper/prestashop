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
 * @copyright 2020 Knowband
 * @license   see file: LICENSE.txt
 * @category  PrestaShop Module
 *
 *
 * Description
 *
 */

//Added By Anshul for Web Browser Changes (Feature: Push Notification (Jan 2020))
include_once(_PS_MODULE_DIR_ . 'abandonedcart/classes/KbABPushSubscribers.php');
class AbandonedCartCronModuleFrontController extends ModuleFrontController
{
    const CRON_TABLE_NAME = 'velsof_abd_cron_log';
    const CRON_DETAIL_TABLE_NAME = 'velsof_abd_cron_log_details';
    public function initContent()
    {
        parent::initContent();
        /*
         * Start: Code added by Anshul to check if the module is enable or not first
         */
        $configurations = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        if (isset($configurations) && !empty($configurations) && $configurations['enable'] != 1) {
            echo $this->module->l('Please enable the module first.', 'cron');
            die;
        }
        /*
         * End: Code added by Anshul to check if the module is enable or not first
         */
        $abd_obj = new Abandonedcart();
        
        if (Tools::getValue('type')) {
            $cron_type = "Manual";
        } else {
            $cron_type = "Automatic";
        }

        if (!Tools::isSubmit('ajax')) {
            if (Tools::getValue('secure_key')) {
                $secure_key = Configuration::get('VELSOF_ABD_SECURE_KEY');
                if ($secure_key == Tools::getValue('secure_key')) {
                    if (Tools::getValue('cron') == 'send_mails') {
                        $abd_obj->sendAutomaticIncentiveMails(true, $cron_type);
                    }
                    /*Start: Code added by anshul to send the push notifications to the subscribed users (Feature: Push Notification (Jan 2020))*/
                    if (Tools::getValue('cron') == 'send_push_notifications') {
                        $this->syncAbandonedCart($cron_type);
                    }
                    /*End: Code added by anshul to send the push notifications to the subscribed users (Feature: Push Notification (Jan 2020))*/
                    if (Tools::getValue('cron') == 'update_carts') {
                        $abd_obj->updateAbandonList(true, false, $cron_type);
                    }
                    //changes by tarun to unsubscribe customer
                    if (Tools::getValue('cron') == 'unsubscribed') {
                        $abd_obj->unsubscribedLink(Tools::getValue('email'), Tools::getValue('id_customer'));
                    }
                    //changes over
                    /* Start - Code added by RS on 07-Sept-2017 for adding a button to update cart totals in case the module has been updated */
                    if (Tools::getValue('cron') == 'update_analytics') {
                        $abd_obj->updateAbandonList(true, true, $cron_type);
                    }
                    /* End - Code added by RS on 07-Sept-2017 for adding a button to update cart totals in case the module has been updated */
                } else {
                    echo $this->module->l('You are not authorized to access this page', 'cron');
                    die;
                }
            } else {
                echo $this->module->l('You are not authorized to access this page', 'cron');
                die;
            }
        }
    }
    
    /*
     * Function defined by Anshul to send abandoned cart notification to the subscribers
     * Feature: Push Notification (Jan 2020)
     */
    protected function syncAbandonedCart($cron_type)
    {
        //update cron log
        $save_time = date('Y-m-d H:i:s', time());
        $update_cart = $this->module->l("Send Notifications", "cron");
        $progress = $this->module->l("Progress", "cron");
        $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_TABLE_NAME . ' 
                    (name, type, status, start_time, 
                    end_time, date_add, date_upd) values("'
                . pSQL($update_cart) . '", "'
                . pSQL($cron_type) . '", "'
                . pSQL($progress) . '", "'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '")';

        Db::getInstance()->execute($query);
        $id_cron = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
        $abd_obj = new Abandonedcart();
        $data = $abd_obj->getWebBrowserReminderListToApply();  //get web notification reminder list to be applied
        if (empty($data)) {
            echo $this->module->l('No reminders are created for Web Push Notification.', 'cron');
            die;
        }
        foreach ($data as $key => $currentReminder) {
            $AbandonedCartDelay = ($currentReminder['abandon_hour'] * 60 * 60) + ($currentReminder['abandon_min'] * 60);
            $abandoned_cart_data = $abd_obj->getAbandonedCart((int)$AbandonedCartDelay);  //get carts which are following the delay rule
            if (!empty($abandoned_cart_data)) {
                foreach ($abandoned_cart_data as $abd_cart_data) {
                    $coupon_data = array();
                    $id_cart = $abd_cart_data['id_cart'];
                    $cart = new Cart($id_cart);
                    if ($cart->nbProducts() > 0) {
                        //check if discount is there or not
                        if ($currentReminder['discount_type'] == 2) {
                            $coupon_data['coupon_code'] = '';
                            $coupon_data['coupon_value'] = 0;
                        } else {
                            //generate coupon for push notification
                            $coupon_data = $abd_obj->getDiscountCodeForWebNotification($currentReminder, $cart, $abd_cart_data['id_customer']);
                        }

                        $cart_total = Cart::getTotalCart($id_cart, true, Cart::BOTH_WITHOUT_SHIPPING);
                        $subscriber = KbABPushSubscribers::getPushSubscriber($id_cart);
                        $check_incentive_status = 'select * from ' . _DB_PREFIX_ .
                                'kb_ab_notification_mapping where id_cart = ' . (int) $id_cart . ' and
								id_reminder = ' . (int) $currentReminder['id_reminder'];

                        $already_sent = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_incentive_status);
                        
                        //do not send the reminder if already sent for current cart
                        if (is_array($already_sent) && count($already_sent) > 0) {
                            continue;
                        }
                        if (!empty($subscriber)) {
                            $id_shop = $subscriber['id_shop'];
                            $reg_id = $subscriber['reg_id'];
                            if ($id_shop == $abd_cart_data['id_shop'] && !empty($reg_id)) {
                                $fcm_setting = Tools::unSerialize(Configuration::get('KB_AB_PUSH_FCM_SERVER_SETTING'), true);
                                if (!empty($fcm_setting)) {
                                    $fcm_server_key = $fcm_setting['server_key'];
                                    $headers = array(
                                        'Authorization:key=' . $fcm_server_key,
                                        'Content-Type:application/json'
                                    );
                                    $fields = array();
                                    $cart_data = array();
                                    $cart_data['id_cart'] = $id_cart;
                                    $cart_data['id_customer'] = $abd_cart_data['id_customer'];
                                    $customer_info = new Customer((int) $abd_cart_data['id_customer']);
                                    $cart_data['customer_secure_key'] = $customer_info->secure_key;
                                    $cart_data['customer_email'] = $customer_info->email;
                                    $cart_data['discount_code'] = $coupon_data['coupon_code'];
                                    $cart_data['id_abandon'] = '';
                                    if (!empty($customer_info->email)) {
                                        $cust_email = $customer_info->email;
                                    } else {
                                        $cust_email = $this->module->l('No email is present', 'cron');
                                    }
                                    $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_DETAIL_TABLE_NAME . ' 
                                        (id_cron, email_id, cart_id, date_add, date_upd) values('
                                        . (int) $id_cron . ', "'
                                        . pSQL($cust_email) . '", '
                                        . (int) $cart_data['id_cart'] . ', "'
                                        . pSQL($save_time) . '","'
                                        . pSQL($save_time) . '")';

                                    Db::getInstance()->execute($query);
                                    $data = array('id_shop' => $id_shop, 'reminder_name' => $currentReminder['name'], 'id_cart' => $id_cart, 'sent_to' => $cart_data['id_customer'], 'is_clicked' => 0, 'sent_at' => Date('Y-m-d H:i:s', time()));
                                    Db::getInstance()->insert('kb_ab_web_push_pushes', $data);
                                    $push_id = Db::getInstance()->Insert_ID();
                                    $getNotifydata = 'SELECT * FROM '._DB_PREFIX_.'kb_ab_web_browser_content_lang Where id_lang = "'.$abd_cart_data['id_lang'].'" And id_reminder = "'.$currentReminder['id_reminder'].'"';
                                    $notify_data = Db::getInstance()->getRow($getNotifydata);
                                    $fields["data"] = array(
                                        "title" => $notify_data['notify_title'],
                                        "action" => $notify_data['notify_title'],
                                        'body' => $notify_data['notify_content'],
                                        "link" => $abd_obj->getFrontActionLink('direct', $cart_data, 0, $push_id),
                                        'icon' => $this->getModuleDirUrl().'abandonedcart/views/img/front/welcome_cart.jpg',
                                    );

                                    if (!empty($fields)) {
                                        if (isset($fields['data']['body'])) {
                                            $message = $fields['data']['body'];
                                            $message = str_replace('{{kb_cart_amount}}', Tools::displayPrice($cart_total), $message);
                                            $message = str_replace('{{min_cart_coupon}}', Tools::displayPrice($currentReminder['min_cart_value_coupon'], (int) $cart->id_currency), $message);
                                            $message = str_replace('{{id_cart}}', $id_cart, $message);
                                            $message = str_replace('{{discount_code}}', $coupon_data['coupon_code'], $message);
                                            $message = str_replace('{{discount_value}}', $coupon_data['coupon_value'], $message);
                                            $message = str_replace('{{coupon_validity}}', $currentReminder['coupon_validity'], $message);
                                            $fields['data']['body'] = $message;
                                        }
                                        $fields['to'] = $reg_id;
                                        $fields["data"]["base_url"] = $this->getBaseUrl();
                                        $fields["data"]["click_url"] = $this->context->link->getModuleLink($this->module->name, 'serviceworker', array('action' => 'updateClickPush'), (bool) Configuration::get('PS_SSL_ENABLED'));
                                        if (!empty($push_id)) {
                                            //send push notification
                                            $result = $abd_obj->sendPushRequestToFCM($headers, $fields);
                                            //Map the sent reminder with cart id
                                            $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'kb_ab_notification_mapping (id_reminder,
								id_cart, id_subscriber, sent_at) values('
                                                    . (int) $currentReminder['id_reminder'] . ',' . (int) $id_cart . ',
								' . (int) $subscriber['id_subscriber'] . ', now())';
                                            Db::getInstance()->execute($sql);
                                            $abd_obj->updateReminderSentInfo($abd_cart_data['id_abandon']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //update cron log
        $end_time = date('Y-m-d H:i:s', time());
        $comp = $this->module->l('Completed', 'cron');
        $query = 'UPDATE ' . _DB_PREFIX_ . self::CRON_TABLE_NAME
                . ' set status = "' . pSQL($comp) . '", 
                    end_time = "' . pSQL($end_time) . '", date_upd="' . pSQL($end_time) . '" WHERE id_cron = ' . (int) $id_cron;
        Db::getInstance()->execute($query);
        echo $this->module->l('Cron executed successfully.', 'cron');
        die;
    }
    
    /*
     * function for Returning the Base URL of the store
     */
    protected function getBaseUrl()
    {
        $module_dir = '';
        if ($this->checkSecureUrl()) {
            $module_dir = _PS_BASE_URL_SSL_ ;
        } else {
            $module_dir = _PS_BASE_URL_ ;
        }
        return $module_dir;
    }
    
    /*
     * Function to get the URL of the store,
     * this function also checks if the store
     * is a secure store or not and returns the URL accordingly
     * Feature: Push Notification (Jan 2020)
     */
    private function checkSecureUrl()
    {
        $custom_ssl_var = 0;
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'on') {
                $custom_ssl_var = 1;
            }
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $custom_ssl_var = 1;
        }
        if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * Function Added by Anshul to get the URL upto module directory
     * Feature: Push Notification (Jan 2020)
     */
    private function getModuleDirUrl()
    {
        $module_dir = '';
        if ($this->checkSecureUrl()) {
            $module_dir = _PS_BASE_URL_SSL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
        } else {
            $module_dir = _PS_BASE_URL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
        }
        return $module_dir;
    }
    

    public function postProcess()
    {
        parent::postProcess();
        //Handle Ajax request
        if (Tools::isSubmit('ajax')) {
            if (Tools::isSubmit('action')) {
                if ($this->context->cart->id != 0) {
                    $customer_data = array();
                    $action = Tools::getValue('action');
                    if ($action == 'add_email') {
                        $customer_data['email'] = Tools::getValue('email');
                        $customer_data['cart_id'] = (int) $this->context->cart->id;
                        $customer_data['fname'] = Tools::getValue('fname', '');
                        $customer_data['lname'] = Tools::getValue('lname', '');
                        $this->addToTrackingTable($customer_data);
                    }
                    /*Start: Code added by Anshul to update the last show and next show time in the DB (Feature: Popup Reminder (Jan 2020))*/
                    if ($action == 'updatePopupReminder') {
                        $this->updatePopupReminderData();
                    }
                    /*End: Code added by Anshul to update the last show and next show time in the DB (Feature: Popup Reminder (Jan 2020))*/
                }
            }
        }
    }
    
    /*
     * Function added by Anshul to update the time for next popup show in tracking table "kb_ab_popup_reminder_track"
     * Feature: Popup Reminder (Jan 2020)
     */
    public function updatePopupReminderData()
    {
        $sql = 'SELECT count(*) as count FROM ' . _DB_PREFIX_ . 'kb_ab_popup_reminder_track WHERE id_cart = ' . (int) Tools::getValue('id_cart') . ' AND id_reminder=' . (int) Tools::getValue('id_reminder');
        $data = Db::getInstance()->getRow($sql);
        if (Tools::getValue('type') == 'last_show') {
            if ($data['count'] > 0) {
                Db::getInstance()->execute(
                    'UPDATE ' . _DB_PREFIX_ . 'kb_ab_popup_reminder_track
                    SET last_show = "' . pSQL(Date('Y-m-d H:i:s', time())) . '" WHERE id_cart = ' . (int) Tools::getValue('id_cart') . ' AND id_reminder=' . (int) Tools::getValue('id_reminder')
                );
            } else {
                Db::getInstance()->execute(
                    'INSERT INTO ' . _DB_PREFIX_ . 'kb_ab_popup_reminder_track
                        set id_cart = ' . (int) Tools::getValue('id_cart')
                        . ', id_reminder = ' . (int) Tools::getValue('id_reminder') . ', last_show = "' . pSQL(Date('Y-m-d H:i:s', time())) . '"'
                );
            }
        } elseif (Tools::getValue('type') == 'next_show') {
            $time = Tools::getValue('nexttime');
            if ($data['count'] > 0) {
                Db::getInstance()->execute(
                    'UPDATE ' . _DB_PREFIX_ . 'kb_ab_popup_reminder_track
                    SET next_show = "' . pSQL(Date('Y-m-d H:i:s', (int) ($time / 1000))) . '" WHERE id_cart = ' . (int) Tools::getValue('id_cart') . ' AND id_reminder=' . (int) Tools::getValue('id_reminder')
                );
            } else {
                Db::getInstance()->execute(
                    'INSERT INTO ' . _DB_PREFIX_ . 'kb_ab_popup_reminder_track
                        set id_cart = ' . (int) Tools::getValue('id_cart')
                        . ', id_reminder = ' . (int) Tools::getValue('id_reminder') . ', next_show = "' . pSQL(Date('Y-m-d H:i:s', (int) ($time / 1000))) . '"'
                );
            }
        }
    }

    private function addToTrackingTable($customer)
    {
        $check_query = 'select email from ' . _DB_PREFIX_ . AbandonedCartCore::ABD_TRACK_CUSTOMERS_TABLE_NAME .
                ' where id_cart = ' . (int) $customer['cart_id'];
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($check_query);

        if ($results && count($results) > 0) {
            $query = 'UPDATE ' . _DB_PREFIX_ . AbandonedCartCore::ABD_TRACK_CUSTOMERS_TABLE_NAME . ' set';
            if (isset($customer['fname']) && $customer['fname'] != '') {
                $query .= ' firstname = "' . pSQL($customer['fname']) . '",';
            }
            if (isset($customer['lname']) && $customer['lname'] != '') {
                $query .= ' lastname = "' . pSQL($customer['lname']) . '",';
            }
            $query .= ' email = "' . pSQL($customer['email']) . '", 
				date_upd = now() WHERE id_cart = ' . (int) $customer['cart_id'];
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($query);
        } else {
            $query = 'INSERT INTO ' . _DB_PREFIX_ . AbandonedCartCore::ABD_TRACK_CUSTOMERS_TABLE_NAME
                    . ' (id_cart, firstname,
                    lastname, email, date_add, date_upd) values('
                    . (int) $customer['cart_id'] . ', "'
                    . pSQL($customer['fname']) . '", "'
                    . pSQL($customer['lname']) . '","' . pSQL($customer['email']) . '", now(), now())';

            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($query);
        }
    }
}
