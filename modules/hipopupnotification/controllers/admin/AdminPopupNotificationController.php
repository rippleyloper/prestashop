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

class AdminPopupNotificationController extends ModuleAdminController
{
    public function __construct()
    {
        $this->secure_key = Tools::getValue('secure_key');
        $this->ajax = Tools::getValue('ajax');
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        if ($this->ajax) {
            if ($this->secure_key == $this->module->secure_key) {
                switch (Tools::getValue('action')) {
                    case 'product_search':
                        $this->productSearch(urldecode(Tools::getValue('q')));
                        break;
                    case 'update_status':
                        $table = new PopupNotification(Tools::getValue('id'));
                        $table->active = Tools::getValue('status') == '0' ? 1 : 0;
                        if ($table->date_start != '0000-00-00') {
                            $table->date_start = $table->date_start;
                        } else {
                            $table->date_start = '';
                        }
                        if ($table->date_end != '0000-00-00') {
                            $table->date_end = $table->date_end;
                        } else {
                            $table->date_end = '';
                        }
                        $table->update();
                        $content = $this->module->renderList();
                        die(Tools::jsonEncode(array(
                            'content' => $content,
                        )));
                    case 'show_form':
                        die(Tools::jsonEncode(array(
                            'content' => $this->module->renderListForm(Tools::getValue('action_type'), Tools::getValue('id')),
                        )));
                    case 'update_helper_list':
                        die(Tools::jsonEncode(array(
                            'content' => $this->module->renderList(),
                        )));
                    case 'save_list':
                        $languages = Language::getLanguages(false);
                        $file_type = Tools::strtolower(Tools::substr(strrchr($_FILES['background_image']['name'], '.'), 1));
                        $multilang_file = true;

                        foreach ($languages as $lang) {
                            if ($_FILES['image_input_'.$lang['id_lang']]['name'] != '') {
                                $multilang_file_type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_input_'.$lang['id_lang']]['name'], '.'), 1));
                                if (!in_array($multilang_file_type, array('jpg', 'gif', 'jpeg', 'png'))) {
                                    $multilang_file = false;
                                    break;
                                }
                            }
                        }
                        if (!Validate::isInt(Tools::getValue('width'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for width'),
                            )));
                        } elseif (!Validate::isInt(Tools::getValue('height'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for height'),
                            )));
                        } elseif (!Validate::isInt(Tools::getValue('cookie_time'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for cookie time'),
                            )));
                        } elseif (!Validate::isInt(Tools::getValue('auto_close_time'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for auto close time'),
                            )));
                        } elseif (!Validate::isInt(Tools::getValue('delay_time'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for delay time'),
                            )));
                        } elseif (Tools::getValue('start_date') != '0000-00-00' && !Validate::isDate(Tools::getValue('start_date'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for Start date'),
                            )));
                        } elseif (Tools::getValue('end_date') != '0000-00-00' && !Validate::isDate(Tools::getValue('end_date'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Invalid value for End date'),
                            )));
                        } elseif ($file_type != '' && !in_array($file_type, array('jpg', 'gif', 'jpeg', 'png'))) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Please upload only image .jpg .gif .jpeg .png'),
                            )));
                        } elseif (Tools::getValue('content_type') == 'image' && $_FILES['image_input_'.Configuration::get('PS_LANG_DEFAULT')]['name'] == '') {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Please upload image'),
                            )));
                        } elseif (!$multilang_file) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->l('Please upload only image .jpg .gif .jpeg .png'),
                            )));
                        } else {
                            $this->module->saveList(Tools::getValue('row_id'));
                            die(Tools::jsonEncode(array(
                                'error' => false,
                            )));
                        }
                        break;
                    case 'delete_list_item':
                        $delete = new PopupNotification(Tools::getValue('id'));
                        $delete->delete();
                        die();
                    case 'delete_list_item_bg':
                        $popupnotification = new PopupNotification(Tools::getValue('id'));
                        if ($popupnotification->background_image) {
                            unlink(_PS_MODULE_DIR_.$this->module->name.'/views/img/upload/'.$popupnotification->background_image);
                        }
                        $popupnotification->background_image = '';
                        if ($popupnotification->date_start != '0000-00-00') {
                            $popupnotification->date_start = $popupnotification->date_start;
                        } else {
                            $popupnotification->date_start = '';
                        }
                        if ($popupnotification->date_end != '0000-00-00') {
                            $popupnotification->date_end = $popupnotification->date_end;
                        } else {
                            $popupnotification->date_end = '';
                        }
                        $popupnotification->update();
                        die();
                /*Add Popup product*/
                    case 'add_popup_product':
                        $id_product = Tools::getValue('id_product');
                        $product_ids = Tools::getValue('product_ids');
                        if ($product_ids == '') {
                            $ids = $id_product.',';
                        } else {
                            $ids = $product_ids.$id_product.',';
                        }
                        $product_load = new Product($id_product);
                        if (!Validate::isLoadedObject($product_load)) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->module->l('The product ID is invalid', 'AdminPopupNotificationController'),
                            )));
                        } elseif (strpos($product_ids, $id_product) !== false) {
                            die(Tools::jsonEncode(array(
                                'error' => $this->module->l(' You already have this product', 'AdminPopupNotificationController'),
                            )));
                        } else {
                            die(Tools::jsonEncode(array(
                                'id_product' => $id_product,
                                'product_name' => Product::getProductName($id_product),
                                'ids' => $ids,
                            )));
                        }
                /*Delete Popup product*/
                    case 'delete_popup_product':
                        $id_product = Tools::getValue('id_product');
                        $product_ids = Tools::getValue('product_ids');
                        $ids = str_replace($id_product.',', "", $product_ids);
                        die(Tools::jsonEncode(array(
                            'id_product' => $id_product,
                            'product_name' => Product::getProductName($id_product),
                            'ids' => $ids,
                        )));
                /*Delete Newsletter user*/
                    case 'delete-newsletter':
                        $id = Tools::getValue('id');
                        $newsletter = new NewsletterUser($id);
                        $newsletter->delete();
                        die();
                /*Delete social connect user*/
                    case 'delete_table':
                        $table_id = (int)Tools::getValue('table_id');
                        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'hipopupsocialconnectuser WHERE id='.(int)$table_id);
                        die();
                    case 'delete_full':
                        $table_id = (int)Tools::getValue('table_id');
                        $email = Db::getInstance()->ExecuteS('SELECT email FROM '._DB_PREFIX_.'hipopupsocialconnectuser WHERE id='.(int)$table_id);
                        if (!empty($email)) {
                            $id_customer = Db::getInstance()->ExecuteS('SELECT id_customer FROM '._DB_PREFIX_.'customer WHERE email=\''.pSQL($email[0]['email']).'\'');
                            if (!empty($id_customer)) {
                                $customer = new Customer($id_customer[0]['id_customer']);
                                $customer->delete();
                            }
                        }
                        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'hipopupsocialconnectuser WHERE id='.(int)$table_id);
                        die();
                }
            } else {
                die();
            }
        } else {
            Tools::redirectAdmin($this->module->HiPrestaClass->getModuleUrl('&'.$this->name.'=list'));
        }
    }

    protected function productSearch($search_val)
    {
        $search_res = '';
        if ($search_val && !is_array($search_val)) {
            $search = Search::find((int)Tools::getValue('id_lang'), $search_val, 1, 10, 'position', 'desc', true, false);
            if (!empty($search)) {
                foreach ($search as $product) {
                    $search_res .= $product['id_product'].'|'.$product['pname'].'|'.$product['cname']."\n";
                }
            }
        }
        die($search_res);
    }
}
