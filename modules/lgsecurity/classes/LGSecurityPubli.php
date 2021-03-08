<?php
/**
*  Please read the terms of the CLUF license attached to this module(cf "licences" folder)
*
* @author    Línea Gráfica E.C.E. S.L.
* @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
* @license   https://www.lineagrafica.es/licenses/license_en.pdf
*            https://www.lineagrafica.es/licenses/license_es.pdf
*            https://www.lineagrafica.es/licenses/license_fr.pdf
*/

class LGSecurityPubli
{
    public static function getHeader($module)
    {
        return self::getP('top', $module);
    }

    public static function getFooter($module)
    {
        return self::getP('bottom', $module);
    }

    protected static function getP($template, $module)
    {
        $context          = Context::getContext();
        $current_iso_lang = $context->language->iso_code;
        $iso              = (in_array($current_iso_lang, LGSecurityConfiguration::$iso_langs)) ? $current_iso_lang : 'en';

        $context->smarty->assign(
            array(
                'lgcookieslaw_iso' => $iso,
                'base_url'         => _MODULE_DIR_. LGSecurityConfiguration::MODULE_NAME,
            )
        );

        return $module->display(
            $module->getLocalPath(),
            'views'
            . DIRECTORY_SEPARATOR . 'templates'
            . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . '_p_' . $template . '.tpl'
        );
    }
}
