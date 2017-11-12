<?php

use App\Core\App;
use App\Core\Database\{QueryBuilder, Connection};


require 'Helpers.php';

App::bind('config', require 'Config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

?>
