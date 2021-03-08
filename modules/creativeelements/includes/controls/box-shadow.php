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

class ControlBoxShadow extends ControlBaseMultiple
{
    public function getType()
    {
        return 'box_shadow';
    }

    public function getDefaultValue()
    {
        return array(
            'horizontal' => 0,
            'vertical' => 0,
            'blur' => 10,
            'spread' => 0,
            'inset' => '',
            'color' => 'rgba(0,0,0,0.5)',
        );
    }

    public function getSliders()
    {
        return array(
            array('label' => __('Blur', 'elementor'), 'type' => 'blur', 'min' => 0, 'max' => 100),
            array('label' => __('Spread', 'elementor'), 'type' => 'spread', 'min' => 0, 'max' => 100),
            array('label' => __('Horizontal', 'elementor'), 'type' => 'horizontal', 'min' => -100, 'max' => 100),
            array('label' => __('Vertical', 'elementor'), 'type' => 'vertical', 'min' => -100, 'max' => 100),
        );
    }

    public function contentTemplate()
    {
        ?>
        <#
        var defaultColorValue = '';

        if ( data.default.color ) {
            if ( '#' !== data.default.color.substring( 0, 1 ) ) {
                defaultColorValue = '#' + data.default.color;
            } else {
                defaultColorValue = data.default.color;
            }

            defaultColorValue = ' data-default-color=' + defaultColorValue; // Quotes added automatically.
        }
        #>
        <div class="elementor-control-field">
            <label class="elementor-control-title"><?php _e('Color', 'elementor');?></label>
            <div class="elementor-control-input-wrapper">
                <input data-setting="color" class="elementor-box-shadow-color-picker" type="text" maxlength="7" placeholder="<?php esc_attr_e('Hex Value', 'elementor');?>" data-alpha="true"{{{ defaultColorValue }}} />
            </div>
        </div>
        <?php foreach ($this->getSliders() as $slider) : ?>
            <div class="elementor-box-shadow-slider">
                <label class="elementor-control-title"><?php echo $slider['label']; ?></label>
                <div class="elementor-control-input-wrapper">
                    <div class="elementor-slider" data-input="<?php echo $slider['type']; ?>"></div>
                    <div class="elementor-slider-input">
                        <input type="number" min="<?php echo $slider['min']; ?>" max="<?php echo $slider['max']; ?>" step="{{ data.step }}" data-setting="<?php echo $slider['type']; ?>"/>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <?php
    }
}
