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

class NewsletterUser extends ObjectModel
{
    public $id;
    public $customer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $code;
    public $date_end;
    public $used;

    public static $definition = array(
        'table' => 'hinewslettervoucher',
        'primary' => 'id_hinewslettervoucher',
        'fields' => array(
            'customer_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'first_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'last_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'email' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'code' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'date_end' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'used' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );
}
