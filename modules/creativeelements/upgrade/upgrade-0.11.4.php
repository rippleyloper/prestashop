<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

function upgrade_module_0_11_4($module)
{
    $module->registerHook('overrideLayoutTemplate');

    $db = Db::getInstance();
    $table = _DB_PREFIX_ . CreativePage::$definition['table'];
    $engine = _MYSQL_ENGINE_;

    $db->execute("
        CREATE TABLE IF NOT EXISTS `{$table}_shop` (
          `id` int(10) UNSIGNED NOT NULL,
          `id_shop` int(10) UNSIGNED NOT NULL,
          PRIMARY KEY (`id`,`id_shop`),
          KEY `id_shop` (`id_shop`)
        ) ENGINE=$engine DEFAULT CHARSET=utf8;
    ");

    $empty = !$db->getValue("SELECT 1 FROM {$table}_shop");

    if ($empty) {
        $rows = $db->executeS("SELECT DISTINCT id, id_shop FROM {$table}_lang");

        foreach ($rows as $row) {
            $db->insert(CreativePage::$definition['table'] . '_shop', $row);
        }
    }

    $db->execute("ALTER TABLE {$table}_lang DROP PRIMARY KEY, ADD PRIMARY KEY(id, id_shop, id_lang)");

    return true;
}
