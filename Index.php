<?php
/*
 * Author: Ken Studdy
 * The starting point for our framework.
 */
require 'vendor/autoload.php';
require 'core/bootstrap.php';
display_errors();

use App\Core\{Router, Request};

Router::load('app/routes.php')->direct(Request::uri(), Request::method());

?>
