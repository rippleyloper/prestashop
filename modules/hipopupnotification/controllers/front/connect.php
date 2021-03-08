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

class HiPopupNotificationConnectModuleFrontController extends ModuleFrontController
{
    public function setMedia()
    {
        parent::setMedia();
            $this->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/connect.css', 'all');
            $this->addJS(_MODULE_DIR_.$this->module->name.'/views/js/connect.js');
    }

    public function init()
    {
        parent::init();
        
        if ($this->ajax && Tools::getValue('login_request')) {
            $errors = array();
            if (Tools::getValue('secure_key') != $this->module->secure_key) {
                $errors[] = $this->module->l('Hack Attempt!', 'connect');
                die(Tools::jsonEncode(array('hasError' => true, 'errors' => $errors)));
            }
            if (Tools::isSubmit('submitAccount')) {
                if (!Validate::isEmail($email = Tools::getValue('email')) || empty($email)) {
                    $errors[] = $this->module->l('Invalid email address', 'connect');
                }

                if (Customer::customerExists($email)) {
                    $errors[] = $this->module->l('This email address is already registered', 'connect');
                }

                if (!Validate::isName($first_name = Tools::getValue('customer_firstname')) || empty($first_name)) {
                    $errors[] = $this->module->l('First Name is invalid', 'connect');
                }

                if (!Validate::isName($last_name = Tools::getValue('customer_lastname')) || empty($last_name)) {
                    $errors[] = $this->module->l('Last Name is invalid', 'connect');
                }

                if (!Validate::isPasswd($passwd = Tools::getValue('passwd')) || empty($passwd)) {
                    $errors[] = $this->module->l('Password is invalid', 'connect');
                }

                if ($this->module->log_reg_terms_url && !Tools::getValue('register_terms')) {
                    $errors[] = $this->module->l('You must agree with Terms of Use', 'connect');
                }

                if (count($errors)) {
                    die(Tools::jsonEncode(array('hasError' => true, 'errors' => $errors)));
                } else {
                    $customer = new Customer();
                    Hook::exec('actionBeforeSubmitAccount');
                    $customer->firstname = Tools::getValue('customer_firstname');
                    $customer->lastname = Tools::getValue('customer_lastname');
                    $customer->email = Tools::getValue('email');
                    $customer->passwd = md5(pSQL(_COOKIE_KEY_.Tools::getValue('passwd')));
                    $customer->is_guest = 0;
                    if (Tools::getValue('newsletter')) {
                        $customer->newsletter = 1;
                    }
                    $customer->active = 1;
                    $customer->add();
                    Hook::exec('actionCustomerAccountAdd', array(
                        '_POST' => $_POST,
                        'newCustomer' => $customer
                    ));
                    $this->module->sendConfirmationMail($customer, Tools::getValue('passwd'));
                    $context = Context::getContext();
                    $context->customer = $customer;
                    $context->cookie->id_customer = (int)$customer->id;
                    $context->cookie->customer_lastname = $customer->lastname;
                    $context->cookie->customer_firstname = $customer->firstname;
                    $context->cookie->passwd = $customer->passwd;
                    $context->cookie->logged = 1;
                    $customer->logged = 1;
                    $context->cookie->email = $customer->email;
                    $context->cookie->is_guest = $customer->is_guest;
                    // Update cart address
                    $context->cart->secure_key = $customer->secure_key;
                    $context->cookie->update();
                    $context->cart->update();

                    die(Tools::jsonEncode(array('hasError' => false)));
                }
            } elseif (Tools::isSubmit('SubmitLogin')) {
                $passwd = trim(Tools::getValue('passwd'));
                $email = trim(Tools::getValue('email'));

                if (!$email) {
                    $errors[] = $this->module->l('An email address required', 'connect');
                } elseif (!Validate::isEmail($email)) {
                    $errors[] = $this->module->l('Invalid email address', 'connect');
                } elseif (!$passwd) {
                    $errors[] = $this->module->l('Password is required', 'connect');
                } elseif (!Validate::isPasswd($passwd)) {
                    $errors[] = $this->module->l('Password is invalid', 'connect');
                }

                if (count($errors)) {
                    die(Tools::jsonEncode(array('hasError' => true, 'errors' => $errors)));
                } else {
                    $customer = new Customer();
                    $authentication = $customer->getByEmail(trim($email), trim($passwd));
                    if (!empty($authentication)) {
                        $context = Context::getContext();
                        Hook::exec('actionBeforeAuthentication');
                        if ($this->module->psv <= 1.6) {
                            if (isset($context->cookie->id_compare)) {
                                $id_compare = $context->cookie->id_compare;
                            } else {
                                $id_compare = CompareProduct::getIdCompareByIdCustomer($customer->id);
                            }
                            $context->cookie->id_compare = $id_compare;
                        }
                        $context->cookie->id_customer = (int)($customer->id);
                        $context->cookie->customer_lastname = $customer->lastname;
                        $context->cookie->customer_firstname = $customer->firstname;
                        $context->cookie->logged = 1;
                        $customer->logged = 1;
                        $context->cookie->is_guest = $customer->isGuest();
                        $context->cookie->passwd = $customer->passwd;
                        $context->cookie->email = $customer->email;
                        /* Add customer to the context */
                        $context->customer = $customer;
                        if (Configuration::get('PS_CART_FOLLOWING')
                            && (empty($context->cookie->id_cart)
                            || Cart::getNbProducts($context->cookie->id_cart) == 0)
                            && $id_cart = (int)Cart::lastNoneOrderedCart($context->customer->id)) {
                            $context->cart = new Cart($id_cart);
                        } else {
                            $context->cart->id_carrier = 0;
                            $context->cart->setDeliveryOption(null);
                            $context->cart->id_address_delivery = (int)Address::getFirstCustomerAddressId((int)($customer->id));
                            $context->cart->id_address_invoice = (int)Address::getFirstCustomerAddressId((int)($customer->id));
                        }
                        $context->cart->id_customer = (int)$customer->id;
                        $context->cart->secure_key = $customer->secure_key;
                        $context->cart->save();
                        $context->cookie->id_cart = (int)$context->cart->id;
                        $context->cookie->write();
                        $context->cart->autosetProductAddress();
                        Hook::exec('actionAuthentication');
                        /* Login information have changed, so we check if the cart rules still apply */
                        CartRule::autoRemoveFromCart($context);
                        CartRule::autoAddToCart($context);

                        die(Tools::jsonEncode(array('hasError' => false)));
                    } else {
                        $errors[] = $this->module->l('Authentication failed', 'connect');
                        die(Tools::jsonEncode(array('hasError' => true, 'errors' => $errors)));
                    }
                }
            } elseif (Tools::getValue('action') == 'newsletter_subscribtion') {
                $context = Context::getContext();

                $first_name = trim(Tools::getValue('firstname'));
                $last_name = trim(Tools::getValue('lastname'));
                $email = trim(Tools::getValue('email'));
                $terms = Tools::getValue('popup_terms');

                if (!$first_name || !Validate::isName($first_name)) {
                    $errors[] = $this->module->l('First Name is invalid', 'connect');
                }
                if (!$last_name || !Validate::isName($last_name)) {
                    $errors[] = $this->module->l('Last Name is invalid', 'connect');
                }
                if (!$email || !Validate::isEmail($email)) {
                    $errors[] = $this->module->l('Invalid email address', 'connect');
                }
                if ($this->module->nl_terms_url && !$terms) {
                    $errors[] = $this->module->l('You must agree with Terms of Use', 'connect');
                }

                if (count($errors)) {
                    die(Tools::jsonEncode(array('hasError' => true, 'errors' => $errors)));
                } else {
                    $customer = 0;
                    if ($customer = $this->module->isCustomerExists($email)) {
                        $this->module->registerUser($email);
                    } else {
                        $customer = 0;
                        if ($this->module->isNewsletterModuleExists()) {
                            if ($this->module->isNewsletterRegistered($email)) {
                                $errors[] = $this->module->l('This email address is already registered', 'connect');
                                die(Tools::jsonEncode(array(
                                    'hasError' => true,
                                    'errors' => $errors,
                                )));
                            } else {
                                $this->module->registerGuest($email);
                            }
                        }
                    }

                    // the sync will work as soon as we create an object.
                    $sendinblue = Module::getInstanceByName('sendinblue');

                    $voucher = $this->module->nl_voucher_code;
                    if ($voucher) {
                        $isVoucher = true;
                        if ($this->module->nl_send_voucher_email) {
                            $this->module->sendVoucherEmail($first_name, $last_name, $email, $voucher);
                        }
                    } else {
                        $voucher = 0;
                        $isVoucher = false;
                    }
                    $subscribed = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'hinewslettervoucher` WHERE email = \''.pSQL($email).'\'');
                    if (!$subscribed) {
                        $newsletter = new NewsletterUser();
                        $newsletter->customer_id = $customer;
                        $newsletter->first_name = $first_name;
                        $newsletter->last_name = $last_name;
                        $newsletter->email = $email;
                        $newsletter->code = $voucher;
                        $newsletter->date_end = '0';
                        $newsletter->used = '0';
                        $newsletter->add();
                    }
                    die(Tools::jsonEncode(array(
                        'hasError' => false,
                        'isVoucher' => $isVoucher,
                    )));
                }
            }
            die();
        } else {
            $customer = new Customer();
            $link = new Link();
            $base_dir = Tools::getHttpHost(true).__PS_BASE_URI__;
            $activate = Tools::getValue('activate');
            $id_user = Tools::getValue('user_data_id');
            $first_name = Tools::getValue('user_fname');
            $last_name = Tools::getValue('user_lname');
            $screen_name = Tools::getValue('screen_name');
            $gender = Tools::getValue('gender');
            $mail = Tools::getValue('email');
            $full_info = Tools::getValue('full_info');
            $popup = Tools::getValue('popup');
            $pass_erro = Tools::getValue('pass_erro');
            if ($mail != '' && $first_name != '' && $last_name != '' && $full_info) {
                $get_email = $customer->getByEmail($mail);
                if (!empty($get_email)) {
                    $this->customerLogin($customer);
                } else {
                    $result = Db::getInstance()->ExecuteS('
                        SELECT * FROM '._DB_PREFIX_.'hipopupsocialconnectuser
                        WHERE id_user ="'.pSQL($id_user).'"');
                    if (empty($result)) {
                        $this->addSCUsers($activate, $mail, $first_name, $last_name, $id_user, $screen_name, $gender);
                    }
                    $this->customerLoginAndRegister($customer, $first_name, $last_name, $mail);
                }
                if (!$popup) {
                    die(Tools::jsonEncode(array('errors' => '', 'have_email' => false, 'activate_die_url' => '')));
                } else {
                    $this->context->smarty->assign(array(
                        'redirect' => Configuration::get('PN_SOCIAL_REDIRECT'),
                        'authentication_page' => $link->getPageLink('my-account', true),
                    ));
                    if ($this->module->psv >= 1.7) {
                        echo $this->context->smarty->fetch('module:'.$this->module->name.'/views/templates/hook/connect_small_js.tpl');
                    } else {
                        echo $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/connect_small_js.tpl');
                    }
                }
            } else {
                $email_result = Db::getInstance()->ExecuteS('
                    SELECT * FROM '._DB_PREFIX_.'hipopupsocialconnectuser
                    WHERE id_user ="'.pSQL($id_user).'"');
                if (empty($email_result)) {
                    if ($this->ajax) {
                        $errors = array();
                        if ($mail == '' || !Validate::isEmail($mail)) {
                            $errors['email'] = $this->module->l('Invalid email address', 'connect');
                        }
                        if ($first_name == '' || !Validate::isName($first_name)) {
                            $errors['fname'] = $this->module->l('First Name is invalid', 'connect');
                        }
                        if ($last_name == '' || !Validate::isName($last_name)) {
                            $errors['lname'] = $this->module->l('Last Name is invalid', 'connect');
                        }
                        if (!empty($errors)) {
                            die(Tools::jsonEncode(array('errors' => $errors, 'have_email' => false)));
                        } else {
                            $get_email = $customer->getByEmail($mail);
                            $password = Tools::encrypt(Tools::getValue('password'));
                            if (!empty($get_email) && $get_email->passwd != $password) {
                                if ($pass_erro == '0') {
                                    $errors['email_exists'] = $this->module->l('An account using this email address has already been registered', 'connect');
                                } else {
                                    $errors['password'] = $this->module->l('Password is invalid', 'connect');
                                }
                                die(Tools::jsonEncode(array('errors' => $errors, 'have_email' => true)));
                            } elseif (!empty($get_email) && $get_email->passwd == $password) {
                                $this->customerLogin($customer);
                            } else {
                                $this->customerLoginAndRegister($customer, $first_name, $last_name, $mail);
                            }
                            $this->addSCUsers($activate, $mail, $first_name, $last_name, $id_user, $screen_name, $gender);
                            die(Tools::jsonEncode(array('errors' => $errors, 'have_email' => false, 'popup' => (bool)$popup)));
                        }
                    }
                } else {
                    $get_email = $customer->getByEmail($email_result[0]['email']);
                    if (!empty($get_email)) {
                        $this->customerLogin($customer);
                    } else {
                        $result = Db::getInstance()->ExecuteS('
                            SELECT * FROM '._DB_PREFIX_.'hipopupsocialconnectuser
                            WHERE id_user ="'.pSQL($id_user).'"');
                        if (!empty($result)) {
                            $this->customerLoginAndRegister($customer, $result[0]['first_name'], $result[0]['last_name'], $result[0]['email']);
                        }
                    }
                    $this->context->smarty->assign(
                        array(
                            'redirect' => Configuration::get('PN_SOCIAL_REDIRECT'),
                            'popup' => $popup,
                            'base_dir' => $base_dir,
                            'authentication_page' => $link->getPageLink('my-account', true),
                        )
                    );
                    if ($this->module->psv >= 1.7) {
                        echo $this->context->smarty->fetch('module:'.$this->module->name.'/views/templates/hook/connect_big_js.tpl');
                    } else {
                        echo $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/connect_big_js.tpl');
                    }
                }
            }
        }
    }

    public function addSCUsers($activate, $mail, $first_name, $last_name, $id_user, $screen_name, $gender)
    {
        include_once(dirname(__FILE__).'/../../classes/popupsocialconnectuser.php');
        $sc_users = new PopupSocialConnectUser();
        $sc_users->social_network = $activate;
        $sc_users->id_user = $id_user;
        $sc_users->screen_name = $screen_name;
        $sc_users->first_name = $first_name;
        $sc_users->last_name = $last_name;
        $sc_users->email = $mail;
        $sc_users->gender = $gender;
        $sc_users->add();
    }

    public function customerLoginAndRegister($customer, $fname, $lname, $email)
    {
        Hook::exec('actionBeforeSubmitAccount');
        $customer->firstname = $fname;
        $customer->lastname = $lname;
        $customer->email = $email;
        $password = Tools::passwdGen();
        $customer->passwd = md5(pSQL(_COOKIE_KEY_.$password));
        $customer->is_guest = 0;
        $customer->active = 1;
        $customer->add();
        Hook::exec('actionCustomerAccountAdd', array(
            '_POST' => $_POST,
            'newCustomer' => $customer
        ));
        $this->module->sendConfirmationMail($customer, $password);
        /*Customer login*/
        $context = Context::getContext();
        $context->customer = $customer;
        $context->cookie->id_customer = (int)$customer->id;
        $context->cookie->customer_lastname = $customer->lastname;
        $context->cookie->customer_firstname = $customer->firstname;
        $context->cookie->passwd = $customer->passwd;
        $context->cookie->logged = 1;
        $customer->logged = 1;
        $context->cookie->email = $customer->email;
        $context->cookie->is_guest = $customer->is_guest;
        $context->cart->secure_key = $customer->secure_key;
        $context->cookie->update();
        $context->cart->update();
    }

    public function customerLogin($customer)
    {
        /*Login when customer isset in customers table*/
        $context = Context::getContext();
        Hook::exec('actionBeforeAuthentication');
        if ($this->module->psv <= 1.6) {
            if (isset($context->cookie->id_compare)) {
                $id_compare = $context->cookie->id_compare;
            } else {
                $id_compare = CompareProduct::getIdCompareByIdCustomer($customer->id);
            }
            $context->cookie->id_compare = $id_compare;
        }
        $context->cookie->id_customer = (int)($customer->id);
        $context->cookie->customer_lastname = $customer->lastname;
        $context->cookie->customer_firstname = $customer->firstname;
        $context->cookie->logged = 1;
        $customer->logged = 1;
        $context->cookie->is_guest = $customer->isGuest();
        $context->cookie->passwd = $customer->passwd;
        $context->cookie->email = $customer->email;
        /* Add customer to the context */
        $context->customer = $customer;
        if (Configuration::get('PS_CART_FOLLOWING')
            && (empty($context->cookie->id_cart)
            || Cart::getNbProducts($context->cookie->id_cart) == 0)
            && $id_cart = (int)Cart::lastNoneOrderedCart($context->customer->id)) {
            $context->cart = new Cart($id_cart);
        } else {
            $context->cart->id_carrier = 0;
            $context->cart->setDeliveryOption(null);
            $context->cart->id_address_delivery = (int)Address::getFirstCustomerAddressId((int)($customer->id));
            $context->cart->id_address_invoice = (int)Address::getFirstCustomerAddressId((int)($customer->id));
        }
        $context->cart->id_customer = (int)$customer->id;
        $context->cart->secure_key = $customer->secure_key;
        $context->cart->save();
        $context->cookie->id_cart = (int)$context->cart->id;
        $context->cookie->write();
        $context->cart->autosetProductAddress();
        Hook::exec('actionAuthentication');
        /* Login information have changed, so we check if the cart rules still apply */
        CartRule::autoRemoveFromCart($context);
        CartRule::autoAddToCart($context);
    }

    public function initContent()
    {
        parent::initContent();
        if (Tools::getValue('email') == '' || Tools::getValue('user_fname') == '' || Tools::getValue('user_lname') == '') {
            $this->context->smarty->assign(array(
                'activate' => Tools::getValue('activate'),
                'email' => Tools::getValue('email'),
                'user_data_id' => Tools::getValue('user_data_id'),
                'user_fname' => Tools::getValue('user_fname'),
                'user_lname' => Tools::getValue('user_lname'),
                'screen_name' => Tools::getValue('screen_name'),
                'gender' => Tools::getValue('gender'),
                'name_status' => Tools::getValue('name_status'),
                'popup' => Tools::getValue('popup'),
                'psv' => $this->module->psv,
                'action' => $this->context->link->getModuleLink('hipopupnotification', 'connect'),
            ));
            if ($this->module->psv >= 1.7) {
                $this->setTemplate('module:'.$this->module->name.'/views/templates/front/connect17.tpl');
            } else {
                $this->setTemplate('connect.tpl');
            }
        } else {
            die('');
        }
    }
}
