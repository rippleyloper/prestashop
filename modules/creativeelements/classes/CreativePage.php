<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

class CreativePage extends ObjectModel
{
    const TPL_LANG = 1;
    const TPL_SHOP = 1;
    const TPL_ACTIVE = 2;

    public $id_employee;
    public $id_page = 0;
    public $type;
    public $title;
    public $data;
    public $active;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'creativepage',
        'primary' => 'id',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'id_employee' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_page' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isHookName', 'required' => true, 'size' => 64),
            'active' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            // Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 128),
            'data' => array('type' => self::TYPE_NOTHING, 'lang' => true, 'validate' => 'isAnything'),
        ),
    );

    public function addTemplate($autodate = true, $null_values = false)
    {
        $db = Db::getInstance();

        if (isset($this->id) && !$this->force_id) {
            unset($this->id);
        }

        // @hook actionObject*AddBefore
        Hook::exec('actionObjectAddBefore', array('object' => $this));
        Hook::exec('actionObject' . get_class($this) . 'AddBefore', array('object' => $this));

        // Automatically fill dates
        if ($autodate && property_exists($this, 'date_add')) {
            $this->date_add = date('Y-m-d H:i:s');
        }

        if ($autodate && property_exists($this, 'date_upd')) {
            $this->date_upd = date('Y-m-d H:i:s');
        }

        if (!$result = $db->insert($this->def['table'], $this->getFields(), $null_values)) {
            return false;
        }

        // Get object id in database
        $this->id = $db->Insert_ID();

        // Database insertion for multilingual fields related to the object
        if (!empty($this->def['multilang'])) {
            $fields = $this->getFieldsLang();
            if ($fields && is_array($fields)) {
                foreach ($fields as $field) {
                    foreach (array_keys($field) as $key) {
                        if (!Validate::isTableOrIdentifier($key)) {
                            throw new PrestaShopException('key ' . $key . ' is not table or identifier');
                        }
                    }
                    $field[$this->def['primary']] = (int) $this->id;
                    $field['id_shop'] = self::TPL_SHOP;

                    $result &= $db->insert($this->def['table'] . '_lang', $field);
                }
            }
        }

        // @hook actionObject*AddAfter
        Hook::exec('actionObjectAddAfter', array('object' => $this));
        Hook::exec('actionObject' . get_class($this) . 'AddAfter', array('object' => $this));

        return $result;
    }

    public function add($auto_date = true, $null_values = false)
    {
        $ctx = Context::getContext();

        $this->id_employee = $ctx->employee->id;
        $this->active = (int) $this->active;
        $res = $this->active == self::TPL_ACTIVE ? $this->addTemplate($auto_date, $null_values) : parent::add($auto_date, $null_values);

        if ($res && !$this->id_page && $this->active <= 1 && $this->type && !empty($ctx->controller->module)) {
            $ctx->controller->module->registerHook($this->type, Shop::getContextListShopID(), null);
        }
        return $res;
    }

    public function update($null_values = false)
    {
        $before = $this->id_page ? null : new CreativePage($this->id);

        $this->active = (int) $this->active;
        $res = parent::update($null_values);

        if ($res && !$this->id_page && $this->active <= 1) {
            $module = Context::getContext()->controller->module;
            // handle hook changes
            if ($before->type && !method_exists($module, 'hook' . $before->type) && !self::getIdByPage($before->type, 0)) {
                $module->unregisterHook($before->type, Shop::getContextListShopID());
            }
            empty($this->type) or $module->registerHook($this->type, Shop::getContextListShopID(), null);
        }

        return $res;
    }

    public function delete()
    {
        $id = (int) $this->id;

        if ($res = parent::delete()) {
            $module = Context::getContext()->controller->module;
            $shops = Shop::getContextListShopID();
            // unregister hook if needed
            if (!$this->id_page && !method_exists($module, 'hook' . $this->type) && !self::getIdByPage($this->type, 0)) {
                $module->unregisterHook($this->type, $shops);
            }

            if ($this->active == self::TPL_ACTIVE) {
                $shops = array(self::TPL_SHOP);
            }

            foreach ($shops as $id_shop) {
                // delete meta data
                if ($id > 0) {
                    Db::getInstance()->delete(self::$definition['table'] . '_meta', "id = $id AND id_shop = $id_shop");
                }

                // delete css files
                $css_files = glob(_PS_MODULE_DIR_ . "creativeelements/views/css/pages/page-$id-*-$id_shop.css", GLOB_NOSORT);

                foreach ($css_files as $css_file) {
                    Tools::deleteFile($css_file);
                }
            }
        }
        return $res;
    }

    public function getFieldsLang()
    {
        $fieldsLang = parent::getFieldsLang();
        $db = Db::getInstance();
        foreach ($fieldsLang as &$fields) {
            if (!empty($fields['data'])) {
                $fields['data'] = $db->escape($fields['data'], true);
            }
        }
        return $fieldsLang;
    }

    public static function displayFieldName($field, $class = __CLASS__, $htmlentities = true, Context $ctx = null)
    {
        return $field == 'type' ? 'Position' : parent::displayFieldName($field, $class, $htmlentities, $ctx);
    }

    public static function getHooks()
    {
        $hooks = array(
            'displayBackOfficeHeader',
            'displayHeader',
            'displayFooterProduct',
            'overrideLayoutTemplate',
            'actionObjectCmsDeleteAfter',
            'actionObjectCategoryDeleteAfter',
            'actionObjectProductDeleteAfter',
            'actionObjectYbc_blog_post_classDeleteAfter',
        );
        $types = array('product', 'category', 'cms', 'tpl', 'ybc_blog_post_class');

        $rows = Db::getInstance()->executeS('SELECT DISTINCT `type` FROM ' . _DB_PREFIX_ . self::$definition['table']);
        foreach ($rows as &$row) {
            $hook = $row['type'];

            if ($hook && !in_array($hook, $types)) {
                $hooks[] = $hook;
            }
        }

        return $hooks;
    }

    public static function getIdByPage($type, $id_page)
    {
        $table = _DB_PREFIX_ . self::$definition['table'];
        $type = preg_replace('~\W+~', '', $type);
        $id_page = (int) $id_page;

        return Db::getInstance()->getValue("SELECT id FROM $table WHERE id_page = $id_page AND type LIKE '$type'");
    }

    public static function getInstance($type, $id_page)
    {
        $id = self::getIdByPage($type, $id_page);

        if ($id) {
            $elem = new CreativePage($id);
        } else {
            $elem = new CreativePage();
            $elem->id_page = $id_page;
            $elem->type = $type;
            $elem->active = true;
            $elem->title = array();
            $elem->data = array();
        }
        return $elem;
    }

    public static function deleteInstance($type, $id_page)
    {
        $id = self::getIdByPage($type, $id_page);

        if ($id) {
            $page = new CreativePage($id);
            return $page->delete();
        }
        return false;
    }

    public static function getData($type, $id_page, $id_lang = 0, $id_shop = 0)
    {
        $ctx = Context::getContext();
        $table = _DB_PREFIX_ . self::$definition['table'];
        $type = preg_replace('~\W+~', '', $type);
        $id_page = (int) $id_page;
        $id_lang = (int) $id_lang;
        $id_shop = (int) $id_shop;

        if (!$id_lang) {
            $id_lang = (int) $ctx->language->id;
        }
        if (!$id_shop && Shop::isFeatureActive()) {
            $id_shop = (int) $ctx->shop->id;
        }

        return Db::getInstance()->getValue(
            "SELECT b.data FROM $table a
            INNER JOIN {$table}_lang b ON a.id = b.id
            WHERE b.id_lang = $id_lang AND a.id_page = $id_page AND a.type LIKE '$type'" .
            ($id_shop ? ' AND b.id_shop = ' . $id_shop : '')
        );
    }

    public static function getDataRows($type, $active = true, $id_page = 0, $id_lang = 0, $id_shop = 0, $limit = 0)
    {
        $ctx = Context::getContext();
        $table = _DB_PREFIX_ . self::$definition['table'];
        $type = preg_replace('~\W+~', '', $type);
        $active = (int) $active;
        $id_page = (int) $id_page;
        $id_lang = (int) $id_lang;
        $id_shop = (int) $id_shop;
        $limit = (int) $limit;

        if (!$id_lang) {
            $id_lang = (int) $ctx->language->id;
        }
        if (!$id_shop && Shop::isFeatureActive()) {
            $id_shop = (int) $ctx->shop->id;
        }

        $res = Db::getInstance()->executeS(
            "SELECT a.id, b.id_lang, b.id_shop, b.data FROM $table a
            LEFT JOIN {$table}_lang AS b ON a.id = b.id
            LEFT JOIN {$table}_shop sa ON sa.id = a.id AND sa.id_shop = b.id_shop
            WHERE b.id_lang = $id_lang AND a.id_page = $id_page AND a.type LIKE '$type'" .
            ($id_shop ? ' AND sa.id_shop = ' . $id_shop : '') .
            ($active ? ' AND a.active = ' . $active : '') .
            ($limit ? ' LIMIT ' . $limit : '')
        );

        return $res ? $res : array();
    }

    public static function getLangIdsByPage($type, $id_page, $id_shop = 0)
    {
        $table = _DB_PREFIX_ . self::$definition['table'];
        $type = preg_replace('~\W+~', '', $type);
        $id_page = (int) $id_page;
        $id_shop = (int) $id_shop;

        if (!$id_shop && Shop::isFeatureActive()) {
            $id_shop = Context::getContext()->shop->id;
        }

        $rows = Db::getInstance()->executeS(
            "SELECT id_lang FROM $table a
            LEFT JOIN {$table}_lang b ON a.id = b.id
            LEFT JOIN {$table}_shop sa ON sa.id = a.id AND sa.id_shop = b.id_shop
            WHERE a.id_page = $id_page AND a.type LIKE '$type' AND b.data != ''" .
            ($id_shop ? ' AND sa.id_shop = ' . $id_shop : '')
        );

        $res = array();
        foreach ($rows as $row) {
            $res[] = $row['id_lang'];
        }

        return $res;
    }
}
