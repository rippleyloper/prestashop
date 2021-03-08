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

abstract class ControlBaseMultiple extends ControlBase
{
    public function getDefaultValue()
    {
        return array();
    }

    public function getValue($control, $instance)
    {
        $value = parent::getValue($control, $instance);

        if (empty($control['default'])) {
            $control['default'] = array();
        }

        if (!is_array($value)) {
            $value = array();
        }

        $control['default'] = array_merge(
            $this->getDefaultValue(),
            $control['default']
        );

        return array_merge(
            $control['default'],
            $value
        );
    }

    public function getReplacedStyleValues($css_property, $control_value)
    {
        if (!is_array($control_value)) {
            return '';
        }

        // Trying to retrieve whole the related properties
        // according to the string matches.
        // When one of the properties is empty, aborting
        // the action and returning an empty string.
        try {
            return preg_replace_callback('/\{\{([A-Z]+)}}/', function ($matches) use ($control_value) {
                $value = $control_value[\Tools::strtolower($matches[1])];

                if ('' === $value) {
                    throw new \Exception();
                }

                if ($matches[1] == 'URL') {
                    $value = Helper::getMediaLink($value);
                }

                return $value;
            }, $css_property);
        } catch (\Exception $e) {
            return '';
        }
    }
}
