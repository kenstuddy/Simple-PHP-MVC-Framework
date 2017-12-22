<?php
namespace App\Core;
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
     * This function returns the method (I.E. GET, POST, etc) of the request.
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

?>
