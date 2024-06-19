<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1a3769c5e5365b23c39f464405a2b7b6
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
        ),
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1a3769c5e5365b23c39f464405a2b7b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1a3769c5e5365b23c39f464405a2b7b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1a3769c5e5365b23c39f464405a2b7b6::$classMap;

        }, null, ClassLoader::class);
    }
}
