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

class ControlCheckboxList extends ControlBaseMultiple
{
    public function getType()
    {
        return 'checkbox_list';
    }

    public function contentTemplate()
    {
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <# _.each( data.options, function( option_title, option_value ) { #>
                    <div>
                        <label class="elementor-control-title">
                            <input type="checkbox" data-setting="{{ option_value }}" />
                            <span>{{{ option_title }}}</span>
                        </label>
                    </div>
                <# } ); #>
            </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
