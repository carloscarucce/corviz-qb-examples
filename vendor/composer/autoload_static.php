<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit72fe8835f4ce00fa0ebd4b40ad5e9ba3
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Corviz\\Connector\\PDO\\' => 21,
            'Corviz\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Corviz\\Connector\\PDO\\' => 
        array (
            0 => __DIR__ . '/..' . '/corviz/pdo-connector/src',
        ),
        'Corviz\\' => 
        array (
            0 => __DIR__ . '/..' . '/corviz/framework/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit72fe8835f4ce00fa0ebd4b40ad5e9ba3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit72fe8835f4ce00fa0ebd4b40ad5e9ba3::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
