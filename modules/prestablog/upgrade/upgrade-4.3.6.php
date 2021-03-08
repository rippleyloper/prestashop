<?php
/**
 * 2008 - 2020 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_4_3_6()
{
    if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
        ALTER TABLE `'.bqSQL(_DB_PREFIX_).'prestablog_author`
        ADD COLUMN `meta_title` varchar(60),
        ADD COLUMN `meta_description` varchar(160)')) {
        return false;
    }

    Tools::clearCache();

    return true;
}
