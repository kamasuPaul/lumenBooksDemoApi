<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//add group for books
$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'BooksController@index');
    // $router->get('/{id}', 'BooksController@show');
    // $router->post('/', 'BooksController@store');
    $router->post('/{id}/comments', 'CommentController@store');
    $router->get('/{id}/comments', 'CommentController@index');

    $router->group(['prefix' => '{id}/characters'], function () use ($router) {
        $router->get('/', 'CharacterController@index');
    });
    // $router->delete('/{id}', 'BooksController@destroy');
});
