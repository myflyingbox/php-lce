<?php

namespace Lce;

class Bootstrap
{
    const DIR_GLUE = DIRECTORY_SEPARATOR;
    const NS_GLUE = '\\';

    public static function init()
    {
        spl_autoload_register(array('\Lce\Bootstrap', 'autoload'));
    }

    public static function autoload($classname)
    {
        self::_autoload(dirname(dirname(__FILE__)), $classname);
    }

    private static function _autoload($base, $classname)
    {
        $parts = explode(self::NS_GLUE, $classname);
        $path = $base.self::DIR_GLUE.implode(self::DIR_GLUE, $parts).'.php';

        if (file_exists($path)) {
            require_once $path;
        }
    }
}
