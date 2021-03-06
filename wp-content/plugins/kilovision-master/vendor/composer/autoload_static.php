<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit073923d3f54c828d84116cb44b0f5fb4
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Kvp\\' => 4,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Kvp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit073923d3f54c828d84116cb44b0f5fb4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit073923d3f54c828d84116cb44b0f5fb4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
