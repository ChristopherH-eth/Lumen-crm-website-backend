<?php

/**
 * This file tests the Accounts API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LayoutsTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $layoutName = 'default';                                // Name of the layout requested
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $layoutEndpoint = 'api/v1/layout/';                     // API Layout Endpoint

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
     * Tests the layout endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testLayoutEndpointGetByNameNoLoginFailure()
    {
        // Get default layout
        $response = $this->get($this->layoutEndpoint . $this->layoutName);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the layout endpoint by sending a GET request with a user being logged in and an invalid
     * layout name, which should result in a response status of 404.
     *
     * @return void
     */
    public function testLayoutEndpointGetByNameInvalidLayoutNameFailure()
    {
        $invalidLayout = 'invalidlayout';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);
        
        // Get default contacts layout
        $response = $this->get($this->layoutEndpoint . $this->layoutName);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the layout endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testLayoutEndpointGetByName()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get default contacts layout
        $response = $this->get($this->layoutEndpoint . $this->layoutName);

        $response->assertResponseStatus(200);
    }
}