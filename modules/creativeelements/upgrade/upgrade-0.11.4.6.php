<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

function upgrade_module_0_11_4_6($module)
{
    $db = Db::getInstance();
    $table = _DB_PREFIX_ . CreativePage::$definition['table'];
    try {
        $db->execute("ALTER TABLE $table ADD KEY id_page (id_page)");
    } catch (Exception $ex) {
        // ignore exception when KEY already exists
    }

    return $module->registerHook('actionObjectYbc_blog_post_classDeleteAfter');
}
