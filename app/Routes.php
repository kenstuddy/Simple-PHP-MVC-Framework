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
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');

$router->get('users', 'UsersController@index');
$router->post('users', 'UsersController@store');
?>
