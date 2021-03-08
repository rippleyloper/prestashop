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

class WidgetPrestaShop extends WidgetBase
{
    private $_widget_name = null;
    private $_widget_instance = null;

    public function getName()
    {
        return 'ps-widget-' . $this->getWidgetInstance()->id_base;
    }

    public function getTitle()
    {
        return $this->getWidgetInstance()->name;
    }

    public function getCategories()
    {
        $category = 'prestashop';
        return array($category);
    }

    public function getIcon()
    {
        return $this->getWidgetInstance()->icon;
    }

    public function isReloadPreviewRequired()
    {
        return true;
    }

    public function getForm($instance = array())
    {
        ob_start();
        $this->getWidgetInstance()->form($instance['ps']);
        return ob_get_clean();
    }

    public function getWidgetInstance()
    {
        if (null === $this->_widget_instance) {
            $class = $this->_widget_name;
            $this->_widget_instance = new $class();
        }
        return $this->_widget_instance;
    }

    protected function _getParsedSettings()
    {
        $settings = parent::_getParsedSettings();

        if (!empty($settings['ps'])) {
            $settings['ps'] = $this->getWidgetInstance()->update($settings['ps'], array());
        }

        return $settings;
    }

    protected function _registerControls()
    {
        $instance = $this->getWidgetInstance();
        $controls = $instance->getForm();

        foreach ($controls as $key => $control) {
            if (isset($control['responsive'])) {
                $this->addResponsiveControl(
                    $key,
                    $control
                );
            } elseif (isset($control['group_type_control'])) {
                $this->addGroupControl(
                    $control['group_type_control'],
                    $control
                );
            } else {
                $this->addControl(
                    $key,
                    $control
                );
            }
        }
    }

    protected function render()
    {
        $context = \Context::getContext();
        $options = $this->getSettings();

        $widgetName = $this->getWidgetInstance()->id_base;
        $tpl = \Tools::strtolower($widgetName) . '.tpl';
        $className = 'CreativeWidget' . $widgetName;
        $widget = new $className($context);

        $context->smarty->assign($widget->parseOptions($options));
        $esc = $context->smarty->escape_html;
        $context->smarty->escape_html = 0;
        echo $context->smarty->fetch(_CE_PATH_ . 'views/templates/front/widgets/' . $tpl);
        $context->smarty->escape_html = $esc;
    }

    protected function contentTemplate()
    {
    }

    public function __construct($data = array(), $args = array())
    {
        $this->_widget_name = $args['widget_name'];
        if (!empty($args['widget_instance'])) {
            $this->_widget_instance = $args['widget_instance'];
        }
        parent::__construct($data, $args);
    }

    public function renderPlainContent($instance = array())
    {
    }
}
