<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1b26efd68fb7e83db1fe1a9a52b4dd4c
{
    public static $files = array (
        '637fa4e5a9fe2956d844ead1daab0f31' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-business-reviews/bootstrap.php',
        '0774e44945781cd5a8d0b0dc32f80615' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-gutenframe/bootstrap.php',
        '0a7ee76a6dd15c6349ed695bd3b2a987' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-loader/module-loader.php',
        '9faa360fe54c7920477332fc60d95b84' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-spam-prevention/bootstrap.php',
        '6e09b332987211bb2939025b3ed3c51b' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-sso/bootstrap.php',
    );

    public static $prefixesPsr0 = array (
        'x' => 
        array (
            'xrstf\\Composer52' => 
            array (
                0 => __DIR__ . '/..' . '/xrstf/composer-php52/lib',
            ),
        ),
    );

    public static $classMap = array (
        'EIG_Module_Gutenframe' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-gutenframe/src/class-eig-module-gutenframe.php',
        'Endurance_Collection' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-loader/includes/Collection.php',
        'Endurance_ModuleManager' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-loader/includes/ModuleManager.php',
        'Endurance_ModuleRegistry' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-loader/includes/ModuleRegistry.php',
        'Endurance_Options' => __DIR__ . '/..' . '/bluehost/endurance-wp-module-loader/includes/Options.php',
        'xrstf\\Composer52\\AutoloadGenerator' => __DIR__ . '/..' . '/xrstf/composer-php52/lib/xrstf/Composer52/AutoloadGenerator.php',
        'xrstf\\Composer52\\Generator' => __DIR__ . '/..' . '/xrstf/composer-php52/lib/xrstf/Composer52/Generator.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit1b26efd68fb7e83db1fe1a9a52b4dd4c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1b26efd68fb7e83db1fe1a9a52b4dd4c::$classMap;

        }, null, ClassLoader::class);
    }
}
