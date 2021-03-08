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

class PopupSocialConnectUser extends ObjectModel
{
    public $id;
    public $social_network;
    public $id_user;
    public $first_name;
    public $last_name;
    public $email;
    public $gender;
    public $date_add;

    public static $definition = array(
        'table' => 'hipopupsocialconnectuser',
        'primary' => 'id_hipopupsocialconnectuser',
        'fields' => array(
            'social_network' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'screen_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'id_user' => array(
                'type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 250, 'required' => true),
            'first_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'last_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'email' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'gender' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 100),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values)) {
            return false;
        }
        return true;
    }
}
