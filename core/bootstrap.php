<?php

use App\Core\App;
use App\Core\Database\{QueryBuilder, Connection};


require 'helpers.php';

App::bind('config', require '../config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

?>
