<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55fc75c4c6a6ca8b84fcdcdf4c7069b2
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Log\\' => 8,
            'Psr\\Cache\\' => 10,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
        'C' => 
        array (
            'CyberSource\\' => 12,
            'Cache\\TagInterop\\' => 17,
            'Cache\\Adapter\\Common\\' => 21,
            'Cache\\Adapter\\Apcu\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'CyberSource\\' => 
        array (
            0 => __DIR__ . '/..' . '/cybersource/rest-client-php/lib',
        ),
        'Cache\\TagInterop\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/tag-interop',
        ),
        'Cache\\Adapter\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/adapter-common',
        ),
        'Cache\\Adapter\\Apcu\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/apcu-adapter',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55fc75c4c6a6ca8b84fcdcdf4c7069b2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55fc75c4c6a6ca8b84fcdcdf4c7069b2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
