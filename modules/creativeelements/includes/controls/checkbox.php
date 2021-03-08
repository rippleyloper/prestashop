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

class ControlCheckbox extends ControlBase
{
    public function getType()
    {
        return 'checkbox';
    }

    public function contentTemplate()
    {
        ?>
        <label class="elementor-control-title">
            <span>{{{ data.label }}}</span>
            <input type="checkbox" data-setting="{{ data.name }}" />
        </label>
        <# if ( data.description ) { #>
        <div class="elementor-control-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
