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

class Utils
{
    public static function getPlaceholderImageSrc()
    {
        return basename(_MODULE_DIR_) . '/creativeelements/views/img/placeholder.png';
    }

    public static function generateRandomString($length = 7)
    {
        $salt = 'abcdefghijklmnopqrstuvwxyz';
        return \Tools::substr(str_shuffle(str_repeat($salt, $length)), 0, $length);
    }

    public static function getYoutubeIdFromUrl($url)
    {
        preg_match('/^.*(?:youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/', $url, $video_id_parts);

        if (empty($video_id_parts[1])) {
            return false;
        }

        return $video_id_parts[1];
    }
}
