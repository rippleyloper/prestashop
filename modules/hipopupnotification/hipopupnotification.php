<?php
/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
* @version   1.0.6
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(dirname(__FILE__).'/classes/HiPrestaModule.php');
include_once(dirname(__FILE__).'/classes/popupnotification.php');
include_once(dirname(__FILE__).'/classes/popupseparatecontent.php');
include_once(dirname(__FILE__).'/classes/newsletteruser.php');
include_once(dirname(__FILE__).'/classes/popupsocialconnectuser.php');


class HiPopupNotification extends Module
{
    public $psv;
    public $errors = array();
    public $success = array();
    public $clean_db;
    public $gdpr_checkbox;
    public $gdpr_content;
    public $social_redirect;
    public $module_hooks = array();

    /*Design Settings*/
    public $popup_template;

    /*Newslatter*/
    public $nl_send_voucher_email;
    public $nl_terms_url;
    public $nl_voucher_code;
    public $nl_popup_description;
    /*Responsive*/
    public $enable_responsive;
    public $responsive_resize_start_point;
    public $responsive_hide_start_point;
    /*Login and register*/
    public $log_reg_enable;
    public $log_reg_login_enable;
    public $log_reg_register_enable;
    public $log_reg_terms_url;
    public $log_reg_background_image;
    public $log_reg_background_repeat;
    /*Facebook*/
    public $sc_enable_facebook;
    public $sc_facebook_position_top;
    public $sc_facebook_position_left;
    public $sc_facebook_position_right;
    public $sc_facebook_position_custom;
    public $sc_facebook_button_size_top;
    public $sc_facebook_button_size_left;
    public $sc_facebook_button_size_right;
    public $sc_facebook_app_id;
    /*Twitter*/
    public $sc_enable_twitter;
    public $sc_twitter_position_top;
    public $sc_twitter_position_left;
    public $sc_twitter_position_right;
    public $sc_twitter_position_custom;
    public $sc_twitter_button_size_top;
    public $sc_twitter_button_size_left;
    public $sc_twitter_button_size_right;
    public $sc_twitter_key;
    public $sc_twitter_secret;
    /*Google*/
    public $sc_enable_google;
    public $sc_google_position_top;
    public $sc_google_position_left;
    public $sc_google_position_right;
    public $sc_google_position_custom;
    public $sc_google_button_size_top;
    public $sc_google_button_size_left;
    public $sc_google_button_size_right;
    public $sc_google_id;

    public function __construct()
    {
        $this->name = 'hipopupnotification';
        $this->tab = 'front_office_features';
        $this->version = '1.0.6';
        $this->author = 'hipresta';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        if ((float)Tools::substr(_PS_VERSION_, 0, 3) >= 1.6) {
            $this->bootstrap = true;
        }
        $this->module_key = '34f6d1e1e0b1f3ffa5773ae48762bf7b';
        $this->author_address = '0xf5655d2008293E524dF46426b60893806f12c8B0';
        parent::__construct();
        $this->globalVars();
        $this->displayName = $this->l('Popup Notification');
        $this->description = $this->l('Create unlimited popups');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->HiPrestaClass = new HiPrestaPopupNOTModule($this);
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        if (!parent::install()
            || !$this->installDb()
            || !$this->registerHook('header')
            || !$this->registerHook('home')
            || !$this->registerHook('rightColumn')
            || !$this->registerHook('leftColumn')
            || !$this->registerHook('displayNav')
            || !$this->registerHook('displayNav2')
            || !$this->registerHook('footer')
            || !$this->registerHook('higdpr')
            || !$this->registerHook('hipopupnotification')
            || !$this->registerHook('hipopupfacebookconnect')
            || !$this->registerHook('hipopuptwitterconnect')
            || !$this->registerHook('hipopupgoogleconnect')
            // || !$this->registerHook('registerGDPRConsent')
            || !$this->registerHook('actionDeleteGDPRCustomer')
            || !$this->registerHook('actionExportGDPRData')
            || !Configuration::updateValue('CLEAN_HI_POPNOT', false)
            || !$this->HiPrestaClass->createTabs('AdminPopupNotification', 'AdminPopupNotification', 'CONTROLLER_TABS_HI_POPNOT', 0)
            ) {
                return false;
        }
        $this->proceedDb();
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }
        $this->HiPrestaClass->deleteTabs('CONTROLLER_TABS_HI_POPNOT');
        if (Configuration::get('CLEAN_HI_POPNOT')) {
            $this->proceedDb(true);
        }
        return true;
    }

    private function installDb()
    {
        $res = (bool)Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'hipopupnotification` (
                `id_hipopupnotification` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `active` TINYINT NOT NULL,
                `popup_type` varchar (100) NOT NULL,
                `width` INT(10) NOT NULL,
                `height` INT(10) NOT NULL,
                `content_type` varchar (100) NOT NULL,
                `content` text,
                `background_image` varchar (255) NOT NULL,
                `background_repeat` varchar (100) NOT NULL,
                `cookie_time` varchar (100) NOT NULL,
                `auto_close_time` varchar (100) NOT NULL,
                `delay_time` varchar (100) NOT NULL,
                `animation` varchar (100) NOT NULL,
                `date_start` date NOT NULL,
                `date_end` date NOT NULL,
                PRIMARY KEY (`id_hipopupnotification`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        $res &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'hipopupnotification_lang` (
                `id_hipopupnotification` int(10) unsigned NOT NULL,
                `id_lang` int(10) unsigned NOT NULL,
                `content_lang` text,
              PRIMARY KEY (`id_hipopupnotification`,`id_lang`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        $res &= Db::getInstance()->Execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'hinewslettervoucher` (
              `id_hinewslettervoucher` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `customer_id` int(11) NOT NULL,
              `first_name` varchar(255) NOT NULL,
              `last_name` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `code` varchar(255) NOT NULL,
              `date_end` datetime NOT NULL,
              `used` int NOT NULL,
              PRIMARY KEY (`id_hinewslettervoucher`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        $res &= Db::getInstance()->Execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'hipopupsocialconnectuser` (
               `id_hipopupsocialconnectuser` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `social_network` VARCHAR (100) NOT NULL,
               `screen_name` VARCHAR (255) NOT NULL,
               `id_user` VARCHAR (250) NOT NULL,
               `first_name` VARCHAR (100) NOT NULL,
               `last_name` VARCHAR (100) NOT NULL,
               `email` VARCHAR (100) NOT NULL,
               `gender` VARCHAR (100) NOT NULL,
               `date_add` DATE NOT NULL,
               PRIMARY KEY ( `id_hipopupsocialconnectuser` )
            ) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        $res &= Db::getInstance()->Execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'hipopup_separate_content` (
               `id` INT NOT NULL AUTO_INCREMENT ,
               `id_popup` int(10) NOT NULL,
               `id_selector` int(10) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        return $res;
    }

    private function proceedDb($drop = false)
    {
        if (!$drop) {
            Configuration::updateValue('CLEAN_HI_POPNOT', false);
            Configuration::updateValue('HI_POPNOT_GDPR_CHECKBOX', false);
            foreach (Language::getLanguages(false) as $lang) {
                Configuration::updateValue('HI_POPNOT_GDPR_CONTENT', array($lang['id_lang'] => 'I agree to the general data protection regulation.'));
            }
            Configuration::updateValue('HI_PN_SC_REDIRECT', 'no_redirect');
            /*Design settings*/
            Configuration::updateValue('HI_PN_TEMPLATE', 'default');
            /*Newsletter*/
            Configuration::updateValue('HI_PN_NL_SEND_VOUCHER_EMAIL', false);
            Configuration::updateValue('HI_PN_NL_TERMS_URL', '');
            Configuration::updateValue('HI_PN_NL_VOUCHER_CODE', '');
            foreach (Language::getLanguages(false) as $lang) {
                Configuration::updateValue('HI_PN_NL_DESC', array($lang['id_lang'] => 'Your voucher code is {code}'));
            }
            /*Responsive*/
            Configuration::updateValue('HI_PN_RES_ENABLE', true);
            Configuration::updateValue('HI_PN_RES_START_POINT', '768');
            Configuration::updateValue('HI_PN_RES_HIDE_START_POINT', '0');
            /*Login and register*/
            Configuration::updateValue('HI_PN_LGRE_ENABLE', false);
            Configuration::updateValue('HI_PN_LGRE_LOGIN_ENABLE', true);
            Configuration::updateValue('HI_PN_LGRE_REGISTER_ENABLE', true);
            Configuration::updateValue('HI_PN_LGRE_TERMS_URL', '');
            Configuration::updateValue('HI_PN_LGRE_BG_IMAGE', '');
            Configuration::updateValue('HI_PN_LGRE_BG_REPEAT', 'no-repeat');
            /*Facebook*/
            Configuration::updateValue('HI_PN_SCF_ENABLE', false);
            Configuration::updateValue('HI_PN_SCF_POSITION_TOP', false);
            Configuration::updateValue('HI_PN_SCF_POSITION_LEFT', false);
            Configuration::updateValue('HI_PN_SCF_POSITION_RIGHT', false);
            Configuration::updateValue('HI_PN_SCF_POSITION_CUSTOM', false);
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_TOP', 'small');
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_LEFT', 'big');
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_RIGHT', 'big');
            Configuration::updateValue('HI_PN_SCF_APP_ID', '');
            /*Twitter*/
            Configuration::updateValue('HI_PN_SCT_ENABLE', false);
            Configuration::updateValue('HI_PN_SCT_POSITION_TOP', false);
            Configuration::updateValue('HI_PN_SCT_POSITION_LEFT', false);
            Configuration::updateValue('HI_PN_SCT_POSITION_RIGHT', false);
            Configuration::updateValue('HI_PN_SCT_POSITION_CUSTOM', false);
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_TOP', 'small');
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_LEFT', 'big');
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_RIGHT', 'big');
            Configuration::updateValue('HI_PN_SCT_KEY', '');
            Configuration::updateValue('HI_PN_SCT_SECRET', '');
            /*Google*/
            Configuration::updateValue('HI_PN_SCG_ENABLE', false);
            Configuration::updateValue('HI_PN_SCG_POSITION_TOP', false);
            Configuration::updateValue('HI_PN_SCG_POSITION_LEFT', false);
            Configuration::updateValue('HI_PN_SCG_POSITION_RIGHT', false);
            Configuration::updateValue('HI_PN_SCG_POSITION_CUSTOM', false);
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_TOP', 'small');
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_LEFT', 'big');
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_RIGHT', 'big');

            Configuration::updateValue('HI_PN_SCG_ID', '');
        } else {
            Configuration::deleteByName('CLEAN_HI_POPNOT');
            Configuration::deleteByName('HI_POPNOT_GDPR_CHECKBOX');
            Configuration::deleteByName('HI_POPNOT_GDPR_CONTENT');
            Configuration::deleteByName('HI_PN_SC_REDIRECT');
            /*Design settings*/
            Configuration::deleteByName('HI_PN_TEMPLATE');
            /*Newsletter*/
            Configuration::deleteByName('HI_PN_NL_SEND_VOUCHER_EMAIL');
            Configuration::deleteByName('HI_PN_NL_TERMS_URL');
            Configuration::deleteByName('HI_PN_NL_VOUCHER_CODE');
            Configuration::deleteByName('HI_PN_NL_DESC');
            /*Responsive*/
            Configuration::deleteByName('HI_PN_RES_ENABLE');
            Configuration::deleteByName('HI_PN_RES_START_POINT');
            Configuration::deleteByName('HI_PN_RES_HIDE_START_POINT');
            /*Login and register*/
            Configuration::deleteByName('HI_PN_LGRE_ENABLE');
            Configuration::deleteByName('HI_PN_LGRE_LOGIN_ENABLE');
            Configuration::deleteByName('HI_PN_LGRE_REGISTER_ENABLE');
            Configuration::deleteByName('HI_PN_LGRE_TERMS_URL');
            Configuration::deleteByName('HI_PN_LGRE_BG_IMAGE');
            Configuration::deleteByName('HI_PN_LGRE_BG_REPEAT');
            /*Facebook*/
            Configuration::deleteByName('HI_PN_SCF_ENABLE');
            Configuration::deleteByName('HI_PN_SCF_POSITION_TOP');
            Configuration::deleteByName('HI_PN_SCF_POSITION_CUSTOM');
            Configuration::deleteByName('HI_PN_SCF_POSITION_LEFT');
            Configuration::deleteByName('HI_PN_SCF_POSITION_RIGHT');
            Configuration::deleteByName('HI_PN_SCF_BUTTON_SIZE_TOP');
            Configuration::deleteByName('HI_PN_SCF_BUTTON_SIZE_LEFT');
            Configuration::deleteByName('HI_PN_SCF_BUTTON_SIZE_RIGHT');
            Configuration::deleteByName('HI_PN_SCF_APP_ID');
            /*Twitter*/
            Configuration::deleteByName('HI_PN_SCT_ENABLE');
            Configuration::deleteByName('HI_PN_SCT_POSITION_TOP');
            Configuration::deleteByName('HI_PN_SCT_POSITION_CUSTOM');
            Configuration::deleteByName('HI_PN_SCT_POSITION_LEFT');
            Configuration::deleteByName('HI_PN_SCT_POSITION_RIGHT');
            Configuration::deleteByName('HI_PN_SCT_BUTTON_SIZE_TOP');
            Configuration::deleteByName('HI_PN_SCT_BUTTON_SIZE_LEFT');
            Configuration::deleteByName('HI_PN_SCT_BUTTON_SIZE_RIGHT');
            Configuration::deleteByName('HI_PN_SCT_KEY');
            Configuration::deleteByName('HI_PN_SCT_SECRET');
            /*Google*/
            Configuration::deleteByName('HI_PN_SCG_ENABLE');
            Configuration::deleteByName('HI_PN_SCG_POSITION_TOP');
            Configuration::deleteByName('HI_PN_SCG_POSITION_CUSTOM');
            Configuration::deleteByName('HI_PN_SCG_POSITION_LEFT');
            Configuration::deleteByName('HI_PN_SCG_POSITION_RIGHT');
            Configuration::deleteByName('HI_PN_SCG_BUTTON_SIZE_TOP');
            Configuration::deleteByName('HI_PN_SCG_BUTTON_SIZE_LEFT');
            Configuration::deleteByName('HI_PN_SCG_BUTTON_SIZE_RIGHT');
            Configuration::deleteByName('HI_PN_SCG_ID');


            $db_drop = array(
                'hipopupnotification',
                'hipopupnotification_lang',
                'hinewslettervoucher',
                'hipopupsocialconnectuser',
                'hipopup_separate_content',
            );
            if (!empty($db_drop)) {
                foreach ($db_drop as $value) {
                    DB::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.pSQL($value));
                }
            }
            $files = glob(_PS_MODULE_DIR_.$this->name.'/views/img/upload/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($file != _PS_MODULE_DIR_.$this->name.'/views/img/upload/index.php') {
                        unlink($file);
                    }
                }
            }
        }
    }

    private function globalVars()
    {
        $this->psv = (float)Tools::substr(_PS_VERSION_, 0, 3);
        $this->clean_db = (bool)Configuration::get('CLEAN_HI_POPNOT');
        $this->gdpr_checkbox = (bool)Configuration::get('HI_POPNOT_GDPR_CHECKBOX');
        foreach (Language::getLanguages(false) as $language) {
            $this->gdpr_content[$language['id_lang']] = Configuration::get('HI_POPNOT_GDPR_CONTENT', $language['id_lang']);
        }
        $this->social_redirect = Configuration::get('HI_PN_SC_REDIRECT');
        /*Design settings*/
        $this->popup_template = Configuration::get('HI_PN_TEMPLATE');
        /*Newsletter*/
        $this->nl_send_voucher_email = (bool)Configuration::get('HI_PN_NL_SEND_VOUCHER_EMAIL');
        $this->nl_terms_url = Configuration::get('HI_PN_NL_TERMS_URL');
        $this->nl_voucher_code = Configuration::get('HI_PN_NL_VOUCHER_CODE');
        foreach (Language::getLanguages(false) as $language) {
            $this->nl_popup_description[$language['id_lang']] = Configuration::get('HI_PN_NL_DESC', $language['id_lang']);
        }
        /*Responsive*/
        $this->enable_responsive = (bool)Configuration::get('HI_PN_RES_ENABLE');
        $this->responsive_resize_start_point = Configuration::get('HI_PN_RES_START_POINT');
        $this->responsive_hide_start_point = Configuration::get('HI_PN_RES_HIDE_START_POINT');
        /*Login And Register*/
        $this->log_reg_enable = (bool)Configuration::get('HI_PN_LGRE_ENABLE');
        $this->log_reg_login_enable = (bool)Configuration::get('HI_PN_LGRE_LOGIN_ENABLE');
        $this->log_reg_register_enable = (bool)Configuration::get('HI_PN_LGRE_REGISTER_ENABLE');
        $this->log_reg_terms_url = Configuration::get('HI_PN_LGRE_TERMS_URL');
        $this->log_reg_background_image = Configuration::get('HI_PN_LGRE_BG_IMAGE');
        $this->log_reg_background_repeat = Configuration::get('HI_PN_LGRE_BG_REPEAT');
        /*Facebook*/
        $this->sc_enable_facebook = (bool)Configuration::get('HI_PN_SCF_ENABLE');
        $this->sc_facebook_position_top = Configuration::get('HI_PN_SCF_POSITION_TOP');
        $this->sc_facebook_position_left = Configuration::get('HI_PN_SCF_POSITION_LEFT');
        $this->sc_facebook_position_right = Configuration::get('HI_PN_SCF_POSITION_RIGHT');
        $this->sc_facebook_position_custom = Configuration::get('HI_PN_SCF_POSITION_CUSTOM');
        $this->sc_facebook_button_size_top = Configuration::get('HI_PN_SCF_BUTTON_SIZE_TOP');
        $this->sc_facebook_button_size_left = Configuration::get('HI_PN_SCF_BUTTON_SIZE_LEFT');
        $this->sc_facebook_button_size_right = Configuration::get('HI_PN_SCF_BUTTON_SIZE_RIGHT');
        $this->sc_facebook_app_id = trim(Configuration::get('HI_PN_SCF_APP_ID'));
        /*Twitter*/
        $this->sc_enable_twitter = (bool)Configuration::get('HI_PN_SCT_ENABLE');
        $this->sc_twitter_position_top = Configuration::get('HI_PN_SCT_POSITION_TOP');
        $this->sc_twitter_position_left = Configuration::get('HI_PN_SCT_POSITION_LEFT');
        $this->sc_twitter_position_right = Configuration::get('HI_PN_SCT_POSITION_RIGHT');
        $this->sc_twitter_position_custom = Configuration::get('HI_PN_SCT_POSITION_CUSTOM');
        $this->sc_twitter_button_size_top = Configuration::get('HI_PN_SCT_BUTTON_SIZE_TOP');
        $this->sc_twitter_button_size_left = Configuration::get('HI_PN_SCT_BUTTON_SIZE_LEFT');
        $this->sc_twitter_button_size_right = Configuration::get('HI_PN_SCT_BUTTON_SIZE_RIGHT');
        $this->sc_twitter_key = Configuration::get('HI_PN_SCT_KEY');
        $this->sc_twitter_secret = Configuration::get('HI_PN_SCT_SECRET');
        /*Google*/
        $this->sc_enable_google = (bool)Configuration::get('HI_PN_SCG_ENABLE');
        $this->sc_google_position_top = Configuration::get('HI_PN_SCG_POSITION_TOP');
        $this->sc_google_position_left = Configuration::get('HI_PN_SCG_POSITION_LEFT');
        $this->sc_google_position_right = Configuration::get('HI_PN_SCG_POSITION_RIGHT');
        $this->sc_google_position_custom = Configuration::get('HI_PN_SCG_POSITION_CUSTOM');
        $this->sc_google_button_size_top = Configuration::get('HI_PN_SCG_BUTTON_SIZE_TOP');
        $this->sc_google_button_size_left = Configuration::get('HI_PN_SCG_BUTTON_SIZE_LEFT');
        $this->sc_google_button_size_right = Configuration::get('HI_PN_SCG_BUTTON_SIZE_RIGHT');
        $this->sc_google_id = Configuration::get('HI_PN_SCG_ID');
    }


    public function renderMenuTabs()
    {
        $tabs = array(
            'list' => $this->l('Popups list'),
            'generel_settings' => $this->l('General settings'),
            'design_settings' => $this->l('Design settings'),
            'newsletter' => $this->l('Newsletter'),
            'responsive' => $this->l('Responsive Settings'),
            'loginRegister' => $this->l('Login and Register Settings'),
            'social_connect' => $this->l('Social Connect'),
            'gdpr' => $this->l('GDPR'),
            'version' => $this->l('Version'),
            'documentation' => $this->l('Documentation'),
        );
        $more_module = $this->HiPrestaClass->getModuleContent('A_PNT', false, '', true);
        if ($more_module) {
            $tabs['more_module'] = $this->l('More Modules');
        }
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
                'tabs' => $tabs,
                'module_version' => $this->version,
                'module_url' => $this->HiPrestaClass->getModuleUrl(),
                'module_tab_key' => $this->name,
                'module_key' => Tools::getValue($this->name),
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/menu_tabs.tpl');
    }

    public function renderTabsAction($prefix, $tab_parent)
    {
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
                'module_url' => $this->HiPrestaClass->getModuleUrl(),
                'url_key' => $this->name,
                'action' => Tools::getValue('action'),
                'tab_parent' => $tab_parent,
                'prefix' => $prefix,
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/tabs_action.tpl');
    }

    public function renderModuleAdvertisingForm()
    {
        $this->HiPrestaClass->getModuleContent('A_PNT');
        return $this->display(__FILE__, 'views/templates/admin/moduleadvertising.tpl');
    }

    public function renderVersionForm()
    {
        $changelog = '';
        if (file_exists(dirname(__FILE__) . '/changelog.txt')) {
            $changelog = Tools::file_get_contents(dirname(__FILE__) . '/changelog.txt');
        }
        $this->context->smarty->assign('changelog', $changelog);

        return $this->display(__FILE__, 'views/templates/admin/version.tpl');
    }

    public function renderDocumentationForm()
    {
        return $this->display(__FILE__, 'views/templates/admin/documentation.tpl');
    }

    public function renderShopGroupError()
    {
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/shop_group_error.tpl');
    }

    public function renderModuleAdminVariables()
    {
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
                'id_lang' => $this->context->language->id,
                'pnt_secure_key' => $this->secure_key,
                'pnt_admin_controller_dir' => $this->context->link->getAdminLink('AdminPopupNotification'),
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/variables.tpl');
    }

    public function renderDisplayForm($content, $tab)
    {
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
                'errors' => $this->errors,
                'success' => $this->success,
                'content' => $content,
                'tab' => $tab,
                'module_url' => Tools::getHttpHost(true)._MODULE_DIR_.$this->name,
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/display_form.tpl');
    }

    public function renderModalTpl()
    {
        $this->context->smarty->assign(
            array(
                'psv' => $this->psv,
            )
        );
        return $this->display(__FILE__, 'views/templates/admin/modal.tpl');
    }

    public function renderSettingsForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                   array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Clean Database when module uninstalled'),
                        'name' => 'clean_db',
                        'class' => 't',
                        'is_bool' => true,
                        'desc' => $this->l('Not recommended, use this only when you’re not going to use the module'),
                        'values' => array(
                            array(
                                'id' => 'clean_db_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'clean_db_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Redirect After Login'),
                        'name' => 'social_redirect',
                        'desc' => $this->l('Redirect after Facebook / Twitter / Google connect'),
                        'options' => array(
                            'query' => array(
                                array('id' => 'no_redirect', 'name' => $this->l('No redirect')),
                                array('id' => 'my_account', 'name' => $this->l('My account page')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_settings_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=generel_settings';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'clean_db' => $this->clean_db,
                'social_redirect' => $this->social_redirect,
            ),
        );
        return $helper->generateForm(array($fields_form));
    }

    public function renderGdprSettingsForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('GDPR Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                   array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable General Data Protection Regulation (GDPR)'),
                        'name' => 'gdpr_checkbox',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'gdpr_checkbox_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'gdpr_checkbox_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                   array(
                        'type' => 'textarea',
                        'label' => $this->l('General Data Protection Regulation Content'),
                        'name' => 'gdpr_content',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 100,
                        'rows' => 10
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_gdpr_settings_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=gdpr';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'gdpr_checkbox' => $this->gdpr_checkbox,
                'gdpr_content' => $this->gdpr_content,
            ),
        );
        return $helper->generateForm(array($fields_form));
    }

    public function renderDesignSettingsForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Design settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Template'),
                        'name' => 'popup_template',
                        'options' => array(
                            'query' => array(
                                array('id' => 'default', 'name' => $this->l('Default')),
                                array('id' => 'custom', 'name' => $this->l('Custom')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_design_settings_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=design_settings';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'popup_template' => $this->popup_template,
            ),
        );
        return $helper->generateForm(array($fields_form));
    }

    public function renderFakeForm()
    {
        $cat = array();
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Description'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'fake_description',
                        'class' => 'fake_desc',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 100,
                        'rows' => 10
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('File'),
                        'name' => 'fake_icon',
                    ),
                    array(
                        'type' => 'categories',
                        'label' => $this->l('Select Categories'),
                        'name' => $this->psv >= 1.6 ? 'iroot_category':'categoryBox[]',
                        ''.$this->psv >= 1.6 ? 'tree':'values' => $this->creatVersionCategoryTree('fake_cat', $cat),
                    ),
                ),
            ),
        );

        $helper = new HelperForm();
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->show_toolbar = false;
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->module = $this;
        $description = array();
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $description[$lang['id_lang']] = '';
        }
        $helper->tpl_vars = array(
            'fields_value' => array(
                'fake_description' => $description,
            )
        );

        return $helper->generateForm(array($fields_form));
    }

     /**
    * uploadMultilangImage uploade multilange image
    * @param string $name (image input name)
    * @param int $id_lang (language id)
    * @param int $id (table row id)
    * @return string
    */
    public function uploadMultilangImage($name, $id_lang, $id = null)
    {
        if ($_FILES[''.$name.'_'.$id_lang.'']['name'] !== '') {
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[''.$name.'_'.$id_lang.'']['name'], '.'), 1));
            $imagesize = array();
            $imagesize = getimagesize($_FILES[''.$name.'_'.$id_lang.'']['tmp_name']);
            if (isset($_FILES[''.$name.'_'.$id_lang.'']) &&
                isset($_FILES[''.$name.'_'.$id_lang.'']['tmp_name']) &&
                !empty($_FILES[''.$name.'_'.$id_lang.'']['tmp_name']) &&
                !empty($imagesize) &&
                in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) &&
                in_array($type, array('jpg', 'gif', 'jpeg', 'png'))) {
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'MF');
                $salt = sha1(microtime());
                if (ImageManager::validateUpload($_FILES[''.$name.'_'.$id_lang.''])) {
                    return true;
                } elseif (!$temp_name || !move_uploaded_file($_FILES[''.$name.'_'.$id_lang.'']['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/'.Tools::encrypt($_FILES[''.$name.'_'.$id_lang.'']['name'].$salt).'.'.$type, null, null, $type)) {
                    return false;
                }
                if (isset($temp_name)) {
                    unlink($temp_name);
                }
                $image = Tools::encrypt($_FILES[''.$name.'_'.$id_lang.'']['name'].$salt).'.'.$type;
                $popupnotification = new PopupNotification($id);
                $popupnotification_img = unserialize($popupnotification->content_lang[$id_lang]);
                $unlink_image = $popupnotification_img['image'];
                if ($unlink_image && $unlink_image != '') {
                    unlink(_PS_MODULE_DIR_.$this->name.'/views/img/upload/'.$unlink_image);
                }
            } else {
                return false;
            }
        } else {
                $popupnotification = new PopupNotification($id);
                $popupnotification_img = unserialize($popupnotification->content_lang[$id_lang]);
                $image = $popupnotification_img['image'];
        }
        return $image;
    }

    /**
    * uploadImage uploade image
    * @param string $name (image input name)
    * @param int $id_lang (language id)
    * @param int $id (table row id)
    * @param string $block_type (field type)
    * @param string $get_config (configuration name)
    * @return string
    */
    public function uploadImage($name, $block_type, $id = null, $get_config = '')
    {
        if ($_FILES[''.$name.'']['name'] !== '') {
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[''.$name.'']['name'], '.'), 1));
            $imagesize = array();
            $imagesize = getimagesize($_FILES[''.$name.'']['tmp_name']);
            if (isset($_FILES[''.$name.'']) &&
                isset($_FILES[''.$name.'']['tmp_name']) &&
                !empty($_FILES[''.$name.'']['tmp_name']) &&
                !empty($imagesize) &&
                in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) &&
                in_array($type, array('jpg', 'gif', 'jpeg', 'png'))) {
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'MF');
                $salt = sha1(microtime());
                if (ImageManager::validateUpload($_FILES[''.$name.''])) {
                    return true;
                } elseif (!$temp_name || !move_uploaded_file($_FILES[''.$name.'']['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/'.Tools::encrypt($_FILES[''.$name.'']['name'].$salt).'.'.$type, null, null, $type)) {
                    return false;
                }
                if (isset($temp_name)) {
                    unlink($temp_name);
                }
                $image = Tools::encrypt($_FILES[''.$name.'']['name'].$salt).'.'.$type;
                if ($block_type == 'background_image') {
                    if ($get_config == '') {
                        $popupnotification = new PopupNotification($id);
                        if ($popupnotification->background_image) {
                            unlink(_PS_MODULE_DIR_.$this->name.'/views/img/upload/'.$popupnotification->background_image);
                        }
                    } else {
                        $unlink_img = Configuration::get($get_config);
                        if ($unlink_img) {
                            unlink(_PS_MODULE_DIR_.$this->name.'/views/img/upload/'.$unlink_img);
                        }
                    }
                }
            } else {
                return false;
            }
        } else {
            if ($block_type == 'background_image') {
                if ($get_config == '') {
                    $popupnotification = new PopupNotification($id);
                    $image = $popupnotification->background_image;
                } else {
                    $image = Configuration::get($get_config);
                }
            }
        }
        return $image;
    }

    public function saveList($id = null)
    {
        $languages = Language::getLanguages(false);
        $popup = new PopupNotification($id);
        $popup->active = Tools::getValue('active');
        $popup->popup_type = Tools::getValue('popup_type');
        $popup->width = Tools::getValue('width');
        $popup->height = Tools::getValue('height');
        $popup->content_type = Tools::getValue('content_type');
        if (Tools::getValue('content_type') == 'html') {
            foreach ($languages as $lang) {
                $popup->content_lang[$lang['id_lang']] = Tools::getValue('description_'.$lang['id_lang'])
                ? Tools::getValue('description_'.$lang['id_lang'])
                : Tools::getValue('description_'.Configuration::get('PS_LANG_DEFAULT'));
            }
        }
        if (Tools::getValue('content_type') == 'youtube') {
            foreach ($languages as $lang) {
                $popup->content_lang[$lang['id_lang']] = Tools::getValue('youtube_link_'.$lang['id_lang'])
                ? Tools::getValue('youtube_link_'.$lang['id_lang'])
                : Tools::getValue('youtube_link_'.Configuration::get('PS_LANG_DEFAULT'));
            }
        }
        if (Tools::getValue('content_type') == 'vimeo') {
            foreach ($languages as $lang) {
                $popup->content_lang[$lang['id_lang']] = Tools::getValue('vimeo_link_'.$lang['id_lang'])
                ? Tools::getValue('vimeo_link_'.$lang['id_lang'])
                : Tools::getValue('vimeo_link_'.Configuration::get('PS_LANG_DEFAULT'));
            }
        }
        if (Tools::getValue('content_type') == 'gmaps') {
            $popup->content = Tools::getValue('gmaps_link');
        }
        if (Tools::getValue('content_type') == 'facebook') {
            $popup->content = Tools::getValue('facebook_link');
        }
        if (Tools::getValue('content_type') == 'image') {
            foreach ($languages as $lang) {
                $multilange_image_content = array(
                    'image' => $this->uploadMultilangImage('image_input', $lang['id_lang'], $id),
                    'link' => Tools::getValue('image_link_'.$lang['id_lang'])
                        ? Tools::getValue('image_link_'.$lang['id_lang'])
                        : Tools::getValue('image_link_'.Configuration::get('PS_LANG_DEFAULT')),
                    );
                $popup->content_lang[$lang['id_lang']] = serialize($multilange_image_content);
            }
        }
        $popup->background_image = $this->uploadImage('background_image', 'background_image', $id);
        $popup->background_repeat = Tools::getValue('background_repeat');
        $popup->cookie_time = Tools::getValue('cookie_time');
        $popup->auto_close_time = Tools::getValue('auto_close_time');
        $popup->delay_time = Tools::getValue('delay_time');
        $popup->animation = Tools::getValue('animation');
        if (Tools::getValue('start_date') != '0000-00-00') {
            $popup->date_start = Tools::getValue('start_date');
        } else {
            $popup->date_start = '';
        }
        if (Tools::getValue('end_date') != '0000-00-00') {
            $popup->date_end = Tools::getValue('end_date');
        } else {
            $popup->date_end = '';
        }

        $popup->save();
        $get_cat = array();
        if ($this->psv >= 1.6) {
            if (Tools::getValue('iroot_category') != '') {
                $get_cat = Tools::getValue('iroot_category');
            }
        } else {
            if (Tools::getValue('categoryBox') != '') {
                $get_cat = Tools::getValue('categoryBox');
            }
        }
        $seletor_ids = array();
        if (Tools::getValue('popup_type') == 'product') {
            $products = trim(Tools::getValue('inputBlockProducts'));
            if ($products != '') {
                $seletor_ids = array_filter(explode(",", $products));
            }
        } else {
            $seletor_ids = $get_cat;
        }
        if (Tools::getValue('popup_type') == 'product' || Tools::getValue('popup_type') == 'category') {
            Db::getInstance()->execute('
                DELETE FROM `'._DB_PREFIX_.'hipopup_separate_content` 
                WHERE id_popup = '.(int)$popup->id);
            if (!empty($seletor_ids)) {
                foreach ($seletor_ids as $id) {
                    Db::getInstance()->execute('
                        INSERT INTO `'._DB_PREFIX_.'hipopup_separate_content` (`id_popup`, `id_selector`)
                        VALUES('.(int)$popup->id.', '.(int)$id.')');
                }
            } else {
                Db::getInstance()->execute('
                    INSERT INTO `'._DB_PREFIX_.'hipopup_separate_content` (`id_popup`, `id_selector`)
                    VALUES('.(int)$popup->id.', 0)');
            }
        }
    }

    public function creatVersionCategoryTree($id, $category_tree = array())
    {
        if ($this->psv >= 1.6) {
            return array(
                 'id' => $id,
                 'use_checkbox' => true,
                 'selected_categories' => $category_tree,
            );
        } else {
            $root_category = Category::getRootCategory();
            $root_category = array('id_category' => $root_category->id, 'name' => $root_category->name);
            return array(
                'trads' => array(
                    'Root' => $root_category,
                    'selected' => $this->l('Selected'),
                    'Collapse All' => $this->l('Collapse All'),
                    'Expand All' => $this->l('Expand All'),
                    'Check All' => $this->l('Check All'),
                    'Uncheck All' => $this->l('Uncheck All'),
                ),
                'selected_cat' => $category_tree,
                'input_name' => 'categoryBox[]',
                'use_radio' => false,
                'use_search' => false,
                'disabled_categories' => array(),
                'top_category' => Category::getTopCategory(),
                'use_context' => true,
            );
        }
    }

    /*
    List form
    */

    public function renderList()
    {
        $fields_list = array(
            'id_hipopupnotification' => array(
                'title' => $this->l('ID'),
                'width' => 60,
                'type' => 'text',
                'search' => false,
            ),
            'popup_type' => array(
                'title' => $this->l('Popup type'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
            ),
            'content_type' => array(
                'title' => $this->l('Content type'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
            ),
            'custom_hook' => array(
                'title' => $this->l('Custom Hook'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
            ),
        );
        $helper = new HelperList();
        $helper->module = $this;
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->no_link = true;
        $helper->actions = array('edit', 'delete');
        $helper->identifier = 'id_hipopupnotification';
        $helper->show_toolbar = false;
        $helper->title = 'List';
        $helper->table = 'hipopupnotification';
        $helper->toolbar_btn['new'] = array(
            'href' => '#',
            'desc' => $this->l('Add')
        );
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&'.$this->name.'=list';
        $sql_result = PopupNotification::getAllList();
        foreach ($sql_result as $key => $hook) {
            $sql_result[$key]['custom_hook'] = $hook['popup_type'] == 'custom' ? '{hook h="hipopupnotification" id='.$hook['id_hipopupnotification'].'}' : '--';
        }
        $helper->listTotal = count($sql_result);
        $page = ($page = Tools::getValue('submitFilter'.$helper->table)) ? $page : 1;
        $pagination = ($pagination = Tools::getValue($helper->table.'_pagination')) ? $pagination : 50;
        $sql_result = $this->HiPrestaClass->pagination($sql_result, $page, $pagination);
        return $helper->generateList($sql_result, $fields_list);
    }


    /*
    *
    Add form
    *
    */
    public function renderListForm($type = '', $id_row = null)
    {
        $popup_bg_image = array();
        $list = new PopupNotification($id_row);
        $popup_bg_image = $list->background_image;
        $category = array();
        if ($type == 'update') {
            $categories = HiPopupSeparateContent::getContentByIdPopup($id_row, 'category');
            if (!empty($categories)) {
                foreach ($categories as $key => $id) {
                    $category[] = $id['id_selector'];
                }
            }
        }
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Options'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'row_id',
                    ),
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable'),
                        'name' => 'active',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Popup type'),
                        'name' => 'popup_type',
                        'desc' => $this->l('If you not select any product/category the popup will show in all places in product/category page'),
                        'options' => array(
                            'query' => array(
                                array('id' => 'all_pages', 'name' => $this->l('All Pages')),
                                array('id' => 'home', 'name' => $this->l('Home')),
                                array('id' => 'product', 'name' => $this->l('Product page')),
                                array('id' => 'category', 'name' => $this->l('Category page')),
                                array('id' => 'exit', 'name' => $this->l('Exit')),
                                array('id' => 'custom', 'name' => $this->l('Custom')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'search_product',
                        'label' => $this->l('Search Product'),
                        'name' => 'product_search',
                        'form_group_class' => 'search_product popup_type_content',
                    ),
                    array(
                        'type' => 'categories',
                        'form_group_class' => 'category_tree popup_type_content',
                        'label' => $this->l('Select Categories'),
                        'name' => $this->psv >= 1.6 ? 'iroot_category':'categoryBox[]',
                        ''.$this->psv >= 1.6 ? 'tree':'values' => $this->creatVersionCategoryTree('popup_cat', $category),
                    ),
                     array(
                        'type' => 'select',
                        'label' => $this->l('Content type'),
                        'name' => 'content_type',
                        'options' => array(
                            'query' => array(
                                array('id' => 'html', 'name' => $this->l('HTML')),
                                array('id' => 'youtube', 'name' => $this->l('YouTube')),
                                array('id' => 'vimeo', 'name' => $this->l('Vimeo')),
                                array('id' => 'gmaps', 'name' => $this->l('Google Maps')),
                                array('id' => 'facebook', 'name' => $this->l('Facebook Like Box')),
                                array('id' => 'newsletter', 'name' => $this->l('Newsletter')),
                                array('id' => 'login', 'name' => $this->l('Login')),
                                array('id' => 'register', 'name' => $this->l('Register')),
                                array('id' => 'login_and_register', 'name' => $this->l('Login and Register')),
                                array('id' => 'image', 'name' => $this->l('Image')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Width'),
                        'name' => 'width',
                        'form_group_class' => 'page_content_size',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Height'),
                        'name' => 'height',
                        'form_group_class' => 'page_content_size',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 100,
                        'rows' => 10,
                        'form_group_class' => 'page_content type_html',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Youtube Link'),
                        'name' => 'youtube_link',
                        'lang' => true,
                        'form_group_class' => 'page_content type_youtube',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Vimeo Link'),
                        'name' => 'vimeo_link',
                        'lang' => true,
                        'form_group_class' => 'page_content type_vimeo',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google Maps Link'),
                        'name' => 'gmaps_link',
                        'lang' => false,
                        'form_group_class' => 'page_content type_gmaps',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook Page Link'),
                        'name' => 'facebook_link',
                        'lang' => false,
                        'form_group_class' => 'page_content type_facebook',
                    ),
                    array(
                        'type' => 'file_lang',
                        'label' => $this->l('Upload Image'),
                        'name' => 'image_input',
                        'class' => 't',
                        'form_group_class' => 'page_content type_image',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link on Image'),
                        'name' => 'image_link',
                        'lang' => true,
                        'form_group_class' => 'page_content type_image',
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Background Image'),
                        'name' => 'background_image',
                        'desc' => $popup_bg_image != '' ? "<img src='".__PS_BASE_URI__."modules/".$this->name."/views/img/upload/".$popup_bg_image."' width='80'>
                        <button type='submit' value='1' name='remove_popup_bg' data-id = ".$id_row." class='remove_popup_bg btn btn-default' style='vertical-align: top;margin-left: 5px'><i class='icon-trash'></i> ".$this->l('Delete')."</button>" :'',
                    ),

                    array(
                        'type' => 'radio',
                        'label' => $this->l('Repeat'),
                        'name' => 'background_repeat',
                        'class' => 't',
                        'values' => array(
                            array(
                                'id' => 'repeat_x',
                                'value' => 'repeat-x',
                                'label' => $this->l('Repeat-x')
                            ),
                            array(
                                'id' => 'repeat_y',
                                'value' => 'repeat-y',
                                'label' => $this->l('Repeat-y')
                            ),
                            array(
                                'id' => 'repeat_x_y',
                                'value' => 'repeat',
                                'label' => $this->l('Repeat-x-y')
                            ),
                            array(
                                'id' => 'no_repeat',
                                'value' => 'no-repeat',
                                'label' => $this->l('No Repeat')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Cookie Time (Days)'),
                        'name' => 'cookie_time',
                        'lang' => false,
                        'desc' => $this->l('"0" for no cookie'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Close popup automatically'),
                        'name' => 'auto_close_time',
                        'lang' => false,
                        'desc' => $this->l('"0" for no autoclose (seconds)'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display popup with delay'),
                        'name' => 'delay_time',
                        'lang' => false,
                        'desc' => $this->l('"0" for no delay (seconds)'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation Effect'),
                        'name' => 'animation',
                        'options' => array(
                            'query' => array(
                                array('id' => '', 'name' => $this->l('None')),
                                array('id' => 'mfp-zoom-in', 'name' => $this->l('Zoom')),
                                array('id' => 'mfp-newspaper', 'name' => $this->l('Newspaper')),
                                array('id' => 'mfp-move-horizontal', 'name' => $this->l('Horizontal move')),
                                array('id' => 'mfp-move-from-top', 'name' => $this->l('Move from top')),
                                array('id' => 'mfp-3d-unfold', 'name' => $this->l('3d unfold')),
                                array('id' => 'mfp-zoom-out', 'name' => $this->l('Zoom-out')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Start Date'),
                        'name' => 'start_date',
                        'lang' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('End Date'),
                        'name' => 'end_date',
                        'lang' => false,
                    ),
                ),
                'submit' => array(
                    'title' => ($type == 'update') ? $this->l('Update') : $this->l('Add'),
                    'name' => ($type == 'update') ? 'submit_list_update' : 'submit_list_add',
                    'class' => 'btn btn-default pull-right submit_item'
                ),
                'buttons' => array(
                    array(
                        'title' =>  $this->l('Cancel'),
                        'name' => 'submit_cancel',
                        'type' => 'submit',
                        'icon' => 'process-icon-cancel',
                        'class' => 'btn btn-default pull-left',
                    )
                )
            ),
        );

        $helper = new HelperForm();
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->show_toolbar = false;
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=list';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->module = $this;
        $products_id = '';
        $product_content = array();
        if ($type == 'update') {
            $image_image_content = array();
            $image_content = PopupNotification::getPopupLangOptionByContentType($id_row, 'image');
            if (!empty($image_content)) {
                foreach ($image_content as $key => $value) {
                    $content = unserialize($value);
                    $image_image_content[$key] = $content['image'];
                }
            }
            $popup_image = $image_image_content;
            $products = HiPopupSeparateContent::getContentByIdPopup($id_row, 'product');
            if (!empty($products)) {
                foreach ($products as $key => $id) {
                    if ($id['id_selector']) {
                        $product_content[$key]['id_product'] = $id['id_selector'];
                        $product_content[$key]['name'] = Product::getProductName($id['id_selector']);
                        $products_id .= $id['id_selector'].',';
                    }
                }
            }
        } else {
            $popup_image = false;
        }

        $this->context->smarty->assign(array(
            'products_id' => trim($products_id),
            'product_content' => $product_content,
        ));

        $helper->tpl_vars = array(
            'name_controller' => 'popup_form',
            'psv' => $this->psv,
            'id_language' => $this->context->language->id,
            'upload_icon_path' => __PS_BASE_URI__.'modules/'.$this->name.'/views/img/upload/',
            'popup_image' => $popup_image,
            'fields_value' => $this->getListAddFieldsValues($type, $id_row)
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getListAddFieldsValues($type = '', $id_row = null)
    {
        $empty_array = array();
        foreach (Language::getLanguages(false) as $lang) {
            $empty_array[$lang['id_lang']] = '';
        }
        if ($type == 'update') {
            $list = new PopupNotification($id_row);
            $image_link_content = array();
            $image_content = PopupNotification::getPopupLangOptionByContentType($id_row, 'image');
            if (!empty($image_content)) {
                foreach ($image_content as $key => $value) {
                    $content = unserialize($value);
                    $image_link_content[$key] = $content['link'];
                }
            }
            $description = PopupNotification::getPopupLangOptionByContentType($id_row, 'html');
            $youtube_link = PopupNotification::getPopupLangOptionByContentType($id_row, 'youtube');
            $vimeo_link = PopupNotification::getPopupLangOptionByContentType($id_row, 'vimeo');
            return array(
                'row_id' => $id_row,
                'active' => $list->active,
                'popup_type' => $list->popup_type,
                'width' => $list->width,
                'height' => $list->height,
                'content_type' => $list->content_type,
                'description' => !empty($description) ? $description : $empty_array,
                'youtube_link' => !empty($youtube_link) ? $youtube_link : $empty_array,
                'vimeo_link' => !empty($vimeo_link) ? $vimeo_link : $empty_array,
                'gmaps_link' => PopupNotification::getPopupOptionByContentType($id_row, 'gmaps'),
                'facebook_link' => PopupNotification::getPopupOptionByContentType($id_row, 'facebook'),
                'image_link' => !empty($image_link_content) ? $image_link_content : $empty_array,
                'background_repeat' => $list->background_repeat,
                'cookie_time' => $list->cookie_time,
                'auto_close_time' => $list->auto_close_time,
                'delay_time' => $list->delay_time,
                'animation' => $list->animation,
                'start_date' => $list->date_start,
                'end_date' => $list->date_end,
            );
        } else {
            return array(
                'row_id' => $id_row,
                'active' => true,
                'popup_type' => 'home',
                'width' => '500',
                'height' => '350',
                'content_type' => 'html',
                'description' => $empty_array,
                'youtube_link' => $empty_array,
                'vimeo_link' => $empty_array,
                'gmaps_link' => '',
                'facebook_link' => '',
                'image_link' => $empty_array,
                'background_repeat' => 'no-repeat',
                'cookie_time' => '0',
                'auto_close_time' => '0',
                'delay_time' => '0',
                'animation' => '',
                'start_date' => '0000-00-00',
                'end_date' => '0000-00-00',
            );
        }
    }

    /***
**Newsletter Settings
***/
    public function renderNewsletterForm()
    {
         $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Newsletter Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Send Voucher Code by Email?'),
                        'name' => 'nl_send_voucher_email',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'nl_send_voucher_email_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'nl_send_voucher_email_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Terms URL'),
                        'name' => 'nl_terms_url',
                        'desc' => $this->l('Leave blank to disable by default'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Voucher code'),
                        'name' => 'nl_voucher_code',
                        'desc' => $this->l('Leave blank to disable by default'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Popup Description'),
                        'name' => 'nl_popup_description',
                        'lang' => true,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_newsletter_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=newsletter&action=settings';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'nl_send_voucher_email' => $this->nl_send_voucher_email,
                'nl_terms_url' => $this->nl_terms_url,
                'nl_voucher_code' => $this->nl_voucher_code,
                'nl_popup_description' => $this->nl_popup_description,
            )
        );

        return $helper->generateForm(array($fields_form));
    }
    
/***
**Newsletter  users list
***/
    public function renderNewsletterUsersList()
    {
        $fields_list = array(
            'id_hinewslettervoucher' => array(
                'title' => $this->l('ID'),
                'search' => false,
                'orderby' => false,
            ),
            'customer_id' => array(
                'title' => $this->l('Customer Id'),
                'search' => false,
                'orderby' => false,
            ),
            'first_name' => array(
                'title' => $this->l('First name'),
                'search' => false,
                'orderby' => false,
            ),
            'last_name' => array(
                'title' => $this->l('Last name'),
                'search' => false,
                'orderby' => false,
            ),
            'email' => array(
                'title' => $this->l('Email'),
                'search' => false,
                'orderby' => false,
            ),
            'code' => array(
                'title' => $this->l('Voucher'),
                'search' => false,
                'orderby' => false,
            ),
        );
        if (!Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            unset($fields_list['shop_name']);
        }
        $helper = new HelperList();
        $helper->module = $this;
        $helper->title = $this->l('Users');
        $helper->shopLinkType = '';
        $helper->no_link = true;
        $helper->show_toolbar = false;
        $helper->simple_header = false;
        $helper->identifier = 'id_hinewslettervoucher';
        $helper->table = 'hinewslettervoucher';
        $helper->actions = array('delete');
        $helper->toolbar_btn['export'] = array(
            'href' => $this->HiPrestaClass->getModuleUrl('&'.$this->name.'=newsletter&action=stats&export_newsleter'),
            'desc' => $this->l('Export')
        );
        // $helper->actions = array('delete'=>array('text'=>$this->l('Delete selected'), 'confirm'=>$this->l('Delete selected items?')));
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=newsletter&action=stats';
       
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        
        $this->_helperlist = $helper;
        $subscribers = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'hinewslettervoucher');
        $helper->listTotal = count($subscribers);
        $page = ($page = Tools::getValue('submitFilter'.$helper->table)) ? $page : 1;
        $pagination = ($pagination = Tools::getValue($helper->table.'_pagination')) ? $pagination : 50;
        $subscribers = $this->HiPrestaClass->pagination($subscribers, $page, $pagination);
        return $helper->generateList($subscribers, $fields_list);
    }

/***
**Responsive Settings
***/
    public function renderResponsiveSettingsForm()
    {
         $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Responsive Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable responsiveness?'),
                        'name' => 'enable_responsive',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable_responsive_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'enable_responsive_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Popup Resize Start Point'),
                        'name' => 'responsive_resize_start_point',
                        'desc' => $this->l('Specify the window width'),
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Popup hide start point'),
                        'name' => 'responsive_hide_start_point',
                        'desc' => $this->l('Specify the window width when to hide the popup'),
                        'suffix' => 'px',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_responsive_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=responsive';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'enable_responsive' => $this->enable_responsive,
                'responsive_resize_start_point' => $this->responsive_resize_start_point,
                'responsive_hide_start_point' => $this->responsive_hide_start_point,
            )
        );
        return $helper->generateForm(array($fields_form));
    }

/***
**Login Register Settings
***/
    public function renderLoginRegisterForm()
    {
        $bg_image = $this->log_reg_background_image;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Login and Register Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable popup for header "Sign in" button'),
                        'name' => 'log_reg_enable',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'log_reg_enable_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'log_reg_enable_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable Login Form'),
                        'name' => 'log_reg_login_enable',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'log_reg_login_enable_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'log_reg_login_enable_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable Register Form'),
                        'name' => 'log_reg_register_enable',
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'log_reg_register_enable_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'log_reg_register_enable_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Terms URL'),
                        'name' => 'log_reg_terms_url',
                        'desc' => $this->l('Leave blank to disable by default'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Background Image'),
                        'name' => 'log_reg_background_image',
                        'desc' => $bg_image != '' ? "
                        <img src='".__PS_BASE_URI__."modules/".$this->name."/views/img/upload/".$bg_image."' width='80'>
                        <button type='submit' value='1' name='remove_log_reg_bg' class='btn btn-default' style='vertical-align: top;margin-left: 5px'><i class='icon-trash'></i> ".$this->l('Delete')."</button>" : '',
                    ),

                    array(
                        'type' => 'radio',
                        'label' => $this->l('Repeat'),
                        'name' => 'log_reg_background_repeat',
                        'class' => 't',
                        'values' => array(
                            array(
                                'id' => 'repeat_x',
                                'value' => 'repeat-x',
                                'label' => $this->l('Repeat-x')
                            ),
                            array(
                                'id' => 'repeat_y',
                                'value' => 'repeat-y',
                                'label' => $this->l('Repeat-y')
                            ),
                            array(
                                'id' => 'repeat_x_y',
                                'value' => 'repeat',
                                'label' => $this->l('Repeat-x-y')
                            ),
                            array(
                                'id' => 'no_repeat',
                                'value' => 'no-repeat',
                                'label' => $this->l('No Repeat')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_loginregister_form',
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $key => $language) {
            $languages[$key]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }
        $helper->languages = $languages;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&'.$this->name.'=loginRegister';
        $helper->tpl_vars = array(
            'fields_value' => array(
                'log_reg_enable' => $this->log_reg_enable,
                'log_reg_login_enable' => $this->log_reg_login_enable,
                'log_reg_register_enable' => $this->log_reg_register_enable,
                'log_reg_terms_url' => $this->log_reg_terms_url,
                'log_reg_background_repeat' => $this->log_reg_background_repeat,
            )
        );
        return $helper->generateForm(array($fields_form));
    }

/*Socila connect block*/

    public function renderSconnectForm($active, $action)
    {
        if ($this->psv >= 1.6) {
            $module_host_domain = Tools::getAdminUrl();
        } else {
            $module_host_domain = Tools::getHttpHost(true).__PS_BASE_URI__;
        }
        $redirect_url = $module_host_domain.'modules/'.$this->name.'/helper/'.$active.'connect.php';
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l($active),
                    'icon' => 'icon-cogs'
                ),
                'description' => $active == 'twitter' ? $this->l('Callback URL') . ': '. $redirect_url : '',
                'input' => array(
                    array(
                        'type' => $this->psv >= 1.6 ? 'switch':'radio',
                        'label' => $this->l('Enable') . ' ' .$active,
                        'name' => 'sc_enable_'.$active,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'sc_enable_'.$active.'_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'sc_enable_'.$active.'_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'label' => $this->l('Positions to display'),
                        'name' => 'sc_'.$active.'_position',
                        'type' => 'checkbox',
                        'desc' => $this->l('Add {hook h="hipopup'.$active.'connect" button_position="inline/apart"
                            button_size="big/small"} to your page tpl file where you want to display.'),
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'top',
                                    'name' => $this->l('Top'),
                                    'val' => 1,
                                ),
                                array(
                                    'id' => 'left',
                                    'name' => $this->l('Left'),
                                    'val' => 1,
                                ),
                                array(
                                    'id' => 'right',
                                    'name' => $this->l('Right'),
                                    'val' => 1,
                                ),
                                array(
                                    'id' => 'custom',
                                    'name' => $this->l('Custom'),
                                    'val' => 1,
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Button size in top position'),
                        'name' => 'sc_'.$active.'_button_size_top',
                        'options' => array(
                            'query' => array(
                                array('id' => 'small', 'name' => $this->l('Small')),
                                array('id' => 'big', 'name' => $this->l('Big')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Button size in left position'),
                        'name' => 'sc_'.$active.'_button_size_left',
                        'options' => array(
                            'query' => array(
                                array('id' => 'small', 'name' => $this->l('Small')),
                                array('id' => 'big', 'name' => $this->l('Big')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Button size in right position'),
                        'name' => 'sc_'.$active.'_button_size_right',
                        'options' => array(
                            'query' => array(
                                array('id' => 'small', 'name' => $this->l('Small')),
                                array('id' => 'big', 'name' => $this->l('Big')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'submit_sc_'.$active,
                    'class' => $this->psv >= 1.6 ? 'btn btn-default pull-right':'button',
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form = array();
        $helper->submit_action = 'submitBlockSettings';
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.
            $this->name.'&tab_module='.$this->tab.'&module_name=
        '.$this->name.'&'.$this->name.'=social_connect&action='.$action.'';
        switch ($active) {
            case 'facebook':
                $fields_value = $this->getFacebookValues();
                $fields_form['form']['input'][] = array(
                    'type' => 'text',
                    'label' => $this->l('App ID'),
                    'name' => 'sc_facebook_app_id',
                );
                break;
            case 'twitter':
                $fields_value = $this->getTwitterValues();
                $fields_form['form']['input'][] = array(
                    'type' => 'text',
                    'label' => $this->l('Consumer Key'),
                    'name' => 'sc_twitter_key',
                );
                $fields_form['form']['input'][] = array(
                    'type' => 'text',
                    'label' => $this->l('Consumer Secret'),
                    'name' => 'sc_twitter_secret',
                );
                break;
            case 'google':
                $fields_value = $this->getGoogleValues();
                $fields_form['form']['input'][] = array(
                    'type' => 'text',
                    'label' => $this->l('Client ID'),
                    'name' => 'sc_google_id',
                );
                break;
        }
        $helper->tpl_vars = array(
            'fields_value' => $fields_value
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getSconnectFieldsValues($name)
    {
        $return = array(
            'sc_enable_'.$name => $this->{'sc_enable_'.$name},
            'sc_'.$name.'_position_top' => $this->{'sc_'.$name.'_position_top'},
            'sc_'.$name.'_position_left' => $this->{'sc_'.$name.'_position_left'},
            'sc_'.$name.'_position_right' => $this->{'sc_'.$name.'_position_right'},
            'sc_'.$name.'_position_custom' => $this->{'sc_'.$name.'_position_custom'},
            'sc_'.$name.'_button_size_top' => $this->{'sc_'.$name.'_button_size_top'},
            'sc_'.$name.'_button_size_left' => $this->{'sc_'.$name.'_button_size_left'},
            'sc_'.$name.'_button_size_right' => $this->{'sc_'.$name.'_button_size_right'},
        );
        return $return;
    }

    public function getFacebookValues()
    {
        $return = array();
        $ret_1 = array(
            'sc_facebook_app_id' => $this->sc_facebook_app_id,
        );
        $ret_2 = $this->getSconnectFieldsValues('facebook');
        $return = array_merge($ret_1, $ret_2);
        return $return;
    }

    public function getTwitterValues()
    {
        $return = array();
        $ret_1 = array(
            'sc_twitter_key' => $this->sc_twitter_key,
            'sc_twitter_secret' => $this->sc_twitter_secret,
        );
        $ret_2 = $this->getSconnectFieldsValues('twitter');
        $return = array_merge($ret_1, $ret_2);
        return $return;
    }

    public function getGoogleValues()
    {
        $return = array();
        $ret_1 = array('sc_google_id' => $this->sc_google_id);
        $ret_2 = $this->getSconnectFieldsValues('google');
        $return = array_merge($ret_1, $ret_2);
        return $return;
    }

    public function renderSconnectUsersList()
    {
        $fields_list = array(
            'id_hipopupsocialconnectuser' => array(
                'title' => $this->l('ID'),
                'search' => false,
            ),
            'id_user' => array(
                'title' => $this->l('ID user'),
                'search' => false,
            ),
            'social_network' => array(
                'title' => $this->l('Social Network'),
                'search' => false,
            ),
            'first_name' => array(
                'title' => $this->l('First name'),
                'search' => false,
            ),
            'last_name' => array(
                'title' => $this->l('Last name'),
                'search' => false,
            ),
            'email' => array(
                'title' => $this->l('Email'),
                'search' => false,
            ),
            'date_add' => array(
                'title' => $this->l('Date add'),
                'search' => false,
            ),
        );
        if (!Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            unset($fields_list['shop_name']);
        }
        $helper = new HelperList();
        $helper->module = $this;
        $helper->title = $this->l('Users');
        $helper->shopLinkType = '';
        $helper->no_link = true;
        $helper->show_toolbar = false;
        $helper->simple_header = false;

        $helper->identifier = 'id_hipopupsocialconnectuser';
        $helper->table = 'hipopupsocialconnectuser';
        $helper->actions = array('delete');
        $helper->toolbar_btn['export'] = array(
            'href' => $this->HiPrestaClass->getModuleUrl('&'.$this->name.'=social_connect&action=stats&export_social_connect'),
            'desc' => $this->l('Export')
        );
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.
            $this->name.'&tab_module='.$this->tab.'&module_name=
        '.$this->name.'&'.$this->name.'=social_connect&action=stats';

        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $this->_helperlist = $helper;
        $subscribers = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'hipopupsocialconnectuser');
        $helper->listTotal = count($subscribers);
        $page = ($page = Tools::getValue('submitFilter'.$helper->table)) ? $page : 1;
        $pagination = ($pagination = Tools::getValue($helper->table.'_pagination')) ? $pagination : 50;
        $subscribers = $this->HiPrestaClass->pagination($subscribers, $page, $pagination);
        return $helper->generateList($subscribers, $fields_list);
    }

    public function postProcess()
    {
        $languages = Language::getLanguages(false);
        if (Tools::isSubmit('submit_settings_form')) {
            Configuration::updateValue('CLEAN_HI_POPNOT', (bool)Tools::getValue('clean_db'));
            Configuration::updateValue('HI_POPNOT_GDPR_CHECKBOX', (bool)Tools::getValue('gdpr_checkbox'));
            foreach ($languages as $lang) {
                Configuration::updateValue('HI_POPNOT_GDPR_CONTENT', array($lang['id_lang'] => Tools::getValue('gdpr_content_'.$lang['id_lang'])));
            }
            Configuration::updateValue('HI_PN_SC_REDIRECT', Tools::getValue('social_redirect'));
            $this->success[] = $this->l('Successfully Saved');
        }
        if (Tools::isSubmit('submit_gdpr_settings_form')) {
            Configuration::updateValue('HI_POPNOT_GDPR_CHECKBOX', (bool)Tools::getValue('gdpr_checkbox'));
            foreach ($languages as $lang) {
                Configuration::updateValue('HI_POPNOT_GDPR_CONTENT', array($lang['id_lang'] => Tools::getValue('gdpr_content_'.$lang['id_lang'])));
            }
            $this->success[] = $this->l('Successfully Saved');
        }
        /*Design settings*/
        if (Tools::isSubmit('submit_design_settings_form')) {
            Configuration::updateValue('HI_PN_TEMPLATE', Tools::getValue('popup_template'));
            $this->success[] = $this->l('Successfully Saved');
        }
        /*Newsletter*/
        if (Tools::isSubmit('submit_newsletter_form')) {
            Configuration::updateValue('HI_PN_NL_SEND_VOUCHER_EMAIL', (bool)Tools::getValue('nl_send_voucher_email'));
            Configuration::updateValue('HI_PN_NL_TERMS_URL', trim(Tools::getValue('nl_terms_url')));
            Configuration::updateValue('HI_PN_NL_VOUCHER_CODE', trim(Tools::getValue('nl_voucher_code')));
            foreach ($languages as $lang) {
                Configuration::updateValue('HI_PN_NL_DESC', array($lang['id_lang'] => Tools::getValue('nl_popup_description_'.$lang['id_lang'])));
            }
            $this->success[] = $this->l('Successfully Saved');
        }
        if (Tools::getIsset('export_newsleter')) {
            $requests_csv_sql = 'SELECT * FROM `'._DB_PREFIX_.'hinewslettervoucher`';
            $csv_exp = array();
            $requests = Db::getInstance()->ExecuteS($requests_csv_sql);
            foreach ($requests as $key => $res) {
                $csv_exp[] = new NewsletterUser($res['id_hinewslettervoucher']);
                unset($csv_exp[$key]->code);
                unset($csv_exp[$key]->date_end);
                unset($csv_exp[$key]->used);
                unset($csv_exp[$key]->id_shop_list);
                unset($csv_exp[$key]->force_id);
            }
            $csv = new CSV($csv_exp, 'newsletter_users');
            $csv->export();
            exit;
        }
        /*Responsive*/
        if (Tools::isSubmit('submit_responsive_form')) {
            if (!Validate::isInt(Tools::getValue('responsive_resize_start_point'))) {
                $this->errors[] = $this->l('Invalide value for "resize start point"');
            } elseif (!Validate::isInt(Tools::getValue('responsive_hide_start_point'))) {
                $this->errors[] = $this->l('Invalide value for "hide start point"');
            } else {
                Configuration::updateValue('HI_PN_RES_ENABLE', (bool)Tools::getValue('enable_responsive'));
                Configuration::updateValue('HI_PN_RES_START_POINT', trim(Tools::getValue('responsive_resize_start_point')));
                Configuration::updateValue('HI_PN_RES_HIDE_START_POINT', trim(Tools::getValue('responsive_hide_start_point')));
                $this->success[] = $this->l('Successfully Saved');
            }
        }
        /*Login and register*/
        if (Tools::isSubmit('submit_loginregister_form')) {
            $file_type = Tools::strtolower(Tools::substr(strrchr($_FILES['log_reg_background_image']['name'], '.'), 1));
            if ($file_type != '' && !in_array($file_type, array('jpg', 'gif', 'jpeg', 'png'))) {
                $this->errors[] = $this->l('Please upload only image .jpg .gif .jpeg .png');
            } else {
                Configuration::updateValue('HI_PN_LGRE_ENABLE', (bool)Tools::getValue('log_reg_enable'));
                Configuration::updateValue('HI_PN_LGRE_LOGIN_ENABLE', (bool)Tools::getValue('log_reg_login_enable'));
                Configuration::updateValue('HI_PN_LGRE_REGISTER_ENABLE', (bool)Tools::getValue('log_reg_register_enable'));
                Configuration::updateValue('HI_PN_LGRE_TERMS_URL', trim(Tools::getValue('log_reg_terms_url')));
                Configuration::updateValue('HI_PN_LGRE_BG_IMAGE', $this->uploadImage('log_reg_background_image', 'background_image', null, 'HI_PN_LGRE_BG_IMAGE'));
                Configuration::updateValue('HI_PN_LGRE_BG_REPEAT', Tools::getValue('log_reg_background_repeat'));
                $this->success[] = $this->l('Successfully Saved');
            }
        }
         /*Login and register bg image delete*/
        if (Tools::isSubmit('remove_log_reg_bg')) {
            $unlink_image = $this->log_reg_background_image;
            if ($unlink_image && $unlink_image != '') {
                unlink(_PS_MODULE_DIR_.$this->name.'/views/img/upload/'.$unlink_image);
            }
            Configuration::updateValue('HI_PN_LGRE_BG_IMAGE', '');
            $this->success[] = $this->l('Successfully deleted');
        }
        /*Facebook*/
        if (Tools::isSubmit('submit_sc_facebook')) {
            Configuration::updateValue('HI_PN_SCF_ENABLE', (bool)Tools::getValue('sc_enable_facebook'));
            Configuration::updateValue('HI_PN_SCF_POSITION_TOP', Tools::getValue('sc_facebook_position_top'));
            Configuration::updateValue('HI_PN_SCF_POSITION_LEFT', Tools::getValue('sc_facebook_position_left'));
            Configuration::updateValue('HI_PN_SCF_POSITION_RIGHT', Tools::getValue('sc_facebook_position_right'));
            Configuration::updateValue('HI_PN_SCF_POSITION_CUSTOM', Tools::getValue('sc_facebook_position_custom'));
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_TOP', Tools::getValue('sc_facebook_button_size_top'));
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_LEFT', Tools::getValue('sc_facebook_button_size_left'));
            Configuration::updateValue('HI_PN_SCF_BUTTON_SIZE_RIGHT', Tools::getValue('sc_facebook_button_size_right'));
            Configuration::updateValue('HI_PN_SCF_APP_ID', trim(Tools::getValue('sc_facebook_app_id')));
            $this->success[] = $this->l('Successfully Saved');
        }
        /*Twitter*/
        if (Tools::isSubmit('submit_sc_twitter')) {
            Configuration::updateValue('HI_PN_SCT_ENABLE', (bool)Tools::getValue('sc_enable_twitter'));
            Configuration::updateValue('HI_PN_SCT_POSITION_TOP', Tools::getValue('sc_twitter_position_top'));
            Configuration::updateValue('HI_PN_SCT_POSITION_LEFT', Tools::getValue('sc_twitter_position_left'));
            Configuration::updateValue('HI_PN_SCT_POSITION_RIGHT', Tools::getValue('sc_twitter_position_right'));
            Configuration::updateValue('HI_PN_SCT_POSITION_CUSTOM', Tools::getValue('sc_twitter_position_custom'));
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_TOP', Tools::getValue('sc_twitter_button_size_top'));
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_LEFT', Tools::getValue('sc_twitter_button_size_left'));
            Configuration::updateValue('HI_PN_SCT_BUTTON_SIZE_RIGHT', Tools::getValue('sc_twitter_button_size_right'));
            Configuration::updateValue('HI_PN_SCT_KEY', trim(Tools::getValue('sc_twitter_key')));
            Configuration::updateValue('HI_PN_SCT_SECRET', trim(Tools::getValue('sc_twitter_secret')));
            $this->success[] = $this->l('Successfully Saved');
        }
        /*Google*/
        if (Tools::isSubmit('submit_sc_google')) {
            Configuration::updateValue('HI_PN_SCG_ENABLE', (bool)Tools::getValue('sc_enable_google'));
            Configuration::updateValue('HI_PN_SCG_POSITION_TOP', Tools::getValue('sc_google_position_top'));
            Configuration::updateValue('HI_PN_SCG_POSITION_LEFT', Tools::getValue('sc_google_position_left'));
            Configuration::updateValue('HI_PN_SCG_POSITION_RIGHT', Tools::getValue('sc_google_position_right'));
            Configuration::updateValue('HI_PN_SCG_POSITION_CUSTOM', Tools::getValue('sc_google_position_custom'));
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_TOP', Tools::getValue('sc_google_button_size_top'));
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_LEFT', Tools::getValue('sc_google_button_size_left'));
            Configuration::updateValue('HI_PN_SCG_BUTTON_SIZE_RIGHT', Tools::getValue('sc_google_button_size_right'));
            Configuration::updateValue('HI_PN_SCG_ID', trim(Tools::getValue('sc_google_id')));
            $this->success[] = $this->l('Successfully Saved');
        }
        /*Socila connect export*/
        if (Tools::getIsset('export_social_connect')) {
            $requests_csv_sql = 'SELECT * FROM `'._DB_PREFIX_.'hipopupsocialconnectuser`';
            $csv_exp = array();
            $requests = Db::getInstance()->ExecuteS($requests_csv_sql);
            foreach ($requests as $key => $res) {
                $csv_exp[] = new PopupSocialConnectUser($res['id_hipopupsocialconnectuser']);
                unset($csv_exp[$key]->id_shop_list);
                unset($csv_exp[$key]->force_id);
            }
            $csv = new CSV($csv_exp, 'social_users');
            $csv->export();
            exit;
        }
    }

    public function displayForm()
    {
        $html = '';
        $content = '';
        $tab = '';
        if (!$this->HiPrestaClass->isSelectedShopGroup()) {
            $html .= $this->renderMenuTabs();
            switch (Tools::getValue($this->name)) {
                case 'list':
                    $content .= $this->renderFakeForm();
                    $content .= $this->renderModalTpl();
                    $content .= $this->renderList();
                    break;
                case 'generel_settings':
                    $content .= $this->renderSettingsForm();
                    break;
                case 'design_settings':
                    $content .= $this->renderDesignSettingsForm();
                    break;
                case 'newsletter':
                    $tab .= $this->renderTabsAction('news_letter', 'newsletter');
                    if (Tools::getValue('action') == 'settings' || !Tools::getValue('action')) {
                        $content .= $this->renderNewsletterForm();
                    } elseif (Tools::getValue('action') == 'stats') {
                        $content .= $this->renderNewsletterUsersList();
                    }
                    break;
                case 'responsive':
                    $content .= $this->renderResponsiveSettingsForm();
                    break;
                case 'loginRegister':
                    $content .= $this->renderLoginRegisterForm();
                    break;
                case 'social_connect':
                    $tab .= $this->renderTabsAction('social_connect', 'social_connect');
                    if (Tools::getValue('action') == 'settings' || !Tools::getValue('action')) {
                        $content .= $this->renderSconnectForm('facebook', 'settings');
                        $content .= $this->renderSconnectForm('twitter', 'settings');
                        $content .= $this->renderSconnectForm('google', 'settings');
                    } elseif (Tools::getValue('action') == 'stats') {
                        $content .= $this->renderSconnectUsersList();
                    }
                    break;
                case 'gdpr':
                    $content .= $this->renderGdprSettingsForm();
                    break;
                case 'version':
                    $content .= $this->renderVersionForm();
                    break;
                case 'documentation':
                    $content .= $this->renderDocumentationForm();
                    break;
                case 'more_module':
                    $content .= $this->renderModuleAdvertisingForm();
                    break;
                default:
                    $content .= $this->renderFakeForm();
                    $content .= $this->renderModalTpl();
                    $content .= $this->renderList();
                    break;
            }
            $html .= $this->renderDisplayForm($content, $tab);
        } else {
            $html .= $this->renderShopGroupError();
        }

        $this->context->controller->addCSS($this->_path.'views/css/admin.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/admin.js');
        $this->context->controller->addJqueryUI("ui.datepicker");
        $html .= $this->renderModuleAdminVariables();
        return $html;
    }

    public function getContent()
    {
        if (Tools::isSubmit('submit_settings_form')
            || Tools::isSubmit('submit_gdpr_settings_form')
            || Tools::isSubmit('submit_design_settings_form')
            || Tools::isSubmit('submit_newsletter_form')
            || Tools::getIsset('export_newsleter')
            || Tools::isSubmit('submit_responsive_form')
            || Tools::isSubmit('submit_loginregister_form')
            || Tools::isSubmit('remove_log_reg_bg')
            || Tools::isSubmit('submit_sc_facebook')
            || Tools::isSubmit('submit_sc_twitter')
            || Tools::isSubmit('submit_sc_google')
            || Tools::getIsset('export_social_connect')
        ) {
            $this->postProcess();
        }
        $this->globalVars();
        $this->HiPrestaClass->createEmailLangFiles();
        return $this->displayForm();
    }

    public function isNewsletterModuleExists()
    {
        if ($this->psv >= 1.7) {
            $module_name = 'ps_emailsubscription';
        } else {
            $module_name = 'blocknewsletter';
        }
        if ($this->isInstalled($module_name) && $this->isEnabled($module_name)) {
            return true;
        }
        return false;
    }

    public function isCustomerExists($email)
    {
        $registered = Db::getInstance()->getRow('SELECT `id_customer`
            FROM '._DB_PREFIX_.'customer
            WHERE `email` = \''.pSQL($email).'\'
            AND id_shop = '.(int)$this->context->shop->id);
        if (!$registered) {
            return false;
        } else {
            return $registered['id_customer'];
        }
    }

    public function registerUser($email)
    {
        return Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'customer
            SET `newsletter` = 1, newsletter_date_add = NOW(), `ip_registration_newsletter` = \''.pSQL(Tools::getRemoteAddr()).'\'
            WHERE `email` = \''.pSQL($email).'\'
            AND id_shop = '.(int)$this->context->shop->id);
    }

    public function registerGuest($email, $active = true)
    {
        if ($this->psv >= 1.7) {
            $table_name = 'emailsubscription';
        } else {
            $table_name = 'newsletter';
        }
        $sql1 = 'SELECT `email`, `active`
                FROM '._DB_PREFIX_.$table_name.'
                WHERE `email` = \''.pSQL($email).'\'
                AND id_shop = '.(int)$this->context->shop->id;

        $registered_news = Db::getInstance()->getRow($sql1);

        if ($registered_news && isset($registered_news['email']) && $registered_news['active'] == 0) {
            $update_sql = 'UPDATE '._DB_PREFIX_.$table_name.'
                SET `active` = 1
                WHERE `email` = \''.pSQL($email).'\'
                AND id_shop = '.(int)$this->context->shop->id;
            return Db::getInstance()->execute($update_sql);
        } else {
            $lang_column = Db::getInstance()->executeS('SHOW COLUMNS FROM '._DB_PREFIX_.pSQL($table_name).' LIKE \'id_lang\'');
            if (is_array($lang_column) && $lang_column) {
                $lang_exists = true;
            } else {
                $lang_exists = false;
            }
            $sql = 'INSERT INTO '._DB_PREFIX_.$table_name.' (id_shop, id_shop_group, email, newsletter_date_add, ip_registration_newsletter, http_referer, active '.($lang_exists ? ', id_lang' : '').')
                    VALUES
                    ('.(int)$this->context->shop->id.',
                    '.(int)$this->context->shop->id_shop_group.',
                    \''.pSQL($email).'\',
                    NOW(),
                    \''.pSQL(Tools::getRemoteAddr()).'\',
                    (
                        SELECT c.http_referer
                        FROM '._DB_PREFIX_.'connections c
                        WHERE c.id_guest = '.(int)$this->context->customer->id.'
                        ORDER BY c.date_add DESC LIMIT 1
                    ),
                    '.(int)$active.'
                    '.($lang_exists ? ','.$this->context->language->id : '').'
                    )';

            return Db::getInstance()->execute($sql);
        }
    }

    public function isNewsletterRegistered($email)
    {
        if ($this->psv >= 1.7) {
            $table_name = 'emailsubscription';
        } else {
            $table_name = 'newsletter';
        }
        $sql1 = 'SELECT `email`, `active`
                FROM '._DB_PREFIX_.$table_name.'
                WHERE `email` = \''.pSQL($email).'\'
                AND id_shop = '.(int)$this->context->shop->id;


        $sql2 = 'SELECT `newsletter`
                FROM '._DB_PREFIX_.'customer
                WHERE `email` = \''.pSQL($email).'\'
                AND id_shop = '.(int)$this->context->shop->id;

        $registered_news = Db::getInstance()->getRow($sql1);
        $registered_cust = Db::getInstance()->getRow($sql2);

        if (($registered_cust && isset($registered_cust['newsletter']) && $registered_cust['newsletter'] == '1') || ($registered_news && $registered_news['active'] == 1)) {
            return true;
        }

        return false;
    }

    public function getSocialConnectButtonsVars($id_popup)
    {
        return $this->context->smarty->assign(array(
            'id_popup' => $id_popup,
            'popup_login_enable_facebook' => $this->sc_enable_facebook,
            'popup_login_enable_twitter' => $this->sc_enable_twitter,
            'popup_login_enable_google' => $this->sc_enable_google,
            'popup_gp_connect_client_id' => $this->sc_google_id,
            'callback_url' => Tools::getHTTPHost(true).__PS_BASE_URI__.'modules/'.$this->name.'/helper/twitterconnect.php',
        ));
    }

    protected function getNewsletterBlock()
    {
        $voucher_desc = str_replace("{code}", $this->nl_voucher_code, $this->nl_popup_description[$this->context->language->id]);
        $this->context->smarty->assign(array(
            'id_module' => $this->id,
            'psv' => $this->psv,
            'popup_template' => $this->popup_template,
            'nl_voucher_code' => $this->nl_voucher_code,
            'nl_terms_url' => $this->nl_terms_url,
            'nl_popup_description' => $voucher_desc,
            'module_image_dir' => _MODULE_DIR_.$this->name.'/views/img',
        ));
        return $this->display(__FILE__, 'newsletter_block.tpl');
    }

    protected function getLoginForm($id_popup)
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectButtonsVars($id_popup);
            $this->context->smarty->assign(array(
                'psv' => $this->psv,
                'id_module' => $this->id,
                'popup_template' => $this->popup_template,
                'forgot_password_url' => $this->context->link->getPageLink('password'),
                'module_image_dir' => _MODULE_DIR_.$this->name.'/views/img',

            ));
            return $this->display(__FILE__, 'login_block.tpl');
        }
    }

    protected function getRegisterForm($id_popup)
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectButtonsVars($id_popup);
            $this->context->smarty->assign(array(
                'popup_login_terms_url' => $this->log_reg_terms_url,
                'psv' => $this->psv,
                'id_module' => $this->id,
                'popup_template' => $this->popup_template,
                'module_image_dir' => _MODULE_DIR_.$this->name.'/views/img',
            ));
            return $this->display(__FILE__, 'register_block.tpl');
        }
    }


    public function getLoginAndRegisterForms($id_popup)
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectButtonsVars($id_popup);
            $this->context->smarty->assign(array(
                'psv' => $this->psv,
                'id_module' => $this->id,
                'popup_template' => $this->popup_template,
                'popup_login_terms_url' => $this->log_reg_terms_url,
                'forgot_password_url' => $this->context->link->getPageLink('password'),
                'login_box_bg' => _MODULE_DIR_.$this->name.'/views/img/upload/'.$this->log_reg_background_image,
                'login_box_bg_repeat' => $this->log_reg_background_repeat,
                'module_image_dir' => _MODULE_DIR_.$this->name.'/views/img',
            ));
            return $this->display(__FILE__, 'login_and_register_block.tpl');
        }
    }

    public function isTypeRequireSize($type)
    {
        $no_size_types = array('login', 'register', 'login_and_register', 'newsletter');
        if (in_array($type, $no_size_types)) {
            return false;
        }

        return true;
    }

    public function hookDisplayHeader()
    {
        $content = '';
        if ($this->log_reg_login_enable && $this->log_reg_register_enable) {
            $content = $this->getLoginAndRegisterForms(0);
        } elseif ($this->log_reg_login_enable && !$this->log_reg_register_enable) {
            $content = $this->getLoginForm(0);
        } elseif (!$this->log_reg_login_enable && $this->log_reg_register_enable) {
            $content = $this->getRegisterForm(0);
        }
        $link = new Link();
        if ($this->log_reg_enable && ($this->log_reg_login_enable || $this->log_reg_register_enable)) {
            $enable_header_popup_login = true;
        } else {
            $enable_header_popup_login = false;
        }

        if ($this->log_reg_login_enable && $this->log_reg_register_enable) {
            $header_both_popups = true;
        } else {
            $header_both_popups = false;
        }

        $back = Tools::getValue('back');
        $key = Tools::safeOutput(Tools::getValue('key'));

        if (!empty($key)) {
            $back .= (strpos($back, '?') !== false ? '&' : '?').'key='.$key;
        }

        if ($back == Tools::secureReferrer(Tools::getValue('back'))) {
            $back = html_entity_decode($back);
        } else {
            $back = Tools::safeOutput($back);
        }
        $this->context->smarty->assign(
            array(
                'pn_back_url' => $back,
                'redirect' => $this->social_redirect,
                'popup_template' => $this->popup_template,
                'enable_responsive' => $this->enable_responsive,
                'resize_start_point' => $this->responsive_resize_start_point,
                'hide_start_point' => $this->responsive_hide_start_point,
                'enable_facebook_login' => $this->sc_enable_facebook,
                'enable_google_login' => $this->sc_enable_google,
                'facebook_app_id' => $this->sc_facebook_app_id,
                'gp_client_id' => $this->sc_google_id,
                'my_account_url' => $link->getPageLink('my-account'),
                'enable_header_login_popup' => $enable_header_popup_login,
                'header_both_popups' => $header_both_popups,
                'content' => $content,
                'psv' => $this->psv,
                'controller_name' => Dispatcher::getInstance()->getController(),
                'popup_secure_key' => $this->secure_key,
                'popup_sc_front_controller_dir' => $this->context->link->getModuleLink('hipopupnotification', 'connect').(Configuration::get('PS_REWRITING_SETTINGS') ? '?' : '&' ).'content_only=1',
                'popup_sc_loader' => Tools::getHttpHost(true).__PS_BASE_URI__.'modules/'.$this->name.'/views/img/spinner.gif',
                'image_dir' => Tools::getProtocol(Tools::usingSecureMode()).$_SERVER['HTTP_HOST'].$this->getPathUri().'views/img/upload',
                'hi_popup_module_dir' => __PS_BASE_URI__.'modules/'.$this->name,
            )
        );
        if ($this->popup_template == 'default') {
            $this->context->controller->addCSS($this->_path.'views/css/front_default.css', 'all');
        } else {
            $this->context->controller->addCSS($this->_path.'views/css/front_custom.css', 'all');
        }
        $this->context->controller->addCSS($this->_path.'views/css/front.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/social-connect.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/magnific-popup.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/animation_effects.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/jquery.magnific-popup.min.js');
        $this->context->controller->addJS(($this->_path).'views/js/jquery.cookie.js');
        $this->context->controller->addJS(($this->_path).'views/js/front.js');
        $this->context->controller->addJS(($this->_path).'views/js/login_register.js');
         $this->context->controller->addJS(($this->_path).'views/js/newsletter.js');
        $this->context->controller->addjQueryPlugin('growl');
        return $this->display(__FILE__, 'header.tpl').$this->display(__FILE__, 'sign_in_block.tpl');
    }

    /**
    * returnHookContent get hooks display content
    * @param array $params (hooks params variable)
    * @param string $hook (hooks name)
    * @return array)()
    */
    public function returnHookContent($popup_type, $id_selector = null)
    {
        $return = '';
        if ($popup_type == 'custom') {
            $popups = PopupNotification::getPopupContentByIdPopup($popup_type, $id_selector);
        } else {
            if ($id_selector != null) {
                $selector_popup = PopupNotification::getPopupContentByIdSelector($popup_type, $id_selector);
                if (!empty($selector_popup)) {
                    $popups = $selector_popup;
                } else {
                    $popups = PopupNotification::getPopupContentByIdSelector($popup_type, '0');
                }
            } else {
                $popups = PopupNotification::getPopupByPopupType($popup_type, 'active');
            }
        }

        if (!empty($popups)) {
            foreach ($popups as $popup) {
                $current_date = date("Y-m-d");
                if (($popup['date_start'] == '0000-00-00' && $popup['date_end'] == '0000-00-00') || ($popup['date_start'] <= $current_date) && ($popup['date_end'] >= $current_date)) {
                    $valid = true;
                } else {
                    $valid = false;
                }
                if ($valid) {
                    $content = '';
                    switch ($popup['content_type']) {
                        case 'html':
                            $content = $popup['content_lang'];
                            break;
                        case 'youtube':
                            $content = $this->HiPrestaClass->getYoutubeIDFromUrl($popup['content_lang']);
                            break;
                        case 'vimeo':
                            $content = $popup['content_lang'];
                            break;
                        case 'gmaps':
                            $content = $popup['content'];
                            break;
                        case 'facebook':
                            $content = $popup['content'];
                            break;
                        case 'newsletter':
                            $content = $this->getNewsletterBlock();
                            break;
                        case 'login':
                            $content = $this->getLoginForm($popup['id_hipopupnotification']);
                            break;
                        case 'register':
                            $content = $this->getRegisterForm($popup['id_hipopupnotification']);
                            break;
                        case 'login_and_register':
                            $content = $this->getLoginAndRegisterForms($popup['id_hipopupnotification']);
                            break;
                        case 'image':
                            $image = unserialize($popup['content_lang']);
                            $content = $image['image'];
                            $image_link = $image['link'];
                            break;
                        default:
                            break;
                    }

                    $this->context->smarty->assign(array(
                        'controller_name' => Dispatcher::getInstance()->getController(),
                        'id_popup' => $popup['id_hipopupnotification'],
                        'remove_padding' => ($popup['content_type'] == 'login' || $popup['content_type'] == 'register' || $popup['content_type'] == 'login_and_register') ? 'popup_remove_padding' : '',
                        'content' => $content,
                        'width' => $popup['width'],
                        'height' => $popup['height'],
                        'cookie_time' => $popup['cookie_time'],
                        'popup_type' => $popup['popup_type'],
                        'content_type' => $popup['content_type'],
                        'valid' => $valid,
                        'delay_time' => $popup['delay_time'],
                        'auto_close_time' => $popup['auto_close_time'],
                        'animation' => $popup['animation'],
                        'image_link' => isset($image_link) ? $image_link : '',
                        'image_dir' => Tools::getProtocol(Tools::usingSecureMode()).$_SERVER['HTTP_HOST'].$this->getPathUri().'views/img/upload',
                        'responsive' => $this->isTypeRequireSize($popup['content_type']),
                        'background_image' => $popup['background_image'],
                        'background_repeat' => $popup['background_repeat'],
                        'sc_facebook_app_id' => $this->sc_facebook_app_id,
                    ));
                    $return .= $this->display(__FILE__, 'popup.tpl');
                }
            }
        }
        return $return;
    }

    public function getSocialConnectHookValue($hook)
    {
        $fb_enable = false;
        $tw_enable = false;
        $gl_enable = false;
        // is Facebook active
        if ($this->sc_enable_facebook
            && $this->sc_facebook_app_id
            && $this->{'sc_facebook_position_'.$hook}) {
            $fb_enable = true;
        }
       
        // is Twitter active
        if ($this->sc_enable_twitter
            && $this->sc_twitter_key
            && $this->sc_twitter_secret
            && $this->{'sc_twitter_position_'.$hook}) {
            $tw_enable = true;
        }
        // is Google active
        if ($this->sc_enable_google
            && $this->sc_google_id
            && $this->{'sc_google_position_'.$hook}) {
            $gl_enable = true;
        }
        
        $this->context->smarty->assign(array(
            'hook' => $hook,
            'psv' => $this->psv,
            'fb_on' => $fb_enable,
            'tw_on' => $tw_enable,
            'gl_on' => $gl_enable,
            'login_page' => $this->social_redirect,
            'callback_url' => Tools::getHTTPHost(true).__PS_BASE_URI__.'modules/'
                .$this->name.'/helper/twitterconnect.php',
            'fb_button_size' => $this->{'sc_facebook_button_size_'.$hook},
            'tw_button_size' => $this->{'sc_twitter_button_size_'.$hook},
            'gl_button_size' => $this->{'sc_google_button_size_'.$hook},
        ));
    }

    public function hookDisplayNav()
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectHookValue('top');
            return $this->display(__FILE__, 'connect_buttons.tpl');
        } else {
            return false;
        }
    }

    public function hookDisplayNav2()
    {
        return $this->hookDisplayNav();
    }

    public function hookLeftColumn($params)
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectHookValue('left');
            return $this->display(__FILE__, 'connect_buttons.tpl');
        } else {
            return false;
        }
    }

    public function hookRightColumn($params)
    {
        if (!$this->context->customer->isLogged()) {
            $this->getSocialConnectHookValue('right');
            return $this->display(__FILE__, 'connect_buttons.tpl');
        } else {
            return false;
        }
    }

    public function hookDisplayHome($params)
    {
        return $this->returnHookContent('home');
    }

    public function hookDisplayFooter($params)
    {
        return $this->returnHookContent('all_pages').
        $this->returnHookContent('exit').
        $this->returnHookContent('category', '0').
        $this->returnHookContent('category', Tools::getValue('id_category')).
        $this->returnHookContent('product', '0').
        $this->returnHookContent('product', Tools::getValue('id_product'));
    }

    /*Custom hooks*/
    public function hookhipopupnotification($params)
    {
        $id = isset($params['id'])?$params['id']: null;
        return $this->returnHookContent('custom', $id);
    }
    // (GDPR) General data protection regulation Hook
    public function hookhigdpr()
    {
        if ($this->gdpr_checkbox) {
            $this->context->smarty->assign(array(
                'psv' => $this->psv,
                'id_module' => $this->id,
                'gdpr_checkbox' => $this->gdpr_checkbox,
                'gdpr_content' => $this->gdpr_content[$this->context->language->id],
            ));
            return $this->display(__FILE__, 'gdpr.tpl');
        }
    }

    public function hookHiPopupFacebookConnect($params)
    {
        if ($this->sc_enable_facebook
            && $this->sc_facebook_app_id
            && $this->sc_facebook_position_custom
            && !$this->context->customer->isLogged()) {
            $this->context->smarty->assign(array(
                'button_position' => isset($params['button_position'])?$params['button_position']:'',
                'button_size' => isset($params['button_size'])?$params['button_size']:'',
            ));
            return $this->display(__FILE__, 'facebookCustom.tpl');
        }
    }

    public function hookHiPopupTwitterConnect($params)
    {
        if ($this->sc_enable_twitter
            && $this->sc_twitter_key
            && $this->sc_twitter_secret
            && $this->sc_twitter_position_custom
            && !$this->context->customer->isLogged()) {
            $this->context->smarty->assign(array(
                'callback_url' => Tools::getHTTPHost(true).__PS_BASE_URI__.'modules/'
                    .$this->name.'/helper/twitterconnect.php',
                'button_position' => isset($params['button_position'])?$params['button_position']:'',
                'button_size' => isset($params['button_size'])?$params['button_size']:'',
            ));
            return $this->display(__FILE__, 'twitterCustom.tpl');
        }
    }

    public function hookHiPopupGoogleConnect($params)
    {
        if ($this->sc_enable_google
            && $this->sc_google_id
            && $this->sc_google_position_custom
            && !$this->context->customer->isLogged()) {
            $this->context->smarty->assign(array(
                'button_position' => isset($params['button_position'])?$params['button_position']:'',
                'button_size' => isset($params['button_size'])?$params['button_size']:'',
                'id_popup' => $this->HiPrestaClass->generateRandomString(5),
            ));
            return $this->display(__FILE__, 'googleCustom.tpl');
        }
    }


    public function sendVoucherEmail($first_name, $last_name, $email, $voucher)
    {
        $template_vars = array(
            '{firstname}' => $first_name,
            '{lastname}' => $last_name,
            '{voucher}' => $voucher,
            '{shop_name}' => Configuration::get('PS_SHOP_NAME')
        );

        Mail::Send(
            (int)$this->context->cookie->id_lang,
            'hipopup_voucher',
            $this->l('New Voucher Code'),
            $template_vars,
            $email,
            $first_name.' '.$last_name,
            null,
            null,
            null,
            null,
            _PS_ROOT_DIR_.'/modules/'.$this->name.'/mails/'
        );
    }

    /**
     * sendConfirmationMail
     * @param Customer $customer
     * @return bool
     */
    public function sendConfirmationMail(Customer $customer, $password)
    {
        return Mail::Send(
            $this->context->language->id,
            'account',
            Mail::l('Welcome!'),
            array(
                '{firstname}' => $customer->firstname,
                '{lastname}' => $customer->lastname,
                '{email}' => $customer->email,
                '{passwd}' => $password),
            $customer->email,
            $customer->firstname.' '.$customer->lastname
        );
    }


    public function hookActionDeleteGDPRCustomer($customer)
    {
        if (!empty($customer['email']) && Validate::isEmail($customer['email'])) {
            $sql1 = "DELETE FROM "._DB_PREFIX_."hinewslettervoucher WHERE email = '".pSQL($customer['email'])."'";
            $sql2 = "DELETE FROM "._DB_PREFIX_."hipopupsocialconnectuser WHERE email = '".pSQL($customer['email'])."'";
            if (Db::getInstance()->execute($sql1) && Db::getInstance()->execute($sql2)) {
                return json_encode(true);
            }
            return json_encode($this->l('Unable to delete customer using email'));
        }
    }

    public function hookActionExportGDPRData($customer)
    {
        if (!Tools::isEmpty($customer['email']) && Validate::isEmail($customer['email'])) {
            $res1 = Db::getInstance()->ExecuteS("SELECT * FROM "._DB_PREFIX_."hinewslettervoucher WHERE email = '".pSQL($customer['email'])."'");
            $res2 = Db::getInstance()->ExecuteS("SELECT * FROM "._DB_PREFIX_."hipopupsocialconnectuser WHERE email = '".pSQL($customer['email'])."'");
            $res = array_merge($res1, $res2);

            if ($res) {
                return json_encode($res);
            }
            return json_encode($this->l('Unable to export customer using email'));
        }
    }
}
