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

class ControlRawhtml extends ControlBase
{
    public function getType()
    {
        return 'raw_html';
    }

    public function contentTemplate()
    {
        ?>
        <# if ( data.label ) { #>
        <span class="elementor-control-title">{{{ data.label }}}</span>
        <# } #>
        <div class="elementor-control-raw-html {{ data.classes }}">{{{ data.raw }}}</div>
        <?php
    }

    public function getDefaultSettings()
    {
        return array(
            'classes' => '',
        );
    }
}
