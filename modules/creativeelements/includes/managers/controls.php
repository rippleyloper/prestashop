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

class ControlsManager
{
    const TAB_CONTENT = 'content';
    const TAB_STYLE = 'style';
    const TAB_ADVANCED = 'advanced';
    const TAB_RESPONSIVE = 'responsive';
    const TAB_LAYOUT = 'layout';

    const TEXT = 'text';
    const NUMBER = 'number';
    const TEXTAREA = 'textarea';
    const SELECT = 'select';
    const CHECKBOX = 'checkbox';
    const SWITCHER = 'switcher';
    const CHECKBOX_LIST = 'checkbox_list';
    const SELECT_BIG = 'select_big';

    const HIDDEN = 'hidden';
    const HEADING = 'heading';
    const RAW_HTML = 'raw_html';
    const SECTION = 'section';
    const TAB = 'tab';
    const DIVIDER = 'divider';

    const COLOR = 'color';
    const MEDIA = 'media';
    const SLIDER = 'slider';
    const DIMENSIONS = 'dimensions';
    const CHOOSE = 'choose';
    const WYSIWYG = 'wysiwyg';
    const CODE = 'code';
    const FONT = 'font';
    const IMAGE_DIMENSIONS = 'image_dimensions';

    const PS_WIDGET = 'ps_widget';

    const URL = 'url';
    const REPEATER = 'repeater';
    const ICON = 'icon';
    // const GALLERY = 'gallery';
    const STRUCTURE = 'structure';
    const SELECT2 = 'select2';
    const DATE_TIME = 'date_time';
    const BOX_SHADOW = 'box_shadow';
    const ANIMATION = 'animation';
    const HOVER_ANIMATION = 'hover_animation';
    const ORDER = 'order';

    /**
     * @var ControlBase[]
     */
    private $_controls = array();

    /**
     * @var GroupControlBase[]
     */
    private $_group_controls = array();

    private $_controls_stack = array();

    private static $_available_tabs_controls;

    private static function _getAvailableTabsControls()
    {
        if (!self::$_available_tabs_controls) {
            self::$_available_tabs_controls = array(
                self::TAB_CONTENT => __('Content', 'elementor'),
                self::TAB_STYLE => __('Style', 'elementor'),
                self::TAB_ADVANCED => __('Advanced', 'elementor'),
                self::TAB_RESPONSIVE => __('Responsive', 'elementor'),
                self::TAB_LAYOUT => __('Layout', 'elementor'),
            );
        }

        return self::$_available_tabs_controls;
    }

    /**
     * @since 1.0.0
     */
    public function registerControls()
    {
        require _CE_PATH_ . 'includes/controls/base.php';
        require _CE_PATH_ . 'includes/controls/base-multiple.php';
        require _CE_PATH_ . 'includes/controls/base-units.php';

        $available_controls = array(
            self::TEXT,
            self::NUMBER,
            self::TEXTAREA,
            self::SELECT,
            self::CHECKBOX,
            self::SWITCHER,
            self::CHECKBOX_LIST,
            self::SELECT_BIG,

            self::HIDDEN,
            self::HEADING,
            self::RAW_HTML,
            self::SECTION,
            self::TAB,
            self::DIVIDER,

            self::COLOR,
            self::MEDIA,
            self::SLIDER,
            self::DIMENSIONS,
            self::CHOOSE,
            self::WYSIWYG,
            self::CODE,
            self::FONT,
            self::IMAGE_DIMENSIONS,

            self::PS_WIDGET,

            self::URL,
            self::REPEATER,
            self::ICON,
            // self::GALLERY,
            self::STRUCTURE,
            self::SELECT2,
            self::DATE_TIME,
            self::BOX_SHADOW,
            self::ANIMATION,
            self::HOVER_ANIMATION,
            self::ORDER,
        );

        foreach ($available_controls as $control_id) {
            $control_filename = str_replace('_', '-', $control_id);
            $control_filename = _CE_PATH_ . "includes/controls/{$control_filename}.php";
            require $control_filename;

            $class_name = __NAMESPACE__ . '\Control' . str_replace('_', '', $control_id);
            $this->registerControl($control_id, $class_name);
        }

        // Group Controls
        require _CE_PATH_ . 'includes/interfaces/group-control.php';
        require _CE_PATH_ . 'includes/controls/groups/base.php';

        require _CE_PATH_ . 'includes/controls/groups/background.php';
        require _CE_PATH_ . 'includes/controls/groups/border.php';
        require _CE_PATH_ . 'includes/controls/groups/typography.php';
        require _CE_PATH_ . 'includes/controls/groups/image-size.php';
        require _CE_PATH_ . 'includes/controls/groups/box-shadow.php';

        $this->_group_controls['background'] = new GroupControlBackground();
        $this->_group_controls['border'] = new GroupControlBorder();
        $this->_group_controls['typography'] = new GroupControlTypography();
        $this->_group_controls['image-size'] = new GroupControlImageSize();
        $this->_group_controls['box-shadow'] = new GroupControlBoxShadow();
    }

    /**
     * @since 1.0.0
     * @param $control_id
     * @param $class_name
     *
     * @return bool|string
     */
    public function registerControl($control_id, $class_name)
    {
        if (!class_exists($class_name)) {
            return new \PrestaShopException('element_class_name_not_exists');
        }
        $instance_control = new $class_name();

        if (!$instance_control instanceof ControlBase) {
            return new \PrestaShopException('wrong_instance_control');
        }
        $this->_controls[$control_id] = $instance_control;

        return true;
    }

    /**
     * @param $control_id
     *
     * @since 1.0.0
     * @return bool
     */
    public function unregisterControl($control_id)
    {
        if (!isset($this->_controls[$control_id])) {
            return false;
        }
        unset($this->_controls[$control_id]);
        return true;
    }

    /**
     * @since 1.0.0
     * @return ControlBase[]
     */
    public function getControls()
    {
        return $this->_controls;
    }

    /**
     * @since 1.0.0
     * @param $control_id
     *
     * @return bool|\CreativeElements\ControlBase
     */
    public function getControl($control_id)
    {
        $controls = $this->getControls();

        return isset($controls[$control_id]) ? $controls[$control_id] : false;
    }

    /**
     * @since 1.0.0
     * @return array
     */
    public function getControlsData()
    {
        $controls_data = array();

        foreach ($this->getControls() as $name => $control) {
            $controls_data[$name] = $control->getSettings();
            $controls_data[$name]['default_value'] = $control->getDefaultValue();
        }

        return $controls_data;
    }

    /**
     * @since 1.0.0
     * @return void
     */
    public function renderControls()
    {
        foreach ($this->getControls() as $control) {
            $control->printTemplate();
        }
    }

    /**
     * @since 1.0.0
     * @return GroupControlBase[]
     */
    public function getGroupControls()
    {
        return $this->_group_controls;
    }

    /**
     * @since 1.0.0
     * @return void
     */
    public function enqueueControlScripts()
    {
        foreach ($this->getControls() as $control) {
            $control->enqueue();
        }
    }

    public function openStack(ElementBase $element)
    {
        $stack_id = $element->getName();

        $this->_controls_stack[$stack_id] = array(
            'tabs' => array(),
            'controls' => array(),
        );
    }

    public function addControlToStack(ElementBase $element, $control_id, $control_data)
    {
        $default_args = array(
            'default' => '',
            'type' => self::TEXT,
            'tab' => self::TAB_CONTENT,
        );

        $control_data['name'] = $control_id;

        $control_data = array_merge($default_args, $control_data);

        $stack_id = $element->getName();

        if (isset($this->_controls_stack[$stack_id]['controls'][$control_id])) {
            _doing_it_wrong(__CLASS__ . '::' . __FUNCTION__, 'Cannot redeclare control with same name. - ' . $control_id, '1.0.0');
            return false;
        }

        $available_tabs = self::_getAvailableTabsControls();

        if (!isset($available_tabs[$control_data['tab']])) {
            $control_data['tab'] = $default_args['tab'];
        }

        $this->_controls_stack[$stack_id]['tabs'][$control_data['tab']] = $available_tabs[$control_data['tab']];

        $this->_controls_stack[$stack_id]['controls'][$control_id] = $control_data;

        return true;
    }

    public function removeControlFromStack(ElementBase $element, $control_id)
    {
        $stack_id = $element->getName();

        if (empty($this->_controls_stack[$stack_id][$control_id])) {
            return new \PrestaShopException('Cannot remove not-exists control.');
        }

        unset($this->_controls_stack[$stack_id][$control_id]);

        return true;
    }

    public function getElementStack(ElementBase $element)
    {
        $stack_id = $element->getName();

        if (!isset($this->_controls_stack[$stack_id])) {
            return null;
        }

        $stack = $this->_controls_stack[$stack_id];

        if ('widget' === $element->getType() && 'common' !== $element->getName()) {
            $common_widget = Plugin::instance()->widgets_manager->getWidgetTypes('common');

            $stack['controls'] = array_merge($stack['controls'], $common_widget->getControls());

            $stack['tabs'] = array_merge($stack['tabs'], $common_widget->getTabsControls());
        }

        return $stack;
    }

    /**
     * ControlsManager constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->registerControls();
    }
}
