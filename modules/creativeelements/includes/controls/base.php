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

abstract class ControlBase
{
    private $_base_settings = array(
        'separator' => 'default',
        'label_block' => false,
        'show_label' => true,
    );

    private $_settings = array();

    abstract public function contentTemplate();

    abstract public function getType();

    public function __construct()
    {
        $this->_settings = wp_parse_args($this->getDefaultSettings(), $this->_base_settings);
    }

    public function enqueue()
    {
    }

    public function getDefaultValue()
    {
        return '';
    }

    public function getValue($control, $instance)
    {
        if (!isset($control['default'])) {
            $control['default'] = $this->getDefaultValue();
        }

        if (!isset($instance[$control['name']])) {
            return $control['default'];
        }

        return $instance[$control['name']];
    }

    public function getReplacedStyleValues($css_property, $control_value)
    {
        return str_replace('{{VALUE}}', $control_value, $css_property);
    }

    public function getStyleValue($css_property, $control_value)
    {
        return $control_value;
    }

    /**
     * @param string $setting_key
     *
     * @return array
     * @since 1.0.0
     */
    final public function getSettings($setting_key = null)
    {
        if ($setting_key) {
            if (isset($this->_settings[$setting_key])) {
                return $this->_settings[$setting_key];
            }

            return null;
        }

        return $this->_settings;
    }

    /**
     * @return void
     *
     * @since 1.0.0
     */
    final public function printTemplate()
    {
        ?>
        <script type="text/html" id="tmpl-elementor-control-<?php echo esc_attr($this->getType()); ?>-content">
            <div class="elementor-control-content">
                <?php $this->contentTemplate();?>
            </div>
        </script>
        <?php
    }

    protected function getDefaultSettings()
    {
        return array();
    }
}
