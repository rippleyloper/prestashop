<?php
/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

function upgrade_module_1_0_3($module)
{
    $table_1 = 'hipopupnotification';
    $table_2 = 'hipopupnotification_lang';
    $table_3 = 'hinewslettervoucher';
    $table_4 = 'hipopupsocialconnectuser';

    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_1).'` CHANGE `id` `id_hipopupnotification` int(10) unsigned NOT NULL AUTO_INCREMENT;');
    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_1).'` DROP PRIMARY KEY, ADD PRIMARY KEY(`id_hipopupnotification`);');

    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_2).'` Change `id` `id_hipopupnotification` int(10) unsigned NOT NULL;');
    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_2).'` DROP PRIMARY KEY, ADD PRIMARY KEY(`id_hipopupnotification`, `id_lang`);');

    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_3).'` CHANGE `id` `id_hinewslettervoucher` int(10) unsigned NOT NULL AUTO_INCREMENT;');
    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_3).'` DROP PRIMARY KEY, ADD PRIMARY KEY(`id_hinewslettervoucher`);');

    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_4).'` CHANGE `id` `id_hipopupsocialconnectuser` int(10) unsigned NOT NULL AUTO_INCREMENT;');
    Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.pSQL($table_4).'` DROP PRIMARY KEY, ADD PRIMARY KEY(`id_hipopupsocialconnectuser`);');

    return true;
}
