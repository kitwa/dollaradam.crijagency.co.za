<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd6d286ad5dfb4d6cbf8161802c29d3ba
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd6d286ad5dfb4d6cbf8161802c29d3ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd6d286ad5dfb4d6cbf8161802c29d3ba::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
