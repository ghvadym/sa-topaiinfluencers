<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit609efd2ad731d13dc69ddba31e8af403
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TikTok\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TikTok\\' => 
        array (
            0 => __DIR__ . '/..' . '/jstolpe/tiktok-api-php-sdk/src/TikTok',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit609efd2ad731d13dc69ddba31e8af403::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit609efd2ad731d13dc69ddba31e8af403::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit609efd2ad731d13dc69ddba31e8af403::$classMap;

        }, null, ClassLoader::class);
    }
}
