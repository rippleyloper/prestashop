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

class Repeater extends ElementBase
{
    public function getName()
    {
        return 'repeater';
    }

    public static function getType()
    {
        return 'repeater';
    }

    public function _getChildType(array $element_data)
    {
        return false;
    }

    public function addControl($id, $args)
    {
        if (null !== $this->_current_tab) {
            $args = array_merge($args, $this->_current_tab);
        }

        return Plugin::instance()->controls_manager->addControlToStack($this, $id, $args);
    }
}
