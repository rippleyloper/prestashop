<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit07ae4bff9b91f1288d7adb510e11fd07
{
    public static $classMap = array (
        'Ps_Crossselling' => __DIR__ . '/../..' . '/ps_crossselling.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit07ae4bff9b91f1288d7adb510e11fd07::$classMap;

        }, null, ClassLoader::class);
    }
}
