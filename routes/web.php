<?php

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
    return view('home');
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->post('bot/{id}', [
        'middleware' => 'throttle:30',
        'uses' => 'BotController@store'
    ]);

    $router->get('bot/{id}', [
        'middleware' => 'throttle:5',
        'uses' => 'BotController@show'
    ]);

    $router->get('stats', [
        'middleware' => 'throttle:1',
        'uses' => 'StatsController@index'
    ]);
});