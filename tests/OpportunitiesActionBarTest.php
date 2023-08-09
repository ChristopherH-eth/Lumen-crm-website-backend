<?php

/**
 * This file tests the Action Bar API Endpoints for the Opportunities model.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OpportunitiesActionBarTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $tableName = 'opportunities';                           // Name of the table we're working in
    private $actionBarName = 'collection_default';                  // Name of the action bar requested
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $actionBarEndpoint = 'api/v1/actionbar/';               // API Action Bar Endpoint

    /**
     * Login function to log the test user into the API.
     * 
     * @param $loginEndpoint
     * @param $email
     * @param $password
     * @return void
     */
    private function login($loginEndpoint, $email, $password)
    {
        $response = $this->post($loginEndpoint, [
            'email' => env($email),
            'password' => env($password)
        ]);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get Route
     *
     *
     ************************************************************/

    /**
     * Tests the action bar endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testActionBarEndpointGetByNameNoLoginFailure()
    {
        // Get default opportunities action bar
        $response = $this->get($this->actionBarEndpoint . $this->tableName . '/' . $this->actionBarName);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the action bar endpoint by sending a GET request with a user being logged in and an invalid
     * action bar name, which should result in a response status of 404.
     *
     * @return void
     */
    public function testActionBarEndpointGetByNameInvalidActionBarNameFailure()
    {
        $invalidActionBar = 'invalidbar';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);
        
        // Get default opportunities action bar
        $response = $this->get($this->actionBarEndpoint . $this->tableName . '/' . $invalidActionBar);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the action bar endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testActionBarEndpointGetByName()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get default opportunities action bar
        $response = $this->get($this->actionBarEndpoint . $this->tableName . '/' . $this->actionBarName);

        $response->assertResponseStatus(200);
    }
}