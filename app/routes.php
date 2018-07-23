<?php
Use App\Core\App;
//If the array notation routing config option in config.php is set to true, let's use array notation routing.
if (App::get('config')['options']['array_routing']) {
    $router->getArray([
        '' => 'PagesController@home',
        'about' => 'PagesController@about',
        'contact' => 'PagesController@contact',
        'users' => 'UsersController@index'
    ]);
    $router->postArray([
        'users' => 'UsersController@store'
    ]);
}
else {
    $router->get('', 'PagesController@home');
    $router->get('about', 'PagesController@about');
    $router->get('contact', 'PagesController@contact');

    $router->get('users', 'UsersController@index');
    $router->post('users', 'UsersController@store');
}

?>
