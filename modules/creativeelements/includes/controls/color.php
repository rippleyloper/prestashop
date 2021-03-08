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

class ControlColor extends ControlBase
{
    public function getType()
    {
        return 'color';
    }

    public function enqueue()
    {
        $suffix = defined('_PS_MODE_DEV_') && _PS_MODE_DEV_ ? '' : '.min';

        wp_enqueue_style('wp-color-picker', _CE_ASSETS_URL_ . 'lib/wp-color-picker/wp-color-picker.min.css', array(), '1.0.7');

        wp_register_script('iris', _CE_ASSETS_URL_ . 'lib/iris/iris.min.js', array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), '1.0.7', 1);
        wp_register_script('wp-color-picker', _CE_ASSETS_URL_ . 'lib/wp-color-picker/wp-color-picker.min.js', array('iris'), false, true);

        wp_localize_script(
            'wp-color-picker',
            'wpColorPickerL10n',
            array(
                'clear' => __('Clear', 'elementor'),
                'defaultString' => __('Default', 'elementor'),
                'pick' => __('Select Color', 'elementor'),
                'current' => __('Current Color', 'elementor'),
            )
        );

        wp_register_script(
            'wp-color-picker-alpha',
            _CE_ASSETS_URL_ . 'lib/wp-color-picker/wp-color-picker-alpha' . $suffix . '.js',
            array(
                'wp-color-picker',
            ),
            '1.1',
            true
        );

        wp_enqueue_script('wp-color-picker-alpha');
    }

    public function contentTemplate()
    {
        ?>
        <#
        var defaultValue = '', dataAlpha = '';
        if ( data.default ) {
            if ( '#' !== data.default.substring( 0, 1 ) ) {
                defaultValue = '#' + data.default;
            } else {
                defaultValue = data.default;
            }
            defaultValue = ' data-default-color=' + defaultValue; // Quotes added automatically.
        }
        if ( data.alpha ) {
            dataAlpha = ' data-alpha=true';
        }
        #>
        <div class="elementor-control-field">
            <label class="elementor-control-title">
            <# if ( data.label ) { #>
                {{{ data.label }}}
            <# } #>
            <# if ( data.description ) { #>
                <span class="elementor-control-description">{{{ data.description }}}</span>
            <# } #>
            </label>
            <div class="elementor-control-input-wrapper">
                <input data-setting="{{ name }}" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e('Hex Value', 'elementor');?>" {{ defaultValue }}{{ dataAlpha }} />
            </div>
        </div>
        <?php
    }

    protected function getDefaultSettings()
    {
        return array(
            'alpha' => true,
        );
    }
}
