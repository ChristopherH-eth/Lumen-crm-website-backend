<?php

/**
 * This file defines the routes and endpoints for the CRM API.
 * 
 * @author 0xChristopher
 */

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
    /**
     * Unauthenticated routes
     */
    $router->group(['prefix' => 'users'], function () use ($router)
    {
        $router->post('register', ['uses' => 'AuthController@register']);
        $router->post('login', ['uses' => 'AuthController@login']);
    });

    /**
     * Authenticated routes
     */
    $router->group(['middleware' => 'auth'], function () use ($router)
    {
        // User routes
        $router->group(['prefix' => 'users'], function () use ($router)
        {
            $router->post('logout', ['uses' => 'AuthController@logout']);
            $router->post('refresh', ['uses' => 'AuthController@refresh']);
            $router->get('refresh', ['uses' => 'AuthController@refresh']);
            $router->get('/', ['uses' => 'UserController@getSession']);
        });

        // Account routes
        $router->group(['prefix' => 'accounts'], function () use ($router)
        {
            $router->post('/', ['uses' => 'AccountController@postAccount']);
            $router->put('{id}', ['uses' => 'AccountController@updateAccount']);
            $router->get('/', ['uses' => 'AccountController@getAccounts']);
            $router->get('{id:[0-9]+}', ['uses' => 'AccountController@getAccountById']);
            $router->get('quicklook', ['uses' => 'AccountController@getAccountsQuickLook']);
            $router->delete('{id}', ['uses' => 'AccountController@deleteAccount']);
        });

        // Contact routes
        $router->group(['prefix' => 'contacts'], function () use ($router)
        {
            $router->post('/', ['uses' => 'ContactController@postContact']);
            $router->put('{id}', ['uses' => 'ContactController@updateContact']);
            $router->get('/', ['uses' => 'ContactController@getContacts']);
            $router->get('{id:[0-9]+}', ['uses' => 'ContactController@getContactById']);
            $router->get('quicklook', ['uses' => 'ContactController@getContactsQuickLook']);
            $router->delete('{id}', ['uses' => 'ContactController@deleteContact']);
        });

        // Lead routes
        $router->group(['prefix' => 'leads'], function () use ($router)
        {
            $router->post('/', ['uses' => 'LeadController@postLead']);
            $router->put('{id}', ['uses' => 'LeadController@updateLead']);
            $router->get('/', ['uses' => 'LeadController@getLeads']);
            $router->get('{id:[0-9]+}', ['uses' => 'LeadController@getLeadById']);
            $router->get('quicklook', ['uses' => 'LeadController@getLeadsQuickLook']);
            $router->delete('{id}', ['uses' => 'LeadController@deleteLead']);
        });
    });
});
