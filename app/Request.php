<?php
namespace App;

class Request
{
    /*
     * This function returns the URI of the request.
     */
    public static function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }
    /*
     * This function returns the method of the request.
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

