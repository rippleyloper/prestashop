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

class ControlImageDimensions extends ControlBaseMultiple
{
    public function getType()
    {
        return 'image_dimensions';
    }

    public function getDefaultValue()
    {
        return array(
            'width' => '',
            'height' => '',
        );
    }

    protected function getDefaultSettings()
    {
        return array(
            'label_block' => true,
            'show_label' => false,
        );
    }

    public function contentTemplate()
    {
        ?>
        <# if ( data.description ) { #>
            <div class="elementor-control-description">{{{ data.description }}}</div>
        <# } #>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <div class="elementor-image-dimensions-field">
                    <input type="text" data-setting="width" />
                    <div class="elementor-image-dimensions-field-description"><?php _e('Width', 'elementor');?></div>
                </div>
                <div class="elementor-image-dimensions-separator">x</div>
                <div class="elementor-image-dimensions-field">
                    <input type="text" data-setting="height" />
                    <div class="elementor-image-dimensions-field-description"><?php _e('Height', 'elementor');?></div>
                </div>
                <button class="elementor-button elementor-button-success elementor-image-dimensions-apply-button"><?php _e('Apply', 'elementor');?></button>
            </div>
        </div>
        <?php
    }
}
