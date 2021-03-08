<?php
/**
* 2007-2019 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class TtBrandlogo extends Module implements WidgetInterface
{
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'ttbrandlogo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'TemplateTrip';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->getTranslator()->trans('TT - Brand Logo', array(), 'Modules.ttbrandlogo.Admin');
        $this->description = $this->getTranslator()->trans('Displays Brand logo on homepage.', array(), 'Modules.ttbrandlogo.Admin');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
        $this->templateFile = 'module:ttbrandlogo/views/templates/hook/ttbrandlogo.tpl';
    }
    public function install()
    {
        Configuration::updateValue('TTBRAND_NAME', 0);

        return parent::install() &&
            $this->registerHook('displayHome');
    }
    public function uninstall()
    {
        return parent::uninstall()
            && Configuration::deleteByName('TTBRAND_NAME');
    }
    public function getContent()
    {
        $errors = array();
        $output = '';
        if (Tools::isSubmit('submitTTBlockBrandLogos')) {
            Configuration::updateValue('TTBRAND_NAME', (int)(Tools::getValue('TTBRAND_NAME')));
            $this->_clearCache('*');
            if (isset($errors) && count($errors)) {
                $output .= $this->displayError(implode('<br />', $errors));
            } else {
                $output .= $this->displayConfirmation($this->trans(
                    'Settings updated.',
                    array(),
                    'Admin.Global'
                ));
            }
        }

        return $output.$this->renderForm();
    }
    public function hookActionObjectManufacturerUpdateAfter()
    {
        $this->_clearCache('*');
    }
    public function hookActionObjectManufacturerAddAfter()
    {
        $this->_clearCache('*');
    }
    public function hookActionObjectManufacturerDeleteAfter()
    {
        $this->_clearCache('*');
    }

    protected function getCacheId($hookName = null)
    {
        return parent::getCacheId().'|'.$hookName;
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans(
                        'Settings',
                        array(),
                        'Admin.Global'
                    ),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                array(
                        'type' => 'switch',
                        'label' => $this->getTranslator()->trans('Display Manufacture Name', array(), 'Modules.ttbrandlogo.Admin'),
                        'name' => 'TTBRAND_NAME',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->getTranslator()->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->getTranslator()->trans('No', array(), 'Admin.Global')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans(
                        'Save',
                        array(),
                        'Admin.Actions'
                    ),
                ),
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang =
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') :
            0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitTTBlockBrandLogos';
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ) .
            '&configure=' . $this->name .
            '&tab_module=' . $this->tab .
            '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }
    public function getConfigFieldsValues()
    {
        return array(
            'TTBRAND_NAME' => (int)Tools::getValue('TTBRAND_NAME', Configuration::get('TTBRAND_NAME')),
        );
    }
    public function getWidgetVariables($hookName = null, array $configuration = array()) 
	{
        $brands = Manufacturer::getManufacturers(false, (int)Context::getContext()->language->id);
        foreach ($brands as &$brand) {
            $brand['image'] = $this->context->language->iso_code.'-default';
            $brand['link'] = $this->context->link->getManufacturerLink($brand);
            $fileExist = file_exists(
                _PS_MANU_IMG_DIR_ . $brand['id_manufacturer'] . '-' .
                ImageType::getFormattedName('medium').'.jpg'
            );

            if ($fileExist) {
                $brand['image'] = $brand['id_manufacturer'];
            }
        }

        return array(
            'brands' => $brands,
            'hookName' => $hookName,
            'configuration' => $configuration,
           	'page_link' => $this->context->link->getPageLink('manufacturer'),
            'brandname' => Configuration::get('TTBRAND_NAME'),
            'display_link_brand' => Configuration::get('PS_DISPLAY_SUPPLIERS'),
        );
    }
    public function renderWidget($hookName = null,array $configuration = array()) 
	{
        $cacheId = $this->getCacheId('ttbrandlogo');
        $isCached = $this->isCached($this->templateFile, $cacheId);
        if (!$isCached) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch($this->templateFile, $cacheId);
    }
}
