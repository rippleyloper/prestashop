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

class GroupControlBoxShadow extends GroupControlBase
{
    public static function getType()
    {
        return 'box-shadow';
    }

    protected function _getControls($args)
    {
        $controls = array();

        $controls['box_shadow_type'] = array(
            'label' => _x('Box Shadow', 'Box Shadow Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'options' => array(
                '' => __('No', 'elementor'),
                'outset' => _x('Yes', 'Box Shadow Control', 'elementor'),
            ),
            'separator' => 'before',
        );

        $controls['box_shadow'] = array(
            'label' => _x('Box Shadow', 'Box Shadow Control', 'elementor'),
            'type' => ControlsManager::BOX_SHADOW,
            'selectors' => array(
                $args['selector'] => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
            ),
            'condition' => array(
                'box_shadow_type!' => '',
            ),
        );

        return $controls;
    }
}
