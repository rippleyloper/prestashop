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

class ControlTab extends ControlBase
{

    public function getType()
    {
        return 'tab';
    }

    public function contentTemplate()
    {
        ?>
        <# if ( ! data.is_tabs_wrapper ) { #>
            <div class="elementor-panel-tab-heading">
                {{{ data.label }}}
            </div>
        <# } #>
        <?php
    }

    protected function getDefaultSettings()
    {
        return array(
            'separator' => 'none',
        );
    }
}
