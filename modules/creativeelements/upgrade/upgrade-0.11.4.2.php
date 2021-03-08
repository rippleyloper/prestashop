<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

function upgrade_module_0_11_4_2($module)
{
    $db = Db::getInstance();
    $table = _DB_PREFIX_ . CreativePage::$definition['table'];
    $db->execute("ALTER TABLE {$table}_lang DROP PRIMARY KEY, ADD PRIMARY KEY(id, id_shop, id_lang)");

    return $module->registerHook('actionObjectCategoryDeleteAfter');
}
