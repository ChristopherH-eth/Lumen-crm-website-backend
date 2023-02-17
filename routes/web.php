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
    // Cryptocurrency routes
    $router->group(['prefix' => 'cryptocurrencies'], function () use ($router)
    {
        $router->post('new', ['uses' => 'CryptoController@postCryptos']);
        $router->get('all', ['uses' => 'CryptoController@getCryptos']);
        $router->get('count', ['uses' => 'CryptoController@getCryptoCount']);
        $router->get('pages', ['uses' => 'CryptoController@getCryptosByPage']);
        $router->get('{id}', ['uses' => 'CryptoController@getCryptoById']);
    });

    // Metadata routes
    $router->group(['prefix' => 'metadata'], function () use ($router)
    {
        $router->post('new', ['uses' => 'MetadataController@postMetadata']);
        $router->get('{id}', ['uses' => 'MetadataController@getMetadataById']);
    });

    // User routes
    $router->group(['prefix' => 'user'], function () use ($router)
    {
        $router->post('register', ['uses' => 'UserController@postRegister']);
        $router->post('login', ['uses' => 'UserController@postLogin']);
        $router->get('cookies', ['uses' => 'UserController@getCookies']);
    });
});
