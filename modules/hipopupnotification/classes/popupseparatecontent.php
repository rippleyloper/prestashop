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

class HiPopupSeparateContent extends ObjectModel
{
    public $id;
    public $id_popup;
    public $id_selector;

    public static $definition = array(
        'table' => 'hipopup_separate_content',
        'primary' => 'id',
        'fields' => array(
            'id_popup' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'id_selector' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
        ),
    );


    public static function getContentByIdPopup($id_popup, $popup_type)
    {
        $query = new DbQuery();
        $return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            $query
                ->select('pns.*')
                ->from('hipopupnotification', 'pn')
                ->leftJoin('hipopup_separate_content', 'pns', 'pns.`id_popup` = pn.`id_hipopupnotification`')
                ->where('pns.`id_selector` != 0')
                ->where('pns.`id_popup` = '.(int)($id_popup))
                ->where('pn.`popup_type` = \''.pSQL($popup_type).'\'')
                ->build()
        );
        return $return;
    }
}
