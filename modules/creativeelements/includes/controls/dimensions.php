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

class ControlDimensions extends ControlBaseUnits
{
    public function getType()
    {
        return 'dimensions';
    }

    public function getDefaultValue()
    {
        return array_merge(parent::getDefaultValue(), array(
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
            'isLinked' => true,
        ));
    }

    protected function getDefaultSettings()
    {
        return array_merge(parent::getDefaultSettings(), array(
            'label_block' => true,
            'allowed_dimensions' => 'all',
            'placeholder' => '',
        ));
    }

    public function contentTemplate()
    {
        $dimensions = array(
            'top' => __('Top', 'elementor'),
            'right' => __('Right', 'elementor'),
            'bottom' => __('Bottom', 'elementor'),
            'left' => __('Left', 'elementor'),
        );
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <?php $this->printUnitsTemplate();?>
            <div class="elementor-control-input-wrapper">
                <ul class="elementor-control-dimensions">
                    <?php foreach ($dimensions as $dimension_key => $dimension_title) : ?>
                        <li class="elementor-control-dimension">
                            <input type="number" data-setting="<?php echo esc_attr($dimension_key); ?>" placeholder="<#
                                if ( _.isObject( data.placeholder ) ) {
                                    if ( ! _.isUndefined( data.placeholder.<?php echo $dimension_key; ?> ) ) {
                                        print( data.placeholder.<?php echo $dimension_key; ?> );
                                    }
                                } else {
                                    print( data.placeholder );
                                } #>"
                                <# if ( -1 === _.indexOf( allowed_dimensions, '<?php echo $dimension_key; ?>' ) ) { #>disabled<# } #>/>
                            <span><?php echo $dimension_title; ?></span>
                        </li>
                    <?php endforeach;?>
                    <li>
                        <button class="elementor-link-dimensions tooltip-target" data-tooltip="<?php _e('Link values together', 'elementor');?>">
                            <span class="elementor-linked"><i class="fa fa-link"></i></span>
                            <span class="elementor-unlinked"><i class="fa fa-chain-broken"></i></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
