<?php

namespace Bootstrap;


use Exception;

class App
{

    protected static $registry = [];

    public static function bind($key, $value): void
    {
        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new Exception("No {$key} is bound in the container.");
        }
        return static::$registry[$key];
    }


    public static function Config()
    {
        return static::get('config');
    }

}

