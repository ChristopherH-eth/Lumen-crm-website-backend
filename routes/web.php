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

$router->group(['prefix' => 'api/v1'], function () use ($router)
{
    $router->post('new', ['uses' => 'CryptoController@postCryptos']);
    $router->get('all', ['uses' => 'CryptoController@getCryptos']);
    $router->get('pages', ['uses' => 'CryptoController@getCryptosByPage']);
    $router->get('cryptocurrencies/{id}', ['uses' => 'CryptoController@getCryptoById']);

    $router->post('new/metadata', ['uses' => 'MetadataController@postMetadata']);
    $router->get('metadata/{id}', ['uses' => 'MetadataController@getMetadataById']);
});
