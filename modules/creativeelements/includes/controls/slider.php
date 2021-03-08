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

class ControlSlider extends ControlBaseUnits
{
    public function getType()
    {
        return 'slider';
    }

    public function getDefaultValue()
    {
        return array_merge(parent::getDefaultValue(), array(
            'size' => '',
        ));
    }

    protected function getDefaultSettings()
    {
        return array_merge(parent::getDefaultSettings(), array(
            'label_block' => true,
        ));
    }

    public function contentTemplate()
    {
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <?php $this->printUnitsTemplate();?>
            <div class="elementor-control-input-wrapper elementor-clearfix">
                <div class="elementor-slider"></div>
                <div class="elementor-slider-input">
                    <input type="number" min="{{ data.min }}" max="{{ data.max }}" step="{{ data.step }}" data-setting="size" />
                </div>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
