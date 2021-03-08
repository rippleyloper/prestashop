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

class GroupControlTypography extends GroupControlBase
{
    private static $_fields;

    private static $_scheme_fields_keys = array('font_family', 'font_weight');

    public static function getSchemeFieldsKeys()
    {
        return self::$_scheme_fields_keys;
    }

    public static function getType()
    {
        return 'typography';
    }

    public static function getFields()
    {
        if (null === self::$_fields) {
            self::_initFields();
        }

        return self::$_fields;
    }

    private static function _initFields()
    {
        $fields = array();

        $fields['font_size'] = array(
            'label' => _x('Size', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SLIDER,
            'size_units' => array('px', 'em', 'rem'),
            'range' => array(
                'px' => array(
                    'min' => 1,
                    'max' => 200,
                ),
            ),
            'responsive' => true,
            'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
        );

        $default_fonts = 'Sans-serif';

        if ($default_fonts) {
            $default_fonts = ', ' . $default_fonts;
        }

        $fields['font_family'] = array(
            'label' => _x('Family', 'Typography Control', 'elementor'),
            'type' => ControlsManager::FONT,
            'default' => '',
            'separator' => '',
            'selector_value' => 'font-family: {{VALUE}}' . $default_fonts . ';',
        );

        $typo_weight_options = array('' => __('Default', 'elementor'));
        foreach (array_merge(array('normal', 'bold'), range(100, 900, 100)) as $weight) {
            $typo_weight_options[$weight] = \Tools::ucfirst($weight);
        }

        $fields['font_weight'] = array(
            'label' => _x('Weight', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'default' => '',
            'options' => $typo_weight_options,
            'separator' => '',
        );

        $fields['text_transform'] = array(
            'label' => _x('Transform', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'default' => '',
            'options' => array(
                '' => __('Default', 'elementor'),
                'uppercase' => _x('Uppercase', 'Typography Control', 'elementor'),
                'lowercase' => _x('Lowercase', 'Typography Control', 'elementor'),
                'capitalize' => _x('Capitalize', 'Typography Control', 'elementor'),
            ),
            'separator' => '',
        );

        $fields['font_style'] = array(
            'label' => _x('Style', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'default' => '',
            'options' => array(
                '' => __('Default', 'elementor'),
                'normal' => _x('Normal', 'Typography Control', 'elementor'),
                'italic' => _x('Italic', 'Typography Control', 'elementor'),
                'oblique' => _x('Oblique', 'Typography Control', 'elementor'),
            ),
            'separator' => '',
        );

        $fields['line_height'] = array(
            'label' => _x('Line-Height', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SLIDER,
            'default' => array(
                'unit' => 'em',
            ),
            'range' => array(
                'px' => array(
                    'min' => 1,
                ),
            ),
            'responsive' => true,
            'size_units' => array('px', 'em'),
            'separator' => '',
            'selector_value' => 'line-height: {{SIZE}}{{UNIT}}',
        );

        $fields['letter_spacing'] = array(
            'label' => _x('Letter Spacing', 'Typography Control', 'elementor'),
            'type' => ControlsManager::SLIDER,
            'range' => array(
                'px' => array(
                    'min' => -5,
                    'max' => 10,
                    'step' => 0.1,
                ),
            ),
            'responsive' => true,
            'separator' => '',
            'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
        );

        self::$_fields = $fields;
    }

    protected function _getControls($args)
    {
        $controls = self::getFields();

        array_walk($controls, function (&$control, $control_name) use ($args) {
            $selector_value = !empty($control['selector_value']) ? $control['selector_value'] : str_replace('_', '-', $control_name) . ': {{VALUE}};';

            $control['selectors'] = array(
                $args['selector'] => $selector_value,
            );

            $control['condition'] = array(
                'typography' => array('custom'),
            );
        });

        $typography_control = array(
            'typography' => array(
                'label' => _x('Typography', 'Typography Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => __('Default', 'elementor'),
                    'custom' => __('Custom', 'elementor'),
                ),
            ),
        );

        /*
         *  Custom Typography switch control version
         *
        $typography_control = array(
        'typography' => array(
        'label' => _x( 'Custom Typography', 'Typography Control', 'elementor' ),
        'type' => ControlsManager::SWITCHER,
        'default' => '',
        'return_value' => 'custom',
        ),
        );
         */

        $controls = $typography_control + $controls;

        return $controls;
    }

    protected function _addGroupArgsToControl($control_id, $control_args)
    {
        $control_args = parent::_addGroupArgsToControl($control_id, $control_args);

        $args = $this->getArgs();

        if (in_array($control_id, self::getSchemeFieldsKeys()) && !empty($args['scheme'])) {
            $control_args['scheme'] = array(
                'type' => self::getType(),
                'value' => $args['scheme'],
                'key' => $control_id,
            );
        }

        return $control_args;
    }
}
