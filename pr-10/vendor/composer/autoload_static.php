<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit11df620dff934e56324fc47d37e7d9a8
{
    public static $prefixesPsr0 = array (
        'I' => 
        array (
            'Imagine' => 
            array (
                0 => __DIR__ . '/..' . '/imagine/imagine/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit11df620dff934e56324fc47d37e7d9a8::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit11df620dff934e56324fc47d37e7d9a8::$classMap;

        }, null, ClassLoader::class);
    }
}
