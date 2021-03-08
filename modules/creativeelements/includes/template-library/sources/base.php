<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements\TemplateLibrary;

defined('_PS_VERSION_') or exit;

use CreativeElements\Plugin;
use CreativeElements\Utils;

abstract class SourceBase
{
    abstract public function getId();

    abstract public function getTitle();

    // abstract public function registerData();

    abstract public function getItems();

    abstract public function getItem($item_id);

    abstract public function getContent($item_id);

    abstract public function deleteTemplate($item_id);

    abstract public function saveItem($template_data);

    abstract public function updateItem($new_data);

    abstract public function exportTemplate($item_id);
/*
    public function __construct()
    {
        $this->registerData();
    }
*/
    protected function replaceElementsIds($data)
    {
        return Plugin::instance()->db->iterateData($data, function ($element) {
            $element['id'] = Utils::generateRandomString();

            return $element;
        });
    }

    /**
     * @param array $data a set of elements
     * @param string $method (onExport|onImport)
     *
     * @return mixed
     */
    protected function processExportImportData($data, $method)
    {
        return Plugin::instance()->db->iterateData($data, function ($element) use ($method) {

            if ('widget' === $element['elType']) {
                $element_class = Plugin::instance()->widgets_manager->getWidgetTypes($element['widgetType']);
            } else {
                $element_class = Plugin::instance()->elements_manager->getElementTypes($element['elType']);
            }

            // If the widget/element isn't exist, like a plugin that creates a widget but deactivated
            if (!$element_class) {
                return $element;
            }

            if (method_exists($element_class, $method)) {
                $element = $element_class->{$method}($element);
            }

            foreach ($element_class->getControls() as $control) {
                $control_class = Plugin::instance()->controls_manager->getControl($control['type']);

                // If the control isn't exist, like a plugin that creates the control but deactivated
                if (!$control_class) {
                    return $element;
                }

                if (method_exists($control_class, $method)) {
                    $element['settings'][$control['name']] = $control_class->{$method}($element['settings'][$control['name']]);
                }
            }

            return $element;
        });
    }
}
