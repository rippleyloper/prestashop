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

abstract class GroupControlBase implements GroupControlInterface
{
    private $_args = array();

    public function __construct()
    {
        $this->_init();
    }

    public function getControlsPrefix()
    {
        return $this->getArgs()['name'] . '_';
    }

    public function getBaseGroupClasses()
    {
        return 'elementor-group-control-' . static::getType() . ' elementor-group-control';
    }

    final public function addControls(ElementBase $element, $user_args)
    {
        $this->_initArgs($user_args);

        // Filter witch controls to display
        $filtered_controls = $this->_filterControls();

        // Add prefixes to all control conditions
        $filtered_controls = $this->addPrefixes($filtered_controls);

        foreach ($filtered_controls as $control_id => $control_args) {
            // Add the global group args to the control
            $control_args = $this->_addGroupArgsToControl($control_id, $control_args);

            // Register the control
            $id = $this->getControlsPrefix() . $control_id;

            if (!empty($control_args['responsive'])) {
                unset($control_args['responsive']);

                $element->addResponsiveControl($id, $control_args);
            } else {
                $element->addControl($id, $control_args);
            }
        }
    }

    final public function getArgs()
    {
        return $this->_args;
    }

    protected function _init()
    {
        add_action('elementor/elements/add_group_control/' . static::getType(), array($this, 'add_controls'), 10, 2);
    }

    protected function _getChildDefaultArgs()
    {
        return array();
    }

    abstract protected function _getControls($args);

    private function _getDefaultArgs()
    {
        return array(
            'default' => '',
            'selector' => '{{WRAPPER}}',
            'fields' => 'all',
        );
    }

    private function _initArgs($args)
    {
        $this->_args = array_merge($this->_getDefaultArgs(), $this->_getChildDefaultArgs(), $args);
    }

    private function _filterControls()
    {
        $args = $this->getArgs();

        $controls = $this->_getControls($args);

        if (!is_array($args['fields'])) {
            return $controls;
        }

        $filtered_controls = array_intersect_key($controls, array_flip($args['fields']));

        // Include all condition depended controls
        foreach ($filtered_controls as $control) {
            if (empty($control['condition'])) {
                continue;
            }

            $depended_controls = array_intersect_key($controls, $control['condition']);
            $filtered_controls = array_merge($filtered_controls, $depended_controls);
            $filtered_controls = array_intersect_key($controls, $filtered_controls);
        }

        return $filtered_controls;
    }

    private function addConditionsPrefix($control)
    {
        $self = $this;
        $prefixed_condition_keys = array_map(
            function ($key) use ($self) {
                return $self->getControlsPrefix() . $key;
            },
            array_keys($control['condition'])
        );
        $control['condition'] = array_combine(
            $prefixed_condition_keys,
            $control['condition']
        );
        return $control;
    }

    private function addSelectorsPrefix($control)
    {
        $self = $this;
        foreach ($control['selectors'] as &$selector) {
            $selector = preg_replace_callback('/(?:\{\{)\K[^.}]+(?=\.[^}]*}})/', function ($matches) use ($self) {
                return $self->getControlsPrefix() . $matches[0];
            }, $selector);
        }
        return $control;
    }

    private function addPrefixes($controls)
    {
        foreach ($controls as &$control) {
            if (!empty($control['condition'])) {
                $control = $this->addConditionsPrefix($control);
            }
            if (!empty($control['selectors'])) {
                $control = $this->addSelectorsPrefix($control);
            }
        }
        return $controls;
    }

    protected function _addGroupArgsToControl($control_id, $control_args)
    {
        $args = $this->getArgs();

        if (!empty($args['tab'])) {
            $control_args['tab'] = $args['tab'];
        }

        if (!empty($args['section'])) {
            $control_args['section'] = $args['section'];
        }

        $control_args['classes'] = $this->getBaseGroupClasses() . ' elementor-group-control-' . $control_id;

        if (!empty($args['condition'])) {
            if (empty($control_args['condition'])) {
                $control_args['condition'] = array();
            }

            $control_args['condition'] += $args['condition'];
        }

        return $control_args;
    }
}
