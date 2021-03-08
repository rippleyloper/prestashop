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
 * The following enhancements are implemented for the v2.0.1:
 * Added Popup functionality for reminding & providing the incentives for abandoned carts. (Search "Feature: Popup Reminder (Jan 2020)" in the code)
 * Added functionality to send Push Notification to remind and send the incentives to users who created abandoned carts. (Search "Feature: Push Notification (Jan 2020)" in the code)
 * Added Cron Log functionality so that admin could check if the cron is being executed or not and how many carts of which customer got synced. (Search "Feature: Cron Log (Jan 2020)" in the code)
 * Some minor bug fixes mentioned in the bug sheet
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) . '/classes/abandonedcart_core.php';
//Following file included by Anshul to send the emails from our Mails folder even if the same folder is created in themes directory (Jan 2020)
//require_once dirname(__FILE__) . '/classes/Kbmail.php';

/**
 * The parent class is extending the "Module" core class.
 * So no need to extend "Module" core class here in this class.
 */
class Abandonedcart extends AbandonedCartCore
{
    private $shopping_settings = array();
    protected $admin_path;

    public function __construct()
    {
        parent::__construct();
        $this->name = 'abandonedcart';
        $this->tab = 'advertising_marketing';
        $this->version = '2.0.6';
        $this->author = 'Knowband';
        //$this->need_instance = 0;
        $this->module_key = '3205b56afee05c629b485725f73b0c68';
        $this->author_address = '0x2C366b113bd378672D4Ee91B75dC727E857A54A6';
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
        //$this->bootstrap = true;

        $this->displayName = $this->l('Abandoned Cart');
        $this->description = $this->l('This module will convert the abandoned carts into sales.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function getErrors()
    {
        return $this->custom_errors;
    }

    public function install()
    {
        $this->installModel();
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()) {
            return false;
        }
        

        if (!Configuration::get('VELSOF_ABANDONED_CART_MAIL_CHECK')) {
            //Tools::chmodr(_PS_MODULE_DIR_ . 'abandonedcart/mails', 0755);
            $mail_dir = dirname(__FILE__) . '/mails/en';
            //Foreach added by Anshul in order to create folder of other languages apart from en while installing the module
            foreach (Language::getLanguages(false) as $lang) {
                if ($lang['iso_code'] != 'en') {
                    $new_dir = dirname(__FILE__) . '/mails/' . $lang['iso_code'];
                    if (!file_exists($new_dir)) {
                        $this->copyfolder($mail_dir, $new_dir);
                    }
                }
            }
            Configuration::updateGlobalValue('VELSOF_ABANDONED_CART_MAIL_CHECK', 1);
            Configuration::updateGlobalValue(
                'VELSOF_ABANDONED_CART_DEFAULT_TEMPLATE_LANG',
                Context::getContext()->language->iso_code
            );
        }

        $check_column = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = "' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME
            . '" AND COLUMN_NAME = "quantity"';
        if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_column)) {
            $create_column = 'ALTER TABLE ' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME
                . ' ADD quantity int(11) NOT NULL DEFAULT -1 AFTER id_incentive';
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($create_column);
        }

        $this->shopping_settings = $this->getDefaultSettings();

        Configuration::updateGlobalValue('VELSOF_ABANDONEDCART', serialize($this->shopping_settings));

        if (!Configuration::get('VELSOF_ABANDONEDCART_START_DATE')) {
            Configuration::updateGlobalValue('VELSOF_ABANDONEDCART_START_DATE', date('Y-m-d H:i:s'));
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    public function hookActionValidateOrder($params = null)
    {
        $order = $params['order'];
        $check_abandon_sql = 'select * from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . ' where id_cart = ' .
                (int) $order->id_cart
                . ' AND reminder_sent = "' . (int) self::REMINDER_SENT . '"';
        $check_abandon = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_abandon_sql);
        if (is_array($check_abandon) && count($check_abandon) > 0) {
            $is_converted = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . '
				set is_converted= "1", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"
				where id_abandon=' . (int) $check_abandon['id_abandon'];
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($is_converted);
        }

        $check_abandon_sql = 'select * from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . ' where id_cart = ' .
                (int) $order->id_cart
                . ' AND reminder_sent = "' . (int) self::REMINDER_NOT_SENT . '"';
        $check_cart = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_abandon_sql);
        if (is_array($check_cart) && count($check_cart) > 0) {
            $is_deleted = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . '
				set shows= "0", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"
				where id_abandon=' . (int) $check_cart['id_abandon'];
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($is_deleted);
        }
    }
    
    public function hookActionDeleteGDPRCustomer($customer)
    {
        if (!empty($customer['email']) && Validate::isEmail($customer['email'])) {
            if (Module::isInstalled('abandonedcart')) {
                $config = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
                if (($config['enable'] == 1) && ($config['enable_delete'] == 1)) {
                    $customerFound = false;
                    $sql = "SELECT * FROM "._DB_PREFIX_."velsof_abd_track_customers WHERE email = '".pSQL($customer['email'])."'";
                    $res = Db::getInstance()->ExecuteS($sql);
                    if (count($res)) {
                        $sql = "DELETE FROM "._DB_PREFIX_."velsof_abd_cart WHERE id_cart IN ( Select distinct id_cart from "._DB_PREFIX_."velsof_abd_track_customers where email = '".pSQL($customer['email'])."')";
                        Db::getInstance()->execute($sql);
                        $sql = "DELETE FROM "._DB_PREFIX_."velsof_abd_track_customers WHERE email = '".pSQL($customer['email'])."'";
                        Db::getInstance()->execute($sql);
                        $customerFound = true;
                    }
                    $sqlCustomer = "SELECT id_customer FROM "._DB_PREFIX_."customer WHERE email = '".pSQL($customer['email'])."'";
                    $customerData = Db::getInstance()->getRow($sqlCustomer);
                    if (!Tools::isEmpty($customerData) && $customerData) {
                        $sql = "DELETE FROM "._DB_PREFIX_."velsof_abd_cart WHERE id_customer = '".(int)$customerData['id_customer']."'";
                        Db::getInstance()->execute($sql);
                        $customerFound = true;
                    }
                    if ($customerFound) {
                        return Tools::jsonEncode(true);
                    } else {
                        return Tools::jsonEncode($this->l('Abandon Cart: No user found with this email.', 'abandonedcart_core'));
                    }
                }
            }
        }
    }

    public function hookActionExportGDPRData($customer)
    {
        if (!empty($customer['email']) && Validate::isEmail($customer['email'])) {
            if (Module::isInstalled('abandonedcart')) {
                $config = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
                if ($config['enable'] == 1) {
                    $export_data = array();
                    $sqlCustomer = "SELECT id_customer FROM "._DB_PREFIX_."customer WHERE email = '".pSQL($customer['email'])."'";
                    $customer_data = Db::getInstance()->getRow($sqlCustomer);
                    if (count($customer_data) && $customer_data) {
                        $getCartIdByCutomerIdSql = 'Select id_cart,cart_total, date_add, date_upd  from '._DB_PREFIX_.'velsof_abd_cart where id_customer = '.(int)$customer_data['id_customer'];
                        $getCartIdByCutomerIdData = Db::getInstance()->executeS($getCartIdByCutomerIdSql);
                        if (count($getCartIdByCutomerIdData)) {
                            foreach ($getCartIdByCutomerIdData as $key => $value) {
                                $cart_id = $value['id_cart'];
                                $cutomer_cart_details = $this->getCustomerCartDetail($customer_data['id_customer'], $cart_id);
                                if (count($cutomer_cart_details)) {
                                    foreach ($cutomer_cart_details['products'] as $productDetails) {
                                        $export_data[] = array(
                                            $this->l('Email') => $customer['email'],
                                            $this->l('Cart Id') => $cart_id,
                                            $this->l('Product') => $productDetails['name'],
                                            $this->l('Reference') => $productDetails['reference'],
                                            $this->l('Quantity') => $productDetails['cart_quantity'],
                                            $this->l('Price') => $productDetails['total_wt'],
                                            $this->l('Cart Total') => $cutomer_cart_details['cart_total'],
                                            $this->l('Added Date') => $value['date_add'],
                                            $this->l('Updated Date') => $value['date_upd'],
                                        );
                                    }
                                }
                            }
                        }
                    }
                    $sqlCustomer = "SELECT * FROM "._DB_PREFIX_."velsof_abd_track_customers WHERE email = '".pSQL($customer['email'])."'";
                    $customer_data = Db::getInstance()->ExecuteS($sqlCustomer);
                    if (count($customer_data)) {
                        foreach ($customer_data as $key => $value) {
                            $cart_id = $value['id_cart'];
                            $cutomer_cart_details = $this->getCustomerCartDetail($customer_data, $cart_id);
                            if (count($cutomer_cart_details)) {
                                foreach ($cutomer_cart_details['products'] as $productDetails) {
                                    $export_data[] = array(
                                        $this->l('Email') => $customer['email'],
                                        $this->l('Cart Id') => $cart_id,
                                        $this->l('Product') => $productDetails['name'],
                                        $this->l('Reference') => $productDetails['reference'],
                                        $this->l('Quantity') => $productDetails['cart_quantity'],
                                        $this->l('Price') => $productDetails['total_wt'],
                                        $this->l('Cart Total') => $cutomer_cart_details['cart_total'],
                                        $this->l('Added Date') => '',
                                        $this->l('Updated Date') => '',
                                    );
                                }
                            }
                        }
                    }
                    if (count($export_data)) {
                        return Tools::jsonEncode($export_data);
                    } else {
                        return Tools::jsonEncode($this->l('Abandon Cart: No User found with this email.'));
                    }
                }
            }
        }
    }
    
    /**
     * Function added by Anshul to get default FCM settings
     * Feature: Push Notification (Jan 2020)
     */
    protected function getDefaultSettingsFCM()
    {
        //FCM key update
        $setting = array(
            'enable_notify' => 0,
            'apiKey' => "",
            'authDomain' => "propane-fusion-156206.firebaseapp.com",
            'databaseURL' => "https://propane-fusion-156206.firebaseio.com",
            'projectId' => "",
            'storageBucket' => "propane-fusion-156206.appspot.com",
            'messagingSenderId' => "",
            'server_key' => "",
        );
        return $setting;
    }
    
    /*
     * function added by Anshul to send push request to FCM
     * to send notification to the subscribers
     * Feature: Push Notification (Jan 2020)
     */
    public function sendPushRequestToFCM($headers, $fields = array())
    {
        $payload = json_encode($fields);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        
        $result = json_decode(curl_exec($curl_session), true);
        return $result;
    }

    public function getContent()
    {
        if (Tools::isSubmit('ajax') && Tools::getValue('ajax')) {
            $this->doAjaxProcess();
        }

        $output = null;
        if (Tools::isSubmit('abd_configuration_form')) {
            $settings = Tools::getValue('velsof_abandoncart');
            if (!$settings || empty($settings)) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                $tmp = $this->getDefaultSettings();
                $settings['plugin_id'] = $tmp['plugin_id'];
                Configuration::updateValue('VELSOF_ABANDONEDCART', serialize($settings));
                $output .= $this->displayConfirmation($this->l('The settings have been updated.'));
            }
            
            /*
             * Start: Added by Anshul to validate & save the FCM setting
             * Feature: Push Notification (Jan 2020)
             */
            $settings1 = Tools::getValue('velsof_abandoncart_fcm');
            if (!$settings1 || empty($settings1)) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('KB_AB_PUSH_FCM_SERVER_SETTING', serialize($settings1));
            }
            /*
             * End: Added by Anshul to validate & save the FCM setting
             */
        } elseif ($cart_re_display_val = Tools::getValue('enable_cart_redisplay')) {
            if (Validate::isBool($cart_re_display_val) && Validate::isCleanHtml($cart_re_display_val)) {
                Configuration::updateValue('PS_CART_FOLLOWING', $cart_re_display_val);
                $output .= $this->displayConfirmation($this->l('Cart Re-Display has been enabled.'));
            } else {
                $output .= $this->displayError($this->l('Invalid Cart Re-Display Submission'));
            }
        }

        if (!Configuration::get('VELSOF_ABANDONEDCART') || Configuration::get('VELSOF_ABANDONEDCART') == '') {
            $settings = $this->getDefaultSettings();
        } else {
            $settings = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        }
        /*
         * Start: Added by Anshul to persist the FCM setting (Feature: Push Notification (Jan 2020))
         */
        if (!Configuration::get('KB_AB_PUSH_FCM_SERVER_SETTING') || Configuration::get('KB_AB_PUSH_FCM_SERVER_SETTING') == '') {
            $settings_fcm = $this->getDefaultSettingsFCM();
        } else {
            $settings_fcm = Tools::unSerialize(Configuration::get('KB_AB_PUSH_FCM_SERVER_SETTING'));
        }
        /*
         * End: Added by Anshul to persist the FCM setting
         */

        $this->shopping_settings = $settings;

        /* Start - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on page load when there are a lot of carts (There is no need for this function to be called here as it is already called thorugh CRON) */
//        $this->updateAbandonList(); //Added to update abandonded cart list on page load
        /* End - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on page load when there are a lot of carts (There is no need for this function to be called here as it is already called thorugh CRON) */
        //changes by tarun to fix the date filter issue
        $from = date('m/d/Y', strtotime('-90 days'));
        $to = date('m/d/Y');
        //changes over
        if (!is_writable($this->getTemplateDir())) {
            //Tools::chmodr(_PS_MODULE_DIR_ . 'abandonedcart/mails', 0755);
            if (!is_writable($this->getTemplateDir())) {
                $output .= $this->displayError(
                    $this->l('Please give read/write permission to ') . '"' . $this->getTemplateDir()
                    . '"' . $this->l(' directory.')
                );
            }
        }

        $cron_link = $this->context->link->getModuleLink('abandonedcart', 'cron');
        $dot_found = 0;
        $needle = 'index.php';
        $dot_found = strpos($cron_link, $needle);
        if ($dot_found !== false) {
            $ch = '&';
        } else {
            $ch = '?';
        }

        $custom_ssl_var = 0;

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $custom_ssl_var = 1;
        }

        if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
            $module_dir = _PS_BASE_URL_SSL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
            $url = _PS_BASE_URL_SSL_ . __PS_BASE_URI__;
        } else {
            $module_dir = _PS_BASE_URL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
            $url = _PS_BASE_URL_ . __PS_BASE_URI__;
        }

        $admin_token = Tools::getAdminTokenLite('AdminModules');
        /* Start - Code Modified by RS for handing the `cart_total` column in case the column is added through module update */
        $cart_total_column_added = 0;
        if (Configuration::get('VELSOF_ABD_CART_TOTAL_ADDED')) {
            $cart_total_column_added = Configuration::get('VELSOF_ABD_CART_TOTAL_ADDED');
        }
        if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
            $ps_base_url = _PS_BASE_URL_SSL_;
        } else {
            $ps_base_url = _PS_BASE_URL_;
        }
        if (_PS_VERSION_ < '1.6.0') {
            $lang_img_dir = _PS_IMG_DIR_ . 'l/';
        } else {
            $lang_img_dir = _PS_LANG_IMG_DIR_;
        }
        $this->smarty->assign(
            array(
                'cancel_action' => AdminController::$currentIndex.'&token='.$admin_token,
                'img_lang_dir' => $ps_base_url . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', $lang_img_dir),
                'action' => AdminController::$currentIndex . '&token='.$admin_token . '&configure=' . $this->name,
                'velsof_abandoncart' => $settings,
                'velsof_abandoncart_fcm' => $settings_fcm,
                'languages' => Language::getLanguages(true),
                'languages_js' => Tools::jsonEncode(Language::getLanguages(true)),
                'email_templates' => $this->getEmailTemplateList(),
                'dropdown_template_list' => $this->loadEmailTemplates(false),
                'dropdown_tran_template_list' => $this->loadEmailTemplates(),
                'incentive_list' => $this->getIncentiveList(),
                'email_types' => $this->getEmailTypeArray(),
                'default_email_type' => $this->getDefaultEmailType(),
                'discount_types' => $this->getDiscountTypeArray(),
                'default_discount_type' => $this->getDefaultDiscountType(),
                'incentive_statuses' => $this->getIncentiveStatuses(),
                'default_incentive_status' => $this->getDefaultIncentiveStatus(),
                'non_discount_email_value' => parent::NON_DISCOUNT_EMAIL,
                'default_language' => $this->context->language->id,
                'currency_format' => $this->context->currency->format,
                'currency_blank' => $this->context->currency->blank,
                'currency_sign' => $this->context->currency->sign,
                'cart_redisplay' => ((Configuration::get('PS_CART_FOLLOWING')) ? true : false),
                'start_date' => $from,
                'end_date' => $to,
                'path' => $url.str_replace(_PS_ROOT_DIR_.'/', '', _PS_MODULE_DIR_).$this->name.'/',
                'admin_path' => __PS_BASE_URI__ . basename(_PS_ADMIN_DIR_),
                'root_path' => $url.str_replace(_PS_ROOT_DIR_ . '/', '', ''),
                'abandon_list' => $this->getAbandonList(),
                'converted_carts' => $this->getConvertedList(),
                'token' => Tools::getAdminTokenLite('AdminModules'),
                'plugin_shop_url' => $this->getPluginShopUrl(),
                'front_cron_url' => $cron_link . $ch,
                'image_path' => $module_dir . 'abandonedcart/views/img/admin/',
                'secure_key' => Configuration::get('VELSOF_ABD_SECURE_KEY'),
                /*Start: Added by Anshul for popup reminder & push notification changes*/
                'cart_total_column_added' => $cart_total_column_added,
                'popup_templates' => $this->getPopUpTemplateList(),
                'dropdown_popup_templates' => $this->loadPopUpTemplates(false),
                'popup_reminder_incentive_list' => $this->getPopupIncentiveList(),
                'WebBrowser_reminder_incentive_list' => $this->getWebBrowserReminderList(),
                'cron_list' => $this->getCronList(),
                'link_admin_cart'=>$this->context->link->getAdminLink('AdminCarts'),
                'link_admin_customer'=>$this->context->link->getAdminLink('AdminCustomers'),
                'getclickpushdata' => $this->getClickPushData()
                /*End: Added by Anshul for popup reminder & push notification changes*/
            )
        );
        /* End - Code Modified by RS for handing the `cart_total` column in case the column is added through module update */

        $this->loadMedia();

        $output .= $this->display(__FILE__, 'views/templates/admin/abandonedcart.tpl');
        return $output;
    }
    
    /*
     * function added by Anshul to check if the
     * push notification is clicked or not
     * Feature: Push Notification (Jan 2020)
     */
    public function getClickPushData()
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'kb_ab_web_push_pushes';
        $select_data = Db::getInstance()->executeS($sql);
        if (isset($select_data) && !empty($select_data)) {
            foreach ($select_data as $key => &$data) {
                if ($data['is_clicked'] == 1) {
                    $data['is_clicked'] = $this->l('Yes');
                } else {
                    $data['is_clicked'] = $this->l('No');
                }
                $data['cart_link'] = $this->context->link->getAdminLink('AdminCarts') . '&id_cart=' . $data['id_cart'] . '&viewcart';
                $data['flag'] = 1;
            }
        } else {
            $select_data['flag'] = 0;
        }
        return $select_data;
    }

    private function doAjaxProcess()
    {
        $json = array();
        switch (Tools::getValue('method')) {
            case 'getnewemailtemplate':
                $json = $this->loadNewEmailTemplate();
                break;
            case 'saveemailtemplate':
                $json = $this->saveEmailTemplate();
                break;
            case 'rememailtemplate':
                $json = $this->remEmailTemplate(Tools::getValue('key_template'));
                break;
            case 'getemailtemplatetranslation':
                $json = $this->loadEmailTemplateTranslation(
                    Tools::getValue('id_template'),
                    Tools::getValue('id_lang')
                );
                break;
            case 'saveemailtemplatetranslation':
                $json = $this->updateEmailTemplateTranslation(Tools::getValue('email_template_translation'));
                break;
            case 'updatetemplatename':
                $json = $this->updateTemplateName(
                    Tools::getValue('id_template'),
                    Tools::getValue('changed_tml_name')
                );
                break;
            case 'gettemplatelist':
                $json = $this->getEmailTemplateList();
                break;
            case 'getincentivedetail':
                $json = $this->loadIncentivebyId(Tools::getValue('key_incentive'));
                break;
            case 'saveincentive':
                $json = $this->saveIncentive();
                break;
            case 'remincentive':
                $json = $this->remIncentive(Tools::getValue('key'));
                break;
            case 'getincentivelist':
                $json = $this->getIncentiveList();
                break;
            case 'changeincentivestatus':
                $json = $this->changeIncentiveStatus(Tools::getValue('incentive'));
                break;
            case 'getabandonlist':
                /* Start - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on page load when there are a lot of carts (There is no need for this function to be called here as it is already called thorugh CRON) */
                if (Tools::getIsset('refresh_list') && Tools::getValue('refresh_list')) {
                    $this->updateAbandonList();
                }
                /* End - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on page load when there are a lot of carts (There is no need for this function to be called here as it is already called thorugh CRON) */
                $json = $this->getAbandonList();
                break;
            case 'gettemplate':
                $json = $this->loadEmailTemplateTranslation(0, 0, Tools::getValue('id_template_content'));
                break;
            case 'getCouponDetail':
                $json = $this->getCustomerCouponDetail(Tools::getValue('id_customer'), Tools::getValue('email'));
                break;
            case 'getCustomerDetail':
                $json = $this->getCustomerDetail(Tools::getValue('id_customer'));
                break;
            case 'getCustomerCartDetail':
                $json = $this->getCustomerCartDetail(Tools::getValue('id_customer'), Tools::getValue('id_cart'));
                break;
            case 'sendreminder':
                $data = Tools::getValue('email_reminder');
                $data['subject'] = Tools::getValue('single_email_subject');
                $data['body'] = Tools::getValue('single_email_body');
                $data['cart_template'] = Tools::getValue('cart_template');
                if ($this->sendReminder($data, false) == 1) {
                    $json = array('status' => true, 'message' => $this->l('Reminder email sent successfully.'));
                } elseif ($this->sendReminder($data, false) == -1) {
                    $json = array(
                        'status' => -1,
                        'message' => $this->l('Unable to send email. Permission error on ') . $this->getTemplateDir()
                    );
                } elseif ($this->sendReminder($data, false) == -2) {
                    $json = array('status' => -2, 'message' => $this->l('The cart is empty, not able to send reminder email.'));
                } else {
                    $json = array('status' => false, 'message' => $this->l('Not able to send reminder email.'));
                }
                break;
            case 'senddiscountemail':
                $data = Tools::getValue('email_discount');
                $data['subject'] = Tools::getValue('single_email_subject');
                $data['body'] = Tools::getValue('single_email_body');
                $data['cart_template'] = Tools::getValue('cart_template');
                if ($this->sendDiscountEmail($data, false) == 1) {
                    $json = array('status' => true, 'message' => $this->l('Discount email sent successfully.'));
                } elseif ($this->sendDiscountEmail($data, false) == -1) {
                    $json = array(
                        'status' => -1,
                        'message' => $this->l('Unable to send email. Permission error on ') . $this->getTemplateDir()
                    );
                } elseif ($this->sendDiscountEmail($data, false) == -2) {
                    $json = array('status' => -2, 'message' => $this->l('The cart is empty, not able to send discount email.'));
                } else {
                    $json = array('status' => false, 'message' => $this->l('Not able to send discount email.'));
                }
                break;
            case 'deleteabandon':
                if ($this->deleteAbandonCart(Tools::getValue('id_abandon'))) {
                    $json = array(
                        'status' => true,
                        'message' => $this->l('Requested abandon cart deleted successfully.')
                    );
                } else {
                    $json = array(
                        'status' => false,
                        'message' => $this->l('Not able to delete requested abandon cart.')
                    );
                }
                break;
            case 'getconvertedlist':
                $json = $this->getConvertedList();
                break;
            case 'refreshtemplatedropwn':
                $json = array(
                    'templates' => $this->loadEmailTemplates(false),
                    'trans_template_discount' => $this->loadEmailTemplates(
                        true,
                        array('type' => parent::DISCOUNT_EMAIL)
                    ),
                    'trans_template_ndiscount' => $this->loadEmailTemplates(
                        true,
                        array('type' => parent::NON_DISCOUNT_EMAIL)
                    )
                );
                break;
            case 'getPieChartsData':
                $json = $this->getPieChartsData();
                break;
            case 'getChartData':
                $start_date = Tools::getValue('start');
                $end_date = Tools::getValue('end');
                $json = $this->graph($start_date, $end_date);
                break;
            case 'checkTemplateType':
                $template_id = Tools::getValue('template_id');
                $json = $this->checkTemplateType($template_id);
                break;
            case 'getdefaultlanguage':
                echo $this->context->language->id;
                break;
            /*
             * Start: Code added by Anshul for push notification & popup reminder enhancement
             */
            case 'savePopupTemplate':
                $json = $this->savePopupTemplate();
                break;
            case 'getpopuptemplatelist':
                $json = $this->getPopUpTemplateList();
                break;
            case 'rempopuptemplate':
                $json = $this->remPopupTemplate(Tools::getValue('key_template'));
                break;
            case 'refreshpopuptemplatedropwn':
                $json = array(
                    'templates' => $this->loadPopUpTemplates(false),
                    'trans_popup_template' => $this->loadPopUpTemplates(true)
                );
                break;
            case 'getpopuptemplatetranslation':
                $json = $this->loadPopupTemplateTranslation(
                    Tools::getValue('id_template'),
                    Tools::getValue('id_lang')
                );
                break;
            case 'getnewpopuptemplate':
                $json = $this->loadPopupTemplateTranslation(
                    0,
                    0
                );
                break;
            case 'savepopuptemplatetranslation':
                $json = $this->updatePopupTemplateTranslation(Tools::getValue('popup_template_translation'));
                break;
            case 'getpopupreminderincentivedetail':
                $json = $this->loadPopupReminderbyId(Tools::getValue('key_incentive'));
                break;
            case 'GetWebBrowserReminderDetail':
                $json = $this->loadWebBrowserReminderbyId(Tools::getValue('key_reminder'));
                break;
            case 'SaveWebBrowserReminder':
                $json = $this->saveWebBrowserReminder();
                break;
            case 'GetWebBrowserList':
                $json = $this->getWebBrowserList();
                break;
            case 'remwebbrowserincentive':
                $json = $this->remWebBrowserTemplate(Tools::getValue('key'));
                break;
            case 'savepopupreminder':
                $json = $this->savePopupReminderIncentive();
                break;
            case 'getpopupincentivelist':
                $json = $this->getPopupIncentiveList();
                break;
            case 'rempopupincentive':
                $json = $this->remPopupIncentive(Tools::getValue('key'));
                break;
            case 'getcrondetail':
                $json = $this->getCronDetail(Tools::getValue('id_cron'));
                break;
            case 'getcronlist':
                $json = $this->getCronlist();
                break;
            case 'changepopupincentivestatus':
                $json = $this->changePopupIncentiveStatus(Tools::getValue('incentive'));
                break;
            case 'changewebbrowserstatus':
                $json = $this->changeWebBrowserStatus(Tools::getValue('incentive'));
                break;
            /*
             * End: Code added by Anshul for push notification & popup reminder enhancement
             */
        }

        header('Content-Type: application/json', true);
        echo Tools::jsonEncode($json);
        die;
    }
    
    /*
     * function add by Anshul Mittal to load the JS and CSS files
     * Feature: Push Notification (Jan 2020)
     */
    protected function kbSetMedia()
    {
        /* JS files */
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase-app.js');
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase-storage.js');
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase-auth.js');
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase-database.js');
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase-messaging.js');
        $this->context->controller->addJS($this->_path . 'views/js/firebase/firebase.js');
        $this->context->controller->addJS($this->_path . 'views/js/service_worker_registeration_template.js');
    }

    public function hookDisplayHeader()
    {
        if (Configuration::get('VELSOF_ABANDONEDCART')) {
            $abd_settings = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
            if (isset($abd_settings['enable']) && $abd_settings['enable'] == 1) {
                $this->context->controller->addJs($this->_path . 'views/js/popup_front.js');
                $this->context->controller->addJQueryPlugin('fancybox');
                $ajax_path = __PS_BASE_URI__ . 'index.php?fc=module&module=abandonedcart&controller=cron';
                $this->context->smarty->assign('ajax_path', $ajax_path);
                $this->context->controller->addJs($this->_path . 'views/js/abandonedcart_front.js');
                
                /* Start: Added By Anshul for assigning the JS and FCM setting (Feature: Push Notification (Jan 2020)) */
                $settings_fcm = Tools::unSerialize(Configuration::get('KB_AB_PUSH_FCM_SERVER_SETTING'));
                if (isset($settings_fcm['enable_notify']) && $settings_fcm['enable_notify'] == 1) {
//                    $this->kbSetMedia();
                    $this->context->smarty->assign(
                        array(
                            'settings_fcm' => Tools::jsonEncode($settings_fcm),
                            'kbsrc' => $this->getModuleDirUrl().$this->name,
                            'id_lang' => Context::getContext()->language->id,
                            'dashboard_worker' => $this->getModuleDirUrl() . $this->name . '/views/js/worker_dashboard.js',
                            'kb_service_worker_front_url' => $this->context->link->getModuleLink($this->name, 'serviceworker', array('action' => 'registerServiceWorker'), (bool) Configuration::get('PS_SSL_ENABLED')),
                        )
                    );
                    return $this->display(__FILE__, 'views/templates/hook/service_worker_registration.tpl');
                }
                /* End: Added By Anshul for assigning the JS and FCM setting (Feature: Push Notification (Jan 2020))*/
                return $this->display(__FILE__, 'views/templates/front/abandonedcart_front.tpl');
            }
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
    
    /*
     * Function Added by Anshul to get the URL of the store,
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
     * Function Added by Anshul to generate the coupon code
     * for popup reminder
     * Feature: Popup Reminder (Jan 2020)
     */
    public function generateCoupon($value, &$template, $cart, $customer_info)
    {
        if ($value['discount_type'] == parent::DISCOUNT_FIXED) {
            $is_used_partial = 1;
            $fixed_reduction = $value['discount_value'];
            $percent_reduction = 0;
        } else {
            $is_used_partial = 0;
            $fixed_reduction = 0;
            $percent_reduction = $value['discount_value'];
        }

        if ($value['min_cart_value'] <= 0 || $value['min_cart_value'] == '') {
            $value['min_cart_value'] = 0;
        }
        if (isset($customer_info->email) && $customer_info->email) {
            $email = $customer_info->email;
        } else {
            $email = 'noemail';
        }
        $rule_desc = Tools::htmlentitiesUTF8('ABD[' . $email . ']');
        $coupon_code = $this->generateCouponCode();
        $coupon_expiry_date = date('Y-m-d 23:59:59', strtotime('+' . $value['coupon_validity'] . ' days'));
        $sql = "SELECT ccr.id_cart_rule "
                . "FROM " . _DB_PREFIX_ . "cart_cart_rule ccr "
                . "INNER JOIN " . _DB_PREFIX_ . "kb_ab_cart_cart_rule pcr "
                . "ON ccr.id_cart_rule = pcr.id_cart_rule "
                . "WHERE ccr.id_cart = '" . (int) $this->context->cart->id . "'";
        $res = Db::getInstance()->executeS($sql);
        foreach ($res as $cart_rule_id) {
            $this->context->cart->removeCartRule((int) $cart_rule_id['id_cart_rule']);
        }
        $sql = 'delete cr, ccr from '._DB_PREFIX_.'cart_rule cr Inner join '._DB_PREFIX_.'kb_ab_cart_cart_rule ccr ON cr.id_cart_rule = ccr.id_cart_rule where ccr.id_cart = '.(int) $this->context->cart->id;
        Db::getInstance()->execute($sql);
        //insert coupon details// id_customer = ' . (int) $this->context->customer->id . ',
        $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule  SET
                date_from = "' . pSQL(date('Y-m-d H:i:s', time())) . '",
                date_to = "' . pSQL($coupon_expiry_date) . '",
                description = "' . pSQL($rule_desc) . '",
                quantity = 1, quantity_per_user = 1, priority = 1, partial_use = ' . (int) $is_used_partial . ',
                code = "' . pSQL($coupon_code) . '", minimum_amount = ' . (float) $value['min_cart_value']
                . ', minimum_amount_tax = 0,
                minimum_amount_currency = ' . (int) $cart->id_currency . ', minimum_amount_shipping = 0,
                country_restriction = 0, carrier_restriction = 0, group_restriction = 0, cart_rule_restriction = 0,
                product_restriction = 0, shop_restriction = 1,
                free_shipping = ' . (int) $value['has_free_shipping'] . ',
                reduction_percent = ' . (float) $percent_reduction . ', reduction_amount = '
                . (float) $fixed_reduction . ',
                reduction_tax = 1, reduction_currency = ' . (int) $cart->id_currency . ',
                reduction_product = 0, gift_product = 0, gift_product_attribute = 0,
                highlight = 0, active = 1,
                date_add = "' . pSQL(date('Y-m-d H:i:s', time()))
                . '", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"';

        Db::getInstance()->execute($sql);


        $cart_rule_id = Db::getInstance()->Insert_ID();
        
        //map cart rule with cart id
        Db::getInstance()->execute(
            'INSERT INTO ' . _DB_PREFIX_ . 'kb_ab_cart_cart_rule
                set id_cart_rule = ' . (int) $cart_rule_id
                . ', id_cart = ' . (int) $this->context->cart->id . ', id_reminder = '.(int)$value['id_incentive']
        );

        Db::getInstance()->execute(
            'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_shop
                set id_cart_rule = ' . (int) $cart_rule_id
                . ', id_shop = ' . (int) $customer_info->id_shop
        );

        $languages = Language::getLanguages(true);
        foreach ($languages as $lang) {
            Db::getInstance()->execute('INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_lang
                        set id_cart_rule = ' . (int) $cart_rule_id . ', id_lang = ' . (int) $lang['id_lang'] . ',
                        name = "' . pSQL($rule_desc) . '"');
        }
        Configuration::updateGlobalValue('PS_CART_RULE_FEATURE_ACTIVE', '1');

        $template['body'] = str_replace("{discount_code}", $coupon_code, $template['body']);
        $template['body'] = str_replace("{total_amount}", Tools::displayPrice($value['min_cart_value']), $template['body']);
        if ($value['discount_type'] == 0) {
            $template['body'] = str_replace("{reduction}", '%', $template['body']);
            $template['body'] = str_replace("{discount_value}", number_format($value['discount_value'], 2), $template['body']);
        } elseif ($value['discount_type'] == 1) {
            $template['body'] = str_replace("{reduction}", '', $template['body']);
            $template['body'] = str_replace("{discount_value}", Tools::displayPrice($value['discount_value']), $template['body']);
        }
        $template['body'] = str_replace("{discount_from}", $value['date_from'], $template['body']);
        $template['body'] = str_replace("{discount_to}", $value['date_to'], $template['body']);
    }
    
    /*
     * Function Added by Anshul to filterout the popup
     * reminders to apply on the abandoned cart
     * Feature: Popup Reminder (Jan 2020)
     */
    public function getPopupIncentiveToApply($id_cart)
    {
        //get all reminders
        $query = 'select inc.*, em.* from ' . _DB_PREFIX_ . self::POPUP_REMINDER_TABLE_NAME . ' as inc 
                INNER JOIN ' . _DB_PREFIX_ . self::POPUP_TEMPLATE_TABLE_NAME . ' as em '
                . 'on (inc.id_template = em.id_template) WHERE inc.status = 1 '
                . 'ORDER BY inc.priority DESC';
        $reminders = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        $reminder_to_apply = array();
        $reminder_to_apply_show = array();
        $final_reminder_to_apply = array();
        $finalize = array();
        //apply the reminder if not shown earlier, comes in the defined time interval & ready to show again
        foreach ($reminders as $reminder) {
            $query = 'SELECT * FROM '._DB_PREFIX_.'kb_ab_popup_reminder_track WHERE id_cart = '.(int)$id_cart .' AND id_reminder = '.(int)$reminder['id_incentive'];
            $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
            if (!(time() >= strtotime($reminder['date_from']) && time() <= strtotime($reminder['date_to']))) {
                continue;
            }
            //changes by tarun to fix the display after time issue
            if ($data['last_show'] == null || $data['next_show'] == null) {
                $reminder_to_apply[] = $reminder;
            } elseif ($data['last_show'] != null && (strtotime($data['next_show']) >= time())) {
                $nInterval_next = strtotime($data['next_show']) - time();
                $nInterval_next = (int)$nInterval_next/60;
                $nInterval_final = number_format($nInterval_next);
                if ($nInterval_final > 59) {
                    $hours = floor($nInterval_final / 60);
                    $minutes = ($nInterval_final % 60);
                    $reminder['frequency_hour'] = $hours;
                    $reminder['frequency_minutes'] = $minutes;
                } else {
                    $reminder['frequency_hour'] = 0;
                    $reminder['frequency_minutes'] = $nInterval_final;
                }
                $reminder_to_apply[] = $reminder;
            }
        }
        //changes over
        //if more than one reminder to apply when the pop up is not shown yet then find with minimum time
        if (!empty($reminder_to_apply) && count($reminder_to_apply) > 0) {
            if (count($reminder_to_apply) > 1) {
                $firstmin = ($reminder_to_apply[0]['frequency_hour'] * 60 * 60) + ($reminder_to_apply[0]['frequency_minutes'] * 60);
                $final_reminder_to_apply[] = $reminder_to_apply[0];
                foreach ($reminder_to_apply as $key => $finalreminder) {
                    if ($key == 0) {
                        continue;
                    }
                    $min = ($finalreminder['frequency_hour'] * 60 * 60) + ($finalreminder['frequency_minutes'] * 60);
                    if ($min < $firstmin) {
                        unset($final_reminder_to_apply);
                        $firstmin = $min;
                        $final_reminder_to_apply[] = $finalreminder;
                    } elseif ($min == $firstmin) { //if more than one same minimum time
                        $final_reminder_to_apply[] = $finalreminder;
                    }
                }
                //if there are more than one reminder with same time then sort by priority
                if (count($final_reminder_to_apply) > 1) {
                    $minprior = $final_reminder_to_apply[0]['priority'];
                    $finalize[] = $final_reminder_to_apply[0];
                    foreach ($final_reminder_to_apply as $key => $finalreminderpriority) {
                        if ($key == 0) {
                            continue;
                        }
                        if ($finalreminderpriority['priority'] < $minprior) {
                            unset($finalize);
                            $minprior = $finalreminderpriority['priority'];
                            $finalize[] = $finalreminderpriority;
                        } elseif ($finalreminderpriority['priority'] == $minprior) {
                            $finalize[] = $finalreminderpriority;
                        }
                    }
                    if (count($finalize) > 1) {
                        return $finalize[0];
                    } else {
                        return $finalize;
                    }
                } else {
                    return $final_reminder_to_apply;
                }
            } else {
                return $reminder_to_apply;
            }
        } elseif (!empty($reminder_to_apply_show) && count($reminder_to_apply_show) > 0) { //if popup already showed then sort on the basis of priority only
            if (count($reminder_to_apply_show) > 1) {
                $minprior = $reminder_to_apply_show[0]['priority'];
                $finalize[] = $reminder_to_apply_show[0];
                foreach ($reminder_to_apply_show as $key => $finalreminderpriority) {
                    if ($key == 0) {
                        continue;
                    }
                    if ($finalreminderpriority['priority'] < $minprior) {
                        unset($finalize);
                        $minprior = $finalreminderpriority['priority'];
                        $finalize[] = $finalreminderpriority;
                    } elseif ($finalreminderpriority['priority'] == $minprior) {
                        $finalize[] = $finalreminderpriority;
                    }
                }
                if (count($finalize) > 1) {
                    return $finalize[0];
                } else {
                    return $finalize;
                }
            } else {
                return $reminder_to_apply_show;
            }
        }
    }

    /*
     * Function Added by Anshul to show the popup
     * reminders when creating an abandoned cart
     * Feature: Popup Reminder (Jan 2020)
     */
    public function hookDisplayTop()
    {
        if (Configuration::get('VELSOF_ABANDONEDCART')) {
            $abd_settings = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
            if (isset($abd_settings['enable']) && $abd_settings['enable'] == 1) {
                if ($this->context->cart->nbProducts() > 0) {
                    $id_cart = $this->context->cart->id;
                    $cart = new Cart((int) $id_cart);
                    $cart_total = $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS);
                    $id_lang = $this->context->language->id;
                    //get reminders to apply it would be only one at a time
                    $data = $this->getPopupIncentiveToApply($id_cart);
                    if (isset($data)) {
                        $popup_data = array();
                        $template = array();
                        foreach ($data as $key => $value) {
                            //check if minimum cart value is as defined or not
                            if ($cart_total >= $value['min_cart_value_for_popup'] && $value['status'] == 1) {
                                $template = $this->loadPopupTemplateTranslation($value['id_template'], $id_lang);
                                $template['body'] = str_replace("{firstname}", $this->context->customer->firstname, $template['body']);
                                $template['body'] = str_replace("{lastname}", $this->context->customer->lastname, $template['body']);
                                $template['body'] = str_replace("{email}", $this->context->customer->email, $template['body']);
                                $custom_ssl_var = 0;

                                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                                    $custom_ssl_var = 1;
                                }

                                if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
                                    $module_dir = _PS_BASE_URL_SSL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
                                } else {
                                    $module_dir = _PS_BASE_URL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
                                }
                                $icon_src = $module_dir . 'abandonedcart/views/img/front/gift.png';
                                $template['body'] = str_replace("{icon_src}", $icon_src, $template['body']);
                                $cart = new Cart((int) $this->context->cart->id);
                                $customer_info = new Customer((int) $this->context->customer->id);

                                $coupon_code = '';
                                $show = true;
                                //if discount type of percentage or fixed
                                if ($value['discount_type'] == 0 || $value['discount_type'] == 1) {
                                    //check if any cart rule is mapped or not with current cart id
                                    $sql = 'SELECT id_cart_rule FROM ' . _DB_PREFIX_ . 'kb_ab_cart_cart_rule ' .
                                            ' WHERE id_cart = ' . (int) $this->context->cart->id .' AND id_reminder = '.(int) $value['id_incentive'];
                                    $id_cart_rule = Db::getInstance()->getValue($sql);
                                    if ((!isset($id_cart_rule) && $id_cart_rule == "") || !$id_cart_rule) {
                                        // generate new coupon if not created for current cart
                                        $this->generateCoupon($value, $template, $cart, $customer_info);
                                    } else {
                                        //if already mapped then check if applied or not
                                        $sql = 'SELECT id_cart_rule FROM ' . _DB_PREFIX_ . 'cart_cart_rule ' .
                                                ' WHERE id_cart = ' . (int) $this->context->cart->id . ' AND id_cart_rule = ' . (int) $id_cart_rule;
                                        $id_cart_rule_new = Db::getInstance()->getValue($sql);
                                        //if not applied
                                        if ((!isset($id_cart_rule_new) && $id_cart_rule_new == "") || !$id_cart_rule_new) {
                                            $sql = 'SELECT date_from, date_to, code, reduction_percent, reduction_amount FROM ' . _DB_PREFIX_ . 'cart_rule WHERE id_cart_rule = ' . (int) $id_cart_rule;
                                            $coupon_data = Db::getInstance()->getRow($sql);
                                            //check if still valid then assign the same code
                                            if (time() >= strtotime($coupon_data['date_from']) && time() <= strtotime($coupon_data['date_to'])) {
                                                $coupon_code = $coupon_data['code'];
                                                $template['body'] = str_replace("{discount_code}", $coupon_code, $template['body']);
                                                $template['body'] = str_replace("{total_amount}", Tools::displayPrice($value['min_cart_value']), $template['body']);
                                                if ($value['discount_type'] == 0) {
                                                    $template['body'] = str_replace("{reduction}", '%', $template['body']);
                                                    $template['body'] = str_replace("{discount_value}", number_format($coupon_data['reduction_percent'], 2), $template['body']);
                                                } elseif ($value['discount_type'] == 1) {
                                                    $template['body'] = str_replace("{reduction}", '', $template['body']);
                                                    $template['body'] = str_replace("{discount_value}", Tools::displayPrice($coupon_data['reduction_amount']), $template['body']);
                                                }
                                                $template['body'] = str_replace("{discount_from}", $coupon_data['date_from'], $template['body']);
                                                $template['body'] = str_replace("{discount_to}", $coupon_data['date_to'], $template['body']);
                                            } else {
                                                //if expired then generate the coupon again
                                                $this->generateCoupon($value, $template, $cart, $customer_info);
                                            }
                                        } else {
                                            //if already added to cart then do not show
                                            $show = false;
                                        }
                                    }
                                } else {
                                    //if no discount selected then assign blank values in case these placeholders are present
                                    $template['body'] = str_replace("{discount_code}", $coupon_code, $template['body']);
                                    $template['body'] = str_replace("{total_amount}", '', $template['body']);
                                    $template['body'] = str_replace("{reduction}", '', $template['body']);
                                    $template['body'] = str_replace("{discount_value}", '', $template['body']);
                                    $template['body'] = str_replace("{discount_from}", '', $template['body']);
                                    $template['body'] = str_replace("{discount_to}", '', $template['body']);
                                }

                                // cart template
                                $cart_data = array();
                                $cart_data['id_cart'] = $id_cart;
                                $cart_data['id_template_content'] = $template['id_template_content'];
                                $cart_data['popup_front'] = 1;
                                $cart_data['cart_template'] = $template['cart_template'];
                                $cart_data['id_customer'] = $this->context->customer->id;
                                $cart_data['customer_secure_key'] = $this->context->customer->secure_key;
                                $cart_data['customer_email'] = $this->context->customer->email;
                                $cart_data['discount_code'] = $coupon_code;

                                $qry = 'Select id_abandon from ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME . ' where id_cart=' . (int) $id_cart;
                                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($qry);

                                if (!empty($result)) {
                                    $cart_data['id_abandon'] = $result[0]['id_abandon'];
                                } else {
                                    $cart_data['id_abandon'] = '';
                                }
                                $content = $this->getCartHtml($cart_data, true);
                                $template['body'] = str_replace("{cart_content}", $content, $template['body']);
                                $popup_data = $value;
                            }
                            break;
                        }
                        if (!empty($popup_data) && $show) {
                            $t = 'Select * from ' . _DB_PREFIX_ . 'cart
                                    where id_cart = ' . (int) $id_cart;
                            $add_cart_time = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($t);
                            //get actual delay time in sec after which the popup will show
                            $min = ($popup_data['frequency_hour'] * 60 * 60) + ($popup_data['frequency_minutes'] * 60);
                            $this->context->smarty->assign('current_time', time());
                            $this->context->smarty->assign('diff_in_sec', $min);
                            //get cart add time to compare it later with current time
                            $this->context->smarty->assign('cart_added_time', strtotime($add_cart_time[0]['date_add']));
                            $this->context->smarty->assign('kb_id_cart', $id_cart);
                            $this->context->smarty->assign('kb_id_reminder', $popup_data['id_incentive']);
                            $this->context->smarty->assign('popup_data', $popup_data);
                            $this->context->smarty->assign('popup_template', $template);
                            return $this->display(__FILE__, 'views/templates/front/popup_front.tpl');
                        }
                    }
                }
            }
        }
    }

    /**
     *
     * @param array $cart_data
     * @param bool $popup This argument added by Anshul to detect if the cart HTML is fetched for popup reminder or not (Feature: Popup Reminder (Jan 2020))
     * @return string
     */
    public function getCartHtml($cart_data, $popup = false)
    {
        $cart_html = '';
        $iso_code = '';
        $cart = new Cart((int) $cart_data['id_cart']);
        if (isset($cart_data['id_template_content'])) {
            $id_template_content = $cart_data['id_template_content'];
            $lang_query = 'Select iso_code from '._DB_PREFIX_.'velsof_abd_email_templates_content where id_template_content ='.(int)$id_template_content;
            $iso_code = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($lang_query, false);
        }

        $lang = new Language($cart->id_lang);
        if (Tools::isEmpty($iso_code)) {
            $iso_code = $lang->iso_code;
        }

//$iso_code = $lang->getIsoById((int)$cart_data['id_lang']);
//$iso_code = $lang->getIsoById((int)$cart_data['id_lang']);
        if ($cart->nbProducts()) {
            if ($cart_data['cart_template'] == 1) {
                if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                    $seperator_path = _PS_BASE_URL_SSL_ . __PS_BASE_URI__
                        . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_)
                        . $this->name . '/views/img/seperator.jpg';
                } else {
                    $seperator_path = _PS_BASE_URL_ . __PS_BASE_URI__
                        . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_)
                        . $this->name . '/views/img/seperator.jpg';
                }
                $cart_html = '<table class="table table-recap" style="width:100%; border-collapse:collapse">
                    <tbody><tr><td colspan="2"><img alt="Seperator" src="' . $seperator_path . '" width="100%"
                    style="background:#0c528b;color:#ffffff;font-size:9px;max-height:50px"></td></tr>';

                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }
                    $row = '';
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $row .= '<tr>';
                    $row .= '<td align="center" width="160" valign="baseline">';
                    $row .= '<a href="' . $action_url . '" target="_blank">';
                    
                    if ($popup) {
                        $row .= '<img alt="Product Image" src="' . $img_path . '"
                       style="background:#0c528b;color:#ffffff;font-size:9px;max-height:140px;" class="CToWUd">';
                    } else {
                        $row .= '<img alt="Product Image" src="' . $img_path . '"
                       style="background:#0c528b;color:#ffffff;font-size:9px;max-height:200px;" class="CToWUd">';
                    }
//                    $row .= '<img alt="Product Image" src="' . $img_path . '"
//                        style="background:#0c528b;color:#ffffff;font-size:9px;max-height:200px;" class="CToWUd">';
                    $row .= '</a></td>';
                    $row .= '<td align="center" width="160" valign="middle">';
                    $row .= '<a
                        style="font-family:Helvetica,Arial,sans-serif;
                        font-weight:800;font-size:18px;line-height:20px;color:#333333"
                        href="' . $action_url . '" target="_blank">';
                    $row .= $products['name'] . '</a><br>' . $products['attributes'] . '<br></td></tr>';
                    $row .= '<tr><td colspan="2">';
                    $row .= '<img alt="Seperator" src="' . $seperator_path . '" width="100%" '
                            . 'style="background:#0c528b;color:#ffffff;font-size:9px;max-height:50px">';
                    $row .= '</td></tr>';
                    $cart_html .= $row;
                    $sno++;
                }

                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= '</tbody></table>';
                /*Start: Modified by Anshul to correct the CSS for popup reminder (Feature: Popup Reminder (Jan 2020))*/
                if ($popup) {
                    $cart_html .= '<br><p style="text-align: center;margin-top: -42px;"><a  href="' . $direct_checkout_url . '" target="_blank"';
                } else {
                    $cart_html .= '<br><p style="float: right;"><a  href="' . $direct_checkout_url . '" target="_blank"';
                }
                /*End: Modified by Anshul to correct the CSS for popup reminder (Feature: Popup Reminder (Jan 2020))*/
                $cart_html .= ' style="font-family: sans-serif; color: #FFFFFF !important; font-size: 15px; ';
                $cart_html .= 'padding: 8px 10px; border-radius: 2px; -webkit-border-radius: 2px; border-radius: 2px;';
                $cart_html .= 'background: #f78828; text-decoration: none; cursor: pointer;">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a>';
            } elseif ($cart_data['cart_template'] == 2) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $cart_html .= "<hr style='background-color: black;height: 2px;'>
                    <div><ul style='list-style-type: none;padding:0px;margin:0px auto;width:80%;'>";
                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }

                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }

                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);

                    $cart_html .= "<li style='float:left;margin:5px;'>
                        <div style='border:1px solid rgba(0, 0, 0, 0.45);'>
                        <a href='" . $action_url . "'><img style='width:200px' src='" . $img_path . "'></a></div>";
                    $cart_html .= "<div style='color: rgba(0, 0, 0, 0.73);text-align: center;margin-top: 2px;";
                    $cart_html .= "font-size: 16px;padding: 5px;font-weight: 700;font-family: sans-serif;'>";
                    $cart_html .= '<span style="display:inline-block;'
                            . 'max-width:184px;text-overflow: ellipsis;white-space:nowrap;overflow:hidden">'
                        . $products['name'] . '</span></div>';
                    $cart_html .= '<div style="font-size: 14px;text-align: center;margin-top: 6px;"><span>'
                        . $products['attributes'] . '</span></div></li>';
                }
                $cart_html .= "</ul></div><div style='clear:both'></div>";
                $cart_html .= "<hr style='background-color: black;height: 2px;'>";

                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                /* Start: Modified by Anshul to correct the CSS for popup reminder (Feature: Popup Reminder (Jan 2020))*/
                if ($popup) {
                    $cart_html .= '<div style=""><a href="'
                            . $direct_checkout_url . '" target="_blank" style="font-weight: bold;font-family: sans-serif;';
                } else {
                    $cart_html .= '<div style="float:right;margin:20px auto;"><a href="'
                            . $direct_checkout_url . '" target="_blank" style="font-weight: bold;font-family: sans-serif;';
                }
                /* End: Modified by Anshul to correct the CSS for popup reminder (Feature: Popup Reminder (Jan 2020))*/
                $cart_html .= 'color: #FFFFFF !important;font-size: 20px;padding: 10px;-webkit-border-radius: 2px;
                    background: #f78828;text-decoration: none;cursor: pointer;">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 3) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= "<div style='width:200px;margin:20px auto;'><a href='"
                    . $direct_checkout_url . "' target='_blank' style='font-weight: bold;
                        font-family: sans-serif;color: #FFFFFF !important;
                        font-size: 20px;padding: 10px;border-radius: 2px;-webkit-border-radius: 2px;
                        background: rgb(95, 158, 160);text-decoration: none;cursor: pointer;'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
                $cart_html .= '<hr><div style="text-align: center;font-size: 20px;color: cadetblue;"><span>'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'YOUR BASKET',
                        'abandonedcart',
                        $iso_code
                    ) . '</span></div>
                    <hr><div style=""><ul style="list-style-type: none;padding:0px;margin:0px auto;">';

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }

                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }

                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }

                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<li style='margin:5px;text-align:center;'>";
                    $cart_html .= "<div style='display:inline-block;float:left;width:30%;'>
                        <a href='" . $action_url . "'>
                        <img  style='border:1px solid rgba(95, 158, 160, 0.66);'
                        src='" . $img_path . "'></a></div>";
                    $cart_html .= '<div style="display:inline-block;margin:10% auto;'
                        . 'width:70%;font-weight: bold;font-size:18px;"><span>'
                        . $products['name'] . '</span><br><div style="font-weight:100;font-size:14px;'
                        . 'text-align:center"><span>'
                        . $products['attributes'] . '</span></div></div>';
                    $cart_html .= "<div style='clear:both'></div>";
                }
                $cart_html .= '<hr><div style="width:200px;margin:20px auto;">
                    <a href="' . $direct_checkout_url . '" target="_blank"
                    style="font-weight: bold;font-family: sans-serif;color: #FFFFFF
                    !important;font-size: 20px;padding: 10px;border-radius: 2px;-webkit-border-radius: 2px;
                    background: rgb(95, 158, 160);text-decoration: none;cursor: pointer;">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 4) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= "<table style='width:100%;border-collapse:collapse'><thead><tr>";
                $cart_html .= '<td style="width:30%;font-family: sans-serif;
                    background: rgb(69, 162, 69);text-align: center;
                    padding: 6px;font-size: 16px;font-weight: bold;color: white;border: 1px solid white">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'IMAGE',
                        'abandonedcart',
                        $iso_code
                    ) . '</td>';
                $cart_html .= '<td style="width:30%;font-family: sans-serif;
                    background: rgb(69, 162, 69);text-align: center;
                    padding: 6px;font-size: 16px;font-weight: bold;color: white;border: 1px solid white">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'DESCRIPTION',
                        'abandonedcart',
                        $iso_code
                    ) . '</td>';
                $cart_html .= '<td style="width:20%;font-family: sans-serif;
                    background: rgb(69, 162, 69);text-align: center;
                    padding: 6px;font-size: 16px;font-weight: bold;color: white;border: 1px solid white">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'QUANTITY',
                        'abandonedcart',
                        $iso_code
                    ) . '</td>';
                $cart_html .= '<td style="width:20%;font-family: sans-serif;
                    background: rgb(69, 162, 69);text-align: center;
                    padding: 6px;font-size: 16px;font-weight: bold;color: white;border: 1px solid white">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'PRICE',
                        'abandonedcart',
                        $iso_code
                    ). '</td></tr>';
                $cart_html .= '</thead>';

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }

                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }

                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }

                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://'.$link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://'.$link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<tr><td style='width:30%;text-align: center;'><a href='"
                        . $action_url . "'><div style='width:100%'><img src='".$img_path."' style='width:100%'>
                        </div></a></td>";
                    $cart_html .= '<td style="width:30%;text-align: center;"><div style="text-align: center;">
                        <span style="font-weight: bolder;text-transform: capitalize;font-size:16px">'
                        . $products['name'] . '</span><br>';
                    $cart_html .= "<span style='text-transform: capitalize;font-size: 12px;'>"
                        . $products['attributes'] . '</span>';
                    $cart_html .= '</div></td><td style="width:20%;text-align: center;font-weight:bold;">'
                        . $products['cart_quantity'] . '</td>';
                    $cart_html .= '<td style="width:20%;text-align: center;font-weight: 600;font-size: 16px;">'
                            . Tools::displayPrice($products['cart_quantity'] * $products['price']) . '</td></tr>';
                }

                $cart_html .= "</table><div style='float:right;text-align: center;padding: 10px;
                    background: rgba(0, 128, 0, 0.73);
                    color: white;font-weight: bold;font-size: 16px;'>
                    <a style='text-decoration:none;color:white' href='"
                    . $direct_checkout_url . "'><span>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</span></a></div>';
            } elseif ($cart_data['cart_template'] == 5) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= "<div style='text-align:left;padding:10px;background: red;
                        background: -webkit-linear-gradient(orange, #FF5722);
                        background: -o-linear-gradient(orange, #FF5722);
                        background: -moz-linear-gradient(orange, #FF5722);
                        background: linear-gradient(orange, #FF5722);'>
                        <span style='font-size:24px;font-weight:bold;color:white;'>"
                        . $this->getModuleTranslationByLanguage(
                            'abandonedcart',
                            'Items In Your Cart...',
                            'abandonedcart',
                            $iso_code
                        ) . "</span><span  style='float: right;
                        font-size: 15px;font-weight: bold;color: white;vertical-align: middle;line-height: 22px;'>
                        <a href='"
                        . $direct_checkout_url . "' style='color:white;text-decoration:underline;'>"
                        . $this->getModuleTranslationByLanguage(
                            'abandonedcart',
                            'View Cart',
                            'abandonedcart',
                            $iso_code
                        ) . '</a></span></div>';

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }

                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }

                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<div style='overflow:auto;border: 1px solid rgba(255, 140, 10, 0.28);'>";
                    $cart_html .= "<div style='width: 20%;padding: 2%;text-align: center;float:left;'>
                        <a href='" . $action_url . "'>
                        <img style='border: 1px solid rgba(255, 140, 10, 0.28);width:100%;
                        ' src='" . $img_path . "'></a></div>";
                    $cart_html .= "<div style='padding: 2%;float:left;width:66%;'>
                        <div style='font-weight: bold;padding: 5px;
                        font-size: 16px'>" . $products['name'] . '</div>';
                    $cart_html .= "<div style='color: rgba(0, 0, 0, 0.79);height:30px;
                        display: -webkit-box;-webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;'>"
                        . trim($products['description_short'], '<p></p>') . '</div>';
                    $cart_html .= "<div style='margin-top:2%;font-size: 14px;font-weight: bold;'>".$this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Qunatity',
                        'abandonedcart',
                        $iso_code
                    ).": "
                    . $products['cart_quantity'] . ' | '.$this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Price',
                        'abandonedcart',
                        $iso_code
                    ).': '
                    . Tools::displayPrice($products['cart_quantity'] * $products['price']).'</div>'
                    . '</div></div>';
                }
                $cart_html .= "<div href='" . $direct_checkout_url . "' style='float:right;
                    cursor:pointer;font-weight: bold;margin-top: 1%;
                    text-align: center;margin: 10px auto;
                    font-family: Arial;color: #ffffff;font-size: 20px;padding: 10px 10px 10px 10px;
                    text-decoration: none;background:rgba(255, 141, 0, 0.97);'>
                    <span><a style='text-decoration:none;color:white' href='" . $direct_checkout_url . "'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></span></div>';
            } elseif ($cart_data['cart_template'] == 6) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $n = 'Open Sans';
                $cart_html .= "<div style='position: relative;padding: 0;"
                    . "border-bottom: 3px solid #e9e9e9;background: #f6f6f6;margin: 0;font: 600 18px/22px "
                    . $n . ", sans-serif;text-transform: uppercase;color: #484848;"
                    . "display: block;padding: 10px;border-bottom: 3px solid #e9e9e9;list-style: none;'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Your Cart Items',
                        'abandonedcart',
                        $iso_code
                    ) . '</div>';
                foreach ($detail as $products) {
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']); //Added by Anshul on 22-Jan-2020 for fixing bug reported by Shubham
                    $cart_html .= "<div style='overflow:auto;position: relative;padding: 0;
                        border-bottom: 3px solid #e9e9e9;background: rgba(246, 246, 246, 0.59);
                        margin: 0;font: 600 18px/22px "
                        . $n . ", sans-serif;text-transform: uppercase;"
                        . "color: #484848;display: block;padding: 10px;list-style: none;'>";
                    $cart_html .= "<div style='width:30%;float:left;'><a href='"
                        . $action_url . "'><img style='width:100%;' src='" . $img_path . "'></a></div>";
                    $cart_html .= '<div style="width:60%;float:left;margin: 3% auto;">
                        <span style="width:40%;float:left;font-size: 16px;
                        font-weight: 100;text-transform:capitalize;">'
                        . $products['name'] . '</span>';
                    $cart_html .= '<span style="width:40%;float:left;font-size: 16px;'
                            . 'font-weight: 100;text-align:center;text-transform:lowercase">x'
                            . $products['cart_quantity'] . '</span></div></div>';
                }
                
                $cart_html .= '<div style="cursor:pointer;float: right;margin-top: 1%;cursor:pointer;
                    background: #3498db;background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
                    background-image: -moz-linear-gradient(top, #3498db, #2980b9);
                    background-image: -ms-linear-gradient(top, #3498db, #2980b9);
                    background-image: -o-linear-gradient(top, #3498db, #2980b9);
                    background-image: linear-gradient(to bottom, #3498db, #2980b9);-webkit-border-radius: 0;
                    -moz-border-radius: 0;border-radius: 0px;font-family: Arial;color: #ffffff;font-size: 20px;
                    padding: 10px 20px 10px 20px;text-decoration: none;">
                    <a style="text-decoration:none;color:white" href="' . $direct_checkout_url . '">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 7) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $n = 'Open Sans';
                $cart_html .= "<div style='color:white;position: relative;padding: 0;border-bottom: 3px solid #e9e9e9;
                    background: rgba(6, 51, 134, 0.61);margin: 0;font: 600 18px/22px "
                    . $n . ", sans-serif;text-transform: uppercase;"
                    . "color: white;display: block;padding: 10px;border-bottom: 3px solid #e9e9e9;list-style: none;'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Items In Your Cart',
                        'abandonedcart',
                        $iso_code
                    ) . '</div>';

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }

                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<div style='overflow:auto;position: relative;padding: 0;
                        border-bottom: 3px solid #6682B5;margin: 0;font: 600 18px/22px '" . $n . "', sans-serif;
                        text-transform: uppercase;color: #484848;display: block;padding: 10px;list-style: none;'>";
                    $cart_html .= "<div style='width:30%;float:left;'><a href='"
                        . $action_url . "'><img  width='100' src='" . $img_path . "'></a></div>";
                    $cart_html .= "<div style='width:30%;float:left;margin: 3% auto;text-align:center'>
                        <div style='font-size: 16px;font-weight: 100;
                        text-transform:capitalize;color: rgba(3, 26, 97, 0.56);font-weight: bold'>"
                        . $products['name'] . '</div>';
                    $cart_html .= "<div style='font-size: 12px;text-transform:capitalize;"
                            . "color: black;font-weight: bold'>" . $products['attributes'] . '</div></div>';
                    $cart_html .= "<div style='width:30%;float:left;margin: 3% auto;"
                            . "text-align:center;text-transform:lowercase;'>x"
                            . $products['cart_quantity'] . '</div></div>';
                }
                $cart_html .= '<div style="float: right;margin-top: 1%;cursor:pointer;background: #6682B5;
                    background-image: -webkit-linear-gradient(top, #6682B5, #6682B5);
                    background-image: -moz-linear-gradient(top, #6682B5, #6682B5);
                    background-image: -ms-linear-gradient(top, #6682B5, #6682B5);
                    background-image: -o-linear-gradient(top, #6682B5, #6682B5);
                    background-image: linear-gradient(to bottom, #6682B5, #6682B5);-webkit-border-radius: 0;
                    -moz-border-radius: 0;border-radius: 0px;font-family: Arial;color: #ffffff;
                    font-size: 20px;padding: 10px 20px 10px 20px;text-decoration: none;">
                    <a style="text-decoration:none;color:white" href="'
                    . $direct_checkout_url . '">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 8) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }

                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<div style='padding: 2%;'>";
                    $cart_html .= "<div style='text-align:center'><div style='padding:1%'>";
                    $cart_html .= "<a href='" . $action_url . "'><img style='width:40%' src='"
                        . $img_path . "'></a></div>";
                    $cart_html .= "<div style='border: 1px solid black;font-weight: bold;padding: 1%;"
                        . "font-size: 150%;margin: 0px auto;'>"
                        . $products['name'] . '</div></div></div>';
                    $cart_html .= "<div style='color: black;font-size: 120%;font-family: sans-serif;padding:1%;'>"
                        . $products['attributes'] . '</div>';
                }
                $cart_html .= '<div style="margin-top: 2%;cursor:pointer;background: #4CAF50;
                    -webkit-border-radius: 0;-moz-border-radius: 0;
                    border-radius: 0px;font-family: Arial;color: #ffffff;font-size: 20px;
                    padding: 10px 20px 10px 20px;text-decoration: none;">
                    <a style="text-decoration:none;color:white" href="' . $direct_checkout_url . '">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 9) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= "<hr><div style='color: #E91E63;display: block;font-size: 20px;"
                    . "text-align: center;margin: 0px auto;padding: 5px;line-height: 30px'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'ITEMS IN YOUR CART',
                        'abandonedcart',
                        $iso_code
                    ) . "</div>
                    <hr><ul style='list-style-type: none;padding:0px;overflow:auto;'>";

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<li style='width:45%;float:left;margin-bottom:2%;margin-right:2%;'>
                        <div style='text-align:center;border:1px solid gray;'><a href='"
                        . $action_url . "'><img style='width:100%' src='"
                        . $img_path . "'></a></div>";
                    $cart_html .= "<div style='text-align: center;margin: 5% auto;font-size: 16px;
                        font-weight: bolder;max-height:20px;text-overflow: ellipsis;
                        white-space:nowrap;overflow:hidden'><span>"
                        . $products['name'] . '</span></div>';
                    $cart_html .= "<div style='background: #00BCD4;color: #fff;display: block;
                        font-size: 120%;text-align: center;
                        margin: 2% auto;padding: 1%;line-height: 30px'>
                        <a style='text-decoration:none;color:white' href='" . $action_url . "'>"
                        . $this->getModuleTranslationByLanguage(
                            'abandonedcart',
                            'View More',
                            'abandonedcart',
                            $iso_code
                        ) . '</a></div></li>';
                }
                $cart_html .= '</ul><hr><div style="float:right;background: #F44336;
                        color: #fff;display: block;font-size: 150%;
                        text-align: center;margin: 0px auto;padding: 1%;line-height: 30px">
                    <a style="text-decoration:none;color:white" href="'
                    . $direct_checkout_url . '">'
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            } elseif ($cart_data['cart_template'] == 10) {
                $cart = new Cart((int) $cart_data['id_cart']);
                $detail = $cart->getProducts();
                $sno = 1;
                $link = new Link();
                $direct_checkout_url = $this->getFrontActionLink('direct', $cart_data);
                $cart_html .= "<hr><div style='display: block;font-size: 20px;text-align: center;"
                    . "margin: 0px auto;padding: 5px;line-height: 30px'>"
                    . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Items In Your Cart',
                        'abandonedcart',
                        $iso_code
                    ) . "</div>
                    <hr><ul style='list-style-type: none;padding:0px;overflow:auto;'>";

                foreach ($detail as $products) {
                    if (!isset($products['attributes'])) {
                        $products['attributes'] = ' ';
                    }
                    if (!isset($products['name'])) {
                        $products['name'] = ' ';
                    }
                    if (!isset($products['description_short'])) {
                        $products['description_short'] = ' ';
                    }
                    if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                        $img_path = 'https://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    } else {
                        $img_path = 'http://' . $link->getImageLink($products['link_rewrite'], $products['id_image']);
                    }
                    $action_url = $this->getFrontActionLink('single', $cart_data, $products['id_product']);
                    $cart_html .= "<li style='overflow:auto;padding:1%;margin:0px auto;'>
                        <div style='text-align:center;width:28%;padding:1%;
                        float:left;border:1px solid gray;'><a href='"
                        . $action_url . "'><img style='width:100%' src='" . $img_path . "'></a></div>";
                    $cart_html .= "<div style='text-align:center;float:left;width:67%;padding:1%'>
                        <div style='font-size: 18px;
                        font-weight: bolder;padding:2%;
                        max-height:20px;text-overflow: ellipsis;white-space:nowrap;overflow:hidden'>
                        <span>" . $products['name'] . "</span></div>
                        <div style='max-height:100%;text-overflow: ellipsis;overflow:hidden'>"
                        . trim($products['description_short'], '<p></p>') . '</div>';
                    $cart_html .= "<div style='background: #d14836;color: #fff;display: block;
                        font-size: 14px;width: 30%;
                        text-align: center;margin: 2% auto;line-height: 30px'>
                        <a style='text-decoration:none;color:white' href='"
                        . $action_url . "'>" . $this->getModuleTranslationByLanguage(
                            'abandonedcart',
                            'View More',
                            'abandonedcart',
                            $iso_code
                        ) . '</a></div></div></li>';
                }
                $cart_html .= '</ul><hr><div style="float:right;background: #35AC19;
                    color: #fff;display: block;font-size: 150%;
                    text-align: center;margin: 0px auto;padding: 1%;
                    line-height: 30px"><a style="text-decoration:none;color:white" href="'
                    . $direct_checkout_url . '">' . $this->getModuleTranslationByLanguage(
                        'abandonedcart',
                        'Direct Checkout',
                        'abandonedcart',
                        $iso_code
                    ) . '</a></div>';
            }
        }
        return $cart_html;
    }

    /*
     * Function arguments modified by Anshul to check if notification clicked or not
     * Feature: Push Notification (Jan 2020)
     */
    public function getFrontActionLink($mode, $cart_data, $id_product = 0, $push_id = 0)
    {
        $params = array();
        /*
         * Start: Code added by Anshul to check if push notification or not
         * Feature: Push Notification (Jan 2020)
         */
        if ($push_id !=0) {
            $params = array('clicked'=> 1, 'push_id' => $push_id);
        }
        /*
         * End: Code added by Anshul to check if push notification or not (Feature: Push Notification (Jan 2020))
         */
        $ssl = (bool)Configuration::get('PS_SSL_ENABLED');
        $contoller_link = $this->context->link->getModuleLink(
            'abandonedcart',
            'action',
            $params,
            $ssl
        );
        $dot_found = 0;
        $needle = 'index.php';
        $dot_found = strpos($contoller_link, $needle);
        if ($dot_found !== false) {
            $ch = '&';
        } else {
            $ch = '?';
        }

        $product_str = '';
        if ($mode == 'single') {
            $action = 'single_product';
            $product_str = '|'.$id_product;
        } else {
            $action = 'direct_checkout';
            $product_str = '|0';
        }
        $final_url = $contoller_link.$ch.'action='.$action;
        $hash_key = '';

        $hash_key .= $cart_data['id_cart'];
        $hash_key .= '|'.$cart_data['id_customer'];
        $hash_key .= '|'.$cart_data['id_abandon'];
        if (isset($cart_data['discount_code'])) {
            $hash_key .= '|'.$cart_data['discount_code'];
        } else {
            $hash_key .= '|0';
        }
        $hash_key .= '|'.urlencode($cart_data['customer_email']);
        $hash_key .= '|'.$cart_data['customer_secure_key'];
        $hash_key .= $product_str;

//        $hash_key .= '~^'.Configuration::get('VELSOF_ABD_SECURE_KEY');
        $final_url .= '&hash_key='.str_rot13($hash_key);
        return $final_url;
    }

    protected function sendReminder($data, $use_saved_template = true)
    {
        if ($use_saved_template) {
            $id_template_content = $data['id_template_content'];
            $template_data = $this->loadEmailTemplateTranslation(0, 0, $id_template_content);
            $data['subject'] = $template_data['subject'];
            $data['body'] = $template_data['body'];
            $data['cart_template'] = $template_data['cart_template'];
        }
       
//        $directory = $this->getTemplateDir();
        $lang_code = "";
        if (isset($data['id_lang'])) {
            $lang_code = Language::getIsoById($data['id_lang']);
        }
        $directory = $this->getTemplateDir($lang_code);
        //Tools::chmodr($directory, 0755);
        if (is_writable($directory)) {
            $html_template = self::REMINDER_TEMPLATE_NAME . '.html';
            $txt_template = self::REMINDER_TEMPLATE_NAME . '.txt';

            $base_html = $this->getTemplateBaseHtml(false);

            $template_html = str_replace('{template_content}', $data['body'], $base_html);

            $file = fopen($directory . $html_template, 'w+');
            fwrite($file, $template_html);
            fclose($file);

            $file = fopen($directory . $txt_template, 'w+');
            fwrite($file, $template_html);
            fclose($file);

            $cart = new Cart($data['id_cart']);
            if (!$cart->nbProducts()) {
                return -2;
            }
            if ($data['id_customer'] != 0) {
                $customer = new Customer($data['id_customer']);
                $data['customer_email'] = $customer->email;
                $data['customer_fname'] = $customer->firstname;
                $data['customer_lname'] = $customer->lastname;
                $data['customer_secure_key'] = $customer->secure_key;
                unset($customer);
            } else {
                $fetch_qry = 'select firstname, lastname, email from ' . _DB_PREFIX_
                        . self::ABD_TRACK_CUSTOMERS_TABLE_NAME . ' where id_cart = ' . (int) $data['id_cart'];
                $user_data = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($fetch_qry);
                if ($user_data && count($user_data) > 0) {
                    $data['customer_fname'] = ($user_data['firstname'] != '' && $user_data['lastname'] != '')
                        ? $user_data['firstname'] : '';
                    $data['customer_lname'] = ($user_data['firstname'] != '' && $user_data['lastname'] != '')
                        ? $user_data['lastname'] : '';
                    $data['customer_email'] = $user_data['email'];
                    $data['customer_secure_key'] = 'none';
                } else {
                    return false;
                }
                unset($user_data);
            }
            $lang = new Language($cart->id_lang);
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $custom_ssl_var = 1;
            }
            if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
                $uri_path = _PS_BASE_URL_SSL_ . __PS_BASE_URI__;
            } else {
                $uri_path = _PS_BASE_URL_ . __PS_BASE_URI__;
            }
            //changes by tarun to add cron link for unsubscribe functionality
            $cron_link = $this->context->link->getModuleLink('abandonedcart', 'cron');
            $dot_found = 0;
            $needle = 'index.php';
            $dot_found = strpos($cron_link, $needle);
            if ($dot_found !== false) {
                $ch = '&';
            } else {
                $ch = '?';
            }
            
            $template_vars = array(
                '{shop_url_link}' => $uri_path,
                '{firstname}' => $data['customer_fname'],
                '{lastname}' => $data['customer_lname'],
                '{cart_content}' => $this->getCartHtml($data),
                '{total_amount}' => Cart::getTotalCart((int) $data['id_cart']),
                '{discount_value}' => '',
                '{discount_code}' => '',
                '{date_end}' => '',
                '{unsubscribed_title}' => $this->l('Unsubscribe'),
                '{unsubscribed_link}' => $cron_link . $ch."cron=unsubscribed&secure_key=".Configuration::get('VELSOF_ABD_SECURE_KEY')."&email=".$data['customer_email']."&id_customer=".$data['id_customer'],
            );
            //changes over

            $lang_iso = Configuration::get('VELSOF_ABANDONED_CART_DEFAULT_TEMPLATE_LANG');

            $config = Configuration::get('VELSOF_ABANDONEDCART');
            $this->my_module_settings = Tools::unSerialize($config);

            if (isset($this->my_module_settings['enable_test']) && $this->my_module_settings['enable_test'] == 1) {
                $data['customer_email'] = $this->my_module_settings['testing_email_id'];
            }

            if (Mail::Send(
                $data['id_lang'],
                self::REMINDER_TEMPLATE_NAME,
                $data['subject'],
                $template_vars,
                $data['customer_email'],
                $data['customer_fname'] . ' ' . $data['customer_lname'],
                Configuration::get('PS_SHOP_EMAIL'),
                Configuration::get('PS_SHOP_NAME'),
                null,
                null,
                _PS_MODULE_DIR_ . 'abandonedcart/mails/',
                false,
                $this->context->shop->id
            )) {
                $mark_reminder_sent = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . ' set
                    reminder_sent= "' . (int) self::REMINDER_SENT . '" where id_abandon=' . (int) $data['id_abandon'];
                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($mark_reminder_sent);
                return true;
            } else {
                return false;
            }
        } else {
            return -1;
        }
    }
    
    /*
     * Function added by Anshul to update the reminder sent info in case of Push Notification
     * Feature: Push Notification (Jan 2020)
     */
    public function updateReminderSentInfo($id_abandoned)
    {
        $mark_reminder_sent = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . ' set
                    reminder_sent= "' . (int) self::REMINDER_SENT . '" where id_abandon=' . (int) $id_abandoned;
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($mark_reminder_sent);
    }

    public function sendDiscountEmail($data, $use_saved_template = true)
    {
        if ($use_saved_template) {
            $id_template_content = $data['id_template_content'];
            $template_data = $this->loadEmailTemplateTranslation(0, 0, $id_template_content);
            $data['subject'] = $template_data['subject'];
            $data['body'] = $template_data['body'];
            $data['cart_template'] = $template_data['cart_template'];
        }

        $lang_code = "";
        if (isset($data['id_lang'])) {
            $lang_code = Language::getIsoById($data['id_lang']);
        }
        $directory = $this->getTemplateDir($lang_code);
        //Tools::chmodr($directory, 0755);
        if (is_writable($directory)) {
            $html_template = self::DISCOUNT_TEMPLATE_NAME . '.html';
            $txt_template = self::DISCOUNT_TEMPLATE_NAME . '.txt';

            $base_html = $this->getTemplateBaseHtml(true);

            $template_html = str_replace('{template_content}', $data['body'], $base_html);
            $file = fopen($directory . $html_template, 'w+');
            fwrite($file, $template_html);
            fclose($file);

            $file = fopen($directory . $txt_template, 'w+');
            fwrite($file, $template_html);
            fclose($file);

            //Disable all previous coupons for passed customer
            $customer_info = new Customer((int) $data['id_customer']);
            $cart = new Cart((int) $data['id_cart']);
            if (!$cart->nbProducts()) {
                return -2;
            }
            $coupon_disable = 'Delete FROM '._DB_PREFIX_.
                'cart_rule where description ="ABD['.pSQL($customer_info->email).']"';
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($coupon_disable);
            if ($data['discount_type'] == parent::DISCOUNT_FIXED) {
                $is_used_partial = 1;
                $fixed_reduction = $data['discount_value'];
                $percent_reduction = 0;
            } else {
                $is_used_partial = 0;
                $fixed_reduction = 0;
                $percent_reduction = $data['discount_value'];
            }

            if ($data['min_cart_value'] <= 0 || $data['min_cart_value'] == '') {
                $data['min_cart_value'] = 0;
            }

            $rule_desc = Tools::htmlentitiesUTF8('ABD[' . $customer_info->email . ']');
            $coupon_code = $this->generateCouponCode();
            $coupon_expiry_date = date('Y-m-d 23:59:59', strtotime('+' . $data['coupon_validity'] . ' days'));

            //insert coupon details
            $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule  SET
                id_customer = ' . (int) $data['id_customer'] . ',
                date_from = "' . pSQL(date('Y-m-d H:i:s', time())) . '",
                date_to = "' . pSQL($coupon_expiry_date) . '",
                description = "' . pSQL($rule_desc) . '",
                quantity = 1, quantity_per_user = 1, priority = 1, partial_use = ' . (int) $is_used_partial . ',
                code = "' . pSQL($coupon_code) . '", minimum_amount = ' . (float) $data['min_cart_value']
                . ', minimum_amount_tax = 0,
                minimum_amount_currency = ' . (int) $cart->id_currency . ', minimum_amount_shipping = 0,
                country_restriction = 0, carrier_restriction = 0, group_restriction = 0, cart_rule_restriction = 0,
                product_restriction = 0, shop_restriction = 1,
                free_shipping = ' . (int) $data['has_free_shipping'] . ',
                reduction_percent = ' . (float) $percent_reduction . ', reduction_amount = '
                . (float) $fixed_reduction . ',
                reduction_tax = 1, reduction_currency = ' . (int) $cart->id_currency . ',
                reduction_product = 0, gift_product = 0, gift_product_attribute = 0,
                highlight = 0, active = 1,
                date_add = "' . pSQL(date('Y-m-d H:i:s', time()))
                . '", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"';

            Db::getInstance()->execute($sql);
            $cart_rule_id = Db::getInstance()->Insert_ID();

            Db::getInstance()->execute(
                'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_shop
                set id_cart_rule = ' . (int) $cart_rule_id
                . ', id_shop = ' . (int) $customer_info->id_shop
            );
            //changes by tarun (reported by anshul sir)
            $languages = Language::getLanguages(true);
            foreach ($languages as $lang) {
                Db::getInstance()->execute('INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_lang
                            set id_cart_rule = ' . (int) $cart_rule_id . ', id_lang = ' . (int) $lang['id_lang'] . ',
                            name = "' . pSQL($rule_desc) . '"');
            }
            //changes over
            Configuration::updateGlobalValue('PS_CART_RULE_FEATURE_ACTIVE', '1');
            if ($data['discount_type'] == parent::DISCOUNT_FIXED) {
                $formatted_discount = Tools::displayprice($data['discount_value']);
            } else {
                $formatted_discount = Tools::ps_round($data['discount_value'], 2) . ' %';
            }

            $data['discount_code'] = $coupon_code;
            $data['customer_email'] = $customer_info->email;
            $data['customer_secure_key'] = $customer_info->secure_key;
            $lang = new Language($cart->id_lang);
            $cart_lang = $lang->iso_code;
            $custom_ssl_var = 0;
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $custom_ssl_var = 1;
            }
            if ((bool) Configuration::get('PS_SSL_ENABLED') && $custom_ssl_var == 1) {
                $uri_path = _PS_BASE_URL_SSL_ . __PS_BASE_URI__;
                $module_dir = _PS_BASE_URL_SSL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
            } else {
                $uri_path = _PS_BASE_URL_ . __PS_BASE_URI__;
                $module_dir = _PS_BASE_URL_ . __PS_BASE_URI__ . str_replace(_PS_ROOT_DIR_ . '/', '', _PS_MODULE_DIR_);
            }
                           
            $icon_src = $module_dir . 'abandonedcart/views/img/front/gift.png';
            //changes by tarun to add cron link in email for unsubscribe functionality
            $cron_link = $this->context->link->getModuleLink('abandonedcart', 'cron');
            $dot_found = 0;
            $needle = 'index.php';
            $dot_found = strpos($cron_link, $needle);
            if ($dot_found !== false) {
                $ch = '&';
            } else {
                $ch = '?';
            }
            $template_vars = array(
                '{shop_url_link}' => $uri_path,
                '{firstname}' => $customer_info->firstname,
                '{lastname}' => $customer_info->lastname,
                '{email}' => $customer_info->email,
                '{cart_content}' => $this->getCartHtml($data),
                '{discount_value}' => $formatted_discount,
                '{discount_code}' => $coupon_code,
                '{date_end}' => Tools::displayDate($coupon_expiry_date, null, true),
                '{voucher_src}' => $icon_src,
                '{unsubscribed_title}' => $this->l('Unsubscribe'),
                '{unsubscribed_link}' => $cron_link . $ch."cron=unsubscribed&secure_key=".Configuration::get('VELSOF_ABD_SECURE_KEY')."&email=".$data['customer_email']."&id_customer=".$data['id_customer'],
            );
            //changes over

//            if ($data['min_cart_value'] <= 0 || $data['min_cart_value'] == '') {
//                $template_vars['{total_amount}'] = Cart::getTotalCart((int) $data['id_cart']);
//            } else {
//                $template_vars['{total_amount}'] = Tools::displayPrice($data['min_cart_value']);
//            }
            $template_vars['{total_amount}'] = Tools::displayPrice($data['min_cart_value']);

            $lang_iso = Configuration::get('VELSOF_ABANDONED_CART_DEFAULT_TEMPLATE_LANG');
//            $template_lng = Language::getIdByIso($lang_iso);

            $config = Configuration::get('VELSOF_ABANDONEDCART');
            $this->my_module_settings = Tools::unSerialize($config);

            if (isset($this->my_module_settings['enable_test']) && $this->my_module_settings['enable_test'] == 1) {
                $data['customer_email'] = $this->my_module_settings['testing_email_id'];
            }
            
            if (Mail::Send(
                $data['id_lang'],
                self::DISCOUNT_TEMPLATE_NAME,
                $data['subject'],
                $template_vars,
                $data['customer_email'],
                $customer_info->firstname . ' ' . $customer_info->lastname,
                Configuration::get('PS_SHOP_EMAIL'),
                Configuration::get('PS_SHOP_NAME'),
                null,
                null,
                _PS_MODULE_DIR_ . 'abandonedcart/mails/',
                false,
                $this->context->shop->id
            )) {
                if (isset($data['auto_email']) && $data['auto_email'] == 1) {
                    $no_auto_mail = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME
                        . ' set auto_email= "0" where id_abandon=' . (int) $data['id_abandon'];
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($no_auto_mail);
                }
                $mark_reminder_sent = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . ' set
                    reminder_sent= "' . (int) self::REMINDER_SENT . '" where id_abandon=' . (int) $data['id_abandon'];
                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($mark_reminder_sent);
                return true;
            } else {
                return false;
            }
        } else {
            return -1;
        }
    }

    private function getCustomerDetail($id_customer)
    {
        $data = array();
        $customer = new Customer($id_customer);
        $data = array(
            'id_customer' => $id_customer,
            'fname' => $customer->firstname,
            'lname' => $customer->lastname,
            'email' => $customer->email
        );
        return $data;
    }

    private function getCustomerCouponDetail($id_customer, $email)
    {
        $data = array();
        $qry = 'select code, minimum_amount,date_from,date_to,reduction_percent,reduction_amount
            from ' . _DB_PREFIX_ . 'cart_rule as cr INNER JOIN ' . _DB_PREFIX_ . 'cart_rule_lang as crl
            on (cr.id_cart_rule = crl.id_cart_rule)
            where cr.active = "1" and cr.id_customer = ' . (int) $id_customer
            . ' AND crl.name = "ABD[' . (string) $email . ']"
            AND crl.id_lang = ' . (int) $this->context->language->id;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($qry);

        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                $row['reduction_format'] = Tools::displayprice($row['reduction_amount']);
                $row['minimum_amount'] = Tools::displayprice($row['minimum_amount']);
                $data[] = $row;
            }
        }
        return $data;
    }

    private function getCustomerCartDetail($id_customer, $id_cart)
    {
        $data = array('customer' => array(), 'cart_total' => 0, 'products' => array());
        $cart = new Cart($id_cart);
        $detail = $cart->getProducts();
        $link = new Link();
        if ($detail && count($detail) > 0) {
            foreach ($detail as $product) {
                if ((bool) Configuration::get('PS_SSL_ENABLED')) {
                    $img_path = 'https://' . $link->getImageLink($product['link_rewrite'], $product['id_image']);
                } else {
                    $img_path = 'http://' . $link->getImageLink($product['link_rewrite'], $product['id_image']);
                }

                $product['pro_link'] = $this->context->link->getProductLink($product['id_product']);
                $product['img_link'] = $img_path;
                $product['price_wt'] = Tools::displayPrice($product['price_wt']);
                $product['total_wt'] = Tools::displayPrice($product['total_wt']);
                $data['products'][] = $product;
            }
            $data['cart_total'] = Tools::displayPrice($cart->getordertotal());
        }

        $data['customer'] = $this->getCustomerDetail($id_customer);
        return $data;
    }

    public function deleteAbandonCart($id_abandon)
    {
        $sql = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME
            . ' set shows= "0" where id_abandon=' . (int) $id_abandon;
        if (Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function hookDisplayOrderConfirmation($params = null)
    {
        $order = $params['order'];
        $check_abandon_sql = 'select * from ' . _DB_PREFIX_
                . self::ABANDON_TABLE_NAME . ' where id_cart = ' . (int) $order->id_cart
                . ' AND reminder_sent = "' . (int) self::REMINDER_SENT . '"';
        $check_abandon = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_abandon_sql);
        if (is_array($check_abandon) && count($check_abandon) > 0) {
            $is_converted = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . '
                set is_converted= "1", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"
                where id_abandon=' . (int) $check_abandon['id_abandon'];
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($is_converted);
        }

        $check_abandon_sql = 'select * from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME
            . ' where id_cart = ' . (int) $order->id_cart
            . ' AND reminder_sent = "' . (int) self::REMINDER_NOT_SENT . '"';
        $check_cart = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_abandon_sql);
        if (is_array($check_cart) && count($check_cart) > 0) {
            $is_deleted = 'update ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME . '
                set shows= "0", date_upd = "' . pSQL(date('Y-m-d H:i:s', time())) . '"
                where id_abandon=' . (int) $check_cart['id_abandon'];
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($is_deleted);
        }
    }

    public function hookActionCartSave($params = null)
    {
        if (isset($params['cart']) && !empty($params['cart'])) {
            $quantity = Db::getInstance()->getRow(
                'select SUM(quantity) as total from '
                . _DB_PREFIX_ . 'cart_product where id_cart=' . (int) $params['cart']->id
            );
            $check_query = 'select * from ' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME . ' where
                id_cart=' . (int) $params['cart']->id . ' and quantity!=' . (int) $quantity['total'];
            if (Db::getInstance()->getRow($check_query)) {
                $delete_cart_mapping = 'DELETE from ' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME .
                        ' where id_cart=' . (int) $params['cart']->id . ' and quantity!=-1';
                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($delete_cart_mapping);
            }
        }
    }
    //Function to unsubscribe customer added by tarun
    public function unsubscribedLink($customer_email = null, $id_customer = 0)
    {
        if ($customer_email != null) {
            $is_exist_sql = 'Select count(*) as row from ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME .
                            ' where email = "' . pSQL($customer_email) . '"';
            $is_exist = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($is_exist_sql);
            if (!is_array($is_exist) || $is_exist['row'] <= 0) {
                $insert_subscriber_data = 'INSERT into ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME
                        . ' (id_customer,email,send_email) values ('
                        . (int) $id_customer . ', "'
                        . pSQL($customer_email) . '", "0")';
                if (Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($insert_subscriber_data)) {
                    echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
                        . $this->l('You are unsubscribed successfully') . '</div>';
                    die;
                } else {
                    echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
                    . $this->l('Please try Again') . '</div>';
                    die;
                }
            } else {
                $up_qry = 'Update ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME
                    . ' set send_email = "0" WHERE email = "' . pSQL($customer_email) . '"';

                if (Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($up_qry)) {
                    echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
                    . $this->l('You are unsubscribed successfully') . '</div>';
                    die;
                } else {
                    echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
                    . $this->l('Please try Again') . '</div>';
                    die;
                }
            }
        } else {
            echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
            . $this->l('Please try Again') . '</div>';
            die;
        }
    }
    //changes over
    /*
     * Function modified by RS on 07-Sept-2017 for optimization purpose and also updating the Cart Totals in case the version has been updated
     */
    public function updateAbandonList($cron = false, $update_cart_total = false, $cron_type = null)
    {
        /* Start - Code Added by RS on 06-Sept-2017 for adding the memory limit and time limit before executing the code so that it doesn't times out */
        ini_set("memory_limit", "-1");
        set_time_limit(10000);
        /* End - Code Added by RS on 06-Sept-2017 for adding the memory limit and time limit before executing the code so that it doesn't times out */
        /*
         * Check the guest cart which are turned into registed user cart later
         */
        
        /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        $save_time = date('Y-m-d H:i:s', time());
        $update_cart = $this->l("Update_Carts");
        $progress = $this->l("Progress");
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

        $is_save = Db::getInstance()->execute($query);
        $id_cron = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
        /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/

        $configurations = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        if ($configurations['enable'] != 1) {
            return false;
        }
        $qry = 'Select * from ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME . ' where id_customer = 0';
        $guest_carts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($qry);
        if (is_array($guest_carts) && count($guest_carts) > 0) {
            foreach ($guest_carts as $c) {
                $t = 'Select id_customer from ' . _DB_PREFIX_ . 'cart
					where id_cart = ' . (int) $c['id_cart'] . ' AND id_customer > 0';
                if ($id_customer = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($t)) {
                    $check_guest = 'select is_guest from ' . _DB_PREFIX_ . 'customer where id_customer = ' .
                            (int) $id_customer;
                    $is_guest = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_guest);
                    $up_qry = 'Update ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME
                            . ' set id_customer = ' . (int) $id_customer . ', is_guest = "' .
                            (int) $is_guest['is_guest'] . '"
						WHERE id_cart = ' . (int) $c['id_cart'] . ' AND id_abandon = ' .
                            (int) $c['id_abandon'];
                    Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($up_qry);
                    
                    /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
                    $customer_info = new Customer((int) $id_customer);
                    $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_DETAIL_TABLE_NAME . ' 
                    (id_cron, email_id, cart_id,  date_add, date_upd) values('
                                        . (int) $id_cron . ', "'
                                        . pSQL($customer_info->email) . '", '
                                        . (int) $c['id_cart'] . ', "'
                                        . pSQL($save_time) . '","'
                                        . pSQL($save_time) . '")';


                    Db::getInstance()->execute($query);
                    /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
                }
            }
        }

        $velsof_abandoncart_start_date = Configuration::get('VELSOF_ABANDONEDCART_START_DATE');

        $delay = (int) $configurations['delay_hours'] + (24 * (int) $configurations['delay_days']);
        $delay_time = date('Y-m-d H:i:s', strtotime('-' . $delay . ' hours'));
        /* Start - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on cron run when there are a lot of carts */
        $delay_time_hour = date('Y-m-d H:i:s', strtotime('-' . ($delay+1) . ' hours'));
        $update_analytics_condition = '';
        if (!$update_cart_total) {
            $update_analytics_condition = ' AND c.date_upd >= "' . pSQL($delay_time_hour) . '"';
        }
        $sql = 'select c.*,o.id_cart as ordered from ' . _DB_PREFIX_ . 'cart as c left JOIN '._DB_PREFIX_.'orders o on (o.id_cart=c.id_cart)
			WHERE c.date_upd >= "' . pSQL(date('Y-m-d H:i:s', strtotime($velsof_abandoncart_start_date))) . '"
            AND c.date_upd <= "' . pSQL($delay_time) . '"'.$update_analytics_condition; //combine
        /* End - Code Modified by RS on 06-Sept-2017 for solving the problem of time delay on cron run when there are a lot of carts */

        $carts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $carts_added = 0;
        if (is_array($carts) && count($carts) > 0) {
            foreach ($carts as $cart) {
                if (is_null($cart['ordered']) || $update_cart_total) {
                    /* Start - Code Modified by RS on 06-Sept-2017 for combining two queries in a single query ($consider_abandon_sql query has been removed and is combined in $sql) + Adding Order Total in the Abandoned Cart Table */
//$consider_abandon_sql = 'Select count(*) as row from ' . _DB_PREFIX_ . 'cart
//WHERE id_cart = ' . (int) $cart['id_cart'] . ' AND date_upd <= "' . pSQL($delay_time) . '"';
//$consider_abandon = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($consider_abandon_sql);
//if (is_array($consider_abandon) && $consider_abandon['row'] > 0) {
                    $cart_obj = new Cart((int) $cart['id_cart']);
                    $is_exist_sql = 'Select count(*) as row from ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME .
                            ' where id_cart =' . (int) $cart['id_cart'];
                    $is_exist = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($is_exist_sql);
                    if (!is_array($is_exist) || $is_exist['row'] <= 0) {
                        $customer = new Customer((int) $cart['id_customer']);
                        $insert_abandon_data = 'INSERT into ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME
                                . ' (id_cart,id_shop,id_lang,id_customer,is_guest,cart_total,date_add,date_upd) values ('
                                . (int) $cart['id_cart'] . ', '
                                . (int) $cart['id_shop'] . ', '
                                . (int) $cart['id_lang'] . ', '
                                . (int) $cart['id_customer'] . ', "' . (int) $customer->isGuest() . '", "'
                                . pSQL($cart_obj->getOrderTotal()) . '", "'
                                . pSQL($cart['date_add']) . '", "' . pSQL($cart['date_upd']) . '")';

                        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($insert_abandon_data);
//                        //changes by tarun to insert data of the customer for unsubscribe functionality
//                        if(!empty($customer->email)) {
//                            $is_subscriber_exist_sql = 'Select count(*) as row from ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME .
//                            ' where email =' . pSQL($customer->email);
//                            $is_subscriber_exist = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($is_subscriber_exist_sql);
//                            if (!is_array($is_subscriber_exist) || $is_subscriber_exist['row'] <= 0 ) {
//                                $insert_subscriber_data = 'INSERT into ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME
//                                . ' (id_customer,email) values ('
//                                . (int) $cart['id_customer'] . ', "'
//                                . pSQL($customer->email) . '")';
//                                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($insert_subscriber_data);
//                            }
//                        }
//                        //changes over
                        $carts_added++;
                    } else {
                        $update_date_update = 'update ' . _DB_PREFIX_ . parent::ABANDON_TABLE_NAME . ' set
                                date_upd = "' . pSQL($cart['date_upd']) . '", id_customer = "'.(int) $cart['id_customer'].'", cart_total = "'.pSQL($cart_obj->getOrderTotal()).'"  where id_cart = ' . (int) $cart['id_cart'];
                        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update_date_update);
                    }
                    
                    $customer = new Customer((int) $cart['id_customer']);

                    if (!empty($customer->email)) {
                        $cust_email = $customer->email;
                    } else {
                        $cust_email = $this->l('No email is present');
                    }
                    
                    $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_DETAIL_TABLE_NAME . ' 
                            (id_cron, email_id, cart_id, date_add, date_upd) values('
                            . (int) $id_cron . ', "'
                            . pSQL($cust_email) . '", '
                            . (int) $cart['id_cart'] . ', "'
                            . pSQL($save_time) . '","'
                            . pSQL($save_time) . '")';

                    Db::getInstance()->execute($query);
                    /* End - Code Modified by RS on 06-Sept-2017 for combining two queries in a single query ($consider_abandon_sql query has been removed and is combined in $sql) + Adding Order Total in the Abandoned Cart Table */
                }
            }
        }
        
        /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        $end_time = date('Y-m-d H:i:s', time());
          
        $query = 'UPDATE ' . _DB_PREFIX_ . self::CRON_TABLE_NAME
                . ' set status = "' . $this->l("Completed") . '", 
                    end_time = "' . pSQL($end_time) . '", date_upd="' . pSQL($end_time) . '" WHERE id_cron = ' . (int) $id_cron;

        Db::getInstance()->execute($query);
        /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        if ($cron && !$update_cart_total) {
            echo '<div class="text_to_show" style="font-size:16px;padding: 10px;">' . $this->l('Total') . ' '
            . $carts_added . ' ' . $this->l('new Carts added.') . '</div>';
            die;
        }
        if ($update_cart_total) {
            Configuration::updateGlobalValue('VELSOF_ABD_CART_TOTAL_ADDED', 0);
            echo '<div class="text_to_show" style="font-size:16px;padding: 10px;">' . $this->l('Analytics Data Updated, please refresh the admin panel.') . '</div>';
            die;
        }
    }
    
    /*
     * function added by Anshul to get abandoned cart list using the same logic which is used to fetch Abandoned carts for sending mails
     * Only changed hours parameters to seconds
     * Feature: Push Notification (Jan 2020)
     * return array
     */
    public function getAbandonedCart($AbandonedCartDelay)
    {
        $settings = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        $delay_abandoned_cart_update = (int) $settings['delay_hours'] + (24 * (int) $settings['delay_days']);
        $delay_abandoned_cart_update = $delay_abandoned_cart_update * 60 * 60;
        if ($delay_abandoned_cart_update > $AbandonedCartDelay) {
            $delay_in_hrs = $delay_abandoned_cart_update;
            $abd_query = 'select abd.* from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME .
                    ' as abd INNER JOIN ' . _DB_PREFIX_ . 'cart_product as cp on (abd.id_cart = cp.id_cart)
                                    LEFT JOIN ' . _DB_PREFIX_ . 'customer as c on (abd.id_customer = c.id_customer)
                                    where (abd.is_converted = "0" AND abd.shows = "1" AND abd.auto_email = "1"
                                    AND abd.id_shop = ' . (int) $this->context->shop->id . '
                                    AND abd.date_upd <= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                            $delay_in_hrs . ' seconds'))) . '"
                AND abd.date_upd >= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                                ($delay_in_hrs + 3600) . ' seconds'))) . '")';
        } else {
            $abd_query = 'select abd.* from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME .
                    ' as abd INNER JOIN ' . _DB_PREFIX_ . 'cart_product as cp on (abd.id_cart = cp.id_cart)
                                LEFT JOIN ' . _DB_PREFIX_ . 'customer as c on (abd.id_customer = c.id_customer)
                                where (abd.is_converted = "0" AND abd.shows = "1" AND abd.auto_email = "1"
                                AND abd.id_shop = ' . (int) $this->context->shop->id . '
                                AND abd.date_upd <= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                            $AbandonedCartDelay . ' seconds'))) . '"
            AND abd.date_upd >= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                            ($AbandonedCartDelay + 3600) . ' seconds'))) . '")';
        }
        $abd_carts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($abd_query);
        return $abd_carts;
    }

    /*
     * Function Modified by RS on 06-Sept-2017 for solving the problem of time delay on cron run when there are a lot of carts (changed the query in $abd_query variable)
     * Added the logic to process carts for sending emails on hourly basis, the logic will now pick the carts that qualifies the delay for the last hour only.
     */
    public function sendAutomaticIncentiveMails($triggered_from = false, $cron_type = null)
    {
             
        /* Start - Code Added by RS on 06-Sept-2017 for adding the memory limit and time limit before executing the code so that it doesn't times out */
        ini_set("memory_limit", "-1");
        set_time_limit(10000);
        /* End - Code Added by RS on 06-Sept-2017 for adding the memory limit and time limit before executing the code so that it doesn't times out */
        /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        $save_time = date('Y-m-d H:i:s', time());
        $send_emails = $this->l("Send_Mails");
        $progress = $this->l("Progress");
        $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_TABLE_NAME . ' 
                    (name, type, status, start_time, 
                    end_time, date_add, date_upd) values("'
                . pSQL($send_emails) . '", "'
                . pSQL($cron_type) . '", "'
                . pSQL($progress) . '", "'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '","'
                . pSQL($save_time) . '")';

        $is_save = Db::getInstance()->execute($query);
        $id_cron = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
        /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/

        $settings = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        $delay_abandoned_cart_update = (int) $settings['delay_hours'] + (24 * (int) $settings['delay_days']);
        if ($triggered_from) {
            if ($settings['enable'] == 1) {
                if ($settings['schedule'] != 1) {
                    echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'.
                        $this->l('`Enable Auto Email` setting has to be enabled to use this functionality.') . '</div>';
                    die;
                }
            } else {
                echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'.
                    $this->l('Please enable the Abandoned Cart module first.') . '</div>';
                die;
            }
        }
        $query = 'Select * from ' . _DB_PREFIX_ . self::INCENTIVE_TABLE_NAME .
                ' WHERE status = ' . (int) parent::INCENTIVE_ENABLE . '
			ORDER by delay_days DESC, delay_hrs DESC';

        $discounts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        $mails_sent = 0;
        if (count($discounts) > 0) {
            $abandon_id_to_be_skipped = array();
            foreach ($discounts as $discount) {
                $delay_in_hrs = (24 * (int) $discount['delay_days']) + (int) $discount['delay_hrs'];
                if ($delay_abandoned_cart_update > $delay_in_hrs) {
                    $delay_in_hrs = $delay_abandoned_cart_update;
                    //changes by tarun to find only those customer abandoned cart who are subscribed
                    $abd_query = 'select abd.* from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME .
                            ' as abd INNER JOIN ' . _DB_PREFIX_ . 'cart_product as cp on (abd.id_cart = cp.id_cart)
                                            LEFT JOIN ' . _DB_PREFIX_ . 'customer as c on (abd.id_customer = c.id_customer)
                                            where (abd.is_converted = "0" AND abd.shows = "1" AND abd.auto_email = "1"
                                            AND abd.id_shop = ' . (int) $this->context->shop->id . '
                                            AND abd.date_upd <= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                                    $delay_in_hrs . ' hours'))) . '"
                        AND abd.date_upd >= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                                        ($delay_in_hrs + 1) . ' hours'))) . '")';
                } else {
                    $abd_query = 'select abd.* from ' . _DB_PREFIX_ . self::ABANDON_TABLE_NAME .
                            ' as abd INNER JOIN ' . _DB_PREFIX_ . 'cart_product as cp on (abd.id_cart = cp.id_cart)
					LEFT JOIN ' . _DB_PREFIX_ . 'customer as c on (abd.id_customer = c.id_customer)
					where (abd.is_converted = "0" AND abd.shows = "1" AND abd.auto_email = "1"
					AND abd.id_shop = ' . (int) $this->context->shop->id . '
					AND abd.date_upd <= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                                    $delay_in_hrs . ' hours'))) . '"
                    AND abd.date_upd >= "' . pSQL(date('Y-m-d H:i:s', strtotime('-' .
                                                    ($delay_in_hrs + 1) . ' hours'))) . '")';
                }
                $abd_carts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($abd_query);
                //changes over
                if (count($abd_carts) > 0) {
                    foreach ($abd_carts as $abd_cart) {
                        $cart_temp = new Cart($abd_cart['id_cart']);
                        if ($cart_temp->getOrderTotal() > $discount['min_cart_value_for_mails']) {
                            if (empty($abd_cart['id_customer']) || $abd_cart['id_customer'] == 0) {
                                if ($discount['incentive_type'] == self::NON_DISCOUNT_EMAIL) {
                                    $fetch_qry = 'select firstname, lastname, email from ' . _DB_PREFIX_
                                            . self::ABD_TRACK_CUSTOMERS_TABLE_NAME . ' where id_cart = ' .
                                            (int) $abd_cart['id_cart'];
                                    $user_data = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($fetch_qry);
                                    if (!$user_data) {
                                        continue;
                                    }
                                } else {
                                    continue;
                                }
                            }

                            if (in_array($abd_cart['id_abandon'], $abandon_id_to_be_skipped)) {
                                continue;
                            }

                            $check_incentive_status = 'select * from ' . _DB_PREFIX_ .
                                    self::INCENTIVE_MAPPING_TABLE_NAME .
                                    ' where id_cart = ' . (int) $abd_cart['id_cart'] . ' and
								id_incentive = ' . (int) $discount['id_incentive'];

                            $already_sent = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_incentive_status);
                            if (is_array($already_sent) && count($already_sent) > 0) {
                                continue;
                            }

                            $abandon_id_to_be_skipped[] = $abd_cart['id_abandon'];
                            $data = array();
                            if (!empty($discount['id_template']) && $discount['id_template'] > 0) {
                                $template_sql = 'SELECT * from ' . _DB_PREFIX_ . parent::TEMPLATE_CONTENT_TABLE_NAME .
                                        ' where id_template = ' . (int) $discount['id_template'] . ' AND id_lang = ' .
                                        (int) $abd_cart['id_lang'];
                                $template = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($template_sql);
                                if (is_array($template) && count($template) > 0) {
                                    $data['subject'] = Tools::htmlentitiesDecodeUTF8($template['subject']);
                                    $data['body'] = Tools::htmlentitiesDecodeUTF8($template['body']);
                                    $data['cart_template'] = $template['cart_template'];
                                } else {
                                    $data['subject'] = Tools::htmlentitiesDecodeUTF8(parent::DEFAULT_TEMPLATE_SUBJECT);
                                    $data['body'] = Tools::htmlentitiesDecodeUTF8($this->getDefaultEmailTemplate(1));
                                    $data['cart_template'] = 1;
                                }
                            } else {
                                $data['subject'] = Tools::htmlentitiesDecodeUTF8(parent::DEFAULT_TEMPLATE_SUBJECT);
                                $data['body'] = Tools::htmlentitiesDecodeUTF8($this->getDefaultEmailTemplate(1));
                                $data['cart_template'] = 1;
                            }
                            $mail_sent = false;
                            //changes by tarun to not send mails to unsubscribed customer
                            if ($abd_cart['id_customer'] != 0) {
                                $customer = new Customer($abd_cart['id_customer']);
                                $data['customer_email'] = $customer->email;
                                $data['customer_fname'] = $customer->firstname;
                                $data['customer_lname'] = $customer->lastname;
                                $data['customer_secure_key'] = $customer->secure_key;
                                unset($customer);
                            } else {
                                $fetch_qry = 'select firstname, lastname, email from ' . _DB_PREFIX_
                                        . self::ABD_TRACK_CUSTOMERS_TABLE_NAME . ' where id_cart = ' . (int) $data['id_cart'];
                                $user_data = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($fetch_qry);
                                if ($user_data && count($user_data) > 0) {
                                    $data['customer_fname'] = ($user_data['firstname'] != '' && $user_data['lastname'] != '')
                                        ? $user_data['firstname'] : '';
                                    $data['customer_lname'] = ($user_data['firstname'] != '' && $user_data['lastname'] != '')
                                        ? $user_data['lastname'] : '';
                                    $data['customer_email'] = $user_data['email'];
                                    $data['customer_secure_key'] = 'none';
                                } else {
                                    continue;
                                }
                                unset($user_data);
                            }
                            $is_exist_sql = 'Select count(*) as row from ' . _DB_PREFIX_ . parent::UNSUBSCRIBE_TABLE_NAME .
                                        ' where email = "' . pSQL($data['customer_email']) . '" AND send_email = "0" ';
                            $is_exist = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($is_exist_sql);
                            if (!is_array($is_exist) || $is_exist['row'] <= 0) {
                            } else {
                                continue;
                            }
                            //Changes over
                            if ($discount['incentive_type'] == self::DISCOUNT_EMAIL) {
                                $data['id_customer'] = $abd_cart['id_customer'];
                                $data['discount_type'] = $discount['discount_type'];
                                $data['discount_value'] = $discount['discount_value'];
                                $data['id_cart'] = $abd_cart['id_cart'];
                                $data['min_cart_value'] = $discount['min_cart_value'];
                                $data['coupon_validity'] = $discount['coupon_validity'];
                                $data['has_free_shipping'] = $discount['has_free_shipping'];
                                $data['id_abandon'] = $abd_cart['id_abandon'];
                                $data['id_lang'] = $abd_cart['id_lang'];
                                $mail_sent = $this->sendDiscountEmail($data, false);
                            } elseif ($discount['incentive_type'] == self::NON_DISCOUNT_EMAIL) {
                                $data['id_customer'] = $abd_cart['id_customer'];
                                $data['id_cart'] = $abd_cart['id_cart'];
                                $data['id_abandon'] = $abd_cart['id_abandon'];
                                $data['id_lang'] = $abd_cart['id_lang'];
                                $mail_sent = $this->sendReminder($data, false);
                            }
                            if ($mail_sent) {
                                /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
                                $customer = new Customer((int) $data['id_customer']);
                                if (!empty($customer->email)) {
                                    $cust_email = $customer->email;
                                } else {
                                    $cust_email = $this->l('No email is present');
                                }
                                $query = 'INSERT INTO ' . _DB_PREFIX_ . self::CRON_DETAIL_TABLE_NAME . ' 
                                        (id_cron, email_id, cart_id, date_add, date_upd) values('
                                        . (int) $id_cron . ', "'
                                        . pSQL($cust_email) . '", '
                                        . (int) $data['id_cart'] . ', "'
                                        . pSQL($save_time) . '","'
                                        . pSQL($save_time) . '")';

                                Db::getInstance()->execute($query);
                                /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
                                if ((int) $mail_sent == -1) {
                                    continue;
                                }

                                $quantity = Db::getInstance()->getRow('select SUM(quantity) as total from '
                                        . _DB_PREFIX_ . 'cart_product where id_cart=' . (int) $abd_cart['id_cart']);

                                $sql = 'INSERT INTO ' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME . ' (id_cart,
								id_customer, id_incentive, quantity, date_add) values('
                                        . (int) $abd_cart['id_cart'] . ',' . (int) $abd_cart['id_customer'] . ',
								' . (int) $discount['id_incentive'] . ', ' . (int) $quantity['total'] . ', now())';
                                Db::getInstance()->execute($sql);

                                $less_delay_inc = $this->getIncentivesHavingLessDelay($discount['id_incentive'], $delay_in_hrs);
                                if (count($less_delay_inc) > 0) {
                                    foreach ($less_delay_inc as $less_inc) {
                                        $check_inc_status = 'select * from ' . _DB_PREFIX_ .
                                                self::INCENTIVE_MAPPING_TABLE_NAME .
                                                ' where id_cart = ' . (int) $abd_cart['id_cart'] . ' and
                                            id_incentive = ' . (int) $less_inc;

                                        $inc_sent = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($check_inc_status);
                                        if (is_array($inc_sent) && count($inc_sent) > 0) {
                                            continue;
                                        }
                                        $sql = 'INSERT INTO ' . _DB_PREFIX_ . self::INCENTIVE_MAPPING_TABLE_NAME . ' (id_cart,
                                        id_customer, id_incentive, quantity, date_add) values('
                                                . (int) $abd_cart['id_cart'] . ',' . (int) $abd_cart['id_customer'] . ',
                                        ' . (int) $less_inc . ', ' . (int) $quantity['total'] . ', now())';
                                        Db::getInstance()->execute($sql);
                                    }
                                }
                                echo '<div class="text_to_show" style="font-size:14px;padding: 5px;">' .
                                $this->l('Mail Successfully Sent to Customer')
                                . ' (id #' . $abd_cart['id_customer'] . ') </div><br>';
                                $mails_sent++;
                            }
                        }
                    }
                }
            }
        }
        /*Start - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        $end_time = date('Y-m-d H:i:s', time());
        $comp = $this->l("Completed");
        $query = 'UPDATE ' . _DB_PREFIX_ . self::CRON_TABLE_NAME
                    . ' set status = "' . pSQL($comp) . '", 
                    end_time = "' . pSQL($end_time) . '", date_upd="'.pSQL($end_time).'" WHERE id_cron = ' . (int) $id_cron;
  
            
        Db::getInstance()->execute($query);
        /*End - Code added by Shubham to make entry for cron log (Feature: Cron Log (Jan 2020))*/
        
        echo '<div class="text_to_show" style="font-size:16px;padding: 5px;">'
        . $this->l('Total') . ' ' . $mails_sent . ' ' . $this->l('Mails sent successfully.') . '</div>';
        die;
    }

    /*
     * Function Modified by RS on 07-Sept-2017 to Optimize the Analytics Process
     */
    public function graph($from, $to)
    {
        $data = array();
        ////changes by tarun to fix the date filter issue
        $from = date("Y-m-d", strtotime($from));
        $to = date("Y-m-d", strtotime($to));
        //changes over
        $data_form = Tools::unSerialize(Configuration::get('VELSOF_ABANDONEDCART'));
        $total_delay = $data_form['delay_hours'] + (24 * $data_form['delay_days']);
        $delay_date = date('Y-m-d H:i:s', strtotime('-' . $total_delay . ' hours'));

        $velsof_abandoncart_start_date = (Configuration::get('VELSOF_ABANDONEDCART_START_DATE'));

        $start_datetime = strtotime($from);

        $end_datetime = strtotime($to);

        $from_date = explode('-', $from);
        $to_date = explode('-', $to);

        $range = '';
        if ($from_date[0] == $to_date[0] && $from_date[1] == $to_date[1] && $from_date[2] == $to_date[2]) {
            $range = 'hour';
        } elseif ($from_date[0] == $to_date[0] && $from_date[1] == $to_date[1]) {
            $range = 'day';
        } elseif ($from_date[0] == $to_date[0]) {
            $range = 'month';
        } else {
            $range = 'year';
        }
        $filter_string = '';
        switch ($range) {
            case 'hour':
                $data['stats']['type'] = 'Hour';
                $data['stats']['from'] = $from;
                $data['stats']['to'] = $to;
                $date = date('Y-m-d', strtotime($from));
                for ($i = 0; $i < 24; $i++) {
                    $filter_string = ' and date_upd > "' . pSQL($velsof_abandoncart_start_date) . '"
					and HOUR(date_upd) ="' . (int) $i . '"
					and date(date_upd) between "' . pSQL($from) . '" and "' . pSQL($to) . '"
					and date_upd < "' . pSQL($delay_date) . '"';

                    $total_carts = $this->getCartsBasedOnFilters($filter_string);
                    $total_cart_abandon = 0;
                    $total_cart_converted = 0;
                    $total_abandon = 0;
                    $total_converted = 0;
                    foreach ($total_carts as $cart) {
                        if ((int) $cart['is_converted'] == 1) {
                            /*
                             * Start: Added By Anshul to fix the analytic stats issue
                             */
                            $sql = 'SELECT total_paid FROM '._DB_PREFIX_.'orders WHERE id_cart = '.(int)$cart['id_cart'];
                            $total_converted += (float) DB::getInstance()->getValue($sql);
                            /*
                             * End: Added By Anshul to fix the analytic stats issue
                             */
                            $total_cart_converted++;
                        } elseif ((int) $cart['is_converted'] == 0) {
                            $total_abandon += (float) $cart['cart_total'];
                            $total_cart_abandon++;
                        }
                    }
                    if ($total_cart_abandon) {
                        $data['stats']['abandon_carts'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            $total_cart_abandon
                        );
                    } else {
                        $data['stats']['abandon_carts'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            0
                        );
                    }
                    if ($total_cart_converted) {
                        $data['stats']['converted_carts'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            $total_cart_converted
                        );
                    } else {
                        $data['stats']['converted_carts'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            0
                        );
                    }
                    if ($total_abandon) {
                        $data['stats']['abandon_amount'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            $total_abandon
                        );
                    } else {
                        $data['stats']['abandon_amount'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            0
                        );
                    }
                    if ($total_converted) {
                        $data['stats']['converted_amount'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            $total_converted
                        );
                    } else {
                        $data['stats']['converted_amount'][] = array(
                            date('h A', mktime($i, 0, 0, date('n'), date('j'), date('Y'))),
                            0
                        );
                    }
                }
                break;

            case 'day':
                $data['stats']['type'] = 'Day';
                for ($i = date('d', $start_datetime); $i <= date('d', $end_datetime); $i++) {
                    $date = date('Y', $start_datetime) . '-' . date('m', $start_datetime) . '-' . $i;
                    $filter_string = 'and date_upd > "' . pSQL($velsof_abandoncart_start_date) . '"
					and DATE(date_upd) ="' . pSQL($date) . '"
					and date(date_upd) between "' . pSQL($from) . '" and "' . pSQL($to) . '"
					and date_upd < "' . pSQL($delay_date) . '"';

                    $total_carts = $this->getCartsBasedOnFilters($filter_string);
                    $total_cart_abandon = 0;
                    $total_cart_converted = 0;
                    $total_abandon = 0;
                    $total_converted = 0;
                    foreach ($total_carts as $cart) {
                        if ((int) $cart['is_converted'] == 1) {
                            $sql = 'SELECT total_paid FROM '._DB_PREFIX_.'orders WHERE id_cart = '.(int)$cart['id_cart'];
                            $total_converted += (float) DB::getInstance()->getValue($sql);
                            $total_cart_converted++;
                        } elseif ((int) $cart['is_converted'] == 0) {
                            $total_abandon += (float) $cart['cart_total'];
                            $total_cart_abandon++;
                        }
                    }
                    if ($total_cart_abandon) {
                        $data['stats']['abandon_carts'][] = array(date('M j', strtotime($date)), $total_cart_abandon);
                    } else {
                        $data['stats']['abandon_carts'][] = array(date('M j', strtotime($date)), 0);
                    }
                    if ($total_cart_converted) {
                        $data['stats']['converted_carts'][] = array(date('M j', strtotime($date)), $total_cart_converted);
                    } else {
                        $data['stats']['converted_carts'][] = array(date('M j', strtotime($date)), 0);
                    }
                    if ($total_abandon) {
                        $data['stats']['abandon_amount'][] = array(
                            date('M j', strtotime($date)),
                            $total_abandon
                        );
                    } else {
                        $data['stats']['abandon_amount'][] = array(date('M j', strtotime($date)), 0);
                    }
                    if ($total_converted) {
                        $data['stats']['converted_amount'][] = array(date('M j', strtotime($date)), $total_converted);
                    } else {
                        $data['stats']['converted_amount'][] = array(date('M j', strtotime($date)), 0);
                    }
                }
                break;

            case 'month':
                $data['stats']['type'] = 'Month';
                for ($i = date('m', $start_datetime); $i <= date('m', $end_datetime); $i++) {
                    $date = date('Y', $start_datetime) . '-' . date('m', $start_datetime) . '-' . $i;
//                    $date = '2019-12-12';
                    $filter_string = 'and date_upd > "' . pSQL($velsof_abandoncart_start_date) . '"
					and YEAR(date_upd) = "' . pSQL(date('Y', $start_datetime)) . '" AND MONTH(date_upd) = "' .
                    (int) $i . '"
					and date(date_upd) between "' . pSQL($from) . '" and "' . pSQL($to) . '"
					and date_upd < "' . pSQL($delay_date) . '"';

                    $total_carts = $this->getCartsBasedOnFilters($filter_string);
                    $total_cart_abandon = 0;
                    $total_cart_converted = 0;
                    $total_abandon = 0;
                    $total_converted = 0;
                    foreach ($total_carts as $cart) {
                        if ((int) $cart['is_converted'] == 1) {
                            $sql = 'SELECT total_paid FROM '._DB_PREFIX_.'orders WHERE id_cart = '.(int)$cart['id_cart'];
                            $total_converted += (float) DB::getInstance()->getValue($sql);
                            $total_cart_converted++;
                        } elseif ((int) $cart['is_converted'] == 0) {
                            $total_abandon += (float) $cart['cart_total'];
                            $total_cart_abandon++;
                        }
                    }
                    if ($total_cart_abandon) {
                        $data['stats']['abandon_carts'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            $total_cart_abandon
                        );
                    } else {
                        $data['stats']['abandon_carts'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            0
                        );
                    }
                    if ($total_cart_converted) {
                        $data['stats']['converted_carts'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            $total_cart_converted
                        );
                    } else {
                        $data['stats']['converted_carts'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            0
                        );
                    }
                    if ($total_abandon) {
                        $data['stats']['abandon_amount'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            $total_abandon
                        );
                    } else {
                        $data['stats']['abandon_amount'][] = array(date('M', mktime(0, 0, 0, $i, 1, date('Y'))), 0);
                    }
                    if ($total_converted) {
                        $data['stats']['converted_amount'][] = array(
                            date('M', mktime(0, 0, 0, $i, 1, date('Y'))),
                            $total_converted);
                    } else {
                        $data['stats']['converted_amount'][] = array(date('M', mktime(0, 0, 0, $i, 1, date('Y'))), 0);
                    }
                }
                break;
            case 'year':
                $data['stats']['type'] = 'Year';
                for ($i = date('Y', $start_datetime); $i <= date('Y', $end_datetime); $i++) {
                    $filter_string = 'and date_upd > "' . pSQL($velsof_abandoncart_start_date) . '"
					and  YEAR(date_upd) = "' . (int) $i . '"
					and date(date_upd) between "' . pSQL($from) . '" and "' . pSQL($to) . '"
					and date_upd < "' . pSQL($delay_date) . '"';

                    $total_carts = $this->getCartsBasedOnFilters($filter_string);
                    $total_cart_abandon = 0;
                    $total_cart_converted = 0;
                    $total_abandon = 0;
                    $total_converted = 0;
                    foreach ($total_carts as $cart) {
                        if ((int) $cart['is_converted'] == 1) {
                            $sql = 'SELECT total_paid FROM '._DB_PREFIX_.'orders WHERE id_cart = '.(int)$cart['id_cart'];
                            $total_converted += (float) DB::getInstance()->getValue($sql);
                            $total_cart_converted++;
                        } elseif ((int) $cart['is_converted'] == 0) {
                            $total_abandon += (float) $cart['cart_total'];
                            $total_cart_abandon++;
                        }
                    }
                    if ($total_cart_abandon) {
                        $data['stats']['abandon_carts'][] = array($i, $total_cart_abandon);
                    } else {
                        $data['stats']['abandon_carts'][] = array($i, 0);
                    }
                    if ($total_cart_converted) {
                        $data['stats']['converted_carts'][] = array($i, $total_cart_converted);
                    } else {
                        $data['stats']['converted_carts'][] = array($i, 0);
                    }
                    if ($total_abandon) {
                        $data['stats']['abandon_amount'][] = array($i, $total_abandon);
                    } else {
                        $data['stats']['abandon_amount'][] = array($i, 0);
                    }
                    if ($total_converted) {
                        $data['stats']['converted_amount'][] = array($i, $total_converted);
                    } else {
                        $data['stats']['converted_amount'][] = array($i, 0);
                    }
                }
                break;
        }
        return $data;
    }

    public function getModuleTranslationByLanguage($module, $string, $source, $language, $sprintf = null, $js = false)
    {
        $modules = array();
        $langadm = array();

        $translations_merged = array();
        $name = $module instanceof Module ? $module->name : $module;
        if (!isset($translations_merged[$name]) && isset(Context::getContext()->language)) {
            $files_by_priority = array(
                _PS_MODULE_DIR_ . $name . '/translations/' . $language . '.php'
            );

            foreach ($files_by_priority as $file) {
                if (file_exists($file)) {
                    include($file);
                    /* No need to define $_MODULE as it is defined in the above included file.*/
                    $modules = $_MODULE;
                    $translations_merged[$name] = true;
                }
            }
        }

        $string = preg_replace("/\\\*'/", "\'", $string);
        $key = md5($string);

        if ($modules == null) {
            if ($sprintf !== null) {
                $string = Translate::checkAndReplaceArgs($string, $sprintf);
            }

            return str_replace('"', '&quot;', $string);
        }

        $current_key = Tools::strtolower('<{' . $name . '}' . _THEME_NAME_ . '>' . $source) . '_' . $key;
        $default_key = Tools::strtolower('<{' . $name . '}prestashop>' . $source) . '_' . $key;

        if ('controller' == Tools::substr($source, -10, 10)) {
            $file = Tools::substr($source, 0, -10);
            $current_key_file = Tools::strtolower('<{' . $name . '}' . _THEME_NAME_ . '>' . $file) . '_' . $key;
            $default_key_file = Tools::strtolower('<{' . $name . '}prestashop>' . $file) . '_' . $key;
        }

        if (isset($current_key_file) && !empty($modules[$current_key_file])) {
            $ret = Tools::stripslashes($modules[$current_key_file]);
        } elseif (isset($default_key_file) && !empty($modules[$default_key_file])) {
            $ret = Tools::stripslashes($modules[$default_key_file]);
        } elseif (!empty($modules[$current_key])) {
            $ret = Tools::stripslashes($modules[$current_key]);
        } elseif (!empty($modules[$default_key])) {
            $ret = Tools::stripslashes($modules[$default_key]);
        } elseif (!empty($langadm)) {
            $ret = Tools::stripslashes(Translate::getGenericAdminTranslation($string, $key, $langadm));
        } else {
            $ret = Tools::stripslashes($string);
        }

        if ($sprintf !== null) {
            $ret = Translate::checkAndReplaceArgs($ret, $sprintf);
        }

        if ($js) {
            $ret = addslashes($ret);
        } else {
            $ret = htmlspecialchars($ret, ENT_COMPAT, 'UTF-8');
        }
        return $ret;
    }

    /*
     * Function added by RS on 07-Sept-2017 for adding additional translations to language file.
     */
    public function includeAdditionalTranslations()
    {
        $this->l('Direct Checkout');
    }
    public function genrateTransalation()
    {
        $this->l('Direct Checkout');
        $this->l('YOUR BASKET');
        $this->l('IMAGE');
        $this->l('DESCRIPTION');
        $this->l('QUANTITY');
        $this->l('PRICE');
        $this->l('Items In Your Cart...');
        $this->l('View Cart');
        $this->l('Your Cart Items');
        $this->l('Items In Your Cart');
        $this->l('ITEMS IN YOUR CART');
        $this->l('View More');
        $this->l('Items In Your Cart');
        $this->l('Qunatity');
        $this->l('Price');
    }
}
