<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf43da660fe32363467343827e252fc8c
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lyre\\Settings\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lyre\\Settings\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf43da660fe32363467343827e252fc8c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf43da660fe32363467343827e252fc8c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf43da660fe32363467343827e252fc8c::$classMap;

        }, null, ClassLoader::class);
    }
}
