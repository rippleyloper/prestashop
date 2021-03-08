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

class GroupControlBorder extends GroupControlBase
{
    public static function getType()
    {
        return 'border';
    }

    protected function _getControls($args)
    {
        $controls = array();

        $property = 'border';
        if (isset($args['property']) && ($args['property'] == 'outline')) {
            $property = 'outline';
        }

        $controls['border'] = array(
            'label' => _x('Border Type', 'Border Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'options' => array(
                '' => __('None', 'elementor'),
                'solid' => _x('Solid', 'Border Control', 'elementor'),
                'double' => _x('Double', 'Border Control', 'elementor'),
                'dotted' => _x('Dotted', 'Border Control', 'elementor'),
                'dashed' => _x('Dashed', 'Border Control', 'elementor'),
            ),
            'default' => empty($args['default']['border']) ? '' : $args['default']['border'],
            'selectors' => array(
                $args['selector'] => $property . '-style: {{VALUE}};',
            ),
            'separator' => 'before',
        );

        $controls['width'] = array(
            'label' => _x('Border Width', 'Border Control', 'elementor'),
            'type' => ControlsManager::DIMENSIONS,
            'selectors' => array(
                $args['selector'] => $property . '-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'default' => empty($args['default']['width']) ? '' : $args['default']['width'],
            'condition' => array(
                'border!' => '',
            ),
        );

        $controls['color'] = array(
            'label' => _x('Border Color', 'Border Control', 'elementor'),
            'type' => ControlsManager::COLOR,
            'default' => empty($args['default']['color']) ? '' : $args['default']['color'],
            'selectors' => array(
                $args['selector'] => $property . '-color: {{VALUE}};',
            ),
            'condition' => array(
                'border!' => '',
            ),
        );

        return $controls;
    }
}
