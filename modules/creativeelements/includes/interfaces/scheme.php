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

interface SchemeInterface
{
    public static function getType();

    public function getTitle();

    public function getDisabledTitle();

    public function getSchemeTitles();

    public function getDefaultScheme();

    public function printTemplateContent();
}
