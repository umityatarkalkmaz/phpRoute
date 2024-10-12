<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit38a8594b465656a1a0c8b327383668d6
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Umityatarkalkmaz\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Umityatarkalkmaz\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit38a8594b465656a1a0c8b327383668d6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit38a8594b465656a1a0c8b327383668d6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit38a8594b465656a1a0c8b327383668d6::$classMap;

        }, null, ClassLoader::class);
    }
}
