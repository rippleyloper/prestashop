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

class Api
{
    public static $api_info_url = 'http://pagebuilder.webshopworks.com/?api=1&info';
    private static $api_feedback_url = 'http://pagebuilder.webshopworks.com/?api=1&feedback';
    private static $api_get_template_content_url = 'http://pagebuilder.webshopworks.com/?api=1&template=%d';

    /**
     * This function notifies the user of upgrade notices, new templates and contributors
     *
     * @param bool $force
     *
     * @return array|bool
     */
    private static function _getInfoData($force = false)
    {
        $cache_key = 'elementor_remote_info_api_data_' . str_replace('.', '_', _CE_VERSION_);
        $info_data = get_transient($cache_key, 0, 0);

        if ($force || false === $info_data) {
            $response = wp_remote_post(self::$api_info_url, array(
                'timeout' => 25,
                'body' => array(
                    // Which API version is used
                    'api_version' => _CE_VERSION_,
                    // Which language to return
                    'site_lang' => \Context::getContext()->language->iso_code,
                ),
            ));

            if (empty($response)) {
                set_transient($cache_key, array(), 5 * 60, 0, 0);

                return false;
            }

            $info_data = json_decode($response, true);
            if (empty($info_data) || !is_array($info_data)) {
                set_transient($cache_key, array(), 5 * 60, 0, 0);

                return false;
            }

            if (isset($info_data['templates'])) {
                update_option('elementor_remote_info_templates_data', $info_data['templates'], 0, 0);
                unset($info_data['templates']);
            }
            set_transient($cache_key, $info_data, 12 * 3600, 0, 0);
        }

        return $info_data;
    }

    public static function getUpgradeNotice()
    {
        $data = self::_getInfoData();
        if (empty($data['upgrade_notice'])) {
            return false;
        }

        return $data['upgrade_notice'];
    }

    public static function getTemplatesData()
    {
        self::_getInfoData();

        $templates = get_option('elementor_remote_info_templates_data', false, 0, 0);
        if (empty($templates)) {
            return array();
        }

        return $templates;
    }

    public static function getTemplateContent($template_id)
    {
        $url = sprintf(self::$api_get_template_content_url, $template_id);
        $response = wp_remote_get($url, array(
            'timeout' => 40,
            'body' => array(
                // Which API version is used
                'api_version' => _CE_VERSION_,
                // Which language to return
                'site_lang' => \Context::getContext()->language->iso_code,
            ),
        ));

        if (empty($response)) {
            return false;
        }

        $template_content = json_decode($response, true);
        if (empty($template_content) || !is_array($template_content)) {
            return false;
        }

        if (empty($template_content['content'])) {
            return false;
        }

        return $template_content['content'];
    }

    public static function sendFeedback($feedback_key, $feedback_text)
    {
        $response = wp_remote_post(self::$api_feedback_url, array(
            'timeout' => 30,
            'body' => array(
                'api_version' => _CE_VERSION_,
                'site_lang' => get_bloginfo('language'),
                'feedback_key' => $feedback_key,
                'feedback' => $feedback_text,
            ),
        ));

        return true;
    }

    public function ajaxResetApiData()
    {
        self::_getInfoData(true);

        wp_send_json_success();
    }
}
