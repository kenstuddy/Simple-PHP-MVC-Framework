<?php
/*
 * Author: Ken Studdy
 * The starting point for the framework.
 */
require 'vendor/autoload.php';
require 'core/Bootstrap.php';
display_errors();

use App\Core\{Router, Request};

Router::load('app/routes.php')->direct(Request::uri(), Request::method());

?>
