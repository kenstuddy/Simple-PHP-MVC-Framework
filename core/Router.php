<?php
namespace App\Core;
use Exception;
class Router
{
    /*
     * This is the routes array. So far it only works for GET and POST but this can be changed.
     */
    public $routes = [

        'GET' => [],
        'POST' => []

    ];
    /*
     * This function loads the routes from a file. In this framework, the routes are stored in app/routes.php.
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }
    /*
     * This function defines the routes of the application.
     */
    public function define($routes)
    {
        $this->routes = $routes;
    }
    /*
     * This function gets the GET route based on the URI and passes it off to the controller.
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }
    /*
     * This function gets the POST route based on the URI and passes it off to the controller.
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }
    /*
     * This function directs the user to the route based on the request type.
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@',$this->routes[$requestType][$uri])
            );
        }

        throw new Exception('No route defined for this URI.');
    }
    /*
     * This function calls the controller for an action.
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";

        $controller = new $controller;

        if (! method_exists($controller, $action))
        {
            throw new Exception("{$controller} does not respond to the {$action} action.");
        }

        return $controller->$action();
    }
}


?>
