<?php
namespace App\Core\Database;
use App\Core\App;
use PDO;
use PDOException;
class Connection
{
    /*
     * This function creates a persistent database connection for the application.
     */
    public static function make($config)
    {
        try {
            return new PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        }
        catch (PDOException $e) {
            App::logError('There was a PDO Exception. Details: ' . $e);
            if (App::get('config')['options']['debug']) {
                return view('error', ['error' => $e->getMessage()]);
            }
            return view('error');
        }
    }
}



?>
