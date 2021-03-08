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

class WidgetsManager
{
    /**
     * @var WidgetBase[]
     */
    private $_widget_types = null;

    private function _initWidgets()
    {
        $build_widgets_filename = array(
            'common',
            'heading',
            'image',
            'text-editor',
            'video',
            'button',
            'divider',
            'spacer',
            'google-maps',
            'icon',
            'facebook-page',
            'image-box',
            'icon-box',
            // 'image-gallery',
            'flip-box',
            'call-to-action',
            'image-carousel',
            'image-hotspot',
            'icon-list',
            'counter',
            'progress',
            'testimonial',
            'tabs',
            'accordion',
            'toggle',
            'social-icons',
            'alert',
            // 'audio',
            'html',
            'menu-anchor',
            // PS
            'ajax-search',
            // 'login',
            'trustedshops-reviews',
            'product-grid',
        );

        // skip following widgets on PS 1.6.x
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $build_widgets_filename[] = 'product-carousel';
            $build_widgets_filename[] = 'image-slider';
            $build_widgets_filename[] = 'email-subscription';
            $build_widgets_filename[] = 'category-tree';
        }

        $this->_widget_types = array();

        foreach ($build_widgets_filename as $widget_filename) {
            include _CE_PATH_ . 'includes/widgets/' . $widget_filename . '.php';

            $class_name = __NAMESPACE__ . '\Widget' . str_replace('-', '', $widget_filename);

            $this->registerWidgetType(new $class_name());
        }

        $this->_registerPsWidgets();
    }

    private function _registerPsWidgets()
    {
        include _CE_PATH_ . 'includes/widgets/prestashop.php';

        $widgets = glob(_CE_PATH_ . 'classes/widgets/CreativeWidget*.php');

        foreach ($widgets as $widget_file) {
            include $widget_file;

            $elementor_widget_class = __NAMESPACE__ . '\WidgetPrestaShop';
            $widget_class = basename($widget_file, '.php');

            // skip Module widget on PS 1.6.x
            if ($widget_class == 'CreativeWidgetModule' && version_compare(_PS_VERSION_, '1.7', '<')) {
                continue;
            }

            if (!property_exists($widget_class, 'require') || ($req = new \ReflectionProperty($widget_class, 'require')) && \Module::isEnabled($req->getValue())) {
                $widget = new $elementor_widget_class(array(), array(
                    'widget_name' => $widget_class,
                ));

                $this->registerWidgetType($widget);
            }
        }
    }

    private function _requireFiles()
    {
        require_once _CE_PATH_ . 'includes/base/element-base.php';
        require _CE_PATH_ . 'includes/base/widget-base.php';
        // require _CE_PATH_ . 'includes/widgets/multi-section-base.php';
    }

    public function registerWidgetType(WidgetBase $widget)
    {
        if (is_null($this->_widget_types)) {
            $this->_initWidgets();
        }

        $this->_widget_types[$widget->getName()] = $widget;

        return true;
    }

    public function unregisterWidgetType($name)
    {
        if (!isset($this->_widget_types[$name])) {
            return false;
        }

        unset($this->_widget_types[$name]);

        return true;
    }

    public function getWidgetTypes($widget_name = null)
    {
        if (is_null($this->_widget_types)) {
            $this->_initWidgets();
        }

        if (null !== $widget_name) {
            return isset($this->_widget_types[$widget_name]) ? $this->_widget_types[$widget_name] : null;
        }

        return $this->_widget_types;
    }

    public function getWidgetTypesConfig()
    {
        $config = array();

        foreach ($this->getWidgetTypes() as $widget_key => $widget) {
            if ('common' === $widget_key) {
                continue;
            }

            $config[$widget_key] = $widget->getConfig();
        }

        return $config;
    }

    public function ajaxRenderWidget()
    {
        $data = empty(${'_POST'}['data']) ? '' : ${'_POST'}['data'];
        $data = json_decode(html_entity_decode($data), true);
        $render_html = 'Missing widget: ' . $data['widgetType'];

        // Start buffering
        ob_start();

        /** @var WidgetBase|WidgetPrestaShop $widget_type */
        $widget_type = $this->getWidgetTypes($data['widgetType']);

        if ($widget_type) {
            $widget_class = $widget_type->getClassName();

            /** @var WidgetBase $widget */
            $widget = new $widget_class($data, $widget_type->getDefaultArgs());

            $widget->renderContent();

            $render_html = ob_get_clean();
        }

        wp_send_json_success(array(
            'render' => $render_html,
        ));
    }

    public function renderWidgetsContent()
    {
        foreach ($this->getWidgetTypes() as $widget) {
            $widget->printTemplate();
        }
    }

    public function __construct()
    {
        $this->_requireFiles();
    }
}
