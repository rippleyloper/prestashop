<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once(_PS_MODULE_DIR_.'lgsecurity'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'LGSecurityConfiguration.php');
require_once(_PS_MODULE_DIR_.'lgsecurity'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'LGSecurityTools.php');
require_once(_PS_MODULE_DIR_.'lgsecurity'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'LGSecurityScanner.php');
require_once(_PS_MODULE_DIR_.'lgsecurity'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'LGSecurityPubli.php');

class Lgsecurity extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'lgsecurity';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Línea Gráfica';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PHPUnit vulnerability Checker');
        $this->description = $this->l('Secure your Prestashop removing PHPUnit');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('LGSECURITY_TOKEN_SEED', LGSecurityTools::generateCode());

        return parent::install() &&
            LGSecurityStack::install() &&
            $this->registerHook('backOfficeHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('LGSECURITY_TOKEN_SEED');

        return parent::uninstall() &&
            LGSecurityStack::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $link     = new Link();
        $warnings = array();
        if (Module::isInstalled('autoupgrade')) {
            $mod = Module::getInstanceByName('autoupgrade');
            if (version_compare($mod->version, '4.10.1', '<')) {
                //$link = $this->buildLinktag($link->getAdminLink('AdminModules'), $this->l('Click here to upgrade it.'));
                $warnings[] = array(
                    'message' => $this->l('Module 1-Click upgrade could be compromised, you should update it.'),
                    'href'    => $link->getAdminLink('AdminModules'),
                    'text'    => $this->l('Click here to upgrade it.'),
                );
            }
        }

        if (Module::isInstalled('pscartabandonmentpro')) {
            $mod = Module::getInstanceByName('pscartabandonmentpro');
            if (version_compare($mod->version, '2.0.10', '<')) {
                //$link = $this->buildLinktag($link->getAdminLink('AdminModules'), $this->l('Click here to upgrade it.'));
                $warnings[] = array(
                    'message' => $this->l('Module Cart Abandonment Pro could be compromised, you should update it.'),
                    'href'    => $link->getAdminLink('AdminModules'),
                    'text'    => $this->l('Click here to upgrade it.'),
                );
            }
        }

        if (Module::isInstalled('ps_facetedsearch')) {
            $mod = Module::getInstanceByName('ps_facetedsearch');
            if (version_compare($mod->version, '3.4.1', '<')) {
                //$link = $this->buildLinktag($link->getAdminLink('AdminModules'), $this->l('Click here to upgrade it.'));
                $warnings[] = array(
                    'message' => $this->l('Module Faceted Search could be compromised, you should update it.'),
                    'href'    => $link->getAdminLink('AdminModules'),
                    'text'    => $this->l('Click here to upgrade it.'),
                );
            }
        }

        if (Module::isInstalled('gamification')) {
            $mod = Module::getInstanceByName('gamification');
            if (version_compare($mod->version, '2.3.2', '<')) {
                //$link = $this->buildLinktag($link->getAdminLink('AdminModules'), $this->l('Click here to upgrade it.'));
                $warnings[] = array(
                    'message' => $this->l('Module Cart Abandonment Pro could be compromised, you should update it.'),
                    'href'    => $link->getAdminLink('AdminModules'),
                    'text'    => $this->l('Click here to upgrade it.'),
                );
            }
        }

        if (Module::isInstalled('ps_checkout')) {
            $mod = Module::getInstanceByName('ps_checkout');
            if (version_compare($mod->version, '1.2.9', '<')) {
                //$link = $this->buildLinktag($link->getAdminLink('AdminModules'), $this->l('Click here to upgrade it.'));
                $warnings[] = array(
                    'message' => $this->l('Module PrestaShop Checkout could be compromised, you should update it.'),
                    'href'    => $link->getAdminLink('AdminModules'),
                    'text'    => $this->l('Click here to upgrade it.'),
                );
            }
        }

        $items_detected = LGSecurityScanner::getInstance()->scan()->getDetected();

        $this->context->smarty->assign(
            array(
                'lgsecurity_module_name' => LGSecurityConfiguration::MODULE_NAME,
                'lgsecurity_auth_token'  => LGSecurityTools::getToken(),
                'lgsecurity_token'       => Tools::getAdminTokenLite('AdminModules'),
                'lgsecurity_list'        => $items_detected,
                'lgsecurity_result'      => count($items_detected), // 0 means OK
                'lgsecurity_warnings'    => $warnings,
            )
        );

        return LGSecurityPubli::getHeader($this)
            . $this->display($this->local_path,'views/templates/admin/configure.tpl')
            . LGSecurityPubli::getFooter($this);
    }

    /***************************************************************************************************************/
    /*                                                                                                             */
    /*                                                  Ajax Calls                                                 */
    /*                                                                                                             */
    /***************************************************************************************************************/

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if ($this->context->controller instanceof AdminModulesController &&
            pSQL(Tools::getValue('configure')) == $this->name) {
            $this->context->controller->addJquery();
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addJS($this->_path . 'views/js/loadingoverlay.min.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
            $this->context->controller->addCSS($this->_path . '/views/css/publi/lgpubli.css');
        }
    }

    /***************************************************************************************************************/
    /*                                                                                                             */
    /*                                                  Ajax Calls                                                 */
    /*                                                                                                             */
    /***************************************************************************************************************/

    public function ajaxProcessScan()
    {
        $response = array();
        $code     = 200;
        try {
            LGSecurityTools::checkToken(Tools::getValue('auth_token', ''));
            $items_detected = LGSecurityScanner::getInstance()->scan()->getDetected();
            $this->context->smarty->assign(
                array(
                    'lgsecurity_list'   => $items_detected,
                    'lgsecurity_result' => count($items_detected), // 0 means OK
                )
            );
            $html = $this->display($this->local_path,'views/templates/admin/_partials/list_content.tpl');

            $response['satus']         = 'success';
            $response['html']          = $html;
            $response['result']        = count($items_detected);
            //$response['debug']['dirs'] = LGSecurityScanner::getInstance()->getDirsScanned();
        } catch (Exception $e) {
            $code                         = 400;
            $response['satus']            = 'error';
            $response['error']['code']    = $e->getCode();
            $response['error']['message'] = $e->getMessage();
            $response['result']           = -1;
        }
        LGSecurityTools::returnAjaxResponse($response, $code);
    }

    public function ajaxProcessDeleteDir()
    {
        $response = array();
        $code     = 200;
        try {
            LGSecurityTools::checkToken(Tools::getValue('auth_token', ''));
            LGSecurityScanner::getInstance()->deleteDir((int)Tools::getValue('id_lgsecuriry_stack', 0));
            $items_detected = LGSecurityScanner::getInstance()->scan()->getDetected();
            $this->context->smarty->assign(
                array(
                    'lgsecurity_list' => $items_detected,
                    'lgsecurity_result' => count($items_detected), // 0 means OK
                )
            );
            $html = $this->display($this->local_path,'views/templates/admin/_partials/list_content.tpl');

            $response['satus']         = 'success';
            $response['html']          = $html;
            $response['result']        = count($items_detected);
            //$response['debug']['dirs'] = LGSecurityScanner::getInstance()->getDirsScanned();
        } catch (Exception $e) {
            $code                         = 400;
            $response['satus']            = 'error';
            $response['error']['code']    = $e->getCode();
            $response['error']['message'] = $e->getMessage();
        }
        LGSecurityTools::returnAjaxResponse($response, $code);
    }
}
