<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

require_once _PS_MODULE_DIR_ . 'creativeelements/includes/plugin.php';

use CreativeElements\Plugin;
use CreativeElements\PostCssFile;

class CreativeElementsPreviewModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        if (!CreativeElements::hasAdminToken('AdminCreativePage')) {
            Tools::redirect('index.php?controller=404');
        }

        if (Tools::getIsset('redirect')) {
            $cookie = CreativeElements\get_option('cookie');
            CreativeElements\delete_option('cookie');

            if (!empty($cookie)) {
                $lifetime = max(1, (int) Configuration::get('PS_COOKIE_LIFETIME_BO')) * 3600 + time();
                $admin = new Cookie('psAdmin', '', $lifetime);
                foreach ($cookie as $key => &$value) {
                    $admin->{$key} = $value;
                }
                $admin->id_employee = Tools::getValue('id_employee');
                $admin->write();
            }
            Tools::redirectAdmin(urldecode(Tools::getValue('redirect')));
        }

        parent::init();
    }

    public function initContent()
    {
        if ($id = (int) Tools::getValue('id')) {
            parent::initContent();

            if (Tools::getIsset('cp_type')) {
                $elem = new stdClass();
                $elem->data = '[]';
            } else {
                $elem = new CreativePage($id, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);

                $css_file = new PostCssFile($id, CreativePage::TPL_LANG, CreativePage::TPL_SHOP);
                $css_file->enqueue();
            }

            $this->context->smarty->assign(array(
                'creative_elements' => Plugin::instance(),
                'creativepage_id' => $id,
                'creativepage_data' => (array) json_decode($elem->data, true),
            ));

            $this->setTemplate('module:creativeelements/views/templates/front/preview.tpl');
        }
    }
}
