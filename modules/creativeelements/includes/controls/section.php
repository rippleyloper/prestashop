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

class ControlSection extends ControlBase
{
    public function getType()
    {
        return 'section';
    }

    public function contentTemplate()
    {
        ?>
        <div class="elementor-panel-heading">
            <div class="elementor-panel-heading-toggle elementor-section-toggle" data-collapse_id="{{ data.name }}">
                <i class="fa"></i>
            </div>
            <div class="elementor-panel-heading-title elementor-section-title">{{{ data.label }}}</div>
        </div>
        <?php
    }

    protected function getDefaultSettings()
    {
        return array(
            'separator' => 'none',
        );
    }
}
