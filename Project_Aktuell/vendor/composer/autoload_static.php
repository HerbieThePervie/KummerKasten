<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit70347b78353072a70e3b38cd8b58824a
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'ParagonIE\\ConstantTime\\' => 23,
        ),
        'O' => 
        array (
            'OTPHP\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
        'OTPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/spomky-labs/otphp/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit70347b78353072a70e3b38cd8b58824a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit70347b78353072a70e3b38cd8b58824a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit70347b78353072a70e3b38cd8b58824a::$classMap;

        }, null, ClassLoader::class);
    }
}
