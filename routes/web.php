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
            $router->put('{id}', ['uses' => 'UserController@updateUser']);
            $router->get('refresh', ['uses' => 'AuthController@refresh']);
            $router->get('/', ['uses' => 'UserController@getSession']);
        });

        // Account routes
        $router->group(['prefix' => 'accounts'], function () use ($router)
        {
            $router->post('/', ['uses' => 'AccountController@postAccount']);
            $router->put('{id}', ['uses' => 'AccountController@updateAccount']);
            $router->get('/', ['uses' => 'AccountController@getAccounts']);
            $router->get('page/{page}', ['uses' => 'AccountController@getAccountsByPage']);
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
            $router->get('page/{page}', ['uses' => 'ContactController@getContactsByPage']);
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
            $router->get('page/{page}', ['uses' => 'LeadController@getLeadsByPage']);
            $router->get('{id:[0-9]+}', ['uses' => 'LeadController@getLeadById']);
            $router->get('quicklook', ['uses' => 'LeadController@getLeadsQuickLook']);
            $router->delete('{id}', ['uses' => 'LeadController@deleteLead']);
        });

        // Opportunity routes
        $router->group(['prefix' => 'opportunities'], function () use ($router)
        {
            $router->post('/', ['uses' => 'OpportunityController@postOpportunity']);
            $router->put('{id}', ['uses' => 'OpportunityController@updateOpportunity']);
            $router->get('/', ['uses' => 'OpportunityController@getOpportunities']);
            $router->get('page/{page}', ['uses' => 'OpportunityController@getOpportunitiesByPage']);
            $router->get('{id:[0-9]+}', ['uses' => 'OpportunityController@getOpportunityById']);
            $router->get('quicklook', ['uses' => 'OpportunityController@getOpportunitiesQuickLook']);
            $router->delete('{id}', ['uses' => 'OpportunityController@deleteOpportunity']);
        });

        // Table View routes
        $router->group(['prefix' => 'tableview'], function () use ($router)
        {
            $router->post('{tableName}', ['uses' => 'TableViewController@postTableView']);
            $router->put('/{tableName}/{id}', ['uses' => 'TableViewController@updateTableView']);
            $router->get('/{tableName}/{viewRequest}', ['uses' => 'TableViewController@getTableViewByName']);
            $router->delete('/{tableName}/{id}', ['uses' => 'TableViewController@deleteTableView']);
        });

        // Action Bar routes
        $router->group(['prefix' => 'actionbar'], function () use ($router)
        {
            $router->post('{tableName}', ['uses' => 'ActionBarController@postActionBar']);
            $router->put('/{tableName}/{id}', ['uses' => 'ActionBarController@updateActionBar']);
            $router->get('/{tableName}/{barRequest}', ['uses' => 'ActionBarController@getActionBarByName']);
            $router->delete('/{tableName}/{id}', ['uses' => 'ActionBarController@deleteActionBar']);
        });

        // Layout routes
        $router->group(['prefix' => 'layout'], function () use ($router)
        {
            $router->post('{layoutName}', ['uses' => 'LayoutController@postLayout']);
            $router->put('{layoutName}', ['uses' => 'LayoutController@updateLayout']);
            $router->get('{layoutName}', ['uses' => 'LayoutController@getLayoutByName']);
            $router->delete('{layoutName}', ['uses' => 'LayoutController@deleteLayout']);
        });
    });
});
