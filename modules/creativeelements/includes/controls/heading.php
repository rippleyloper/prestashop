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

class ControlHeading extends ControlBase
{
    public function getType()
    {
        return 'heading';
    }

    protected function getDefaultSettings()
    {
        return array(
            'label_block' => true,
        );
    }

    public function contentTemplate()
    {
        ?>
        <h3 class="elementor-control-title">{{ data.label }}</h3>
        <?php
    }
}
