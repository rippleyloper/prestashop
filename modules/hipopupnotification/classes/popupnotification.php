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

class PopupNotification extends ObjectModel
{
    public $id;
    public $active;
    public $popup_type;
    public $width;
    public $height;
    public $content_type;
    public $content;
    public $content_lang;
    public $background_image;
    public $background_repeat;
    public $cookie_time;
    public $auto_close_time;
    public $delay_time;
    public $animation;
    public $date_start;
    public $date_end;

    public static $definition = array(
        'table' => 'hipopupnotification',
        'primary' => 'id_hipopupnotification',
        'multilang' => true,
        'fields' => array(
            'active' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'popup_type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'width' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'height' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'content_type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'content' =>   array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'content_lang' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'lang' => true),
            'background_image' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'background_repeat' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'cookie_time' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'auto_close_time' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'delay_time' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'animation' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'date_start' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_end' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function delete()
    {
        $res = parent::delete();
        $res &= Db::getInstance()->execute('
            DELETE FROM `'._DB_PREFIX_.'hipopup_separate_content`
            WHERE id_popup = '.(int)$this->id);
        return $res;
    }


    public static function getAllList($active = '')
    {
        $id_lang = Context::getContext()->language->id;
        $query = new DbQuery();
        $active_in = $active != '' ? '("1")' : '("0","1")';
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pn.*')
                ->select('pnl.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopupnotification_lang', 'pnl', 'pnl.`id_hipopupnotification` = pn.`id_hipopupnotification`')
                ->where('pnl.`id_lang` = '.(int)$id_lang)
                ->where('pn.active IN '.$active_in)
                ->build()
        );
        return $return;
    }

    public static function getPopupByPopupType($popup_type, $active = '')
    {
        $id_lang = Context::getContext()->language->id;
        $active_in = $active != '' ? '("1")' : '("0","1")';
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pn.*')
                ->select('pnl.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopupnotification_lang', 'pnl', 'pnl.`id_hipopupnotification` = pn.`id_hipopupnotification`')
                ->where('pnl.`id_lang` = '.(int)$id_lang)
                ->where('pn.active IN '.$active_in)
                ->where('pn.`popup_type` = \''.pSQL($popup_type).'\'')
                ->build()
        );
        return $return;
    }


    public static function getPopupOptionByContentType($id, $content_type)
    {
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow(
            $query
                ->select('pn.content')
                ->from('hipopupnotification', 'pn')
                ->where('pn.`id_hipopupnotification` = '.(int)$id)
                ->where('pn.`content_type` = \''.pSQL($content_type).'\'')
                ->build()
        );
        return !empty($return) ? $return['content'] : $return;
    }

    

    public static function getPopupLangOptionByContentType($id, $content_type)
    {
        $res = array();
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pnl.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopupnotification_lang', 'pnl', 'pnl.`id_hipopupnotification` = pn.`id_hipopupnotification`')
                ->where('pn.`id_hipopupnotification` = '.(int)$id)
                ->where('pn.`content_type` = \''.pSQL($content_type).'\'')
                ->build()
        );
        if (!empty($return)) {
            foreach ($return as $value) {
                $res[$value['id_lang']] = $value['content_lang'];
            }
        }
        return $res;
    }

    public static function getPopupContentByIdPopup($popup_type, $id_popup)
    {
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pn.*')
                ->select('pnl.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopupnotification_lang', 'pnl', 'pnl.`id_hipopupnotification` = pn.`id_hipopupnotification`')
                ->where('pn.`id_hipopupnotification` = '.(int)($id_popup))
                ->where('pn.`popup_type` = \''.pSQL($popup_type).'\'')
                ->where('pn.active = 1')
                ->build()
        );
        return $return;
    }

    public static function getPopupContentByIdSelector($popup_type, $id_selector)
    {
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pn.*')
                ->select('pnl.*')
                ->select('pns.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopupnotification_lang', 'pnl', 'pnl.`id_hipopupnotification` = pn.`id_hipopupnotification`')
                ->leftJoin('hipopup_separate_content', 'pns', 'pns.`id_popup` = pn.`id_hipopupnotification`')
                ->where('pns.`id_selector` = '.(int)($id_selector))
                ->where('pn.active = 1')
                ->where('pn.`popup_type` = \''.pSQL($popup_type).'\'')
                ->build()
        );
        return $return;
    }
}
