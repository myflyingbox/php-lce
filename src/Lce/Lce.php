<?php

namespace Lce;

use Lce\Exception\LceException;

class Lce
{
    const VERSION = '0.0.1-dev';

    public static $connection;

    public static function configure($login, $password, $env = 'staging', $version = '1')
    {
        return self::$connection = new Connection($login, $password, $env, $version);
    }

    public static function login()
    {
        return self::$connection->login;
    }

    public static function server()
    {
        return self::$connection->server();
    }

    public static function env()
    {
        return self::$connection->env;
    }

    public static function check($throw_exceptions = false)
    {
        try {
            return self::$connection->get() == true;
        } catch (LceException $e) {
            error_log($e->getMessage());
            if ($throw_exceptions === true) {
                throw $e;
            }
        }
    }
}
