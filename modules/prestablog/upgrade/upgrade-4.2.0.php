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

function upgrade_module_4_2_0()
{
    Tools::clearCache();

    return true;
}
