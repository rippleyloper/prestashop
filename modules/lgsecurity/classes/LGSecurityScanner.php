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

require_once(_PS_MODULE_DIR_.'lgsecurity'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'LGSecurityStack.php');

class LGSecurityScanner {
    public static $instance;

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new LGSecurityScanner();
        }

        return self::$instance;
    }

    public function scan()
    {
        LGSecurityStack::scan();
        LGSecurityStack::searchPHPUnit();
        return $this;
    }

    public function getDetected()
    {
        return LGSecurityStack::getDetected();
    }

    public function getDirsScanned()
    {
        return LGSecurityStack::getDirsScanned();
    }

    public function deleteDir($id)
    {
        $dir = new LGSecurityStack((int)$id);
        if (Validate::isLoadedObject($dir)) {
            $this->rrmdir($dir->path);
            if (!file_exists($dir)) {
                $dir->delete();
            }
        }
    }

    /**
     * Lo hacemos privado para que no se pueda llamar desde otro sitio
     *
     * @param $dir
     */
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object) && !is_link($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }
}
