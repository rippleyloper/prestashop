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

class PostsCssManager
{
    /*
    public function __construct()
    {
        $this->init();
        $this->registerActions();
    }

    public function init()
    {
        // Create the css directory if it's not exist
        $wp_upload_dir = wp_upload_dir(null, false);
        $css_path = $wp_upload_dir['basedir'] . PostCssFile::FILE_BASE_DIR;

        if (!is_dir($css_path)) {
            wp_mkdir_p($css_path);
        }
    }
    */

    public function onSavePost($post_id, $lang_id)
    {
        $css_file = new PostCssFile($post_id, $lang_id);
        $css_file->update();
    }

    public function onDeletePost($post_id, $lang_id)
    {
        $css_file = new PostCssFile($post_id, $lang_id);
        $css_file->delete();
    }

    /**
     * @param bool $skip
     * @param string $meta_key
     *
     * @return bool
     */
    public function onExportPostMeta($skip, $meta_key)
    {
        if (PostCssFile::META_KEY_CSS === $meta_key) {
            $skip = true;
        }

        return $skip;
    }

    /*
    public function clearCache()
    {
        $errors = array();

        // Delete post meta
        global $wpdb;

        $deleted = $wpdb->delete($wpdb->postmeta, array(
            'meta_key' => PostCssFile::META_KEY_CSS,
        ));

        if (false === $deleted) {
            $errors['db'] = __('Cannot delete DB cache', 'elementor');
        }

        // Delete files
        $wp_upload_dir = wp_upload_dir(null, false);
        $path = sprintf('%s%s%s%s*', $wp_upload_dir['basedir'], PostCssFile::FILE_BASE_DIR, '/', PostCssFile::FILE_PREFIX);

        foreach (glob($path) as $file) {
            $deleted = unlink($file);

            if (!$deleted) {
                $errors['files'] = __('Cannot delete files cache', 'elementor');
            }
        }

        return $errors;
    }

    private function registerActions()
    {
        add_action('save_post', array($this, 'on_save_post'));
        add_action('deleted_post', array($this, 'on_delete_post'));

        add_filter('wxr_export_skip_postmeta', array($this, 'on_export_post_meta'), 10, 2);
    }
    */
}
