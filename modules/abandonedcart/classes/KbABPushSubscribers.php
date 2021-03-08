<?php
/**
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future.If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
* We offer the best and most useful modules PrestaShop and modifications for your online store.
*
* @author    knowband.com <support@knowband.com>
* @copyright 2020 Knowband
* @license   see file: LICENSE.txt
* @category  PrestaShop Module
*/

/**
 * This file is added by Anshul for adding Web Push Notification changes.
 * It will allow an Admin to send browser notifications to those customers who left their carts abandoned.
 * Feature: Push Notification (Jan 2020)
 */

//Class and its methods to handle
class KbABPushSubscribers extends ObjectModel
{
    public $id_subscriber;
    public $id_lang;
    public $id_shop;
    public $id_guest;
    public $id_cart;
    public $reg_id;
    public $ip;
    public $browser;
    public $browser_version;
    public $platform;
    public $device;
    public $token_id;
    public $date_add;
    public $date_upd;
    
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'kb_ab_web_push_subscribers',
        'primary' => 'id_subscriber',
        'fields' => array(
            'id_subscriber' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'id_lang' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'id_guest' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'id_cart' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'reg_id' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHTML'
            ),
            'ip' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHTML'
            ),
            'browser' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName'
            ),
            'browser_version' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHTML'
            ),
            'platform' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHTML'
            ),
            'device' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
            ),
            'token_id' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHTML',
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
                'copy_post' => false
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
                'copy_post' => false
            ),
        ),
    );
    
    public function __construct($id_subscriber = null)
    {
        parent::__construct($id_subscriber);
    }
    
    /*
     * function to get subscriber by guest id
     * Feature: Push Notification (Jan 2020)
     *
     * @param id_cart
     * @return array
     */
    public static function getPushSubscriber($id_cart, $token = null)
    {
        if (empty($id_cart) && $id_cart == null) {
            return;
        }
        
        return Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'kb_ab_web_push_subscribers where id_cart='.(int)$id_cart);
    }
    
    /*
     * function to get listing of registration tokens
     * Feature: Push Notification (Jan 2020)
     *
     * @param id_guest, id_shop
     * @return array
     */
    public static function getSubscriberRegIDs($id_guest = null, $id_shop = null)
    {
        $str = '';
        if (!empty($id_guest)) {
            $str .= ' AND id_guest='.(int)$id_guest;
        }
        if (!empty($id_shop)) {
            $str .= ' AND id_shop='.(int)$id_shop;
        }
        $query = Db::getInstance()->executeS('SELECT reg_id FROM '._DB_PREFIX_.'kb_ab_web_push_subscribers Where 1 '.pSQL($str));
        return $query;
    }
    
    /*
     * function to get the subscriber by registation token and id_cart
     * Feature: Push Notification (Jan 2020)
     *
     * @return array
     */
    public static function getSubscriberbyRegID($reg_id, $id_cart = null)
    {
        $str = '';
        if (!empty($id_cart) && $id_cart != null) {
            $str .= ' AND id_cart='.(int)$id_cart;
        }
        
        return Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'kb_ab_web_push_subscribers where reg_id="'.pSQL($reg_id).'" '.$str);
    }
}
