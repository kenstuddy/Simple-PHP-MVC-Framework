<?php
//First way of routing
//uncomment to use array notation routing
/*
$router->get([
    '' => 'PagesController@home',
    'about' => 'PagesController@about',
    'contact' => 'PagesController@contact',
    'users' => 'UsersController@index'
]);
$router->post([
    'users' => 'UsersController@store'
]);
*/

//Second way of routing
$router->get('', 'PagesController@home');
$router->get('About', 'PagesController@about');
$router->get('Contact', 'PagesController@contact');

$router->get('Users', 'UsersController@index');
$router->post('Users', 'UsersController@store');
?>
