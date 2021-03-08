<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements\TemplateLibrary;

defined('_PS_VERSION_') or exit;

use Tools;
use Configuration;
use PrestaShopException;
use CreativePage;
use CreativeElements\Helper;
use CreativeElements\DB;
use CreativeElements\Plugin;
use CreativeElements\Settings;
use CreativeElements\User;

class SourceLocal extends SourceBase
{
    const CPT = 'elementor_library';

    const TAXONOMY_TYPE_SLUG = 'elementor_library_type';

    const TYPE_META_KEY = '_elementor_template_type';

    public static function getTemplateTypes()
    {
        return array(
            'page',
            'section',
        );
    }

    public function getId()
    {
        return 'local';
    }

    public function getTitle()
    {
        return __('Local', 'elementor');
    }

    /*
    public function registerData()
    {
        $labels = array(
            'name' => _x('My Library', 'Template Library', 'elementor'),
            'singular_name' => _x('Template', 'Template Library', 'elementor'),
            'add_new' => _x('Add New', 'Template Library', 'elementor'),
            'add_new_item' => _x('Add New Template', 'Template Library', 'elementor'),
            'edit_item' => _x('Edit Template', 'Template Library', 'elementor'),
            'new_item' => _x('New Template', 'Template Library', 'elementor'),
            'all_items' => _x('All Templates', 'Template Library', 'elementor'),
            'view_item' => _x('View Template', 'Template Library', 'elementor'),
            'search_items' => _x('Search Template', 'Template Library', 'elementor'),
            'not_found' => _x('No Templates found', 'Template Library', 'elementor'),
            'not_found_in_trash' => _x('No Templates found in Trash', 'Template Library', 'elementor'),
            'parent_item_colon' => '',
            'menu_name' => _x('My Library', 'Template Library', 'elementor'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'rewrite' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array('title', 'thumbnail', 'author', 'elementor'),
        );

        register_post_type(
            self::CPT,
            apply_filters('elementor/template_library/sources/local/register_post_type_args', $args)
        );

        $args = array(
            'hierarchical' => false,
            'show_ui' => false,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'query_var' => is_admin(),
            'rewrite' => false,
            'public' => false,
            'label' => _x('Type', 'Template Library', 'elementor'),
        );

        register_taxonomy(
            self::TAXONOMY_TYPE_SLUG,
            self::CPT,
            apply_filters('elementor/template_library/sources/local/register_taxonomy_args', $args)
        );
    }

    public function registerAdminMenu()
    {
        add_submenu_page(
            Settings::PAGE_ID,
            __('My Library', 'elementor'),
            __('My Library', 'elementor'),
            'edit_pages',
            'edit.php?post_type=' . self::CPT
        );
    }
    */

    public function getItems()
    {
        $table = _DB_PREFIX_ . CreativePage::$definition['table'];
        $active = CreativePage::TPL_ACTIVE;
        $templates = array();

        $elems = \Db::getInstance()->executeS("
            SELECT e.id, el.title, e.type AS template_type FROM $table AS e
            INNER JOIN {$table}_lang AS el ON e.id = el.id
            WHERE e.active = $active
            ORDER BY el.title ASC
        ");

        foreach ($elems as $elem) {
            $templates[] = $this->getItem($elem);
        }

        return $templates;
    }

    public function saveItem($template_data)
    {
        if (!empty($template_data['type']) && !in_array($template_data['type'], self::getTemplateTypes())) {
            return new PrestaShopException('save_error - The specified template type doesn\'t exists');
        }

        $lang = (int) Configuration::get('PS_LANG_DEFAULT');
        Configuration::set('PS_LANG_DEFAULT', CreativePage::TPL_LANG);

        $elem = new CreativePage(null, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);
        $elem->active = CreativePage::TPL_ACTIVE;
        $elem->type = $template_data['type'];
        $elem->title = !empty($template_data['title']) ? $template_data['title'] : \CreativeElements\__('(no title)', 'elementor');
        $elem->data = array(
            CreativePage::TPL_LANG => json_encode($template_data['data'])
        );
        $elem->add();

        Configuration::set('PS_LANG_DEFAULT', $lang);

        if (empty($elem->id)) {
            return new PrestashopException('save_error - ' . \Db::getInstance()->getMsgError());
        }

        return array(
            'id' => $elem->id,
            'title' => $elem->title,
            'template_type' => $elem->type,
        );
    }

    public function updateItem($new_data)
    {
        Plugin::instance()->db->save_editor($new_data['id'], $new_data['data']);

        return true;
    }

    /**
     * @param int $item_id
     *
     * @return array
     */
    public function getItem($item)
    {
        $context = \Context::getContext();

        if (!is_array($item)) {
            throw new PrestaShopException('TODO: getItem by id');
        }

        return array(
            'template_id' => $item['id'],
            'source' => $this->getId(),
            'type' => $item['template_type'],
            'title' => $item['title'],
            // 'thumbnail' => get_the_post_thumbnail_url($post),
            // 'date' => mysql2date(get_option('date_format'), $post->post_date),
            // 'author' => $user->display_name,
            'categories' => array(),
            'keywords' => array(),
            'export_link' => $context->link->getAdminLink($context->controller->name) . '&' . http_build_query(array(
                'ajax' => 1,
                'action' => 'ExportTemplate',
                'source' => $this->getId(),
                'template_id' => $item['id'],
            )),
            'url' => Helper::getTemplatePreviewLink($item['id']),
        );
    }

    public function getContent($item_id, $context = 'display')
    {
        $elem = new CreativePage($item_id, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);
        $data = json_decode($elem->data, true);

        /*
        // TODO: Valid the data (in JS too!)
        if ('display' === $context) {
            $data = $db->get_builder($item_id);
        } else {
            $data = $db->get_plain_editor($item_id);
        }
        */

        return $this->replaceElementsIds($data);
    }

    public function deleteTemplate($item_id)
    {
        $elem = new CreativePage($item_id, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);
        $elem->id = $item_id;
        $elem->delete();
    }

    public function exportTemplate($item_id)
    {
        $elem = new CreativePage($item_id, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);

        $template_data = json_decode($elem->data, true);
        $template_data = $this->processExportImportData($template_data, 'onExport');
        if (empty($template_data)) {
            return new PrestaShopException('404 - The template does not exist');
        }

        // TODO: More fields to export?
        $export_data = array(
            'version' => _CE_VERSION_,
            'title' => $elem->title,
            'type' => $elem->type,
            'data' => $template_data,
        );

        $filename = 'CreativeElements_' . $item_id . '_' . date('Y-m-d') . '.json';
        $template_contents = json_encode($export_data);
        $filesize = Tools::strlen($template_contents);

        // Headers to prompt "Save As"
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $filesize);

        // Clear buffering just in case
        @ob_end_clean();

        flush();

        // Output file contents
        echo $template_contents;

        die;
    }

    public function importTemplate()
    {
        $import_file = $_FILES['file']['tmp_name'];

        if (empty($import_file)) {
            return new PrestaShopException('file_error - Please upload a file to import');
        }

        $data = 'data';
        $is_invalid_file = true;
        $content = json_decode(Tools::file_get_contents($import_file), true);

        if ($content) {
            if (!empty($content[$data]) && is_array($content[$data])) {
                $is_invalid_file = false;
            } elseif (!empty($content['content']) && is_array($content['content'])) {
                $is_invalid_file = false;
                $data = 'content';
            }
        }

        if ($is_invalid_file) {
            return new PrestaShopException('file_error - Invalid File');
        }

        $content_data = $this->processExportImportData($content[$data], 'onImport');

        $item_id = $this->saveItem(array(
            'data' => $content_data,
            'title' => $content['title'],
            'type' => $content['type'],
        ));

        if ($item_id instanceof PrestaShopException) {
            return $item_id;
        }

        return $this->getItem($item_id);
    }

    /*
    public function postRowActions($actions, \WP_Post $post)
    {
        if ($this->_isBaseTemplatesScreen()) {
            $actions['export-template'] = sprintf('<a href="%s">%s</a>', $this->_getExportLink($post->ID), __('Export Template', 'elementor'));
            unset($actions['inline hide-if-no-js']);
        }

        return $actions;
    }

    public function adminImportTemplateForm()
    {
        if (!$this->_isBaseTemplatesScreen()) {
            return;
        }
        ?>
        <div id="elementor-hidden-area">
            <a id="elementor-import-template-trigger" class="page-title-action"><?php _e('Import Template', 'elementor');?></a>
            <div id="elementor-import-template-area">
                <div id="elementor-import-template-title"><?php _e('Choose an Elementor template JSON file, and add it to the list of templates available in your library.', 'elementor');?></div>
                <form id="elementor-import-template-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="elementor_import_template">
                    <fieldset id="elementor-import-template-form-inputs">
                        <input type="file" name="file" accept="application/json" required>
                        <input type="submit" class="button" value="<?php _e('Import Now', 'elementor');?>">
                    </fieldset>
                </form>
            </div>
        </div>
        <?php
    }

    public function blockTemplateFrontend()
    {
        if (is_singular(self::CPT) && !User::is_current_user_can_edit()) {
            wp_redirect(site_url(), 301);
            die;
        }
    }

    private function _isBaseTemplatesScreen()
    {
        global $current_screen;

        if (!$current_screen) {
            return false;
        }

        return 'edit' === $current_screen->base && self::CPT === $current_screen->post_type;
    }

    private function _getExportLink($item_id)
    {
        return add_query_arg(
            array(
                'action' => 'elementor_export_template',
                'source' => $this->getId(),
                'template_id' => $item_id,
            ),
            admin_url('admin-ajax.php')
        );
    }

    private function _addActions()
    {
        if (is_admin()) {
            add_action('admin_menu', array($this, 'register_admin_menu'), 50);
            add_filter('post_row_actions', array($this, 'post_row_actions'), 10, 2);
            add_action('admin_footer', array($this, 'admin_import_template_form'));
        }

        add_action('template_redirect', array($this, 'block_template_frontend'));
    }

    public function __construct()
    {
        parent::__construct();

        $this->_addActions();
    }
    */
}
