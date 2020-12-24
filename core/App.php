<?php

namespace App\Core;

use App\Core\Logger\Logger;
use App\Core\Logger\LogToFile;
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

    public static function DB()
    {
        return static::get('database');
    }

    public static function Config()
    {
        return static::get('config');
    }

    public static function logInfo($data, Logger $logger = null): bool
    {
        $logger = $logger ?: new LogToFile();
        return $logger->info($data);
    }

    public static function logError($data, Logger $logger = null): bool
    {
        $logger = $logger ?: new LogToFile();
        return $logger->error($data);
    }
}

?>
