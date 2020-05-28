<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf890f12bb8803a4726284b660b685d67
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf890f12bb8803a4726284b660b685d67::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf890f12bb8803a4726284b660b685d67::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
