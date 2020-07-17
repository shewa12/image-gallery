<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc58ee6fe2015bac57127a9cfeaf0efba
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'I' => 
        array (
            'Imagine' => 
            array (
                0 => __DIR__ . '/..' . '/imagine/imagine/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc58ee6fe2015bac57127a9cfeaf0efba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc58ee6fe2015bac57127a9cfeaf0efba::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitc58ee6fe2015bac57127a9cfeaf0efba::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
