<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements\TemplateLibrary\Classes;

defined('_PS_VERSION_') or exit;

class ImportImages
{
    const DIR = 'cms/';
    const PLACEHOLDER = 'placeholder.png';

    public static $allowed_ext = array('jpg', 'jpe', 'jpeg', 'png', 'gif', 'svg');

    private static $imported = array();

    public function import($attachment)
    {
        $url = $attachment['url'];
        if (stripos($url, 'https://') === 0) {
            $url = 'http' . \Tools::substr($url, 5);
        }

        if (isset(self::$imported[$url])) {
            // Image was already imported
            return self::$imported[$url];
        }

        $filename = basename($url);
        if (self::PLACEHOLDER == $filename) {
            // Don't import placeholder
            return self::$imported[$url] = false;
        }

        $file_content = \CreativeElements\wp_remote_get($url);
        if (empty($file_content)) {
            // Image isn't available
            return self::$imported[$url] = false;
        }

        $file_info = pathinfo($filename);
        if (in_array(\Tools::strToLower($file_info['extension']), self::$allowed_ext)) {
            // Image extension is allowed
            $file_path = _PS_IMG_DIR_ . self::DIR . $filename;

            if (file_exists($file_path)) {
                // Filename already exists
                $existing_content = \Tools::file_get_contents($file_path);

                if ($file_content === $existing_content) {
                    // Same image already exists
                    return self::$imported[$url] = array(
                        'id' => 0,
                        'url' => basename(_PS_IMG_) . '/' . self::DIR . $filename,
                    );
                }

                // Add unique filename
                $filename = $file_info['filename'] . '_' . \CreativeElements\Utils::generateRandomString() . '.' . $file_info['extension'];
                $file_path = _PS_IMG_DIR_ . self::DIR . $filename;
            }

            if (file_put_contents($file_path, $file_content)) {
                // Image saved successfuly
                return self::$imported[$url] = array(
                    'id' => 0,
                    'url' => basename(_PS_IMG_) . '/' . self::DIR . $filename,
                );
            }
        }

        return $attachment;
    }
}
