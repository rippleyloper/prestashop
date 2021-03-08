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
 * @copyright 2017 Knowband
 * @license   see file: LICENSE.txt
 * @category  PrestaShop Module
 *
 */

/**
 * This file is added by Anshul for adding Web Push Notification changes.
 * It will allow an Admin to send browser notifications to those customers who left their carts abandoned.
 * Feature: Push Notification (Jan 2020)
 */

require_once(_PS_ROOT_DIR_ . '/init.php');
//include_once(_PS_MODULE_DIR_ . 'kbpushnotification/kbpushnotification.php');
include_once(_PS_MODULE_DIR_ . 'abandonedcart/classes/KbABPushSubscribers.php');
//include_once(_PS_MODULE_DIR_ . 'kbpushnotification/classes/KbPushPushes.php');

class AbandonedcartserviceworkerModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;
    
    public function __construct()
    {
        $this->display_column_left = false;
        $this->display_column_right = false;
//        $this->ssl = true;
        parent::__construct();
    }
    
    public function initContent()
    {
        parent::initContent();
    }
    
    public function postProcess()
    {
        /*
         * function to register/update the subscriber after service worker
         */
        if (Tools::getValue('action') == 'registerServiceWorker') {
            $json = array();
            $reg_id = Tools::getValue('reg_id');
            if (!empty($reg_id)) {
                $id_guest = Context::getContext()->cookie->id_guest;
                $id_cart = Context::getContext()->cart->id;
                //if not cart then do nothing
                if ($id_cart == 0) {
                    echo false;
                    die;
                }
                //check if there is already an entry or not for the cart & user token
                $check_reg_exist = KbABPushSubscribers::getSubscriberbyRegID($reg_id, $id_cart);
                $pushSubscriber = new KbABPushSubscribers();
                if (!empty($check_reg_exist)) {
                    $id_subscriber = $check_reg_exist['id_subscriber'];
                    $pushSubscriber = new KbABPushSubscribers($id_subscriber);
                }

                $pushSubscriber->id_guest = $id_guest;
                $id_lang = Context::getContext()->language->id;
                $id_shop = Context::getContext()->shop->id;
                $browser = Tools::getValue('browser');
                $browser_version = Tools::getValue('browser_version');
                $platform = Tools::getValue('platform');
                $pushSubscriber->id_lang = $id_lang;
                $pushSubscriber->id_shop = $id_shop;
                $pushSubscriber->reg_id = $reg_id;
                $pushSubscriber->browser = $browser;
                $pushSubscriber->browser_version = $browser_version;
                $pushSubscriber->platform = $platform;
                $pushSubscriber->id_cart = $id_cart;
//                print_r($pushSubscriber);die;

                $ip_addr = $this->getRemoteAddr();
                $pushSubscriber->ip = $ip_addr;

                require_once(_PS_VENDOR_DIR_ . 'mobiledetect/mobiledetectlib/Mobile_Detect.php');
                $detect = new Mobile_Detect();
                $device = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'Desktop');
                $pushSubscriber->device = $device;

                if (!empty($check_reg_exist)) {
                    if ($pushSubscriber->update()) {
                        $subscriber_id = $pushSubscriber->id;
                        $json['success'] = $this->module->l('Subscriber saved successfully.', 'serviceworker');
                        $json['subscriber_id'] = $subscriber_id;
                        echo json_encode($json);
                        die;
                    }
                } else {
                    if ($pushSubscriber->save()) {
                        $subscriber_id = $pushSubscriber->id;
                        $json['success'] = $this->module->l('Subscriber saved successfully.', 'serviceworker');
                        $json['subscriber_id'] = $subscriber_id;
                        echo json_encode($json);
                        die;
                    }
                }
            }
            $json['error'] = $this->module->l('Error in retriving token', 'serviceworker');
            echo json_encode($json);
            die;
        }
    }
    
    /*
     * Function added by Anshul to get the remote IP
     */
    public static function getRemoteAddr()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}
