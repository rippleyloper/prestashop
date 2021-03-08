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

include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../init.php');

$hipopup = Module::getInstanceByName('hipopupnotification');

if (Tools::getValue('secure_key') != $hipopup->secure_key) {
    die(Tools::jsonEncode(array('error' => $hipopup->l('Hack Attempt!'))));
}

$link = new Link();
$first_name = preg_replace('/\PL/u', '', Tools::getValue('user_fname'));
$last_name = preg_replace('/\PL/u', '', Tools::getValue('user_lname'));
$email = Tools::getValue('email');
$gender = Tools::getValue('gender');
$activate_url = $link->getModuleLink('hipopupnotification', 'connect').(Configuration::get('PS_REWRITING_SETTINGS') ? '?' : '&' ).'content_only=1&activate=facebook&email='.$email.'&user_data_id='.Tools::getValue('user_data_id').'&user_fname='.$first_name.'&user_lname='.$last_name.'&name_status=full&gender='.$gender;

if ($first_name == '' || $last_name == '' || $email == '') {
    die(Tools::jsonEncode(array('activate_die_url' => $activate_url.'&full_info=false&popup=0')));
} else {
    Tools::redirect($activate_url.'&full_info=true&popup=0');
}
