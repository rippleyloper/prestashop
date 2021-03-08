<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements;

defined('_PS_VERSION_') or exit;

class Editor
{
    private $_is_edit_mode;

    private $_editor_templates = array(
        'editor-templates/global.php',
        'editor-templates/panel.php',
        'editor-templates/panel-elements.php',
        'editor-templates/repeater.php',
        'editor-templates/templates.php',
    );

    public function __construct()
    {
        $context = \Context::getContext();
        $this->_is_edit_mode = !empty($context->controller->name) && $context->controller->name == 'CreativeEditor';
    }

    public function init()
    {
        if (!$this->isEditMode()) {
            return;
        }
        /*
        add_filter('show_admin_bar', '__return_false');

        // Remove all WordPress actions
        remove_all_actions('wp_head');
        remove_all_actions('wp_print_styles');
        remove_all_actions('wp_print_head_scripts');
        remove_all_actions('wp_footer');
        */

        // Handle `wp_head`
        add_action('wp_head', 'wp_enqueue_scripts', 1);
        add_action('wp_head', 'wp_print_styles', 8);
        add_action('wp_head', 'wp_print_head_scripts', 9);
        add_action('wp_head', array($this, 'editor_head_trigger'), 30);

        // Handle `wp_footer`
        add_action('wp_footer', 'wp_print_footer_scripts', 20);
        // add_action('wp_footer', 'wp_auth_check_html', 30);
        add_action('wp_footer', array($this, 'wp_footer'));

        // Handle `wp_enqueue_scripts`
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 999999);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'), 999999);
        /*
        $post_id = get_the_ID();

        // Change mode to Builder
        Plugin::instance()->db->set_edit_mode($post_id);

        // Post Lock
        if (!$this->get_locked_user($post_id)) {
            $this->lock_post($post_id);
        }

        // Setup default heartbeat options
        add_filter('heartbeat_settings', function ($settings) {
            $settings['interval'] = 15;
            return $settings;
        });

        // Tell to WP Cache plugins do not cache this request.
        Utils::do_not_cache();
        */

        // Print the panel
        $this->printPanelHtml();
        die;
    }

    public function isEditMode()
    {
        return $this->_is_edit_mode;
    }

    public function printPanelHtml()
    {
        include 'editor-templates/editor-wrapper.php';
    }

    public function enqueueScripts()
    {
        // $post_id = get_the_ID();
        $plugin = Plugin::instance();

        // $editor_data = $plugin->db->get_builder($post_id, DB::REVISION_DRAFT);

        $suffix = defined('_PS_MODE_DEV_') && _PS_MODE_DEV_ ? '' : '.min';

        // Hack for waypoint with editor mode.
        wp_register_script(
            'waypoints',
            _CE_ASSETS_URL_ . 'lib/waypoints/waypoints-for-editor.js',
            array(
                'jquery',
            ),
            '2.0.2',
            true
        );

        // Enqueue frontend scripts too
        $plugin->frontend->enqueueScripts();

        wp_register_script(
            'backbone-marionette',
            _CE_ASSETS_URL_ . 'lib/backbone/backbone.marionette' . $suffix . '.js',
            array(
                'backbone',
            ),
            '2.4.5',
            true
        );

        wp_register_script(
            'backbone-radio',
            _CE_ASSETS_URL_ . 'lib/backbone/backbone.radio' . $suffix . '.js',
            array(
                'backbone',
            ),
            '1.0.4',
            true
        );

        wp_register_script(
            'perfect-scrollbar',
            _CE_ASSETS_URL_ . 'lib/perfect-scrollbar/perfect-scrollbar.jquery' . $suffix . '.js',
            array(
                'jquery',
            ),
            '0.6.12',
            true
        );

        wp_register_script(
            'jquery-easing',
            _CE_ASSETS_URL_ . 'lib/jquery-easing/jquery-easing' . $suffix . '.js',
            array(
                'jquery',
            ),
            '1.3.2',
            true
        );

        wp_register_script(
            'nprogress',
            _CE_ASSETS_URL_ . 'lib/nprogress/nprogress' . $suffix . '.js',
            array(),
            '0.2.0',
            true
        );

        wp_register_script(
            'tipsy',
            _CE_ASSETS_URL_ . 'lib/tipsy/tipsy' . $suffix . '.js',
            array(
                'jquery',
            ),
            '1.0.0',
            true
        );

        wp_register_script(
            'imagesloaded',
            _CE_ASSETS_URL_ . 'lib/imagesloaded/imagesloaded' . $suffix . '.js',
            array(
                'jquery',
            ),
            '4.1.0',
            true
        );

        wp_register_script(
            'elementor-dialog',
            _CE_ASSETS_URL_ . 'lib/dialog/dialog' . $suffix . '.js',
            array(
                'jquery-ui-position',
            ),
            '3.0.0',
            true
        );

        wp_register_script(
            'jquery-select2',
            _CE_ASSETS_URL_ . 'lib/select2/js/select2' . $suffix . '.js',
            array(
                'jquery',
            ),
            '4.0.2',
            true
        );

        wp_register_script(
            'jquery-simple-dtpicker',
            _CE_ASSETS_URL_ . 'lib/jquery-simple-dtpicker/jquery.simple-dtpicker' . $suffix . '.js',
            array(
                'jquery',
            ),
            '1.12.0',
            true
        );

        wp_register_script(
            'elementor-editor',
            _CE_ASSETS_URL_ . 'js/editor' . $suffix . '.js',
            array(
                // 'wp-auth-check',
                'jquery-ui-sortable',
                'jquery-ui-resizable',
                'backbone-marionette',
                'backbone-radio',
                'perfect-scrollbar',
                'jquery-easing',
                'nprogress',
                'tipsy',
                'imagesloaded',
                // 'heartbeat',
                'elementor-dialog',
                'jquery-select2',
                'jquery-simple-dtpicker',
            ),
            _CE_VERSION_,
            true
        );
        wp_enqueue_script('elementor-editor');
        wp_enqueue_script('ce-migrate', _CE_ASSETS_URL_ . 'js/migrate.js', array(), _CE_VERSION_, true);
        /*
        // Tweak for WP Admin menu icons
        wp_print_styles('editor-buttons');

        $locked_user = $this->get_locked_user($post_id);
        if ($locked_user) {
            $locked_user = $locked_user->display_name;
        }
        */
        $context = \Context::getContext();
        $id = (int) \Tools::getValue('id_page');
        $id_lang = (int) \Tools::getValue('id_lang', $context->language->id);
        $type = \Tools::getValue('type');
        $preview_args = array(
            'id_employee' => $context->employee->id,
        );
        $editor_data = '';

        if (!$id) {
            $id = (int) \Tools::getValue('id');
            $type = \Tools::strtolower($type);
        }

        switch ($type) {
            case 'cms':
                $editor_data = (array) json_decode(\CreativePage::getData($type, $id, $id_lang), true);
                if (empty($editor_data)) {
                    $page = new \CMS($id, $id_lang);
                    $editor_data = $plugin->db->getDataFromContent($page->content);
                }
                $edit_post_link = $context->link->getAdminLink('AdminCmsContent') . "&id_cms=$id&updatecms";
                $permalink = $context->link->getCMSLink($id, null, null, $id_lang, null, true);
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminCmsContent');
                break;
            case 'category':
                $editor_data = (array) json_decode(\CreativePage::getData($type, $id, $id_lang), true);
                if (empty($editor_data)) {
                    $page = new \Category($id, $id_lang);
                    $editor_data = $plugin->db->getDataFromContent($page->description);
                }
                $edit_post_link = $context->link->getAdminLink('AdminCategories') . "&id_category=$id&updatecategory";
                $permalink = $context->link->getCategoryLink($id, null, $id_lang, null, null, true);
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminCreativePage');
                break;
            case 'product':
                $editor_data = (array) json_decode(\CreativePage::getData($type, $id, $id_lang), true);
                $prod = new \Product($id, false, $id_lang);
                if (empty($editor_data)) {
                    $editor_data = $plugin->db->getDataFromContent($prod->description);
                }
                $edit_post_link = $context->link->getAdminLink('AdminProducts') . "&id_product=$id&updateproduct";
                $prod_attr = empty($prod->cache_default_attribute) ? 0 : $prod->cache_default_attribute;
                $permalink = $context->link->getProductLink($prod, null, null, null, $id_lang, null, $prod_attr, false, true);
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminProducts');
                break;
            case 'ybc_blog_post_class':
                $editor_data = (array) json_decode(\CreativePage::getData($type, $id, $id_lang), true);
                if (empty($editor_data)) {
                    $page = new \Ybc_blog_post_class($id, $id_lang);
                    $editor_data = $plugin->db->getDataFromContent($page->description);
                }
                $edit_post_link = $context->link->getAdminLink('AdminModules') . '&configure=ybc_blog&tab_module=front_office_features&module_name=ybc_blog&control=post&id_post=' . $id;
                $permalink = \Module::getInstanceByName('ybc_blog')->getLink('blog', array('id_post' => $id), $id_lang);
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminCreativePage');
                break;
            case 'displayFooterProduct':
                $editor_data = (array) json_decode(\CreativePage::getData($type, $id, $id_lang), true);
                $edit_post_link = $context->controller->productLink . "&id_product=$id&updateproduct";
                $page = new \Product($id, false, $id_lang);
                $prod_attr = empty($prod->cache_default_attribute) ? 0 : $prod->cache_default_attribute;
                $permalink = $context->link->getProductLink($page, null, null, null, $id_lang, null, $prod_attr, false, true);
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminProducts');
                break;
            default:
                $elem = new \CreativePage($id, $id_lang);
                $editor_data = (array) json_decode($elem->data, true);
                $edit_post_link = $context->link->getAdminLink('AdminCreativePage') . "&id=$id&updatecreativepage";
                if (in_array($type, Helper::$productHooks)) {
                    $prods = \Product::getProducts($id_lang, 0, 1, 'date_upd', 'DESC', false, true);
                    $prod = new \Product(!empty($prods[0]['id_product']) ? $prods[0]['id_product'] : null, false, $id_lang);
                    $prod_attr = empty($prod->cache_default_attribute) ? 0 : $prod->cache_default_attribute;
                    $permalink = $context->link->getProductLink($prod, null, null, null, $id_lang, null, $prod_attr, false, true);
                } else {
                    $page = stripos($type, 'displayShoppingCart') === 0 ? 'cart' : 'index';
                    $permalink = $context->link->getPageLink($page, null, $id_lang, null, false, null, true);
                    if ($page == 'cart') {
                        $preview_args['action'] = 'show';
                    }
                }
                $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminCreativePage');
                $preview_args['id'] = $id;
                break;
        }

        if (\Tools::getIsset('force')) {
            $permalink = $context->link->getModuleLink('creativeelements', 'preview', array(), true, $id_lang);
            $preview_args['adtoken'] = \Tools::getAdminTokenLite('AdminCreativePage');
        }
        $permalink = explode('#', $permalink)[0] . (\Tools::strpos($permalink, '?') === false ? '?' : '&') . http_build_query($preview_args);

        wp_localize_script(
            'elementor-editor',
            'ElementorConfig',
            array(
                'ajaxurl' => $context->link->getAdminLink('CreativeEditor', true) . '&ajax',
                'home_url' => __PS_BASE_URI__,
                'preview_link' => $permalink . '&cp_type=' . $type,
                'elements_categories' => $plugin->elements_manager->getCategories(),
                'controls' => $plugin->controls_manager->getControlsData(),
                'elements' => $plugin->elements_manager->getElementTypesConfig(),
                'widgets' => $plugin->widgets_manager->getWidgetTypesConfig(),
                'schemes' => array(
                    'items' => $plugin->schemes_manager->getRegisteredSchemesData(),
                    'enabled_schemes' => SchemesManager::getEnabledSchemes(),
                ),
                'default_schemes' => $plugin->schemes_manager->getSchemesDefaults(),
                'system_schemes' => $plugin->schemes_manager->getSystemSchemes(),
                'post_id' => $id,
                'lang_id' => $id_lang,
                'post_type' => $type,
                'post_permalink' => $permalink,
                'edit_post_link' => $edit_post_link,
                // 'settings_page_link' => Settings::get_url(),
                'elementor_site' => __('https://addons.prestashop.com/administrative-tools/44064-creative-elements-elementor-based-pagebuilder.html'),
                // 'help_the_content_url' => __('http://docs.webshopworks.com/CreativeElements.pdf'),
                'assets_url' => _CE_ASSETS_URL_,
                'data' => $editor_data,
                'locked_user' => false, // $locked_user,
                'is_rtl' => !empty($context->language->is_rtl),
                'locale' => $context->language->iso_code,
                'introduction' => $plugin->getCurrentIntroduction(), //User::get_introduction(),
                'viewportBreakpoints' => Responsive::getBreakpoints(),
                'i18n' => array(
                    'elementor' => __('Creative Elements', 'elementor'),
                    'dialog_confirm_delete' => __('Are you sure you want to remove this {0}?', 'elementor'),
                    'dialog_user_taken_over' => __('{0} has taken over and is currently editing. Do you want to take over this page editing?', 'elementor'),
                    'delete' => __('Delete', 'elementor'),
                    'cancel' => __('Cancel', 'elementor'),
                    'delete_element' => __('Delete {0}', 'elementor'),
                    'take_over' => __('Take Over', 'elementor'),
                    'go_back' => __('Go Back', 'elementor'),
                    'saved' => __('Saved', 'elementor'),
                    'before_unload_alert' => __('Please note: All unsaved changes will be lost.', 'elementor'),
                    'edit_element' => __('Edit {0}', 'elementor'),
                    'global_colors' => __('Global Colors', 'elementor'),
                    'global_fonts' => __('Global Fonts', 'elementor'),
                    'elementor_settings' => __('Creative Elements Settings', 'elementor'),
                    'soon' => __('Soon', 'elementor'),
                    'revisions_history' => __('Revisions History', 'elementor'),
                    'about_elementor' => __('About Creative Elements', 'elementor'),
                    'inner_section' => __('Columns', 'elementor'),
                    'dialog_confirm_gallery_delete' => __('Are you sure you want to reset this gallery?', 'elementor'),
                    'delete_gallery' => __('Reset Gallery', 'elementor'),
                    'gallery_images_selected' => __('{0} Images Selected', 'elementor'),
                    'insert_media' => __('Insert Media', 'elementor'),
                    'preview_el_not_found_header' => __('Sorry, the content area was not found in this page.', 'elementor'),
                    'preview_el_not_found_message' => __('This position is not supported by your theme, or your site is in Maintenance mode.', 'elementor'),
                    'learn_more' => __('Force Edit', 'elementor'),
                    'an_error_occurred' => __('An error occurred', 'elementor'),
                    'templates_request_error' => __('The following error occurred when processing the request:', 'elementor'),
                    'save_your_template' => __('Save Your {0} to Library', 'elementor'),
                    'page' => __('Page', 'elementor'),
                    'section' => __('Section', 'elementor'),
                    'delete_template' => __('Delete Template', 'elementor'),
                    'delete_template_confirm' => __('Are you sure you want to delete this template?', 'elementor'),
                    'color_picker' => __('Color Picker', 'elementor'),
                    'clear_page' => __('Delete All Content', 'elementor'),
                    'dialog_confirm_clear_page' => __('Attention! We are going to DELETE ALL CONTENT from this page. Are you sure you want to do that?', 'elementor'),
                    'asc' => __('Ascending order', 'elementor'),
                    'desc' => __('Descending order', 'elementor'),
                ),
            )
        );

        $plugin->controls_manager->enqueueControlScripts();
    }

    public function enqueueStyles()
    {
        $suffix = defined('_PS_MODE_DEV_') && _PS_MODE_DEV_ ? '' : '.min';

        $direction_suffix = \Context::getContext()->language->is_rtl ? '-rtl' : '';

        wp_register_style(
            'font-awesome',
            _CE_ASSETS_URL_ . 'lib/font-awesome/css/font-awesome' . $suffix . '.css',
            array(),
            '4.7.0'
        );

        wp_register_style(
            'select2',
            _CE_ASSETS_URL_ . 'lib/select2/css/select2' . $suffix . '.css',
            array(),
            '4.0.2'
        );

        wp_register_style(
            'elementor-icons',
            _CE_ASSETS_URL_ . 'lib/eicons/css/elementor-icons' . $suffix . '.css',
            array(),
            _CE_VERSION_
        );

        wp_register_style(
            'google-font-roboto',
            'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
            array(),
            _CE_VERSION_
        );

        wp_register_style(
            'jquery-simple-dtpicker',
            _CE_ASSETS_URL_ . 'lib/jquery-simple-dtpicker/jquery.simple-dtpicker' . $suffix . '.css',
            array(),
            '1.12.0'
        );

        wp_register_style(
            'elementor-editor',
            _CE_ASSETS_URL_ . 'css/editor' . $direction_suffix . $suffix . '.css',
            array(
                'font-awesome',
                'select2',
                'elementor-icons',
                'wp-auth-check',
                'google-font-roboto',
                'jquery-simple-dtpicker',
            ),
            _CE_VERSION_
        );

        wp_enqueue_style('elementor-editor');
    }

    public function editorHeadTrigger()
    {
        do_action('elementor/editor/wp_head');
    }

    public function wpFooter()
    {
        $plugin = Plugin::instance();

        $plugin->controls_manager->renderControls();
        $plugin->widgets_manager->renderWidgetsContent();
        $plugin->elements_manager->renderElementsContent();

        $plugin->schemes_manager->printSchemesTemplates();

        foreach ($this->_editor_templates as $editor_template) {
            include $editor_template;
        }
    }

    /**
     * @param bool $edit_mode
     */
    public function setEditMode($edit_mode)
    {
        $this->_is_edit_mode = $edit_mode;
    }
}
