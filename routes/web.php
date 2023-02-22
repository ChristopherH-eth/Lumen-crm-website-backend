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

/**
 * API V1 Routes
 */
$router->group(['prefix' => 'api/v1'], function () use ($router)
{
    // Contact routes
    $router->group(['prefix' => 'contacts'], function () use ($router)
    {
        $router->post('/', ['uses' => 'ContactController@postContact']);
        $router->put('{id}', ['uses' => 'ContactController@updateContact']);
        $router->get('/', ['uses' => 'ContactController@getContacts']);
        $router->get('{id}', ['uses' => 'ContactController@getContactById']);
        $router->delete('{id}', ['uses' => 'ContactController@deleteContact']);
    });
});
