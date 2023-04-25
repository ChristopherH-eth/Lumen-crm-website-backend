<?php

/**
 * This file tests the Leads API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

class LeadTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $leadsEndpoint = 'api/v1/leads/';                       // API Leads Endpoint

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

    /**
     * Tests the leads endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testLeadsEndpointFailure()
    {
        // Get all leads
        $response = $this->get($this->leadsEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testLeadsEndpoint()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get all leads
        $response = $this->get($this->leadsEndpoint);

        $response->assertResponseStatus(200);
    }
}