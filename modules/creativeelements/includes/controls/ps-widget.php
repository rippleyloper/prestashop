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

class ControlPsWidget extends ControlBase
{
    public function getType()
    {
        return 'ps_widget';
    }

    public function contentTemplate()
    {
        ?>
        <form action="" method="post">
            <div class="wp-widget-form-loading">Loading..</div>
        </form>
        <?php
    }
}
