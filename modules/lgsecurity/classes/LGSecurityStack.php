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

class LGSecurityStack extends ObjectModel
{
    const STATUS_DETECTED = 'detected';
    const STATUS_DELETED  = 'deleted';

    public $path;
    public $date_add;
    public $status;

    private static $dir_stack = array();

    public static $definition = array(
        'table' => 'lgsecurity_stack',
        'primary' => 'id_lgsecurity_stack',
        'multilang' => false,
        'fields' => array(
            'path'      => array('type' => self::TYPE_STRING, 'size' => 255),
            'date_add'  => array('type' => self::TYPE_DATE),
            'status'    => array('type' => self::TYPE_STRING, 'size' => 20),
        )
    );

    public static function install($db = null)
    {
        if (is_null($db)) {
            $db = Db::getInstance();
        }
        $sql = array();
        $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . self::$definition['table'] . '` (
                     `' . self::$definition['primary'] . '` int(10) unsigned NOT NULL AUTO_INCREMENT,
                     `path` TEXT,
                     `date_add` datetime NOT NULL,
                     `status` VARCHAR(20) NOT NULL DEFAULT "'.self::STATUS_DETECTED.'",
                     PRIMARY KEY (`' . self::$definition['primary'] . '`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8';

        //$sql[] = 'ALTER TABLE `'._DB_PREFIX_.self::$definition['table'].'` ADD INDEX(`path`);';
        $sql[] = 'ALTER TABLE `'._DB_PREFIX_.self::$definition['table'].'` ADD INDEX(`date_add`);';

        foreach ($sql as $query) {
            if ($db->execute($query) == false) {
                return false;
            }
        }
        return true;
    }

    public static function uninstall($db = null)
    {
        if (is_null($db)) {
            $db = Db::getInstance();
        }
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . self::$definition['table'] . '`';

        return $db->execute($sql);
    }

    protected static function scanDirRecursive($path = false)
    {
        $dirs_listed = glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        if (!empty($dirs_listed)) {
            foreach ($dirs_listed as $dir) {
                if (!in_array($dir, self::$dir_stack)) {
                    self::$dir_stack[] = $dir;
                    self::scanDirRecursive($dir);
                }
            }
        }
    }

    public static function addDetectedItem($dir)
    {
        $item = new LGSecurityStack();
        $item->path = pSQL($dir);
        $item->status = self::STATUS_DETECTED;
        $item->save();
    }

    public static function searchPHPUnit()
    {
        self::searchDirName('phpunit');
    }

    public static function searchDirName($dirname)
    {
        foreach (self::$dir_stack as $dir) {
            if (strpos($dir, $dirname) !== false && !self::existDetecteditem($dir)) {
                self::addDetectedItem($dir);
            }
        }
    }

    public static function scan($path = false)
    {
        self::cleanDirs();

        $PrestashopVendorPath  = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'vendor';
        $PrestashopModulesPath = _PS_MODULE_DIR_;

        if (file_exists($PrestashopVendorPath)) {
            self::scanDirRecursive($PrestashopVendorPath);
        }

        if (file_exists($PrestashopModulesPath)) {
            self::scanDirRecursive($PrestashopModulesPath);
        }
    }

    public static function existDetecteditem($dir)
    {
        $query = new DbQuery();
        $query->from(self::$definition['table']);
        $query->where('path = "'.str_replace("\\", '\\\\', pSQL($dir)).'"');
        $query->where('status = "'.self::STATUS_DETECTED.'"');

        return !empty(Db::getInstance()->getRow($query));
    }

    public static function getDetected($limit = 10, $offset = 0)
    {
        $query = new DbQuery();
        $query->from(self::$definition['table']);
        $query->where('status LIKE "'.self::STATUS_DETECTED.'"');
        //$query->limit($limit, $offset);
        $result = Db::getInstance()->executeS($query);
        
        if (!empty($result)) {
            foreach ($result as $i => $r) {
                $result[$i]['path'] = str_replace('\\\\', "\\", $r['path']);
            }
        }

        return $result;
    }

    public static function cleanDirs()
    {
        self::$dir_stack = array();
    }

    public static function getDirsScanned()
    {
        return self::$dir_stack;
    }
}
