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

abstract class ElementBase
{
    const RESPONSIVE_DESKTOP = 'desktop';
    const RESPONSIVE_TABLET = 'tablet';
    const RESPONSIVE_MOBILE = 'mobile';

    private $_id;

    private $_settings;

    private $_data;

    /**
     * @var Element_Base[]
     */
    private $_children;

    private $_render_attributes = array();

    private $_default_args = array();

    protected static $_edit_tools;

    /**
     * Holds the current section while render a set of controls sections
     *
     * @var null|array
     */
    private $_current_section = null;

    /**
     * Holds the current tab while render a set of controls tabs
     *
     * @var null|array
     */
    protected $_current_tab = null;

    final public static function getEditTools()
    {
        if (null === static::$_edit_tools) {
            self::_initEditTools();
        }

        return static::$_edit_tools;
    }

    final public static function addEditTool($tool_name, $tool_data, $after = null)
    {
        if (null === static::$_edit_tools) {
            self::_initEditTools();
        }

        // Adding the tool at specific position
        // in the tools array if requested
        if ($after) {
            $after_index = array_search($after, array_keys(static::$_edit_tools)) + 1;

            static::$_edit_tools = array_slice(static::$_edit_tools, 0, $after_index, true) +
            array($tool_name => $tool_data) +
            array_slice(static::$_edit_tools, $after_index, null, true);
        } else {
            static::$_edit_tools[$tool_name] = $tool_data;
        }
    }

    public static function getType()
    {
        return 'element';
    }

    protected static function getDefaultEditTools()
    {
        return array();
    }

    /**
     * @param array $haystack
     * @param string $needle
     *
     * @return mixed the whole haystack or the
     * needle from the haystack when requested
     */
    private static function _getItems(array $haystack, $needle = null)
    {
        if ($needle) {
            return isset($haystack[$needle]) ? $haystack[$needle] : null;
        }

        return $haystack;
    }

    private static function _initEditTools()
    {
        static::$_edit_tools = static::getDefaultEditTools();
    }

    /**
     * @param array $element_data
     *
     * @return Element_Base
     */
    abstract protected function _getChildType(array $element_data);

    abstract public function getName();

    public function getControls($control_id = null)
    {
        $stack = Plugin::instance()->controls_manager->getElementStack($this);

        if (null === $stack) {
            $this->_initControls();

            return $this->getControls();
        }

        return self::_getItems($stack['controls'], $control_id);
    }

    public function addControl($id, $args)
    {
        if (empty($args['type']) || !in_array($args['type'], array(ControlsManager::SECTION, ControlsManager::PS_WIDGET))) {
            if (null !== $this->_current_section) {
                if (!empty($args['section']) || !empty($args['tab'])) {
                    _doing_it_wrong(__CLASS__ . '::' . __FUNCTION__, 'Cannot redeclare control with `tab` or `section` args inside section. - ' . $id, '1.0.0');
                }
                $args = array_merge($args, $this->_current_section);

                if (null !== $this->_current_tab) {
                    $args = array_merge($args, $this->_current_tab);
                }
            } elseif (empty($args['section'])) {
                die(__CLASS__ . '::' . __FUNCTION__ . ': Cannot add a control outside a section (use `startControlsSection`).');
            }
        }

        return Plugin::instance()->controls_manager->addControlToStack($this, $id, $args);
    }

    public function removeControl($id)
    {
        return Plugin::instance()->controls_manager->removeControlFromStack($this, $id);
    }

    final public function addGroupControl($group_name, $args = array())
    {
        do_action_ref_array('elementor/elements/add_group_control/' . $group_name, array($this, $args));
    }

    final public function getTabsControls()
    {
        $stack = Plugin::instance()->controls_manager->getElementStack($this);

        return $stack['tabs'];
    }

    final public function getSchemeControls()
    {
        $enabled_schemes = SchemesManager::getEnabledSchemes();

        return array_filter($this->getControls(), function ($control) use ($enabled_schemes) {
            return (!empty($control['scheme']) && in_array($control['scheme']['type'], $enabled_schemes));
        });
    }

    final public function getStyleControls($controls = null)
    {
        if (null === $controls) {
            $controls = $this->getControls();
        }

        $style_controls = array();

        foreach ($controls as $control_name => $control) {
            if (ControlsManager::REPEATER === $control['type']) {
                $control['style_fields'] = $this->getStyleControls($control['fields']);
            }

            if (!empty($control['style_fields']) || !empty($control['selectors'])) {
                $style_controls[$control_name] = $control;
            }
        }

        return $style_controls;
    }

    final public function getClassControls()
    {
        return array_filter($this->getControls(), function ($control) {
            return (isset($control['prefix_class']));
        });
    }

    final public function addResponsiveControl($id, $args = array())
    {
        // Desktop
        $control_args = $args;

        if (!empty($args['prefix_class'])) {
            $control_args['prefix_class'] = sprintf($args['prefix_class'], '');
        }

        $control_args['responsive'] = self::RESPONSIVE_DESKTOP;

        $this->addControl(
            $id,
            $control_args
        );

        // Tablet
        $control_args = $args;

        if (!empty($args['prefix_class'])) {
            $control_args['prefix_class'] = sprintf($args['prefix_class'], '-' . self::RESPONSIVE_TABLET);
        }
        if (isset($args['tablet_default'])) {
            $control_args['default'] = $args['tablet_default'];
        }

        $control_args['responsive'] = self::RESPONSIVE_TABLET;

        $this->addControl(
            $id . '_tablet',
            $control_args
        );

        // Mobile
        $control_args = $args;

        if (!empty($args['prefix_class'])) {
            $control_args['prefix_class'] = sprintf($args['prefix_class'], '-' . self::RESPONSIVE_MOBILE);
        }
        if (isset($args['mobile_default'])) {
            $control_args['default'] = $args['mobile_default'];
        }

        $control_args['responsive'] = self::RESPONSIVE_MOBILE;

        $this->addControl(
            $id . '_mobile',
            $control_args
        );
    }

    final public function getClassName()
    {
        return get_called_class();
    }

    public function beforeRender()
    {
    }

    public function afterRender()
    {
    }

    public function getTitle()
    {
        return '';
    }

    public function getKeywords()
    {
        return array();
    }

    public function getCategories()
    {
        return array('basic');
    }

    public function getIcon()
    {
        return 'columns';
    }

    public function isReloadPreviewRequired()
    {
        return false;
    }

    public function getConfig($item = null)
    {
        $config = array(
            'name' => $this->getName(),
            'elType' => $this->getType(),
            'title' => $this->getTitle(),
            'controls' => array_values($this->getControls()),
            'tabs_controls' => $this->getTabsControls(),
            'categories' => $this->getCategories(),
            'keywords' => $this->getKeywords(),
            'icon' => $this->getIcon(),
            'reload_preview' => $this->isReloadPreviewRequired(),
        );

        return self::_getItems($config, $item);
    }

    public function printTemplate()
    {
        ob_start();

        $this->_contentTemplate();

        // $content_template = apply_filters('elementor/elements/print_template', ob_get_clean(), $this);
        $content_template = ob_get_clean();

        if (empty($content_template)) {
            return;
        }
        ?>
        <script type="text/html" id="tmpl-elementor-<?php echo $this->getType(); ?>-<?php echo esc_attr($this->getName()); ?>-content">
            <?php $this->_renderSettings();?>
            <?php echo $content_template; ?>
        </script>
        <?php
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getData($item = null)
    {
        return self::_getItems($this->_data, $item);
    }

    public function getSettings($setting = null)
    {
        return self::_getItems($this->_settings, $setting);
    }

    public function getChildren()
    {
        if (null === $this->_children) {
            $this->_initChildren();
        }

        return $this->_children;
    }

    public function getDefaultArgs($item = null)
    {
        return self::_getItems($this->_default_args, $item);
    }

    /**
     * @return Element_Base
     */
    public function getParent()
    {
        return $this->getData('parent');
    }

    /**
     * @param array $child_data
     * @param array $child_args
     *
     * @return Element_Base|false
     */
    public function addChild(array $child_data, array $child_args = array())
    {
        if (null === $this->_children) {
            $this->_initChildren();
        }

        $child_type = $this->_getChildType($child_data);

        if (!$child_type) {
            return false;
        }

        $child_args = array_merge($child_type->getDefaultArgs(), $child_args);

        $child_class = $child_type->getClassName();

        $child = new $child_class($child_data, $child_args);

        $this->_children[] = $child;

        return $child;
    }

    public function isControlVisible($control, $values = null)
    {
        if (null === $values) {
            $values = $this->getSettings();
        }

        // Repeater fields
        if (!empty($control['conditions'])) {
            return Conditions::check($control['conditions'], $values);
        }

        if (empty($control['condition'])) {
            return true;
        }

        foreach ($control['condition'] as $condition_key => $condition_value) {
            if (preg_match('/(\w+)(?:\[([a-z_]+)])?(!?)$/i', $condition_key, $condition_key_parts)) {
                $pure_condition_key = $condition_key_parts[1];
                $condition_sub_key = $condition_key_parts[2];
                $is_negative_condition = !!$condition_key_parts[3];

                $instance_value = $values[$pure_condition_key];

                if (null === $instance_value) {
                    return false;
                }

                if ($condition_sub_key) {
                    if (!isset($instance_value[$condition_sub_key])) {
                        return false;
                    }

                    $instance_value = $instance_value[$condition_sub_key];
                }

                $is_contains = is_array($condition_value) ? in_array($instance_value, $condition_value) : $instance_value === $condition_value;

                if ($is_negative_condition && $is_contains || !$is_negative_condition && !$is_contains) {
                    return false;
                }
            }
        }

        return true;
    }

    public function addRenderAttribute($element, $key = null, $value = null)
    {
        if (is_array($element)) {
            foreach ($element as $element_key => $attributes) {
                $this->addRenderAttribute($element_key, $attributes);
            }

            return $this;
        }

        if (is_array($key)) {
            foreach ($key as $attribute_key => $attributes) {
                $this->addRenderAttribute($element, $attribute_key, $attributes);
            }

            return $this;
        }

        if (empty($this->_render_attributes[$element][$key])) {
            $this->_render_attributes[$element][$key] = array();
        }

        $this->_render_attributes[$element][$key] = array_merge($this->_render_attributes[$element][$key], (array) $value);

        // return $this;
    }

    public function getRenderAttributeString($element)
    {
        if (empty($this->_render_attributes[$element])) {
            return '';
        }

        $render_attributes = $this->_render_attributes[$element];

        $attributes = array();

        foreach ($render_attributes as $attribute_key => $attribute_values) {
            $attributes[] = sprintf('%s="%s"', $attribute_key, esc_attr(implode(' ', $attribute_values)));
        }

        return implode(' ', $attributes);
    }

    public function printElement()
    {
        //do_action('elementor/frontend/' . static::getType() . '/before_render', $this);

        $this->beforeRender();

        $this->_printContent();

        $this->afterRender();

        //do_action('elementor/frontend/' . static::getType() . '/after_render', $this);
    }

    public function getRawData($with_html_content = false)
    {
        $data = $this->getData();

        $elements = array();

        foreach ($this->getChildren() as $child) {
            $elements[] = $child->getRawData($with_html_content);
        }

        return array(
            'id' => $this->_id,
            'elType' => $data['elType'],
            'settings' => $data['settings'],
            'elements' => $elements,
            'isInner' => $data['isInner'],
        );
    }

    public function startControlsSection($section_id, $args)
    {
        // do_action('elementor/element/before_section_start', $this, $section_id, $args);
        // do_action('elementor/element/' . $this->getName() . '/' . $section_id . '/before_section_start', $this, $args);

        $args['type'] = ControlsManager::SECTION;

        $this->addControl($section_id, $args);

        if (null !== $this->_current_section) {
            die(sprintf('Elementor: You can\'t start a section before the end of the previous section: `%s`', $this->_current_section['section']));
        }

        $this->_current_section = array(
            'section' => $section_id,
            'tab' => $this->getControls($section_id)['tab'],
        );

        // do_action('elementor/element/after_section_start', $this, $section_id, $args);
        // do_action('elementor/element/' . $this->getName() . '/' . $section_id . '/after_section_start', $this, $args);
    }

    public function endControlsSection()
    {
        // Save the current section for the action
        $current_section = $this->_current_section;
        $section_id = $current_section['section'];
        $args = array('tab' => $current_section['tab']);

        // do_action('elementor/element/before_section_end', $this, $section_id, $args);
        // do_action('elementor/element/' . $this->get_name() . '/' . $section_id . '/before_section_end', $this, $args);

        $this->_current_section = null;

        // do_action('elementor/element/after_section_end', $this, $section_id, $args);
        // do_action('elementor/element/' . $this->get_name() . '/' . $section_id . '/after_section_end', $this, $args);
    }

    public function startControlsTabs($tabs_id)
    {
        if (null !== $this->_current_tab) {
            die(sprintf('Elementor: You can\'t start tabs before the end of the previous tabs: `%s`', $this->_current_tab['tabs_wrapper']));
        }

        $this->addControl(
            $tabs_id,
            array(
                'type' => ControlsManager::TAB,
                'is_tabs_wrapper' => true,
            )
        );

        $this->_current_tab = array(
            'tabs_wrapper' => $tabs_id,
        );
    }

    public function endControlsTabs()
    {
        $this->_current_tab = null;
    }

    public function startControlsTab($tab_id, $args)
    {
        if (!empty($this->_current_tab['inner_tab'])) {
            die(sprintf('Elementor: You can\'t start a tab before the end of the previous tab: `%s`', $this->_current_tab['inner_tab']));
        }

        $args['type'] = ControlsManager::TAB;
        $args['tabs_wrapper'] = $this->_current_tab['tabs_wrapper'];

        $this->addControl($tab_id, $args);

        $this->_current_tab['inner_tab'] = $tab_id;
    }

    public function endControlsTab()
    {
        unset($this->_current_tab['inner_tab']);
    }

    final public function setSettings($key, $value = null)
    {
        if (null === $value) {
            $this->_settings = $key;
        } else {
            $this->_settings[$key] = $value;
        }
    }

    protected function _registerControls()
    {
    }

    protected function _contentTemplate()
    {
    }

    protected function _renderSettings()
    {
        ?>
        <div class="elementor-element-overlay">
            <div class="elementor-editor-element-settings elementor-editor-<?php echo esc_attr($this->getType()); ?>-settings elementor-editor-<?php echo esc_attr($this->getName()); ?>-settings">
                <ul class="elementor-editor-element-settings-list">
                    <li class="elementor-editor-element-setting elementor-editor-element-add">
                        <a href="#" title="<?php _e('Add Widget', 'elementor');?>">
                            <span class="elementor-screen-only"><?php _e('Add', 'elementor');?></span>
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>
                    <li class="elementor-editor-element-setting elementor-editor-element-duplicate">
                        <a href="#" title="<?php _e('Duplicate Widget', 'elementor');?>">
                            <span class="elementor-screen-only"><?php _e('Duplicate', 'elementor');?></span>
                            <i class="fa fa-files-o"></i>
                        </a>
                    </li>
                    <li class="elementor-editor-element-setting elementor-editor-element-remove">
                        <a href="#" title="<?php _e('Remove Widget', 'elementor');?>">
                            <span class="elementor-screen-only"><?php _e('Remove', 'elementor');?></span>
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }

    protected function render()
    {
    }

    protected function getDefaultData()
    {
        return array(
            'id' => 0,
            'settings' => array(),
            'elements' => array(),
            'isInner' => false,
        );
    }

    protected function _getParsedSettings()
    {
        $settings = $this->_data['settings'];

        foreach ($this->getControls() as $control) {
            $control_obj = Plugin::instance()->controls_manager->getControl($control['type']);

            $settings[$control['name']] = $control_obj->getValue($control, $settings);
        }

        return $settings;
    }

    protected function _printContent()
    {
        foreach ($this->getChildren() as $child) {
            $child->printElement();
        }
    }

    private function _initControls()
    {
        Plugin::instance()->controls_manager->openStack($this);

        $this->_registerControls();
    }

    private function _initChildren()
    {
        $this->_children = array();

        $children_data = $this->getData('elements');

        if (!$children_data) {
            return;
        }

        foreach ($children_data as $child_data) {
            $this->addChild($child_data);
        }
    }

    private function _init($data)
    {
        $this->_data = array_merge($this->getDefaultData(), $data);
        $this->_id = $data['id'];
        $this->_settings = $this->_getParsedSettings();
    }

    public function __construct($data = array(), $args = array())
    {
        if ($data) {
            $this->_init($data);
        } else {
            $this->_default_args = $args;
        }
    }
}
