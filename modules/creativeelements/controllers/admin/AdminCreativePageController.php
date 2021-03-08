<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

require_once _PS_MODULE_DIR_ . 'creativeelements/classes/CreativePage.php';

class AdminCreativePageController extends ModuleAdminController
{
    public $bootstrap = true;

    public function __construct()
    {
        $this->table = 'creativepage';
        $this->identifier = 'id';
        $this->className = 'CreativePage';
        $this->lang = true;
        parent::__construct();

        if ((Tools::getIsset('updatecreativepage') || Tools::getIsset('addcreativepage')) && Shop::getContextShopID() === null) {
            $this->displayWarning(
                $this->trans('You are in a multistore context: any modification will impact all your shops, or each shop of the active group.', array(), 'Admin.Catalog.Notification')
            );
        }

        $this->addRowAction('edit');
        // $this->addRowAction('duplicate');
        $this->addRowAction('delete');

        $table_shop = _DB_PREFIX_ . $this->table . '_shop';
        $this->_join = "LEFT JOIN $table_shop sa ON sa.id = a.id AND b.id_shop = sa.id_shop";
        $this->_where = "AND sa.id_shop = {$this->context->shop->id} AND id_page = 0 AND active < " . CreativePage::TPL_ACTIVE;
        $this->_orderBy = 'title';
        $this->_use_found_rows = false;

        $this->fields_list = array(
            'id' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'orderby' => true,
            ),
            'title' => array(
                'title' => $this->trans('Title', array(), 'Admin.Global'),
                'orderby' => true,
            ),
            'type' => array(
                'title' => $this->trans('Position', array(), 'Admin.Global'),
                'orderby' => true,
            ),
            'active' => array(
                'title' => $this->trans('Displayed', array(), 'Admin.Global'),
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
            ),
            'date_add' => array(
                'title' => $this->trans('Created on', array(), 'Modules.Facetedsearch.Admin'),
                'class' => 'fixed-width-lg',
                'type' => 'datetime',
            ),
            'date_upd' => array(
                'title' => $this->l('Modified on'),
                'class' => 'fixed-width-lg',
                'type' => 'datetime',
            ),
        );

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->trans('Delete selected', array(), 'Admin.Notifications.Info'),
                'icon' => 'icon-trash',
                'confirm' => $this->trans('Delete selected items?', array(), 'Admin.Notifications.Info')
            ),
        );
    }

    public function setHelperDisplay(Helper $helper)
    {
        parent::setHelperDisplay($helper);
        // PS 1.7.6.1 compatibility fix
        if (version_compare(_PS_VERSION_, '1.7.6.1', '>=')) {
            $helper->identifier = 'id_creativepage';
        }
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addJquery();
        $this->js_files[] = _MODULE_DIR_ . 'creativeelements/views/lib/select2/js/select2.min.js?ver=4.0.2';
        $this->css_files[_MODULE_DIR_ . 'creativeelements/views/lib/select2/css/select2.min.css?ver=4.0.2'] = 'all';

        return parent::setMedia($isNewTheme);
    }

    public function initHeader()
    {
        parent::initHeader();
        $tabs = &$this->context->smarty->tpl_vars['tabs']->value;
        foreach ($tabs as &$tab0) {
            if ($tab0['class_name'] == 'IMPROVE') {
                foreach ($tab0['sub_tabs'] as &$tab1) {
                    if ($tab1['class_name'] == 'AdminParentThemes') {
                        foreach ($tab1['sub_tabs'] as &$tab2) {
                            if ($tab2['class_name'] == 'AdminParentCreativeElements') {
                                $sub_tabs = &$tab2['sub_tabs'];

                                $tab = Tab::getTab($this->context->language->id, Tab::getIdFromClassName('AdminCmsContent'));
                                $tab['current'] = '';
                                $tab['href'] = $this->context->link->getAdminLink('AdminCmsContent');
                                $sub_tabs[1] = $tab;

                                $tab = Tab::getTab($this->context->language->id, Tab::getIdFromClassName('AdminCategories'));
                                $tab['current'] = '';
                                $tab['href'] = $this->context->link->getAdminLink('AdminCategories');
                                $sub_tabs[2] = $tab;

                                $tab = Tab::getTab($this->context->language->id, Tab::getIdFromClassName('AdminProducts'));
                                $tab['current'] = '';
                                $tab['href'] = $this->context->link->getAdminLink('AdminProducts');
                                $sub_tabs[3] = $tab;
                                break;
                            }
                        }
                        break;
                    }
                }
                break;
            }
        }
    }

    public function initToolBarTitle()
    {
        $this->toolbar_title[] = $this->l('Place Content Anywhere');
    }

    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['add_creative_page'] = array(
                'href' => self::$currentIndex . '&addcreativepage&token=' . $this->token,
                'desc' => $this->trans('Add new', array(), 'Admin.Actions'),
                'icon' => 'process-icon-new',
            );
        }
        parent::initPageHeaderToolbar();
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        // PS 1.7.6.1 compatibility fix
        foreach ($this->_list as &$item) {
            $item['id_creativepage'] = $item['id'];
        }
    }

    public function renderList()
    {
        return str_replace(
            'id_creativepage',
            'id',
            parent::renderList()
        );
    }

    public function renderView()
    {
        if (($elem = $this->loadObject(true)) && Validate::isLoadedObject($elem)) {
            $link = $this->context->link->getAdminLink('AdminCreativePage') . '&id=' . $elem->id;
            Tools::redirectLink($link);
        }
        return $this->displayWarning($this->trans('Page not found', array(), 'Admin.Notifications.Error'));
    }

    public function renderForm()
    {
        if (($elem = $this->loadObject(true)) && Validate::isLoadedObject($elem)) {
            /** @var Attachment $elem */
            $link = $this->context->link->getAdminLink('AdminCreativePage') . '&id=' . $elem->id;
        }

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Content'),
                'icon' => 'icon-folder-close',
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->trans('Title', array(), 'Admin.Global'),
                    'name' => 'title',
                    'lang' => true,
                    'col' => 4,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->trans('Position', array(), 'Admin.Global'),
                    'name' => 'type',
                    'required' => true,
                    'col' => 3,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'content',
                    'lang' => true,
                    'col' => 4,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Displayed', array(), 'Admin.Global'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('Enabled', array(), 'Admin.Global'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Disabled', array(), 'Admin.Global'),
                        ),
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->trans('Save and stay', array(), 'Admin.Actions'),
                'stay' => true,
            ),
        );

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->trans('Shop association', array(), 'Admin.Global'),
                'name' => 'checkBoxShopAsso',
            );
        }

        return str_replace(
            'id_creativepage',
            'id',
            parent::renderForm()
        );
    }

    protected function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return empty($this->translator) ? $this->l($id) : parent::trans($id, $parameters, $domain, $locale);
    }

    protected function l($string, $module = null, $addslashes = false, $htmlentities = true)
    {
        $str = Translate::getModuleTranslation(null === $module ? 'creativeelements' : $module, $string, '', null, $addslashes || !$htmlentities);

        return $htmlentities ? $str : call_user_func('strip' . 'slashes', $str);
    }
}
